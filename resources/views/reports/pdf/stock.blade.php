<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <title>Laporan Stok</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            margin-bottom: 20px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #444;
            padding: 7px;
        }

        th {
            background: #eeeeee;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>

<h2>LAPORAN STOK BARANG</h2>

<div class="subtitle">
    Sistem Informasi Inventory Logistik
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
            <th>Minimum</th>
            <th>Status</th>
        </tr>

    </thead>

    <tbody>

        @foreach($items as $item)

            <tr>

                <td class="text-center">
                    {{ $loop->iteration }}
                </td>

                <td>
                    {{ $item->code }}
                </td>

                <td>
                    {{ $item->name }}
                </td>

                <td>
                    {{ $item->category->name ?? '-' }}
                </td>

                <td>
                    {{ $item->unit->name ?? '-' }}
                </td>

                <td>
                    {{ $item->warehouse->name ?? '-' }}
                </td>

                <td class="text-center">
                    {{ $item->stock }}
                </td>

                <td class="text-center">
                    {{ $item->minimum_stock }}
                </td>

                <td class="text-center">

                    {{ $item->stock <= $item->minimum_stock
                        ? 'Menipis'
                        : 'Aman' }}

                </td>

            </tr>

        @endforeach

    </tbody>

</table>

</body>

</html>