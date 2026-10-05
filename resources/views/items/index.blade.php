@extends('layouts.app')

@section('title', 'Data Barang')

@section('content')

    <div class="page-header">

        <div>
            <h1>Data Barang</h1>

            <div class="subtitle">
                Kelola data barang inventory
            </div>
        </div>

        <a href="{{ route('items.create') }}" class="btn btn-primary">
            + Tambah Barang
        </a>

    </div>

    <div class="card" style="margin-bottom:20px;">

        <form action="{{ route('items.index') }}" method="GET">

            <div style="
                    display:flex;
                    gap:10px;
                    align-items:end;
                ">

                <div class="form-group" style="margin:0; flex:1;">

                    <label for="search">
                        Cari Barang
                    </label>

                    <input type="text" id="search" name="search" class="form-control" value="{{ request('search') }}"
                        placeholder="Cari kode atau nama barang...">

                </div>

                <button type="submit" class="btn btn-primary">
                    Cari
                </button>

                <a href="{{ route('items.index') }}" class="btn btn-secondary">
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
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Satuan</th>
                        <th>Sumber Dana</th>
                        <th>Harga Satuan</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($items as $item)

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
                                {{ $item->supplier->name ?? '-' }}
                            </td>

                            <td>
                                {{ $item->price !== null ? 'Rp ' . number_format((float) $item->price, 0, ',', '.') : '-' }}
                            </td>

                            <td>

                                @if ($item->stock <= $item->minimum_stock)

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

                                <div class="actions">

                                    <a href="{{ route('items.edit', $item->id) }}" class="btn btn-warning">
                                        Edit
                                    </a>

                                    <form action="{{ route('items.destroy', $item->id) }}" method="POST"
                                        data-confirm-message="Hapus barang ini? Data yang sudah dihapus tidak dapat dikembalikan."
                                        onsubmit="return window.simlogConfirmEnabled ? true : confirm('Hapus barang ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger">
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="9" style="text-align:center; padding:40px;">
                                Belum ada data barang.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

            @if($items->hasPages())

                <div class="pagination">

                    @if($items->onFirstPage())

                        <span class="page-disabled">
                            ←
                        </span>

                    @else

                        <a href="{{ $items->previousPageUrl() }}">
                            ←
                        </a>

                    @endif


                    @foreach($items->getUrlRange(1, $items->lastPage()) as $page => $url)

                        @if($page == $items->currentPage())

                            <span class="page-active">
                                {{ $page }}
                            </span>

                        @else

                            <a href="{{ $url }}">
                                {{ $page }}
                            </a>

                        @endif

                    @endforeach


                    @if($items->hasMorePages())

                        <a href="{{ $items->nextPageUrl() }}">
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