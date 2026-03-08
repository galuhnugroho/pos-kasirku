@extends('layouts.app')
@section('title', 'Produk')

@section('content')
    <div class="page-heading">
        <h3>Daftar Produk</h3>
    </div>
    <!-- Bordered table start -->
    <section class="section">
        <div class="row" id="table-bordered">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary mb-2">Tambah</a>
                            <!-- table bordered -->
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th>NO.</th>
                                            <th>NAMA</th>
                                            <th>KATEGORI</th>
                                            <th>HARGA</th>
                                            <th>STOK</th>
                                            <th>GAMBAR</th>
                                            <th>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td class="text-bold-500">{{ $loop->iteration }}</td>
                                                <td class="text-bold-500">{{ $product->name }}</td>
                                                <td class="text-bold-500">{{ $product->category->name }}</td>
                                                <td class="text-bold-500">
                                                    Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                                                <td class="text-bold-500">{{ $product->stock }}</td>
                                                <td class="text-bold-500">
                                                    @if ($product->image)
                                                        <img src="{{ Storage::url($product->image) }}" alt="image"
                                                            width="50">
                                                    @else
                                                        <span class="text-muted">No Image</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                                        class="btn btn-sm btn-warning">Edit</a>
                                                    <form action="{{ route('admin.products.destroy', $product->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Yakin ingin menghapus produk ini?')">Delete</button>
                                                    </form>
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
