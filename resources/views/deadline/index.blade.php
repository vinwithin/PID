@extends('layout.app')
@section('title', 'Tenggat Waktu')
@section('description', 'Kelola Tenggat Waktu')

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
                        @can('create deadline')
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#tambahOrmawaModal">
                                Tambah Tenggat Waktu
                            </button>
                        @endcan


                        <!-- Modal -->
                        <!-- Modal Tambah Ormawa -->
                        <div class="modal fade" id="tambahOrmawaModal" tabindex="-1" aria-labelledby="tambahOrmawaLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('deadline.store') }}" method="POST">
                                        @method('POST')

                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold" id="tambahOrmawaLabel">Tambah Tenggat Waktu</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="nama_dokumen" class="form-label text-dark">Nama</label>
                                                <input type="text" class="form-control" id="nama_dokumen"
                                                    name="nama_dokumen" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="dibuka" class="form-label text-dark">Dibuka</label>
                                                <input type="date" class="form-control" id="dibuka" name="dibuka"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="ditutup" class="form-label text-dark">Ditutup</label>
                                                <input type="date" class="form-control" id="ditutup" name="ditutup"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>




                    </div>

                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 5%">No</th>
                                    <th style="width: 35%">Nama</th>
                                    <th style="width: 35%">Waktu</th>

                                    <th style="width: 25%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="fw-bold text-start">{{ $item->nama_dokumen }}</td>
                                        <td class="fw-bold text-start">
                                            {{ \Carbon\Carbon::parse($item->dibuka)->translatedFormat('j F Y') }}
                                            -
                                            {{ \Carbon\Carbon::parse($item->ditutup)->translatedFormat('j F Y') }}
                                        </td>



                                        <td class="text-center">
                                            @can('manage deadline')
                                                <!-- Tombol untuk membuka modal -->
                                                <a href="#" class="btn btn-outline-warning" data-bs-toggle="modal"
                                                    data-bs-target="#editModal{{ $item->id }}">
                                                    <i class="fa-solid fa-pen"></i>
                                                </a>
                                                <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
                                                    aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <form action="{{ route('deadline.update', $item->id) }}"
                                                                method="POST">
                                                                @csrf

                                                                <div class="modal-header">
                                                                    <h5 class="modal-title fw-bold" id="tambahOrmawaLabel">Edit
                                                                        Tenggat Waktu</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                                </div>
                                                                <div class="modal-body text-start">

                                                                    <div class="mb-3">
                                                                        <label for="nama_dokumen"
                                                                            class="form-label text-dark">Nama</label>
                                                                        <input type="text" class="form-control"
                                                                            id="nama_dokumen" name="nama_dokumen"
                                                                            value="{{ $item->nama_dokumen }}" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="dibuka"
                                                                            class="form-label text-dark">Dibuka</label>
                                                                        <input type="date" class="form-control"
                                                                            id="dibuka" name="dibuka"
                                                                            value="{{ $item->dibuka }}" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="ditutup"
                                                                            class="form-label text-dark">Ditutup</label>
                                                                        <input type="date" class="form-control"
                                                                            id="ditutup" name="ditutup"
                                                                            value="{{ $item->ditutup }}" required>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit"
                                                                            class="btn btn-success">Simpan</button>
                                                                    </div>
                                                                </div>
                                                            </form>

                                                        </div>

                                                    </div>
                                                </div>
                                            @endcan


                                            @can('create deadline')
                                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $item->id }}">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                                <x-confirm-modal modal-id="deleteModal{{ $item->id }}"
                                                    title="Konfirmasi Persetujuan"
                                                    message="Apakah Anda yakin ingin menghapus tenggat waktu ini ini?"
                                                    action-url="deadline/destroy/{{ $item->id }}"
                                                    confirm-text="Ya, Setujui" />
                                            @endcan


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
