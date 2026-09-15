@extends('layouts.app')

@section('title', 'Laporan Stok')

@section('content')

<div class="page-header">

    <div>
        <h1>Laporan Stok</h1>

        <div class="subtitle">
            Informasi persediaan barang saat ini
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
        action="{{ route('reports.stock') }}"
        method="GET"
    >

        <div
            style="
                display:grid;
                grid-template-columns:2fr 1fr auto;
                gap:15px;
                align-items:end;
            "
        >

            <div class="form-group" style="margin-bottom:0;">

                <label for="search">
                    Cari Barang
                </label>

                <input
                    type="text"
                    id="search"
                    name="search"
                    class="form-control"
                    value="{{ request('search') }}"
                    placeholder="Kode atau nama barang..."
                >

            </div>


            <div class="form-group" style="margin-bottom:0;">

                <label for="stock_status">
                    Status Stok
                </label>

                <select
                    id="stock_status"
                    name="stock_status"
                    class="form-control"
                >

                    <option value="">
                        Semua
                    </option>

                    <option
                        value="low"
                        {{ request('stock_status') === 'low' ? 'selected' : '' }}
                    >
                        Stok Menipis
                    </option>

                    <option
                        value="safe"
                        {{ request('stock_status') === 'safe' ? 'selected' : '' }}
                    >
                        Stok Aman
                    </option>

                </select>

            </div>


            <div
                style="
                    display:flex;
                    gap:8px;
                "
            >

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Filter
                </button>

                <a
                    href="{{ route('reports.stock') }}"
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
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Satuan</th>
                    <th>Gudang</th>
                    <th>Stok</th>
                    <th>Minimum</th>
                    <th>Status</th>
                </tr>

            </thead>


            <tbody>

                @forelse($items as $item)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $item->code }}
                        </td>

                        <td>
                            <strong>
                                {{ $item->name }}
                            </strong>
                        </td>

                        <td>
                            {{ $item->category->name ?? '-' }}
                        </td>

                        <td>
                            {{ $item->unit->name ?? '-' }}
                        </td>

                        <td>
                            {{ $item->warehouse->name ?? '-' }}
                        </td>

                        <td>

                            @if($item->stock <= $item->minimum_stock)

                                <span class="badge badge-red">
                                    {{ $item->stock }}
                                </span>

                            @else

                                <span class="badge badge-green">
                                    {{ $item->stock }}
                                </span>

                            @endif

                        </td>

                        <td>
                            {{ $item->minimum_stock }}
                        </td>

                        <td>

                            @if($item->stock <= $item->minimum_stock)

                                <span class="badge badge-red">
                                    Menipis
                                </span>

                            @else

                                <span class="badge badge-green">
                                    Aman
                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="9"
                            style="
                                text-align:center;
                                padding:40px;
                            "
                        >
                            Data barang tidak ditemukan.
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
            box-shadow: none;
            border: none;
        }

        table {
            font-size: 12px;
        }

    }

    @media (max-width: 800px) {

        form > div {
            grid-template-columns: 1fr !important;
        }

    }

</style>

@endsection