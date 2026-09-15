@extends('layouts.app')

@section('title', 'Detail Barang Keluar')

@section('content')

<div class="page-header">

    <div>
        <h1>Detail Barang Keluar</h1>

        <div class="subtitle">
            Informasi lengkap transaksi barang keluar
        </div>
    </div>

    <a
        href="{{ route('outgoing-transactions.index') }}"
        class="btn btn-secondary"
    >
        ← Kembali
    </a>

</div>


<div class="card" style="margin-bottom:20px;">

    <div
        style="
            display:grid;
            grid-template-columns:180px 1fr;
            gap:14px;
        "
    >

        <strong>
            No. Transaksi
        </strong>

        <div>
            {{ $outgoingTransaction->transaction_number }}
        </div>


        <strong>
            Tanggal
        </strong>

        <div>
            {{ $outgoingTransaction->date->format('d-m-Y') }}
        </div>


        <strong>
            Unit / Bidang
        </strong>

        <div>
            {{ $outgoingTransaction->department->name ?? '-' }}
        </div>


        <strong>
            Keterangan
        </strong>

        <div>
            {{ $outgoingTransaction->description ?: '-' }}
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
                    <th>Keterangan</th>
                </tr>

            </thead>

            <tbody>

                @forelse($outgoingTransaction->details as $detail)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $detail->item->name ?? '-' }}
                        </td>

                        <td>
                            <span class="badge badge-blue">
                                {{ $detail->quantity }}
                            </span>
                        </td>

                        <td>
                            {{ $detail->description ?: '-' }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="4"
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