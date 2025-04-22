@extends('layout.app')
@section('title', 'Dokumen Teknis')

@section('content')
    <div class="w-100">
        @if (session('success'))
            <x-success-modal :message="session('success')" />
        @endif
        @if (session('error'))
            <x-error-modal :message="session('error')" />
        @endif
        <div class="card">
            <div class="container-fluid px-4 ">
                <div class="card-header d-flex justify-content-end align-items-end">
                    <form action="{{ route('dokumen-teknis') }}" method="GET" class="">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari tim..."
                                value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-search"></i> Cari
                            </button>
                            <a href="{{ route('dokumen-teknis') }}" class="btn btn-success ms-2">Reset</a>

                        </div>
                    </form>
                </div>

                <div class="card-body p-0">
                    <table class="table table-bordered">
                        <thead>
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
                                                class="btn btn-sm btn-outline-primary" target="_blank"><i
                                                    class="fas fa-eye me-1"></i>Lihat File</a>
                                        @else
                                            <span class="badge bg-danger">Belum Upload</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($item->dokumenTeknis && $item->dokumenTeknis->file_bukti_publikasi)
                                            <a href="{{ asset('storage/dokumen-teknis/' . $item->dokumenTeknis->file_bukti_publikasi) }}"
                                                class="btn btn-sm btn-outline-primary" target="_blank"><i
                                                    class="fas fa-eye me-1"></i>Lihat File</a>
                                        @else
                                            <span class="badge bg-danger">Belum Upload</span>
                                        @endif
                                    </td>
                                    <td rowspan="2" class="text-center">
                                        @if ($item->dokumenTeknis && $item->dokumenTeknis->file_proposal)
                                            <a href="{{ asset('storage/dokumen-teknis/' . $item->dokumenTeknis->file_proposal) }}"
                                                class="btn btn-sm btn-outline-primary" target="_blank"><i
                                                    class="fas fa-eye me-1"></i>Lihat File</a>
                                        @else
                                            <span class="badge bg-danger">Belum Upload</span>
                                        @endif
                                    </td>
                                    <td rowspan="2" class="text-center">
                                        @if ($item->dokumenTeknis && $item->dokumenTeknis->file_laporan_keuangan)
                                            <a href="{{ asset('storage/dokumen-teknis/' . $item->dokumenTeknis->file_laporan_keuangan) }}"
                                                class="btn btn-sm btn-outline-primary" target="_blank"><i
                                                    class="fas fa-eye me-1"></i>Lihat File</a>
                                        @else
                                            <span class="badge bg-danger">Belum Upload</span>
                                        @endif
                                    </td>
                                    <td rowspan="2" class="text-center">
                                        @if ($item->dokumenTeknis && $item->dokumenTeknis->status === 'Ditolak')
                                            <span class="badge bg-danger">
                                                Ditolak
                                                <i class="fas fa-info-circle ms-1 text-white" tabindex="0" role="button"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModal"></i>
                                            </span>
                                            <!-- Scrollable modal -->
                                            <div class="modal fade" id="exampleModal" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Komentar
                                                                Dokumen
                                                            </h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                            {{ $item->dokumenTeknis->komentar }}
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif(!$item->dokumenTeknis)
                                            <span>Belum Ada Status</span>
                                        @else
                                            {{ $item->dokumenTeknis->status }}
                                        @endif
                                    </td>
                                    @can('agree publication')
                                        <td rowspan="2" class="text-center">
                                            @if ($item->dokumenTeknis)
                                                @if ($item->dokumenTeknis->status === 'Valid')
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#rejectModal{{ $item->dokumenTeknis->id }}">
                                                        <i class="fas fa-exclamation-triangle me-1"></i> Tolak
                                                    </button>
                                                    <x-reject-with-comment modal-id="rejectModal{{ $item->dokumenTeknis->id }}"
                                                        action-url="/dokumen-teknis/reject/{{ $item->dokumenTeknis->id }}"
                                                        value="{{ $item->dokumenTeknis->komentar }}" />
                                                @elseif($item->dokumenTeknis->status === 'Ditolak')
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
                                                @else
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#rejectModal{{ $item->dokumenTeknis->id }}">
                                                        <i class="fas fa-exclamation-triangle me-1"></i> Tolak
                                                    </button>
                                                    <x-reject-with-comment
                                                        modal-id="rejectModal{{ $item->dokumenTeknis->id }}"
                                                        action-url="/dokumen-teknis/reject/{{ $item->dokumenTeknis->id }}"
                                                        value="{{ $item->dokumenTeknis->komentar }}" />
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
                                                @endif
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
                <div class="d-flex justify-content-center mt-4">
                    {{ $dataAdmin->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
