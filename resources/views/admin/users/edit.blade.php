@extends('layouts.app')

@section('title', 'Edit Akun')
@section('content')

    <div class="page-heading">
        <h3>Edit Akun</h3>
    </div>

    <section id="basic-vertical-layouts">
        <div class="row match-height">

            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="form form-vertical">
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
                                                name="name" placeholder="Name" value="{{ old('name', $user->name) }}">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="first-name-vertical">Email</label>
                                            <input type="email" id="first-name-vertical"
                                                class="form-control @error('email')
                                                is-invalid
                                            @enderror"
                                                name="email" placeholder="email@example.com"
                                                value="{{ old('email', $user->email) }}">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="first-name-vertical">Password</label>
                                            <input type="password" id="first-name-vertical"
                                                class="form-control @error('password')
                                                is-invalid
                                            @enderror"
                                                name="password" placeholder="Kosongkan jika tidak ingin mengganti">
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="first-name-vertical">Konfirmasi Password</label>
                                            <input type="password" id="first-name-vertical"
                                                class="form-control @error('password_confirmation')
                                                is-invalid
                                            @enderror"
                                                name="password_confirmation"
                                                placeholder="Kosongkan jika tidak ingin mengganti">
                                            @error('password_confirmation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-end">
                                        <a href="{{ route('admin.users.index') }}"
                                            class="btn btn-secondary me-1 mb-1">Batal</a>
                                        <button type="submit" class="btn btn-warning me-1 mb-1">Update</button>
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
