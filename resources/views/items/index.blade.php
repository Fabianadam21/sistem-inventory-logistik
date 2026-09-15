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

    <a
        href="{{ route('items.create') }}"
        class="btn btn-primary"
    >
        + Tambah Barang
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
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Satuan</th>
                    <th>Gudang</th>
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
                            {{ $item->warehouse->name ?? '-' }}
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

                                <a
                                    href="{{ route('items.edit', $item->id) }}"
                                    class="btn btn-warning"
                                >
                                    Edit
                                </a>

                                <form
                                    action="{{ route('items.destroy', $item->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus barang ini?')"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger"
                                    >
                                        Hapus
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="8"
                            style="text-align:center; padding:40px;"
                        >
                            Belum ada data barang.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection