@extends('layouts.app')

@section('title', 'Unit / Bidang')

@section('content')

<div class="page-header">

    <div>
        <h1>Unit / Bidang</h1>

        <div class="subtitle">
            Kelola data unit atau bidang kerja
        </div>
    </div>

    <a
        href="{{ route('departments.create') }}"
        class="btn btn-primary"
    >
        + Tambah Unit/Bidang
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
                    <th>Nama Unit / Bidang</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($departments as $department)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $department->name }}
                        </td>

                        <td>

                            <div class="actions">

                                <a
                                    href="{{ route('departments.edit', $department->id) }}"
                                    class="btn btn-warning"
                                >
                                    Edit
                                </a>

                                <form
                                    action="{{ route('departments.destroy', $department->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus Unit/Bidang ini?')"
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
                            Belum ada data Unit/Bidang.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection