@extends('layouts.app')

@section('title', 'Buat Kategori')
@section('content')

    <div class="page-heading">
        <h3>Buat Kategori</h3>
    </div>

    <section id="basic-vertical-layouts">
        <div class="row match-height">

            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form action="{{ route('admin.categories.store') }}" method="POST" class="form form-vertical">
                            @csrf
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="first-name-vertical">Nama Kategori</label>
                                            <input type="text" id="first-name-vertical"
                                                class="form-control @error('name')
                                                is-invalid
                                            @enderror"
                                                name="name" placeholder="Nama Kategori" value="{{ old('name') }}">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-end">
                                        <a href="{{ route('admin.categories.index') }}"
                                            class="btn btn-secondary me-1 mb-1">Batal</a>
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Buat</button>
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
