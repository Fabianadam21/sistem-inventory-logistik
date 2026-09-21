@extends('layouts.app')

@section('title', 'Edit User')

@section('content')

<div class="page-header">

    <div>
        <h1>Edit User</h1>

        <div class="subtitle">
            Perbarui informasi dan hak akses pengguna
        </div>
    </div>

    <a
        href="{{ route('users.index') }}"
        class="btn btn-secondary"
    >
        ← Kembali
    </a>

</div>


@if ($errors->any())

    <div class="alert alert-error">

        <strong>Terjadi kesalahan:</strong>

        <ul style="margin:8px 0 0 18px;">

            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach

        </ul>

    </div>

@endif


<div class="card">

    <form
        action="{{ route('users.update', $user->id) }}"
        method="POST"
    >

        @csrf
        @method('PUT')


        <div class="form-group">

            <label for="name">
                Nama
            </label>

            <input
                type="text"
                id="name"
                name="name"
                class="form-control"
                value="{{ old('name', $user->name) }}"
                required
            >

        </div>


        <div class="form-group">

            <label for="email">
                Email
            </label>

            <input
                type="email"
                id="email"
                name="email"
                class="form-control"
                value="{{ old('email', $user->email) }}"
                required
            >

        </div>


        <div class="form-group">

            <label for="role">
                Role
            </label>

            <select
                id="role"
                name="role"
                class="form-control"
                required
            >

                <option
                    value="admin"
                    {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}
                >
                    Admin
                </option>

                <option
                    value="petugas"
                    {{ old('role', $user->role) === 'petugas' ? 'selected' : '' }}
                >
                    Petugas
                </option>

                <option
                    value="pimpinan"
                    {{ old('role', $user->role) === 'pimpinan' ? 'selected' : '' }}
                >
                    Pimpinan
                </option>

            </select>

        </div>


        <div class="form-group">

            <label for="password">
                Password Baru
            </label>

            <input
                type="password"
                id="password"
                name="password"
                class="form-control"
                minlength="8"
                placeholder="Kosongkan jika tidak ingin mengubah password"
            >

        </div>


        <div class="form-group">

            <label for="password_confirmation">
                Konfirmasi Password Baru
            </label>

            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                class="form-control"
                minlength="8"
            >

        </div>


        <div class="actions">

            <button
                type="submit"
                class="btn btn-primary"
            >
                Simpan Perubahan
            </button>

            <a
                href="{{ route('users.index') }}"
                class="btn btn-secondary"
            >
                Batal
            </a>

        </div>

    </form>

</div>

@endsection