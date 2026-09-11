<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Barang Keluar</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fb;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 1000px;
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

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
            color: #374151;
        }

        input,
        select,
        textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            font-size: 14px;
        }

        textarea {
            min-height: 90px;
            resize: vertical;
        }

        .detail-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .detail-header h3 {
            margin: 0;
            color: #374151;
        }

        .detail-row {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr auto;
            gap: 12px;
            align-items: end;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e5e7eb;
        }

        .stock-info {
            font-size: 12px;
            color: #6b7280;
            margin-top: 5px;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 7px;
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
            background: #6b7280;
            color: white;
        }

        .btn-add {
            background: #16a34a;
            color: white;
        }

        .btn-delete {
            background: #dc2626;
            color: white;
        }

        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .alert {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 7px;
            margin-bottom: 20px;
        }

        @media (max-width: 700px) {
            body {
                padding: 20px;
            }

            .detail-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Tambah Barang Keluar</h1>

    <div class="subtitle">
        Input transaksi barang yang keluar dari gudang
    </div>

    @if ($errors->any())
        <div class="alert">
            <strong>Terjadi kesalahan:</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('outgoing-transactions.store') }}" method="POST">

        @csrf

        <!-- INFORMASI TRANSAKSI -->
        <div class="card">

            <h3>Informasi Transaksi</h3>

            <div class="form-group">
                <label for="transaction_number">
                    No. Transaksi
                </label>

                <input
                    type="text"
                    id="transaction_number"
                    name="transaction_number"
                    value="{{ old('transaction_number') }}"
                    placeholder="Contoh: BKL-2026-001"
                    required
                >
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
            </div>

            <div class="form-group">
                <label for="department_id">
                    Unit / Bidang Tujuan
                </label>

                <select
                    id="department_id"
                    name="department_id"
                    required
                >
                    <option value="">
                        -- Pilih Unit / Bidang --
                    </option>

                    @foreach ($departments as $department)
                        <option
                            value="{{ $department->id }}"
                            {{ old('department_id') == $department->id ? 'selected' : '' }}
                        >
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="description">
                    Keterangan
                </label>

                <textarea
                    id="description"
                    name="description"
                    placeholder="Keterangan transaksi (opsional)"
                >{{ old('description') }}</textarea>
            </div>

        </div>


        <!-- DETAIL BARANG -->
        <div class="card">

            <div class="detail-header">
                <h3>Detail Barang</h3>

                <button
                    type="button"
                    class="btn btn-add"
                    onclick="addRow()"
                >
                    + Tambah Barang
                </button>
            </div>

            <div id="items-container">

                <div class="detail-row">

                    <div>
                        <label>Barang</label>

                        <select
                            name="items[0][item_id]"
                            class="item-select"
                            onchange="showStock(this)"
                            required
                        >
                            <option value="">
                                -- Pilih Barang --
                            </option>

                            @foreach ($items as $item)
                                <option
                                    value="{{ $item->id }}"
                                    data-stock="{{ $item->stock }}"
                                >
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>

                        <div class="stock-info">
                            Stok tersedia:
                            <span class="stock-value">-</span>
                        </div>
                    </div>

                    <div>
                        <label>Jumlah</label>

                        <input
                            type="number"
                            name="items[0][quantity]"
                            min="1"
                            required
                        >
                    </div>

                    <div>
                        <label>Keterangan</label>

                        <input
                            type="text"
                            name="items[0][description]"
                            placeholder="Opsional"
                        >
                    </div>

                    <div>
                        <!-- Baris pertama tidak bisa dihapus -->
                    </div>

                </div>

            </div>

        </div>


        <!-- BUTTON -->
        <div class="buttons">

            <button
                type="submit"
                class="btn btn-primary"
            >
                Simpan Transaksi
            </button>

            <a
                href="{{ route('outgoing-transactions.index') }}"
                class="btn btn-secondary"
            >
                Kembali
            </a>

        </div>

    </form>

</div>


<script>

let rowIndex = 1;

function addRow()
{
    const container = document.getElementById('items-container');

    const row = document.createElement('div');

    row.className = 'detail-row';

    row.innerHTML = `
        <div>
            <label>Barang</label>

            <select
                name="items[${rowIndex}][item_id]"
                class="item-select"
                onchange="showStock(this)"
                required
            >
                <option value="">
                    -- Pilih Barang --
                </option>

                @foreach ($items as $item)
                    <option
                        value="{{ $item->id }}"
                        data-stock="{{ $item->stock }}"
                    >
                        {{ $item->name }}
                    </option>
                @endforeach

            </select>

            <div class="stock-info">
                Stok tersedia:
                <span class="stock-value">-</span>
            </div>
        </div>

        <div>
            <label>Jumlah</label>

            <input
                type="number"
                name="items[${rowIndex}][quantity]"
                min="1"
                required
            >
        </div>

        <div>
            <label>Keterangan</label>

            <input
                type="text"
                name="items[${rowIndex}][description]"
                placeholder="Opsional"
            >
        </div>

        <div>
            <button
                type="button"
                class="btn btn-delete"
                onclick="this.closest('.detail-row').remove()"
            >
                Hapus
            </button>
        </div>
    `;

    container.appendChild(row);

    rowIndex++;
}


function showStock(select)
{
    const selectedOption =
        select.options[select.selectedIndex];

    const stock =
        selectedOption.dataset.stock || '-';

    const stockValue =
        select.parentElement.querySelector('.stock-value');

    stockValue.textContent = stock;
}

</script>

</body>
</html>
