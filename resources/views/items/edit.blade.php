<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Barang - SIMLOG</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f7fb;
            color: #1f2937;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        h1 {
            margin-top: 0;
            margin-bottom: 5px;
        }

        .subtitle {
            color: #6b7280;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            font-family: Arial, sans-serif;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #2563eb;
        }

        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .btn {
            padding: 11px 18px;
            border-radius: 8px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #374151;
        }

        .error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 5px;
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 600px) {
            .row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="card">

        <h1>Edit Barang</h1>

        <p class="subtitle">
            Perbarui informasi data barang inventory.
        </p>

        <form action="{{ route('items.update', $item->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="row">

                <div class="form-group">

                    <label for="code">
                        Kode Barang
                    </label>

                    <input
                        type="text"
                        id="code"
                        name="code"
                        value="{{ old('code', $item->code) }}"
                        required
                    >

                    @error('code')
                        <div class="error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="form-group">

                    <label for="name">
                        Nama Barang
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $item->name) }}"
                        required
                    >

                    @error('name')
                        <div class="error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>

            <div class="row">

                <div class="form-group">

                    <label for="category_id">
                        Kategori
                    </label>

                    <select id="category_id" name="category_id" required>

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

                    @error('category_id')
                        <div class="error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="form-group">

                    <label for="unit_id">
                        Satuan
                    </label>

                    <select id="unit_id" name="unit_id" required>

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

                    @error('unit_id')
                        <div class="error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>

            <div class="form-group">

                <label for="warehouse_id">
                    Gudang
                </label>

                <select id="warehouse_id" name="warehouse_id" required>

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

                @error('warehouse_id')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="row">

                <div class="form-group">

                    <label for="stock">
                        Stok
                    </label>

                    <input
                        type="number"
                        id="stock"
                        name="stock"
                        value="{{ old('stock', $item->stock) }}"
                        min="0"
                        required
                    >

                    @error('stock')
                        <div class="error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="form-group">

                    <label for="minimum_stock">
                        Minimum Stok
                    </label>

                    <input
                        type="number"
                        id="minimum_stock"
                        name="minimum_stock"
                        value="{{ old('minimum_stock', $item->minimum_stock) }}"
                        min="0"
                        required
                    >

                    @error('minimum_stock')
                        <div class="error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>

            <div class="form-group">

                <label for="price">
                    Harga
                </label>

                <input
                    type="number"
                    id="price"
                    name="price"
                    value="{{ old('price', $item->price) }}"
                    min="0"
                    step="0.01"
                    placeholder="Contoh: 25000"
                >

                @error('price')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="form-group">

                <label for="description">
                    Keterangan
                </label>

                <textarea
                    id="description"
                    name="description"
                    placeholder="Keterangan barang..."
                >{{ old('description', $item->description) }}</textarea>

                @error('description')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="buttons">

                <button type="submit" class="btn btn-primary">
                    Simpan Perubahan
                </button>

                <a
                    href="{{ route('items.index') }}"
                    class="btn btn-secondary"
                >
                    Kembali
                </a>

            </div>

        </form>

    </div>

</div>

</body>
</html>