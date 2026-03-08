@extends('layouts.app')

@section('title', 'Edit Produk')
@section('content')

    <div class="page-heading">
        <h3>Edit Produk</h3>
    </div>

    <section id="basic-vertical-layouts">
        <div class="row match-height">

            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form action="{{ route('admin.products.update', $product->id) }}" method="POST"
                            class="form form-vertical" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="first-name-vertical">Nama</label>
                                            <input type="text" id="first-name-vertical"
                                                class="form-control @error('name')
                                                is-invalid
                                            @enderror"
                                                name="name" placeholder="Nama" value="{{ old('name', $product->name) }}">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="first-name-vertical">Kategori</label>
                                            <select class="form-select @error('category_id') is-invalid @enderror"
                                                name="category_id" id="basicSelect">
                                                <option value="">-- Pilih Kategori--</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach

                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="first-name-vertical">Harga</label>
                                            <input type="number" id="first-name-vertical"
                                                class="form-control @error('price')
                                                is-invalid
                                            @enderror"
                                                name="price" placeholder="Harga"
                                                value="{{ old('price', $product->price) }}">
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="first-name-vertical">Stok</label>
                                            <input type="number" id="first-name-vertical"
                                                class="form-control @error('stock')
                                                is-invalid
                                            @enderror"
                                                name="stock" placeholder="Stok"
                                                value="{{ old('stock', $product->stock) }}">
                                            @error('stock')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="first-name-vertical">Barcode</label>
                                            <input type="text" id="first-name-vertical"
                                                class="form-control @error('barcode')
                                                is-invalid
                                            @enderror"
                                                name="barcode" placeholder="Barcode"
                                                value="{{ old('barcode', $product->barcode) }}">
                                            @error('barcode')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="first-name-vertical">Deskripsi</label>
                                            <textarea class="form-control" name="Deskripsi" id="exampleFormControlTextarea1" rows="3">{{ old('description', $product->description) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="first-name-vertical">Gambar</label>
                                            @if ($product->image)
                                                <img src="{{ Storage::url($product->image) }}" width="80"
                                                    class="mb-2 d-block">
                                                <small class="text-muted">Kosongkan jika tidak ingin mengganti
                                                    gambar</small>
                                            @endif
                                            <input type="file" id="first-name-vertical"
                                                class="form-control @error('image')
                                                is-invalid
                                            @enderror"
                                                name="image" placeholder="Image">
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-end">
                                        <a href="{{ route('admin.products.index') }}"
                                            class="btn btn-secondary me-1 mb-1">Batal</a>
                                        <button type="submit" class="btn btn-warning me-1 mb-1">Edit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
