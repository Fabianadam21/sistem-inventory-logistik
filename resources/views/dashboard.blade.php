@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard SIMLOG</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fb;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        h1 {
            margin-bottom: 5px;
            color: #1f2937;
        }

        .subtitle {
            color: #6b7280;
            margin-bottom: 25px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 25px;
        }

        .card {
            background: white;
            padding: 22px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .card-title {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .card-value {
            font-size: 28px;
            font-weight: bold;
            color: #1f2937;
        }

        .section {
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }

        th {
            background: #f9fafb;
        }

        .warning {
            color: #dc2626;
            font-weight: bold;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Dashboard SIMLOG</h1>

    <div class="subtitle">
        Sistem Informasi Inventory Logistik
    </div>

    <div class="cards">

        <div class="card">
            <div class="card-title">
                Total Jenis Barang
            </div>

            <div class="card-value">
                {{ $totalItems }}
            </div>
        </div>

        <div class="card">
            <div class="card-title">
                Total Stok
            </div>

            <div class="card-value">
                {{ $totalStock }}
            </div>
        </div>

        <div class="card">
            <div class="card-title">
                Transaksi Barang Masuk
            </div>

            <div class="card-value">
                {{ $totalIncoming }}
            </div>
        </div>

        <div class="card">
            <div class="card-title">
                Transaksi Barang Keluar
            </div>

            <div class="card-value">
                {{ $totalOutgoing }}
            </div>
        </div>

    </div>

    <div class="section">

        <div class="card">

            <h3>Stok Menipis</h3>

            <table>

                <thead>
                    <tr>
                        <th>Barang</th>
                        <th>Stok</th>
                        <th>Minimum</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($lowStockItems as $item)

                        <tr>
                            <td>
                                {{ $item->name }}
                            </td>

                            <td class="warning">
                                {{ $item->stock }}
                            </td>

                            <td>
                                {{ $item->minimum_stock }}
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="3">
                                Tidak ada barang dengan stok menipis.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="grid">

        <div class="card">

            <h3>Barang Masuk Terbaru</h3>

            <table>

                <thead>
                    <tr>
                        <th>No. Transaksi</th>
                        <th>Supplier</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($recentIncoming as $transaction)

                        <tr>
                            <td>
                                {{ $transaction->transaction_number }}
                            </td>

                            <td>
                                {{ $transaction->supplier->name }}
                            </td>

                            <td>
                                {{ $transaction->date->format('d-m-Y') }}
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="3">
                                Belum ada transaksi.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="card">

            <h3>Barang Keluar Terbaru</h3>

            <table>

                <thead>
                    <tr>
                        <th>No. Transaksi</th>
                        <th>Unit</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($recentOutgoing as $transaction)

                        <tr>
                            <td>
                                {{ $transaction->transaction_number }}
                            </td>

                            <td>
                                {{ $transaction->department->name }}
                            </td>

                            <td>
                                {{ $transaction->date->format('d-m-Y') }}
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="3">
                                Belum ada transaksi.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>

</html>


@endsection