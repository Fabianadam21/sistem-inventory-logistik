@extends('layouts.app')

@section('title', 'Edit Barang')

@section('content')

<div class="page-header">

    <div>
        <h1>Edit Barang</h1>

        <div class="subtitle">
            Perbarui informasi data barang
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
        action="{{ route('items.update', $item->id) }}"
        method="POST"
    >

        @csrf
        @method('PUT')


        <div class="form-group">

            <label for="code">
                Kode Barang
            </label>

            <input
                type="text"
                id="code"
                name="code"
                class="form-control"
                value="{{ old('code', $item->code) }}"
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
                value="{{ old('name', $item->name) }}"
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
                        {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}
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
                        {{ old('unit_id', $item->unit_id) == $unit->id ? 'selected' : '' }}
                    >
                        {{ $unit->name }}
                    </option>

                @endforeach

            </select>

        </div>


        <div class="form-group">

            <label for="warehouse_id">
                Gudang
            </label>

            <select
                id="warehouse_id"
                name="warehouse_id"
                class="form-control"
                required
            >

                <option value="">
                    -- Pilih Gudang --
                </option>

                @foreach($warehouses as $warehouse)

                    <option
                        value="{{ $warehouse->id }}"
                        {{ old('warehouse_id', $item->warehouse_id) == $warehouse->id ? 'selected' : '' }}
                    >
                        {{ $warehouse->name }}
                    </option>

                @endforeach

            </select>

        </div>


        <div class="form-group">

            <label for="stock">
                Stok
            </label>

            <input
                type="number"
                id="stock"
                name="stock"
                class="form-control"
                value="{{ old('stock', $item->stock) }}"
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
                value="{{ old('minimum_stock', $item->minimum_stock) }}"
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
                value="{{ old('price', $item->price) }}"
                min="0"
                step="0.01"
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
            >{{ old('description', $item->description) }}</textarea>

        </div>


        <div class="actions">

            <button
                type="submit"
                class="btn btn-primary"
            >
                Simpan Perubahan
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