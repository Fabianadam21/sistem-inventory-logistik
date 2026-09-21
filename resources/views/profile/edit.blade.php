@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<div class="page-header">

    <div>
        <h1>Profile</h1>

        <div class="subtitle">
            Kelola informasi akun Anda
        </div>
    </div>

</div>


@if(session('success'))

    <div class="alert alert-success">
        {{ session('success') }}
    </div>

@endif


@if($errors->any())

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
        action="{{ route('profile.update') }}"
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


        <div
            style="
                margin:25px 0 20px;
                padding-top:20px;
                border-top:1px solid #e5e7eb;
            "
        >

            <h3 style="margin:0 0 7px;">
                Ubah Password
            </h3>

            <div class="subtitle">
                Kosongkan jika tidak ingin mengubah password.
            </div>

        </div>


        <div class="form-group">

            <label for="current_password">
                Password Saat Ini
            </label>

            <input
                type="password"
                id="current_password"
                name="current_password"
                class="form-control"
                placeholder="Masukkan password saat ini"
            >

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
                placeholder="Minimal 8 karakter"
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

        </div>

    </form>

</div>

@endsection