<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Barang - SIMLOG</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 800px;
            margin: auto;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,.05);
        }

        h1 {
            margin-top: 0;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input, select, textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 15px;
        }

        textarea {
            min-height: 100px;
        }

        .buttons {
            margin-top: 25px;
        }

        .btn {
            display: inline-block;
            padding: 10px 18px;
            border-radius: 6px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #111827;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="card">

        <h1>Tambah Data Barang</h1>
        <p>Masukkan informasi barang baru.</p>

        <form action="{{ route('items.store') }}" method="POST">

            @csrf

            <div class="form-group">
                <label>Kode Barang</label>
                <input type="text" name="code" required>
            </div>

            <div class="form-group">
                <label>Nama Barang</label>
                <input type="text" name="name" required>
            </div>

            <div class="form-group">
                <label>Kategori</label>

                <select name="category_id" required>
                    <option value="">-- Pilih Kategori --</option>

                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Satuan</label>

                <select name="unit_id" required>
                    <option value="">-- Pilih Satuan --</option>

                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}">
                            {{ $unit->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Gudang</label>

                <select name="warehouse_id" required>
                    <option value="">-- Pilih Gudang --</option>

                    @foreach ($warehouses as $warehouse)
                        <option value="{{ $warehouse->id }}">
                            {{ $warehouse->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Stok Awal</label>
                <input type="number" name="stock" min="0" value="0" required>
            </div>

            <div class="form-group">
                <label>Minimum Stok</label>
                <input type="number" name="minimum_stock" min="0" value="0" required>
            </div>

            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="price" min="0" step="0.01">
            </div>

            <div class="form-group">
                <label>Keterangan</label>
                <textarea name="description"></textarea>
            </div>

            <div class="buttons">

                <button type="submit" class="btn btn-primary">
                    Simpan Barang
                </button>

                <a href="{{ route('items.index') }}" class="btn btn-secondary">
                    Kembali
                </a>

            </div>

        </form>

    </div>

</div>

</body>
</html>