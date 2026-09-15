@extends('layouts.app')

@section('title', 'Detail Barang Masuk')

@section('content')

<div class="page-header">

    <div>
        <h1>Detail Barang Masuk</h1>

        <div class="subtitle">
            Informasi lengkap transaksi barang masuk
        </div>
    </div>

    <a
        href="{{ route('incoming-transactions.index') }}"
        class="btn btn-secondary"
    >
        ← Kembali
    </a>

</div>


<div class="card" style="margin-bottom: 20px;">

    <div
        style="
            display:grid;
            grid-template-columns:180px 1fr;
            gap:14px;
        "
    >

        <strong>No. Transaksi</strong>

        <div>
            {{ $incomingTransaction->transaction_number }}
        </div>


        <strong>Tanggal</strong>

        <div>
            {{ $incomingTransaction->date->format('d-m-Y') }}
        </div>


        <strong>Supplier</strong>

        <div>
            {{ $incomingTransaction->supplier->name ?? '-' }}
        </div>


        <strong>Keterangan</strong>

        <div>
            {{ $incomingTransaction->description ?: '-' }}
        </div>

    </div>

</div>


<div class="card">

    <h3 style="margin-top:0;">
        Detail Barang
    </h3>

    <div class="table-wrapper">

        <table>

            <thead>
                <tr>
                    <th>No</th>
                    <th>Barang</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>
            </thead>

            <tbody>

                @forelse($incomingTransaction->details as $detail)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $detail->item->name ?? '-' }}
                        </td>

                        <td>
                            {{ $detail->quantity }}
                        </td>

                        <td>
                            Rp {{ number_format($detail->price ?? 0, 0, ',', '.') }}
                        </td>

                        <td>
                            Rp {{ number_format(($detail->price ?? 0) * $detail->quantity, 0, ',', '.') }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="5"
                            style="text-align:center; padding:40px;"
                        >
                            Tidak ada detail barang.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection