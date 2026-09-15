@extends('layouts.app')

@section('title', 'Tambah Barang Masuk')

@section('content')

<div class="page-header">

    <div>
        <h1>Tambah Barang Masuk</h1>

        <div class="subtitle">
            Input transaksi barang yang masuk ke gudang
        </div>
    </div>

    <a
        href="{{ route('incoming-transactions.index') }}"
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
    action="{{ route('incoming-transactions.store') }}"
    method="POST"
>

    @csrf


    <div class="card" style="margin-bottom: 20px;">

        <h3 style="margin-top: 0;">
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
                placeholder="Contoh: BM-001"
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

            <label for="supplier_id">
                Supplier
            </label>

            <select
                id="supplier_id"
                name="supplier_id"
                class="form-control"
                required
            >

                <option value="">
                    -- Pilih Supplier --
                </option>

                @foreach ($suppliers as $supplier)

                    <option
                        value="{{ $supplier->id }}"
                        {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}
                    >
                        {{ $supplier->name }}
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
                    Masukkan barang yang diterima
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
                        class="form-control"
                        required
                    >

                        <option value="">
                            -- Pilih Barang --
                        </option>

                        @foreach ($items as $item)

                            <option
                                value="{{ $item->id }}"
                            >
                                {{ $item->name }}
                            </option>

                        @endforeach

                    </select>

                </div>


                <div class="form-group">

                    <label>
                        Jumlah
                    </label>

                    <input
                        type="number"
                        name="items[0][quantity]"
                        class="form-control"
                        min="1"
                        placeholder="Jumlah"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Harga
                    </label>

                    <input
                        type="number"
                        name="items[0][price]"
                        class="form-control"
                        min="0"
                        step="0.01"
                        placeholder="Harga"
                    >

                </div>


                <div style="display:flex; align-items:end; padding-bottom:18px;">

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
            href="{{ route('incoming-transactions.index') }}"
            class="btn btn-secondary"
        >
            Batal
        </a>

    </div>

</form>


<style>

    .detail-row {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr auto;
        gap: 15px;
        padding: 18px;
        margin-bottom: 15px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
    }

    .detail-row .form-group {
        margin-bottom: 0;
    }

    @media (max-width: 800px) {

        .detail-row {
            grid-template-columns: 1fr;
        }

    }

</style>


<script>

    let rowIndex = 1;

    function addRow()
    {
        const container = document.getElementById('items-container');

        const row = document.createElement('div');

        row.className = 'detail-row';

        row.innerHTML = `
            <div class="form-group">

                <label>
                    Barang
                </label>

                <select
                    name="items[${rowIndex}][item_id]"
                    class="form-control"
                    required
                >

                    <option value="">
                        -- Pilih Barang --
                    </option>

                    @foreach ($items as $item)

                        <option value="{{ $item->id }}">
                            {{ $item->name }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div class="form-group">

                <label>
                    Jumlah
                </label>

                <input
                    type="number"
                    name="items[${rowIndex}][quantity]"
                    class="form-control"
                    min="1"
                    placeholder="Jumlah"
                    required
                >

            </div>

            <div class="form-group">

                <label>
                    Harga
                </label>

                <input
                    type="number"
                    name="items[${rowIndex}][price]"
                    class="form-control"
                    min="0"
                    step="0.01"
                    placeholder="Harga"
                >

            </div>

            <div style="display:flex; align-items:end; padding-bottom:18px;">

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
        const rows = document.querySelectorAll('.detail-row');

        if (rows.length <= 1) {
            alert('Minimal harus ada satu barang.');
            return;
        }

        button.closest('.detail-row').remove();
    }

</script>

@endsection