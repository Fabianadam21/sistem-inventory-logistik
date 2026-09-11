<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Unit / Bidang</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fb;
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
            color: #1f2937;
        }

        .subtitle {
            color: #6b7280;
            margin-top: 7px;
        }

        .btn {
            display: inline-block;
            padding: 9px 14px;
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

        .btn-edit {
            background: #f59e0b;
            color: white;
        }

        .btn-delete {
            background: #dc2626;
            color: white;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 7px;
            margin-bottom: 20px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
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
        }

        th {
            background: #f9fafb;
        }

        .actions {
            display: flex;
            gap: 6px;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <div>
            <h1>Unit / Bidang</h1>
            <div class="subtitle">
                Kelola data unit atau bidang kerja
            </div>
        </div>

        <a href="{{ route('departments.create') }}" class="btn btn-primary">
            + Tambah Unit/Bidang
        </a>
    </div>

    @if(session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert error">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">

        <table>

            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Unit / Bidang</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($departments as $department)

                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $department->name }}
                        </td>

                        <td>
                            <div class="actions">

                                <a
                                    href="{{ route('departments.edit', $department) }}"
                                    class="btn btn-edit"
                                >
                                    Edit
                                </a>

                                <form
                                    action="{{ route('departments.destroy', $department) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus Unit/Bidang ini?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-delete"
                                    >
                                        Hapus
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="3" style="text-align:center;">
                            Belum ada data Unit/Bidang.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

</body>

</html>