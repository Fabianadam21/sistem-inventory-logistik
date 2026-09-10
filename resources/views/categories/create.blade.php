<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Kategori - SIMLOG</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 700px;
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
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input,
        textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 11px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 15px;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
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
            font-size: 14px;
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

        <h1>Tambah Kategori</h1>

        <p>Masukkan kategori barang baru.</p>

       <form action="{{ route('categories.store') }}" method="POST">

    @csrf

    <div class="form-group">
        <label for="name">Nama Kategori</label>

        <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name') }}"
            placeholder="Contoh: Alat Tulis Kantor"
            required
        >

        @error('name')
            <small style="color: red;">
                {{ $message }}
            </small>
        @enderror
    </div>

    <div class="buttons">

        <button type="submit" class="btn btn-primary">
            Simpan Kategori
        </button>

        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
            Kembali
        </a>

    </div>

</form>

    </div>

</div>

</body>
</html>