@extends('layout.app')
@section('title', 'Laporan Kemajuan')

@section('content')
    <div class="w-100">
        <div class="card">
            <div class="container-fluid px-4 py-4">
                <div class="card shadow-sm border-0">

                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="mb-0 text-light">
                            <i class="fas fa-file-alt me-2"></i>Laporan Kemajuan
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th style="width: 15%">Tim</th>
                                    <th style="width: 15%" class="text-center">File
                                    </th>
                                    <th style="width: 15%" class="text-center">Status
                                    </th>
                                    <th style="width: 15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataAdmin as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="fw-bold text-center">Tim {{ $item->judul }}</td>

                                        <td class="text-center">
                                            @if ($item->laporan_kemajuan && $item->laporan_kemajuan->file_path)
                                                <a href="{{ asset('storage/laporan-kemajuan/' . $item->laporan_kemajuan->file_path) }}"
                                                    class="btn btn-sm btn-outline-info" target="_blank"><i
                                                        class="fas fa-eye me-1"></i>Lihat File</a>
                                            @else
                                                <span class="badge bg-danger">Belum Upload</span>
                                            @endif
                                        </td>
                                        <td class="fw-bold text-center">
                                            @if ($item->laporan_kemajuan && $item->laporan_kemajuan->status)
                                                {{ $item->laporan_kemajuan->status }}
                                            @else
                                                <span class="badge bg-danger"></span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @role('admin')
                                                @if ($item->laporan_kemajuan && $item->laporan_kemajuan->file_path)
                                                    @if ($item->laporan_kemajuan->status === 'Valid')
                                                        <button type="button" class="btn btn-sm btn-outline-success"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#rejectModal{{ $item->id }}">
                                                            <i class="fas fa-exclamation-triangle me-1"></i> Tolak
                                                        </button>
                                                        <!-- Gunakan komponen modal -->
                                                        <x-confirm-modal modal-id="rejectModal{{ $item->id }}"
                                                            title="Konfirmasi Persetujuan"
                                                            message="Apakah Anda yakin ingin menolak laporan ini?"
                                                            action-url="/laporan-kemajuan/reject/{{ $item->laporan_kemajuan->id }}"
                                                            confirm-text="Iya" />
                                                    @elseif($item->laporan_kemajuan->status === 'Ditolak')
                                                        <button type="button" class="btn btn-sm btn-outline-success"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#approveModal{{ $item->id }}">
                                                            <i class="fas fa-check me-1"></i> Terima
                                                        </button>
                                                        <!-- Gunakan komponen modal -->
                                                        <x-confirm-modal modal-id="approveModal{{ $item->id }}"
                                                            title="Konfirmasi Persetujuan"
                                                            message="Apakah Anda yakin ingin menerima laporan ini?"
                                                            action-url="/laporan-kemajuan/approve/{{ $item->laporan_kemajuan->id }}"
                                                            confirm-text="Iya" />
                                                    @else
                                                        <button type="button" class="btn btn-sm btn-outline-success"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#rejectModal{{ $item->id }}">
                                                            <i class="fas fa-exclamation-triangle me-1"></i> Tolak
                                                        </button>
                                                        <!-- Gunakan komponen modal -->
                                                        <x-confirm-modal modal-id="rejectModal{{ $item->id }}"
                                                            title="Konfirmasi Persetujuan"
                                                            message="Apakah Anda yakin ingin menolak laporan ini?"
                                                            action-url="/laporan-kemajuan/reject/{{ $item->laporan_kemajuan->id }}"
                                                            confirm-text="Iya" />
                                                        <button type="button" class="btn btn-sm btn-outline-success"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#approveModal{{ $item->id }}">
                                                            <i class="fas fa-check me-1"></i> Terima
                                                        </button>
                                                        <!-- Gunakan komponen modal -->
                                                        <x-confirm-modal modal-id="approveModal{{ $item->id }}"
                                                            title="Konfirmasi Persetujuan"
                                                            message="Apakah Anda yakin ingin menerima laporan ini?"
                                                            action-url="/laporan-kemajuan/approve/{{ $item->laporan_kemajuan->id }}"
                                                            confirm-text="Iya" />
                                                    @endif
                                                @else
                                                @endif
                                            @endrole
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
