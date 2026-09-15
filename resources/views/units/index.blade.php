@extends('layouts.app')

@section('title', 'Satuan')

@section('content')

<div class="page-header">

    <div>
        <h1>Satuan</h1>

        <div class="subtitle">
            Kelola satuan barang
        </div>
    </div>

    <a
        href="{{ route('units.create') }}"
        class="btn btn-primary"
    >
        + Tambah Satuan
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
                    <th>Nama Satuan</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($units as $unit)

                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $unit->name }}
                        </td>

                        <td>

                            <div class="actions">

                                <a
                                    href="{{ route('units.edit', $unit->id) }}"
                                    class="btn btn-warning"
                                >
                                    Edit
                                </a>

                                <form
                                    action="{{ route('units.destroy', $unit->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus satuan ini?')"
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
                            colspan="3"
                            style="text-align:center; padding:40px;"
                        >
                            Belum ada data satuan.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection