<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPenjualanHariIni = Transaction::whereDate('created_at', today())->sum('total_price');
        $totalTransactionHariIni = Transaction::whereDate('created_at', today())->count();
        $produkHampirHabis = Product::where('stock', '<', 10)->count();
        $totalKasirAktif = User::where('role', 'kasir')->where('is_active', true)->count();
        $produkTerlaris = TransactionItem::select('product_name', DB::raw('SUM(quantity) as total_terjual'))->groupBy('product_name')->orderByDesc('total_terjual')->limit(5)->get();
        $penjualan7Hari = Transaction::select(DB::raw('DATE(created_at) as tanggal'), DB::raw('SUM(total_price) as total'))->whereDate('created_at', '>=', Carbon::now()->subDays(6))->groupBy('tanggal')->orderBy('tanggal')->get();

        return view('admin.dashboard', compact('totalPenjualanHariIni', 'totalTransactionHariIni', 'produkHampirHabis', 'totalKasirAktif', 'produkTerlaris', 'penjualan7Hari'));
    }
}
