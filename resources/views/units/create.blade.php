@extends('layouts.app')

@section('title', 'Tambah Satuan')

@section('content')

<div class="page-header">

    <div>
        <h1>Tambah Satuan</h1>

        <div class="subtitle">
            Tambahkan satuan barang baru
        </div>
    </div>

    <a
        href="{{ route('units.index') }}"
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
        action="{{ route('units.store') }}"
        method="POST"
    >

        @csrf

        <div class="form-group">

            <label for="name">
                Nama Satuan
            </label>

            <input
                type="text"
                id="name"
                name="name"
                class="form-control"
                value="{{ old('name') }}"
                placeholder="Contoh: Pcs"
                required
            >

        </div>

        <div class="actions">

            <button
                type="submit"
                class="btn btn-primary"
            >
                Simpan Satuan
            </button>

            <a
                href="{{ route('units.index') }}"
                class="btn btn-secondary"
            >
                Batal
            </a>

        </div>

    </form>

</div>

@endsection