<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Barang - SIMLOG</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 1200px;
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
    </style>
</head>

<body>

<div class="container">
    @if (session('success'))
        <div style="
            background: #dcfce7;
            color: #166534;
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
        ">
            {{ session('success') }}
        </div>
    @endif
    <div class="header">
        <div>
            <h1>Data Barang</h1>
            <p>Kelola data inventory barang</p>
        </div>

        <a href="{{ route('items.create') }}" class="btn">
            + Tambah Barang
        </a>
    </div>

    <table>

        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Satuan</th>
                <th>Gudang</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($items as $item)

                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category->name ?? '-' }}</td>
                    <td>{{ $item->unit->name ?? '-' }}</td>
                    <td>{{ $item->warehouse->name ?? '-' }}</td>
                    <td>{{ $item->stock }}</td>

                    <td>
                        <a href="{{ route('items.edit', $item) }}">
                            Edit
                        </a>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="8" style="text-align:center;">
                        Belum ada data barang.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>

</body>
</html>