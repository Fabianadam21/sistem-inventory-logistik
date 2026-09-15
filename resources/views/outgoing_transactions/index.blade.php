@extends('layouts.app')

@section('title', 'Barang Keluar')

@section('content')

<div class="page-header">

    <div>
        <h1>Barang Keluar</h1>

        <div class="subtitle">
            Kelola transaksi barang keluar
        </div>
    </div>

    <a
        href="{{ route('outgoing-transactions.create') }}"
        class="btn btn-primary"
    >
        + Barang Keluar
    </a>

</div>


@if(session('success'))

    <div class="alert alert-success">
        {{ session('success') }}
    </div>

@endif


@if(session('error'))

    <div class="alert alert-error">
        {{ session('error') }}
    </div>

@endif


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

                            <div class="actions">

                                <a
                                    href="{{ route('outgoing-transactions.show', $transaction->id) }}"
                                    class="btn btn-detail"
                                >
                                    Detail
                                </a>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            style="text-align:center; padding:40px;"
                        >
                            Belum ada transaksi barang keluar.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection