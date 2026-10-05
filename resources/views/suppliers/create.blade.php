@extends('layouts.app')

@section('title', 'Tambah Sumber Dana')

@section('content')

<div class="page-header">

    <div>
        <h1>Tambah Sumber Dana</h1>

        <div class="subtitle">
            Tambahkan data sumber dana baru
        </div>
    </div>

    <a
        href="{{ route('suppliers.index') }}"
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
        action="{{ route('suppliers.store') }}"
        method="POST"
    >

        @csrf

        <div class="form-group">

            <label for="name">
                Nama Sumber Dana
            </label>

            <input
                type="text"
                id="name"
                name="name"
                class="form-control"
                value="{{ old('name') }}"
                placeholder="Contoh: PT Sumber Makmur"
                required
            >

        </div>

        <div class="actions">

            <button
                type="submit"
                class="btn btn-primary"
            >
                Simpan Sumber Dana
            </button>

            <a
                href="{{ route('suppliers.index') }}"
                class="btn btn-secondary"
            >
                Batal
            </a>

        </div>

    </form>

</div>

@endsection