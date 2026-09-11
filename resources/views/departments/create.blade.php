<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Unit / Bidang</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fb;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 700px;
            margin: auto;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        h1 {
            margin-top: 0;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 11px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            margin-bottom: 18px;
        }

        .btn {
            padding: 10px 16px;
            border: none;
            border-radius: 7px;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 7px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Tambah Unit / Bidang</h1>

    <div class="card">

        @if($errors->any())

            <div class="error">

                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        @endif

        <form
            action="{{ route('departments.store') }}"
            method="POST"
        >

            @csrf

            <label>
                Nama Unit / Bidang
            </label>

            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                placeholder="Contoh: Sekretariat"
                required
            >

            <button
                type="submit"
                class="btn btn-primary"
            >
                Simpan
            </button>

            <a
                href="{{ route('departments.index') }}"
                class="btn btn-secondary"
            >
                Kembali
            </a>

        </form>

    </div>

</div>

</body>

</html>