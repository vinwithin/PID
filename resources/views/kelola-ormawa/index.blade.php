@extends('layout.app')
@section('title', 'Ormawa')
@section('description', 'Kelola Ormawa')

@section('content')
    <div class="w-100">
        @if (session('success'))
            <x-success-modal :message="session('success')" />
        @endif
        @if (session('error'))
            <x-error-modal :message="session('error')" />
        @endif
        <div class="card">
            <div class="container-fluid">
                <div class="card-header text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <!-- Tombol untuk membuka modal -->
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#tambahOrmawaModal">
                            <i class="fa-solid fa-plus me-2"></i>Tambah Ormawa
                        </button>

                        <!-- Modal -->
                        <!-- Modal Tambah Ormawa -->
                        <div class="modal fade" id="tambahOrmawaModal" tabindex="-1" aria-labelledby="tambahOrmawaLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('kelola-ormawa.store') }}" method="POST">
                                        @method('POST')

                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold" id="tambahOrmawaLabel"><i
                                                    class="fa-regular fa-circle-info me-2"></i>Tambah Ormawa</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="nama" class="form-label fw-bold text-dark">Nama Ormawa</label>
                                                <input type="text" class="form-control" id="nama" name="nama"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>



                        <div class="mb-3">
                            <form action="{{ route('kelola-ormawa.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control me-2"
                                        placeholder="Cari ormawa..." value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary">Cari</button>
                                    <a href="/kelola-ormawa" class="btn btn-primary ms-2">Atur Ulang</a>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 5%">No</th>
                                    <th style="width: 70%">Nama</th>

                                    <th style="width: 25%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="fw-bold text-start">{{ $item->nama }}</td>

                                        <td class="text-center">
                                            <!-- Tombol untuk membuka modal -->
                                            <a href="#" class="btn btn-outline-warning" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $item->id }}">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
                                                aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <form action="{{ route('kelola-ormawa.update', $item->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-header">
                                                                <h5 class="modal-title fw-bold"
                                                                    id="editModalLabel{{ $item->id }}">
                                                                    <i class="fa-regular fa-circle-info me-2"></i>Edit
                                                                    Ormawa
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3 text-start">
                                                                    <label for="nama" class="form-label fw-bold text-dark text-start">Nama
                                                                        Ormawa</label>
                                                                    <input type="text" class="form-control"
                                                                        id="nama" name="nama"
                                                                        value="{{ $item->nama }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit"
                                                                    class="btn btn-success">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>



                                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $item->id }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                            <x-confirm-modal modal-id="deleteModal{{ $item->id }}"
                                                title="Konfirmasi Persetujuan"
                                                message="Apakah Anda yakin ingin menghapus ormawa ini?"
                                                action-url="/kelola-ormawa/delete/{{ $item->id }}"
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
