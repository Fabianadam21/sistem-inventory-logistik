@extends('layouts.app')

@section('title', 'Sumber Dana')

@section('content')

<div class="page-header">

    <div>
        <h1>Sumber Dana</h1>

        <div class="subtitle">
            Kelola data sumber dana barang
        </div>
    </div>

    <a
        href="{{ route('suppliers.create') }}"
        class="btn btn-primary"
    >
        + Tambah Sumber Dana
    </a>

</div>

<div class="card">

    <div class="table-wrapper">

        <table>

            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Sumber Dana</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($suppliers as $supplier)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $supplier->name }}
                        </td>

                        <td>

                            <div class="actions">

                                <a
                                    href="{{ route('suppliers.edit', $supplier->id) }}"
                                    class="btn btn-warning"
                                >
                                    Edit
                                </a>

                                <form
                                    action="{{ route('suppliers.destroy', $supplier->id) }}"
                                    method="POST"
                                    data-confirm-message="Hapus sumber dana ini? Data yang sudah dihapus tidak dapat dikembalikan."
                                    onsubmit="return window.simlogConfirmEnabled ? true : confirm('Hapus sumber dana ini?')"
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
                            Belum ada data sumber dana.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection