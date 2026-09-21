@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')

<div class="page-header">

    <div>
        <h1>Tambah User</h1>

        <div class="subtitle">
            Tambahkan akun pengguna baru
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
        action="{{ route('users.store') }}"
        method="POST"
    >

        @csrf


        <div class="form-group">

            <label for="name">
                Nama
            </label>

            <input
                type="text"
                id="name"
                name="name"
                class="form-control"
                value="{{ old('name') }}"
                placeholder="Nama pengguna"
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
                value="{{ old('email') }}"
                placeholder="nama@email.com"
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

                <option value="">
                    -- Pilih Role --
                </option>

                <option
                    value="admin"
                    {{ old('role') === 'admin' ? 'selected' : '' }}
                >
                    Admin
                </option>

                <option
                    value="petugas"
                    {{ old('role') === 'petugas' ? 'selected' : '' }}
                >
                    Petugas
                </option>

                <option
                    value="pimpinan"
                    {{ old('role') === 'pimpinan' ? 'selected' : '' }}
                >
                    Pimpinan
                </option>

            </select>

        </div>


        <div class="form-group">

            <label for="password">
                Password
            </label>

            <input
                type="password"
                id="password"
                name="password"
                class="form-control"
                minlength="8"
                required
            >

        </div>


        <div class="form-group">

            <label for="password_confirmation">
                Konfirmasi Password
            </label>

            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                class="form-control"
                minlength="8"
                required
            >

        </div>


        <div class="actions">

            <button
                type="submit"
                class="btn btn-primary"
            >
                Simpan User
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