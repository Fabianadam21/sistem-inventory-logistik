<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Persediaan Barang - {{ $period_title }}</title>
    <style>
        @page {
            size: landscape;
            margin: 8mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 6px;
        }

        h2 {
            margin: 0 0 3px;
            text-align: center;
            font-size: 13px;
        }

        .subtitle {
            margin-bottom: 12px;
            color: #555;
            text-align: center;
            font-size: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 3px 2px;
            border: 1px solid #777;
        }

        th {
            background: #f2edda;
            text-align: center;
        }

        td.numeric {
            text-align: right;
            white-space: nowrap;
        }

        thead {
            display: table-header-group;
        }

        tr {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>
    <h2>LAPORAN PERSEDIAAN BARANG</h2>
    <div class="subtitle">Sistem Informasi Inventory Logistik · {{ $period_title }}</div>

    <table>
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Kode</th>
                <th rowspan="2">Nama Barang</th>
                <th rowspan="2">Kategori</th>
                <th rowspan="2">Satuan</th>
                <th rowspan="2">Sumber Dana</th>
                <th rowspan="2">{{ $opening_stock_label }}</th>
                @foreach($months as $month)
                    <th colspan="2">{{ $month['name'] }}</th>
                @endforeach
                <th rowspan="2">Total Barang Masuk</th>
                <th rowspan="2">Total Barang Keluar</th>
                <th rowspan="2">Buffer Stock</th>
                <th rowspan="2">Harga Satuan</th>
                <th rowspan="2">Total Harga</th>
                <th rowspan="2">Minimum</th>
                <th rowspan="2">Status</th>
            </tr>
            <tr>
                @foreach($months as $month)
                    <th>Masuk</th>
                    <th>Keluar</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category->name ?? '-' }}</td>
                    <td>{{ $item->unit->name ?? '-' }}</td>
                    <td>{{ $item->supplier->name ?? '-' }}</td>
                    <td class="numeric">{{ number_format($item->opening_stock, 0, ',', '.') }}</td>
                    @foreach($months as $month)
                        <td class="numeric">{{ number_format($item->monthly_movements[$month['number']]['incoming'], 0, ',', '.') }}</td>
                        <td class="numeric">{{ number_format($item->monthly_movements[$month['number']]['outgoing'], 0, ',', '.') }}</td>
                    @endforeach
                    <td class="numeric">{{ number_format($item->total_incoming, 0, ',', '.') }}</td>
                    <td class="numeric">{{ number_format($item->total_outgoing, 0, ',', '.') }}</td>
                    <td class="numeric">{{ number_format($item->buffer_stock, 0, ',', '.') }}</td>
                    <td class="numeric">
                        {{ $item->price !== null ? 'Rp ' . number_format((float) $item->price, 0, ',', '.') : '-' }}
                    </td>
                    <td class="numeric">
                        {{ $item->total_value !== null ? 'Rp ' . number_format($item->total_value, 0, ',', '.') : '-' }}
                    </td>
                    <td class="numeric">{{ number_format($item->minimum_stock, 0, ',', '.') }}</td>
                    <td>{{ $item->buffer_stock <= $item->minimum_stock ? 'Menipis' : 'Aman' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
