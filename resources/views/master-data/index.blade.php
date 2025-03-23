@extends('layout.app')
@section('title', 'Master Data')

@section('content')
    <div class="w-100">
        @if (session('success'))
            <x-success-modal :message="session('success')" />
        @endif
        @if (session('error'))
            <x-error-modal :message="session('error')" />
        @endif
        <div class="card">
            <div class="container-fluid px-4 py-4">
                <div class="card-header text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="text-dark">
                            <i class="fa-solid fa-bars-progress me-1"></i>Kelola Role
                        </h3>
                        <div class="mb-3">
                            <form action="{{ route('manage-users.search') }}" method="GET" class="d-flex">
                                <input type="text" name="search" class="form-control me-2"
                                    placeholder="Cari nama, email, atau role..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </form>
                        </div>
                    </div>
                    <a href="/manage-users/create" class="btn btn-primary">Tambah Pengguna</a>

                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th style="width: 10%">Nama</th>
                                    <th style="width: 15%" class="text-center">Email</th>
                                    <th style="width: 15%" class="text-center">Role</th>
                                    <th style="width: 15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="fw-bold text-center">{{ $item->name }}</td>
                                        <td class="text-center">{{ $item->email }}</td>
                                        <td class="text-center">
                                            @foreach ($item->getRoleNames() as $role)
                                                <p>{{ $role }}</p>
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                            <a href="/manage-users/edit/{{ $item->id }}"
                                                class="btn btn-sm btn-outline-success">
                                                <i class="fa-solid fa-pen me-1"></i>Edit
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-success"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}">
                                                <i class="fa-solid fa-trash me-1"></i> Delete
                                            </button>
                                            <x-confirm-modal modal-id="deleteModal{{ $item->id }}"
                                                title="Konfirmasi Persetujuan"
                                                message="Apakah Anda yakin ingin menghapus pengguna ini?"
                                                action-url="/manage-users/delete/{{ $item->id }}"
                                                confirm-text="Ya, Setujui" />

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
