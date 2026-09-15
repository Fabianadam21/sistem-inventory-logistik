@extends('layouts.app')

@section('title', 'Supplier')

@section('content')

<div class="page-header">

    <div>
        <h1>Supplier</h1>

        <div class="subtitle">
            Kelola data supplier barang
        </div>
    </div>

    <a
        href="{{ route('suppliers.create') }}"
        class="btn btn-primary"
    >
        + Tambah Supplier
    </a>

</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-error">
        {{ session('error') }}
    </div>
@endif

<div class="card">

    <div class="table-wrapper">

        <table>

            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Supplier</th>
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
                                    onsubmit="return confirm('Yakin ingin menghapus supplier ini?')"
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
                            Belum ada data supplier.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection