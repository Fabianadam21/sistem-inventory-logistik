<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Barang Keluar</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f6f8;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
        }

        h1 {
            margin-bottom: 5px;
        }

        .subtitle {
            color: #666;
            margin-bottom: 25px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .info-grid {
            display: grid;
            grid-template-columns: 180px 1fr;
            gap: 12px;
        }

        .label {
            font-weight: bold;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #f1f3f5;
        }

        .buttons {
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 6px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Detail Barang Keluar</h1>

    <div class="subtitle">
        Informasi lengkap transaksi barang keluar
    </div>

    <div class="card">

        <div class="info-grid">

            <div class="label">
                No. Transaksi
            </div>

            <div>
                {{ $outgoingTransaction->transaction_number }}
            </div>


            <div class="label">
                Tanggal
            </div>

            <div>
                {{ $outgoingTransaction->date->format('d-m-Y') }}
            </div>


            <div class="label">
                Unit / Bidang
            </div>

            <div>
                {{ $outgoingTransaction->department->name }}
            </div>


            <div class="label">
                Keterangan
            </div>

            <div>
                {{ $outgoingTransaction->description ?: '-' }}
            </div>

        </div>

    </div>


    <div class="card">

        <h3>Detail Barang</h3>

        <table>

            <thead>
                <tr>
                    <th>No</th>
                    <th>Barang</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($outgoingTransaction->details as $index => $detail)

                    <tr>

                        <td>
                            {{ $index + 1 }}
                        </td>

                        <td>
                            {{ $detail->item->name }}
                        </td>

                        <td>
                            {{ $detail->quantity }}
                        </td>

                        <td>
                            {{ $detail->description ?: '-' }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="4">
                            Tidak ada detail barang.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    <div class="buttons">

        <a
            href="{{ route('outgoing-transactions.index') }}"
            class="btn btn-secondary"
        >
            ← Kembali
        </a>

    </div>

</div>

</body>
</html>