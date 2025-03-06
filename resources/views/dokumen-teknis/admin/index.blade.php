@extends('layout.app')
@section('title', 'Dokumen Teknis')

@section('content')
    <div class="w-100">
        <div class="card">
            <div class="container-fluid px-4 py-4">
                <div class="card shadow-sm border-0">

                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="mb-0 text-light">
                            <i class="fas fa-file-alt me-2"></i>Publikasi Dokumen Teknis
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th style="width: 10%">Tim</th>
                                    <th style="width: 10%">Konten</th>
                                    <th style="width: 15%" class="text-center">Dokumen Manual/Panduan</th>
                                    <th style="width: 15%" class="text-center">Bukti Ketercapaian Seminar atau Publikasi
                                        Artikel
                                    </th>
                                    <th style="width: 15%" class="text-center">Draft proposal PPK Ormawa untuk tahun
                                        berikutnya</th>
                                    <th style="width: 15%" class="text-center">Dokumen Laporan Keuangan</th>
                                    <th style="width: 10%" class="text-center">Status</th>
                                    @can('agree publication')
                                        <th style="width: 15%" class="text-center">Aksi</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataAdmin as $item)
                                    <tr>
                                        <td rowspan="2" class="text-center">{{ $loop->iteration }}</td>
                                        <td rowspan="2" class="fw-bold text-center">Tim {{ $item->judul }}</td>
                                        <td>Dokumen</td>
                                        <td class="text-center">
                                            @if ($item->dokumenTeknis && $item->dokumenTeknis->file_manual)
                                                <a href="{{ asset('storage/dokumen-teknis/' . $item->dokumenTeknis->file_manual) }}"
                                                    class="btn btn-sm btn-outline-info" target="_blank"><i
                                                        class="fas fa-eye me-1"></i>Lihat File</a>
                                            @else
                                                <span class="badge bg-danger">Belum Upload</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($item->dokumenTeknis && $item->dokumenTeknis->file_bukti_publikasi)
                                                <a href="{{ asset('storage/dokumen-teknis/' . $item->dokumenTeknis->file_bukti_publikasi) }}"
                                                    class="btn btn-sm btn-outline-info" target="_blank"><i
                                                        class="fas fa-eye me-1"></i>Lihat File</a>
                                            @else
                                                <span class="badge bg-danger">Belum Upload</span>
                                            @endif
                                        </td>
                                        <td rowspan="2" class="text-center">
                                            @if ($item->dokumenTeknis && $item->dokumenTeknis->file_proposal)
                                                <a href="{{ asset('storage/dokumen-teknis/' . $item->dokumenTeknis->file_proposal) }}"
                                                    class="btn btn-sm btn-outline-info" target="_blank"><i
                                                        class="fas fa-eye me-1"></i>Lihat File</a>
                                            @else
                                                <span class="badge bg-danger">Belum Upload</span>
                                            @endif
                                        </td>
                                        <td rowspan="2" class="text-center">
                                            @if ($item->dokumenTeknis && $item->dokumenTeknis->file_laporan_keuangan)
                                                <a href="{{ asset('storage/dokumen-teknis/' . $item->dokumenTeknis->file_laporan_keuangan) }}"
                                                    class="btn btn-sm btn-outline-info" target="_blank"><i
                                                        class="fas fa-eye me-1"></i>Lihat File</a>
                                            @else
                                                <span class="badge bg-danger">Belum Upload</span>
                                            @endif
                                        </td>
                                        <td rowspan="2" class="text-center">
                                            {{ $item->dokumenTeknis->status }}
                                        </td>
                                        @can('agree publication')
                                            <td rowspan="2" class="text-center">
                                                @if ($item->dokumenTeknis)
                                                    <button type="button" class="btn btn-sm btn-outline-success"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#approveModal{{ $item->dokumenTeknis->id }}">
                                                        <i class="fas fa-check me-1"></i> Terima
                                                    </button>
                                                    <x-confirm-modal modal-id="approveModal{{ $item->dokumenTeknis->id }}"
                                                        title="Konfirmasi Persetujuan"
                                                        message="Apakah Anda yakin ingin menerima laporan akhir ini?"
                                                        action-url="/dokumen-teknis/approve/{{ $item->dokumenTeknis->id }}"
                                                        confirm-text="Ya, Setujui" />

                                                    <button type="button" class="btn btn-sm btn-outline-success"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#rejectModal{{ $item->dokumenTeknis->id }}">
                                                        <i class="fas fa-exclamation-triangle me-1"></i> Tolak
                                                    </button>
                                                    <x-confirm-modal modal-id="rejectModal{{ $item->dokumenTeknis->id }}"
                                                        title="Konfirmasi Persetujuan"
                                                        message="Apakah Anda yakin ingin menolak laporan akhir ini?"
                                                        action-url="/dokumen-teknis/reject/{{ $item->dokumenTeknis->id }}"
                                                        confirm-text="Ya, Tolak" />
                                                @else
                                                @endif
                                            </td>

                                        </tr>
                                    @endcan

                                    <tr>
                                        <td>Status</td>
                                        <td class="text-center">
                                            <span class="badge {{ $item->dokumenTeknis ? 'bg-primary' : 'bg-danger' }}">
                                                {{ $item->dokumenTeknis ? $item->dokumenTeknis->status_manual : 'Belum Upload' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge {{ $item->dokumenTeknis ? 'bg-primary' : 'bg-danger' }}">
                                                {{ $item->dokumenTeknis ? $item->dokumenTeknis->status_publikasi : 'Belum Upload' }}
                                            </span>
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
