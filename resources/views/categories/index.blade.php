@extends('layouts.app')

@section('title', 'Kategori')

@section('content')

<div class="page-header">

    <div>
        <h1>Kategori</h1>

        <div class="subtitle">
            Kelola kategori barang
        </div>
    </div>

    <a
        href="{{ route('categories.create') }}"
        class="btn btn-primary"
    >
        + Tambah Kategori
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
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($categories as $category)

                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $category->name }}
                        </td>

                        <td>

                            <div class="actions">

                                <a
                                    href="{{ route('categories.edit', $category->id) }}"
                                    class="btn btn-warning"
                                >
                                    Edit
                                </a>

                                <form
                                    action="{{ route('categories.destroy', $category->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus kategori ini?')"
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
                        <td colspan="3" style="text-align:center; padding:40px;">
                            Belum ada data kategori.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection