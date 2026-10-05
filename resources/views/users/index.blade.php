@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')

<div class="page-header">

    <div>
        <h1>Manajemen User</h1>

        <div class="subtitle">
            Kelola akun pengguna dan hak akses sistem
        </div>
    </div>

    <a
        href="{{ route('users.create') }}"
        class="btn btn-primary"
    >
        + Tambah User
    </a>

</div>

<div class="card">

    <div class="table-wrapper">

        <table>

            <thead>

                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>

            </thead>

            <tbody>

                @forelse($users as $user)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            <strong>
                                {{ $user->name }}
                            </strong>
                        </td>

                        <td>
                            {{ $user->email }}
                        </td>

                        <td>

                            @if($user->role === 'admin')

                                <span class="badge badge-blue">
                                    Admin
                                </span>

                            @elseif($user->role === 'petugas')

                                <span class="badge badge-green">
                                    Petugas
                                </span>

                            @else

                                <span class="badge badge-red">
                                    Pimpinan
                                </span>

                            @endif

                        </td>

                        <td>

                            <div class="actions">

                                <a
                                    href="{{ route('users.edit', $user->id) }}"
                                    class="btn btn-warning"
                                >
                                    Edit
                                </a>

                                @if($user->id !== auth()->id())

                                    <form
                                        action="{{ route('users.destroy', $user->id) }}"
                                        method="POST"
                                        data-confirm-message="Hapus user ini? Data yang sudah dihapus tidak dapat dikembalikan."
                                        onsubmit="return window.simlogConfirmEnabled ? true : confirm('Hapus user ini?')"
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

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="5"
                            style="
                                text-align:center;
                                padding:40px;
                            "
                        >
                            Belum ada user.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection