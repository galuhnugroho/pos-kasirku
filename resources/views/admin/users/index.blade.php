    @extends('layouts.app')
    @section('title', 'DAFTAR AKUN')

    @section('content')
        <div class="page-heading">
            <h3>Daftar Akun</h3>
        </div>
        <!-- Bordered table start -->
        <section class="section">
            <div class="row" id="table-bordered">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary mb-2">Buat Akun</a>
                                <!-- table bordered -->
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead>
                                            <tr>
                                                <th>NO.</th>
                                                <th>NAMA</th>
                                                <th>EMAIL</th>
                                                <th>STATUS</th>
                                                <th>AKSI</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td class="text-bold-500">{{ $loop->iteration }}</td>
                                                    <td class="text-bold-500">{{ $user->name }}</td>
                                                    <td class="text-bold-500">{{ $user->email }}</td>
                                                    <td class="text-bold-500">
                                                        @if ($user->is_active)
                                                            <span class="badge bg-success">Aktif</span>
                                                        @else
                                                            <span class="badge bg-danger">Nonaktif</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                                            class="btn btn-sm btn-warning">Edit</a>
                                                        @if ($user->is_active)
                                                            <form
                                                                action="{{ route('admin.users.toggleActive', $user->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('Patch')
                                                                <button type="submit" class=" btn btn-sm btn-danger"
                                                                    onclick="return confirm('Apakah Anda yakin ingin menonaktifkan kasir ini?')">
                                                                    Nonaktifkan
                                                                </button>
                                                            </form>
                                                        @else
                                                            <form
                                                                action="{{ route('admin.users.toggleActive', $user->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class=" btn btn-sm btn-success"
                                                                    onclick="return confirm('Aktifkan akun ini?')">
                                                                    Aktifkan
                                                                </button>
                                                            </form>
                                                        @endif

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Bordered table end -->
    @endsection
