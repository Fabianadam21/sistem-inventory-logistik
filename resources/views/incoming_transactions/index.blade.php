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

        <a href="{{ route('incoming-transactions.create') }}" class="btn btn-primary">
            + Barang Masuk
        </a>

    </div>


    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif

    <div class="card" style="margin-bottom:20px;">

        <form action="{{ route('incoming-transactions.index') }}" method="GET">

            <div style="
                        display:flex;
                        gap:10px;
                        align-items:end;
                    ">

                <div class="form-group" style="margin:0; flex:1;">

                    <label for="search">
                        Cari Transaksi
                    </label>

                    <input type="text" id="search" name="search" class="form-control" value="{{ request('search') }}"
                        placeholder="Cari nomor transaksi...">

                </div>

                <button type="submit" class="btn btn-primary">
                    Cari
                </button>

                <a href="{{ route('incoming-transactions.index') }}" class="btn btn-secondary">
                    Reset
                </a>

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

                                <div class="actions">

                                    <a href="{{ route('incoming-transactions.show', $transaction->id) }}"
                                        class="btn btn-detail">
                                        Detail
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" style="text-align:center; padding:40px;">
                                Belum ada transaksi barang masuk.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

            @if($transactions->hasPages())

                <div class="pagination">

                    @if($transactions->onFirstPage())

                        <span class="page-disabled">
                            ←
                        </span>

                    @else

                        <a href="{{ $transactions->previousPageUrl() }}">
                            ←
                        </a>

                    @endif


                    @foreach($transactions->getUrlRange(1, $transactions->lastPage()) as $page => $url)

                        @if($page == $transactions->currentPage())

                            <span class="page-active">
                                {{ $page }}
                            </span>

                        @else

                            <a href="{{ $url }}">
                                {{ $page }}
                            </a>

                        @endif

                    @endforeach


                    @if($transactions->hasMorePages())

                        <a href="{{ $transactions->nextPageUrl() }}">
                            →
                        </a>

                    @else

                        <span class="page-disabled">
                            →
                        </span>

                    @endif

                </div>

            @endif

        </div>

    </div>

@endsection