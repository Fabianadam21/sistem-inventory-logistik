@extends('layouts.app')

@section('title', 'Tambah Barang')

@section('content')

<div class="page-header">
    <div>
        <h1>Tambah Barang</h1>

        <div class="subtitle">
            Tambahkan data barang baru ke inventory
        </div>
    </div>

    <a
        href="{{ route('items.index') }}"
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
        action="{{ route('items.store') }}"
        method="POST"
    >

        @csrf

        <div class="form-group">

            <label for="code">
                Kode Barang
            </label>

            <input
                type="text"
                id="code"
                name="code"
                class="form-control"
                value="{{ old('code') }}"
                placeholder="Contoh: BRG-001"
                required
            >

        </div>


        <div class="form-group">

            <label for="name">
                Nama Barang
            </label>

            <input
                type="text"
                id="name"
                name="name"
                class="form-control"
                value="{{ old('name') }}"
                placeholder="Contoh: Kertas A4"
                required
            >

        </div>


        <div class="form-group">

            <label for="category_id">
                Kategori
            </label>

            <select
                id="category_id"
                name="category_id"
                class="form-control"
                required
            >

                <option value="">
                    -- Pilih Kategori --
                </option>

                @foreach($categories as $category)

                    <option
                        value="{{ $category->id }}"
                        {{ old('category_id') == $category->id ? 'selected' : '' }}
                    >
                        {{ $category->name }}
                    </option>

                @endforeach

            </select>

        </div>


        <div class="form-group">

            <label for="unit_id">
                Satuan
            </label>

            <select
                id="unit_id"
                name="unit_id"
                class="form-control"
                required
            >

                <option value="">
                    -- Pilih Satuan --
                </option>

                @foreach($units as $unit)

                    <option
                        value="{{ $unit->id }}"
                        {{ old('unit_id') == $unit->id ? 'selected' : '' }}
                    >
                        {{ $unit->name }}
                    </option>

                @endforeach

            </select>

        </div>


        <div class="form-group">

            <label for="supplier_id">
                Sumber Dana
            </label>

            <select
                id="supplier_id"
                name="supplier_id"
                class="form-control"
                required
            >

                <option value="">
                    -- Pilih Sumber Dana --
                </option>

                @foreach($suppliers as $supplier)

                    <option
                        value="{{ $supplier->id }}"
                        {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}
                    >
                        {{ $supplier->name }}
                    </option>

                @endforeach

            </select>

        </div>


        <div class="form-group">

            <label for="stock">
                Stok Awal
            </label>

            <input
                type="number"
                id="stock"
                name="stock"
                class="form-control"
                value="{{ old('stock', 0) }}"
                min="0"
                required
            >

        </div>


        <div class="form-group">

            <label for="minimum_stock">
                Minimum Stok
            </label>

            <input
                type="number"
                id="minimum_stock"
                name="minimum_stock"
                class="form-control"
                value="{{ old('minimum_stock', 0) }}"
                min="0"
                required
            >

        </div>


        <div class="form-group">

            <label for="price">
                Harga
            </label>

            <input
                type="number"
                id="price"
                name="price"
                class="form-control"
                value="{{ old('price') }}"
                min="0"
                step="0.01"
                placeholder="Contoh: 25000"
            >

        </div>


        <div class="form-group">

            <label for="description">
                Deskripsi
            </label>

            <textarea
                id="description"
                name="description"
                class="form-control"
                rows="4"
                placeholder="Keterangan tambahan barang"
            >{{ old('description') }}</textarea>

        </div>


        <div class="actions">

            <button
                type="submit"
                class="btn btn-primary"
            >
                Simpan Barang
            </button>

            <a
                href="{{ route('items.index') }}"
                class="btn btn-secondary"
            >
                Batal
            </a>

        </div>

    </form>

</div>

@endsection