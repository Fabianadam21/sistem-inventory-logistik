<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Barang Masuk - SIMLOG</title>

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
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        h1 {
            margin: 0 0 5px;
        }

        .subtitle {
            margin: 0;
            color: #6b7280;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,.05);
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
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

        .alert {
            background: #dcfce7;
            color: #166534;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 14px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }

        th {
            background: #f9fafb;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #6b7280;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">

        <div>
            <h1>Barang Masuk</h1>

            <p class="subtitle">
                Kelola transaksi barang masuk
            </p>
        </div>

        <a
            href="{{ route('incoming-transactions.create') }}"
            class="btn btn-primary"
        >
            + Barang Masuk
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
                    <th>Supplier</th>
                    <th>Jumlah Item</th>
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
                            {{ $transaction->supplier->name }}
                        </td>

                        <td>
                            {{ $transaction->details->count() }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="5"
                            class="empty"
                        >
                            Belum ada transaksi barang masuk.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

</body>

</html>