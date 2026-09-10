<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kategori - SIMLOG</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 900px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        h1 {
            margin: 0;
        }

        .btn {
            background: #2563eb;
            color: white;
            padding: 10px 18px;
            border-radius: 6px;
            text-decoration: none;
        }

        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            box-shadow: 0 2px 10px rgba(0,0,0,.05);
        }

        th, td {
            padding: 14px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        th {
            background: #f8fafc;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

<div class="container">

    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <div class="header">
        <div>
            <h1>Kategori Barang</h1>
            <p>Kelola kategori barang inventory</p>
        </div>

        <a href="{{ route('categories.create') }}" class="btn">
            + Tambah Kategori
        </a>
    </div>

    <table>

        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($categories as $category)

                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        <a href="{{ route('categories.edit', $category) }}">
                            Edit
                        </a>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="3" style="text-align:center;">
                        Belum ada kategori.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>

</body>
</html>