<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('role', 'kasir')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name' => $validate['name'],
            'email' => $validate['email'],
            'password' => $validate['password'],
            'role' => 'kasir',
            'is_active' => true,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun kasir berhasil dibuat!');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.users.index')->with('error', 'Tidak bisa edit akun admin!');
        }
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validate = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $data = [
            'name' => $validate['name'],
            'email' => $validate['email'],
        ];

        if (!empty($validate['password'])) {
            $data['password'] = $validate['password'];
        }

        $user->update($data);
        return redirect()->route('admin.users.index')->with('success', 'Data akun berhasil diperbarui!');
    }


    public function toggleActive(User $user)
    {
        $pesan = $user->is_active ? 'dinonaktifkan' : 'diaktifkan';

        $user->update(['is_active' => !$user->is_active]);

        return redirect()->route('admin.users.index')
            ->with('success', "Akun berhasil {$pesan}!");
    }
}
