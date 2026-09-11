<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Barang Keluar</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fb;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 1100px;
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
            color: #1f2937;
        }

        .subtitle {
            color: #6b7280;
            margin-top: 7px;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 7px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-detail {
            background: #2563eb;
            color: white;
        }

        .btn-detail:hover {
            background: #1d4ed8;
        }

        .alert {
            background: #dcfce7;
            color: #166534;
            padding: 12px 16px;
            border-radius: 7px;
            margin-bottom: 20px;
        }

        .card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 13px 12px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
            white-space: nowrap;
        }

        th {
            background: #f9fafb;
            color: #374151;
        }

        td {
            color: #4b5563;
        }

        .empty {
            text-align: center;
            padding: 40px;
            color: #9ca3af;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="header">
            <div>
                <h1>Barang Keluar</h1>
                <div class="subtitle">
                    Kelola transaksi barang keluar
                </div>
            </div>

            <a href="{{ route('outgoing-transactions.create') }}" class="btn btn-primary">
                + Barang Keluar
            </a>
        </div>

        @if(session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No. Transaksi</th>
                        <th>Tanggal</th>
                        <th>Unit Kerja</th>
                        <th>Jumlah Item</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($transactions as $transaction)

                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $transaction->transaction_number }}
                            </td>

                            <td>
                                {{ $transaction->date->format('d-m-Y') }}
                            </td>

                            <td>
                                {{ $transaction->department->name }}
                            </td>

                            <td>
                                {{ $transaction->details->count() }}
                            </td>

                            <td>
                                <a href="{{ route('outgoing-transactions.show', $transaction) }}" class="btn btn-detail">
                                    Detail
                                </a>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="empty">
                                Belum ada transaksi barang keluar.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</body>

</html>