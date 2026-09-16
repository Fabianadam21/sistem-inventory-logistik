@extends('layouts.app')

@section('title', 'Laporan Barang Masuk')

@section('content')

<div class="page-header">

    <div>
        <h1>Laporan Barang Masuk</h1>

        <div class="subtitle">
            Riwayat transaksi barang masuk
        </div>
    </div>

    <button
        type="button"
        onclick="window.print()"
        class="btn btn-primary no-print"
    >
        🖨 Cetak
    </button>

</div>


<div class="card no-print" style="margin-bottom:20px;">

    <form
        action="{{ route('reports.incoming') }}"
        method="GET"
    >

        <div
            style="
                display:grid;
                grid-template-columns:2fr 1.5fr 1fr 1fr auto;
                gap:15px;
                align-items:end;
            "
        >

            <div class="form-group" style="margin-bottom:0;">

                <label for="search">
                    No. Transaksi
                </label>

                <input
                    type="text"
                    id="search"
                    name="search"
                    class="form-control"
                    value="{{ request('search') }}"
                    placeholder="Contoh: BM-001"
                >

            </div>


            <div class="form-group" style="margin-bottom:0;">

                <label for="supplier_id">
                    Supplier
                </label>

                <select
                    id="supplier_id"
                    name="supplier_id"
                    class="form-control"
                >

                    <option value="">
                        Semua Supplier
                    </option>

                    @foreach($suppliers as $supplier)

                        <option
                            value="{{ $supplier->id }}"
                            {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}
                        >
                            {{ $supplier->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div class="form-group" style="margin-bottom:0;">

                <label for="start_date">
                    Dari
                </label>

                <input
                    type="date"
                    id="start_date"
                    name="start_date"
                    class="form-control"
                    value="{{ request('start_date') }}"
                >

            </div>


            <div class="form-group" style="margin-bottom:0;">

                <label for="end_date">
                    Sampai
                </label>

                <input
                    type="date"
                    id="end_date"
                    name="end_date"
                    class="form-control"
                    value="{{ request('end_date') }}"
                >

            </div>


            <div style="display:flex; gap:8px;">

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Filter
                </button>

                <a
                    href="{{ route('reports.incoming') }}"
                    class="btn btn-secondary"
                >
                    Reset
                </a>

            </div>

        </div>

    </form>

</div>


<div class="card">

    <div class="table-wrapper">

        <table>

            <thead>

                <tr>
                    <th>No</th>
                    <th>No. Transaksi</th>
                    <th>Tanggal</th>
                    <th>Supplier</th>
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
                            <strong>
                                {{ $transaction->transaction_number }}
                            </strong>
                        </td>

                        <td>
                            {{ $transaction->date->format('d-m-Y') }}
                        </td>

                        <td>
                            {{ $transaction->supplier->name ?? '-' }}
                        </td>

                        <td>
                            <span class="badge badge-blue">
                                {{ $transaction->details->count() }} item
                            </span>
                        </td>

                        <td>

                            <a
                                href="{{ route('incoming-transactions.show', $transaction->id) }}"
                                class="btn btn-detail"
                            >
                                Detail
                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            style="
                                text-align:center;
                                padding:40px;
                            "
                        >
                            Data transaksi tidak ditemukan.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


<style>

    @media print {

        .sidebar,
        .no-print {
            display: none !important;
        }

        .content {
            width: 100%;
            margin-left: 0;
            padding: 0;
        }

        body {
            background: white;
        }

        .card {
            border: none;
            box-shadow: none;
        }

    }

    @media (max-width: 1000px) {

        form > div {
            grid-template-columns: 1fr !important;
        }

    }

</style>

@endsection