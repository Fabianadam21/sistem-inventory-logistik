@extends('layouts.app')

@section('title', 'Tambah Gudang')

@section('content')

<div class="page-header">

    <div>
        <h1>Tambah Gudang</h1>

        <div class="subtitle">
            Tambahkan data gudang baru
        </div>
    </div>

    <a
        href="{{ route('warehouses.index') }}"
        class="btn btn-secondary"
    >
        ← Kembali
    </a>

</div>

@if ($errors->any())

    <div class="alert alert-error">

        <strong>Terjadi kesalahan:</strong>

        <ul style="margin: 8px 0 0 18px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>

    </div>

@endif

<div class="card">

    <form
        action="{{ route('warehouses.store') }}"
        method="POST"
    >

        @csrf

        <div class="form-group">

            <label for="name">
                Nama Gudang
            </label>

            <input
                type="text"
                id="name"
                name="name"
                class="form-control"
                value="{{ old('name') }}"
                placeholder="Contoh: Gudang Utama"
                required
            >

        </div>

        <div class="form-group">

            <label for="location">
                Lokasi
            </label>

            <input
                type="text"
                id="location"
                name="location"
                class="form-control"
                value="{{ old('location') }}"
                placeholder="Contoh: Gedung A Lantai 1"
            >

        </div>

        <div class="actions">

            <button
                type="submit"
                class="btn btn-primary"
            >
                Simpan Gudang
            </button>

            <a
                href="{{ route('warehouses.index') }}"
                class="btn btn-secondary"
            >
                Batal
            </a>

        </div>

    </form>

</div>

@endsection