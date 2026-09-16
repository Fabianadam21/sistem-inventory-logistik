@extends('layouts.app')

@section('title', 'Laporan Barang Keluar')

@section('content')

<div class="page-header">

    <div>
        <h1>Laporan Barang Keluar</h1>

        <div class="subtitle">
            Riwayat transaksi barang keluar
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
        action="{{ route('reports.outgoing') }}"
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
                    placeholder="Contoh: BK-001"
                >

            </div>


            <div class="form-group" style="margin-bottom:0;">

                <label for="department_id">
                    Unit / Bidang
                </label>

                <select
                    id="department_id"
                    name="department_id"
                    class="form-control"
                >

                    <option value="">
                        Semua Unit / Bidang
                    </option>

                    @foreach($departments as $department)

                        <option
                            value="{{ $department->id }}"
                            {{ request('department_id') == $department->id ? 'selected' : '' }}
                        >
                            {{ $department->name }}
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
                    href="{{ route('reports.outgoing') }}"
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
                    <th>Unit / Bidang</th>
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
                            {{ $transaction->department->name ?? '-' }}
                        </td>

                        <td>
                            <span class="badge badge-blue">
                                {{ $transaction->details->count() }} item
                            </span>
                        </td>

                        <td>

                            <a
                                href="{{ route('outgoing-transactions.show', $transaction->id) }}"
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