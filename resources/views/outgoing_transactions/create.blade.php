@extends('layouts.app')

@section('title', 'Tambah Barang Keluar')

@section('content')

<div class="page-header">

    <div>
        <h1>Tambah Barang Keluar</h1>

        <div class="subtitle">
            Input transaksi barang yang keluar dari gudang
        </div>
    </div>

    <a
        href="{{ route('outgoing-transactions.index') }}"
        class="btn btn-secondary"
    >
        ← Kembali
    </a>

</div>


@if ($errors->any())

    <div class="alert alert-error">

        <strong>Terjadi kesalahan:</strong>

        <ul style="margin: 8px 0 0 18px;">

            @foreach ($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif


<form
    action="{{ route('outgoing-transactions.store') }}"
    method="POST"
>

    @csrf


    {{-- INFORMASI TRANSAKSI --}}

    <div class="card" style="margin-bottom:20px;">

        <h3 style="margin-top:0;">
            Informasi Transaksi
        </h3>

        <div class="form-group">

            <label for="transaction_number">
                No. Transaksi
            </label>

            <input
                type="text"
                id="transaction_number"
                name="transaction_number"
                class="form-control"
                value="{{ old('transaction_number') }}"
                placeholder="Contoh: BK-001"
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
                class="form-control"
                value="{{ old('date', date('Y-m-d')) }}"
                required
            >

        </div>


        <div class="form-group">

            <label for="department_id">
                Unit / Bidang
            </label>

            <select
                id="department_id"
                name="department_id"
                class="form-control"
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
                class="form-control"
                rows="3"
                placeholder="Keterangan transaksi (opsional)"
            >{{ old('description') }}</textarea>

        </div>

    </div>


    {{-- DETAIL BARANG --}}

    <div class="card">

        <div
            style="
                display:flex;
                justify-content:space-between;
                align-items:center;
                margin-bottom:20px;
            "
        >

            <div>

                <h3 style="margin:0;">
                    Detail Barang
                </h3>

                <div class="subtitle">
                    Pilih barang dan jumlah yang akan dikeluarkan
                </div>

            </div>


            <button
                type="button"
                class="btn btn-primary"
                onclick="addRow()"
            >
                + Tambah Barang
            </button>

        </div>


        <div id="items-container">

            <div class="detail-row">

                <div class="form-group">

                    <label>
                        Barang
                    </label>

                    <select
                        name="items[0][item_id]"
                        class="form-control item-select"
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

                        <strong class="stock-value">
                            -
                        </strong>

                    </div>

                </div>


                <div class="form-group">

                    <label>
                        Jumlah
                    </label>

                    <input
                        type="number"
                        name="items[0][quantity]"
                        class="form-control quantity-input"
                        min="1"
                        required
                        oninput="checkQuantity(this)"
                    >

                    <small class="stock-warning">
                    </small>

                </div>


                <div class="form-group">

                    <label>
                        Keterangan
                    </label>

                    <input
                        type="text"
                        name="items[0][description]"
                        class="form-control"
                        placeholder="Opsional"
                    >

                </div>


                <div class="delete-wrapper">

                    <button
                        type="button"
                        class="btn btn-danger"
                        onclick="removeRow(this)"
                    >
                        Hapus
                    </button>

                </div>

            </div>

        </div>

    </div>


    <div
        class="actions"
        style="margin-top:20px;"
    >

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
            Batal
        </a>

    </div>

</form>


<style>

    .detail-row {
        display: grid;
        grid-template-columns: 2fr 1fr 2fr auto;
        gap: 15px;
        padding: 18px;
        margin-bottom: 15px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        align-items: start;
    }

    .detail-row .form-group {
        margin-bottom: 0;
    }

    .stock-info {
        margin-top: 7px;
        font-size: 12px;
        color: #64748b;
    }

    .stock-value {
        color: #2563eb;
    }

    .stock-warning {
        display: block;
        margin-top: 6px;
        color: #dc2626;
        font-size: 12px;
        font-weight: 600;
    }

    .delete-wrapper {
        display: flex;
        align-items: end;
        height: 100%;
        padding-bottom: 18px;
    }

    @media (max-width: 900px) {

        .detail-row {
            grid-template-columns: 1fr;
        }

        .delete-wrapper {
            padding-bottom: 0;
        }

    }

</style>


<script>

    let rowIndex = 1;


    function addRow()
    {
        const container =
            document.getElementById('items-container');

        const row =
            document.createElement('div');

        row.className = 'detail-row';

        row.innerHTML = `
            <div class="form-group">

                <label>
                    Barang
                </label>

                <select
                    name="items[${rowIndex}][item_id]"
                    class="form-control item-select"
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
                    <strong class="stock-value">-</strong>

                </div>

            </div>


            <div class="form-group">

                <label>
                    Jumlah
                </label>

                <input
                    type="number"
                    name="items[${rowIndex}][quantity]"
                    class="form-control quantity-input"
                    min="1"
                    required
                    oninput="checkQuantity(this)"
                >

                <small class="stock-warning"></small>

            </div>


            <div class="form-group">

                <label>
                    Keterangan
                </label>

                <input
                    type="text"
                    name="items[${rowIndex}][description]"
                    class="form-control"
                    placeholder="Opsional"
                >

            </div>


            <div class="delete-wrapper">

                <button
                    type="button"
                    class="btn btn-danger"
                    onclick="removeRow(this)"
                >
                    Hapus
                </button>

            </div>
        `;

        container.appendChild(row);

        rowIndex++;
    }


    function removeRow(button)
    {
        const rows =
            document.querySelectorAll('.detail-row');

        if (rows.length <= 1) {

            alert('Minimal harus ada satu barang.');

            return;
        }

        button
            .closest('.detail-row')
            .remove();
    }


    function showStock(select)
    {
        const row =
            select.closest('.detail-row');

        const selectedOption =
            select.options[select.selectedIndex];

        const stock =
            selectedOption.dataset.stock || 0;

        const stockValue =
            row.querySelector('.stock-value');

        stockValue.textContent = stock;

        const quantity =
            row.querySelector('.quantity-input');

        quantity.max = stock;

        checkQuantity(quantity);
    }


    function checkQuantity(input)
    {
        const row =
            input.closest('.detail-row');

        const select =
            row.querySelector('.item-select');

        const selectedOption =
            select.options[select.selectedIndex];

        if (!selectedOption) {
            return;
        }

        const stock =
            Number(selectedOption.dataset.stock || 0);

        const quantity =
            Number(input.value || 0);

        const warning =
            row.querySelector('.stock-warning');

        if (quantity > stock) {

            warning.textContent =
                'Jumlah melebihi stok yang tersedia.';

            input.setCustomValidity(
                'Jumlah melebihi stok tersedia.'
            );

        } else {

            warning.textContent = '';

            input.setCustomValidity('');
        }
    }

</script>

@endsection