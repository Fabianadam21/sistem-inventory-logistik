@extends('layouts.app')

@section('title', 'Barang Masuk')

@section('content')

<div class="page-header">

    <div>
        <h1>Barang Masuk</h1>

        <div class="subtitle">
            Kelola transaksi barang masuk
        </div>
    </div>

    <a
        href="{{ route('incoming-transactions.create') }}"
        class="btn btn-primary"
    >
        + Barang Masuk
    </a>

</div>


@if(session('success'))

    <div class="alert alert-success">
        {{ session('success') }}
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

                            <div class="actions">

                                <a
                                    href="{{ route('incoming-transactions.show', $transaction->id) }}"
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
                            Belum ada transaksi barang masuk.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection