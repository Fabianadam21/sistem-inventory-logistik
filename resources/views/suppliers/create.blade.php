<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Supplier - SIMLOG</title>

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
            max-width: 700px;
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

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
        }

        input:focus {
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
    </style>
</head>

<body>

<div class="container">

    <div class="card">

        <h1>Tambah Supplier</h1>

        <p class="subtitle">
            Tambahkan supplier baru ke sistem inventory.
        </p>

        <form
            action="{{ route('suppliers.store') }}"
            method="POST"
        >

            @csrf

            <div class="form-group">

                <label for="name">
                    Nama Supplier
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Contoh: PT Sumber Makmur"
                    required
                >

                @error('name')

                    <div class="error">
                        {{ $message }}
                    </div>

                @enderror

            </div>

            <div class="buttons">

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Simpan Supplier
                </button>

                <a
                    href="{{ route('suppliers.index') }}"
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