@extends('layouts.app')

@section('title', 'Gudang')

@section('content')

<div class="page-header">

    <div>
        <h1>Gudang</h1>

        <div class="subtitle">
            Kelola data gudang penyimpanan
        </div>
    </div>

    <a
        href="{{ route('warehouses.create') }}"
        class="btn btn-primary"
    >
        + Tambah Gudang
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
                    <th>Nama Gudang</th>
                    <th>Lokasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($warehouses as $warehouse)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $warehouse->name }}
                        </td>

                        <td>
                            {{ $warehouse->location ?? '-' }}
                        </td>

                        <td>

                            <div class="actions">

                                <a
                                    href="{{ route('warehouses.edit', $warehouse->id) }}"
                                    class="btn btn-warning"
                                >
                                    Edit
                                </a>

                                <form
                                    action="{{ route('warehouses.destroy', $warehouse->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus gudang ini?')"
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
                            colspan="4"
                            style="text-align:center; padding:40px;"
                        >
                            Belum ada data gudang.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection