<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Barang Masuk - SIMLOG</title>

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
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,.05);
            margin-bottom: 20px;
        }

        h1 {
            margin-top: 0;
            margin-bottom: 5px;
        }

        .subtitle {
            color: #6b7280;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
        }

        textarea {
            min-height: 90px;
            resize: vertical;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: #2563eb;
        }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .detail-table th,
        .detail-table td {
            padding: 10px;
            border: 1px solid #e5e7eb;
        }

        .detail-table th {
            background: #f9fafb;
            text-align: left;
        }

        .detail-table input,
        .detail-table select {
            width: 100%;
        }

        .btn {
            padding: 10px 16px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #374151;
        }

        .btn-danger {
            background: #dc2626;
            color: white;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 5px;
        }

        .add-row {
            margin-top: 15px;
        }

        @media (max-width: 700px) {
            .row {
                grid-template-columns: 1fr;
            }

            .detail-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="card">

        <h1>Tambah Barang Masuk</h1>

        <p class="subtitle">
            Input transaksi barang yang masuk ke gudang.
        </p>

        <form
            action="{{ route('incoming-transactions.store') }}"
            method="POST"
        >

            @csrf

            <div class="row">

                <div class="form-group">

                    <label for="transaction_number">
                        No. Transaksi
                    </label>

                    <input
                        type="text"
                        id="transaction_number"
                        name="transaction_number"
                        value="{{ old('transaction_number') }}"
                        placeholder="Contoh: BM-001"
                        required
                    >

                    @error('transaction_number')
                        <div class="error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="form-group">

                    <label for="date">
                        Tanggal
                    </label>

                    <input
                        type="date"
                        id="date"
                        name="date"
                        value="{{ old('date', date('Y-m-d')) }}"
                        required
                    >

                    @error('date')
                        <div class="error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

            </div>

            <div class="form-group">

                <label for="supplier_id">
                    Supplier
                </label>

                <select
                    id="supplier_id"
                    name="supplier_id"
                    required
                >

                    <option value="">
                        -- Pilih Supplier --
                    </option>

                    @foreach($suppliers as $supplier)

                        <option
                            value="{{ $supplier->id }}"
                            {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}
                        >
                            {{ $supplier->name }}
                        </option>

                    @endforeach

                </select>

                @error('supplier_id')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="form-group">

                <label for="description">
                    Keterangan
                </label>

                <textarea
                    id="description"
                    name="description"
                    placeholder="Keterangan transaksi..."
                >{{ old('description') }}</textarea>

                @error('description')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror

            </div>

    </div>


    <div class="card">

        <h2>Detail Barang</h2>

        <p class="subtitle">
            Masukkan barang dan jumlah yang diterima.
        </p>

        <table class="detail-table">

            <thead>
                <tr>
                    <th width="45%">Barang</th>
                    <th width="20%">Jumlah</th>
                    <th width="25%">Harga</th>
                    <th width="10%">Aksi</th>
                </tr>
            </thead>

            <tbody id="detail-container">

                <tr>

                    <td>

                        <select
                            name="items[0][item_id]"
                            required
                        >

                            <option value="">
                                -- Pilih Barang --
                            </option>

                            @foreach($items as $item)

                                <option value="{{ $item->id }}">
                                    {{ $item->code }} - {{ $item->name }}
                                </option>

                            @endforeach

                        </select>

                    </td>

                    <td>

                        <input
                            type="number"
                            name="items[0][quantity]"
                            min="1"
                            required
                        >

                    </td>

                    <td>

                        <input
                            type="number"
                            name="items[0][price]"
                            min="0"
                            step="0.01"
                            placeholder="0"
                        >

                    </td>

                    <td>
                        -
                    </td>

                </tr>

            </tbody>

        </table>

        <button
            type="button"
            class="btn btn-secondary add-row"
            onclick="addRow()"
        >
            + Tambah Barang
        </button>

        <div class="actions">

            <button
                type="submit"
                class="btn btn-primary"
            >
                Simpan Transaksi
            </button>

            <a
                href="{{ route('incoming-transactions.index') }}"
                class="btn btn-secondary"
            >
                Kembali
            </a>

        </div>

        </form>

    </div>

</div>


<script>

let rowIndex = 1;

function addRow()
{
    const container =
        document.getElementById('detail-container');

    const row =
        document.createElement('tr');

    row.innerHTML = `
        <td>

            <select
                name="items[${rowIndex}][item_id]"
                required
            >

                <option value="">
                    -- Pilih Barang --
                </option>

                @foreach($items as $item)

                    <option value="{{ $item->id }}">
                        {{ $item->code }} - {{ $item->name }}
                    </option>

                @endforeach

            </select>

        </td>

        <td>

            <input
                type="number"
                name="items[${rowIndex}][quantity]"
                min="1"
                required
            >

        </td>

        <td>

            <input
                type="number"
                name="items[${rowIndex}][price]"
                min="0"
                step="0.01"
                placeholder="0"
            >

        </td>

        <td>

            <button
                type="button"
                class="btn btn-danger"
                onclick="removeRow(this)"
            >
                Hapus
            </button>

        </td>
    `;

    container.appendChild(row);

    rowIndex++;
}

function removeRow(button)
{
    button.closest('tr').remove();
}

</script>

</body>

</html>