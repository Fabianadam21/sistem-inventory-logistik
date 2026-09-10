<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Supplier - SIMLOG</title>

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

        .header h1 {
            margin: 0 0 5px;
            font-size: 28px;
        }

        .header p {
            margin: 0;
            color: #6b7280;
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

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        th {
            background: #f9fafb;
            font-size: 14px;
        }

        td {
            font-size: 14px;
        }

        .empty {
            text-align: center;
            color: #6b7280;
            padding: 30px;
        }

        .alert {
            background: #dcfce7;
            color: #166534;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        @media (max-width: 600px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">

        <div>
            <h1>Supplier</h1>

            <p>
                Kelola data supplier barang
            </p>
        </div>

        <a
            href="{{ route('suppliers.create') }}"
            class="btn btn-primary"
        >
            + Tambah Supplier
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
                    <th width="80">No</th>
                    <th>Nama Supplier</th>
                    <th width="150">Aksi</th>
                </tr>

            </thead>

            <tbody>

                @forelse($suppliers as $supplier)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $supplier->name }}
                        </td>

                        <td>
                            <span style="color:#6b7280;">
                                -
                            </span>
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="3"
                            class="empty"
                        >
                            Belum ada data supplier.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

</body>

</html>