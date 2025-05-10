@extends('layout.app')
@section('title', 'Dokumen Publikasi')
@section('description', 'Laporan Akhir')

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
                    <form action="{{ route('dokumen-publikasi') }}" method="GET" class="">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari tim..."
                                value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-search"></i> Cari
                            </button>
                            <a href="{{ route('dokumen-publikasi') }}" class="btn btn-success ms-2">Reset</a>

                        </div>
                    </form>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 5%" class="text-center">No</th>
                                <th style="width: 10%" class="text-center">Tim</th>
                                <th style="width: 15%" class="text-center">File draf Artikel Berita Media Massa</th>
                                <th style="width: 15%" class="text-center">Bukti Ketercapaian HAKI (Sertifikat
                                    Haki/Draft Pendaftaran HAKI)</th>
                                <th style="width: 20%" class="text-center">Bukti Ketercapaian Seminar atau Publikasi Artikel
                                </th>
                                <th style="width: 15%" class="text-center">Link Artikel</th>
                                <th style="width: 10%" class="text-center">Status</th>
                                @can('agree publication')
                                    <th style="width: 15%" class="text-center">Aksi</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataAdmin as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="fw-bold text-center">Tim {{ $item->judul }}</td>

                                    <td class="text-center">
                                        @if ($item->dokumenPublikasi && $item->dokumenPublikasi->file_artikel)
                                            <div class="d-flex justify-content-center align-items-center gap-2">

                                                <a href="{{ asset('storage/dokumen-publikasi/' . $item->dokumenPublikasi->file_artikel) }}"
                                                    class="btn btn-sm btn-outline-primary" target="_blank"><i
                                                        class="fas fa-eye me-1"></i>Lihat File</a>
                                                <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ $item->dokumenPublikasi->status_artikel }}">
                                                    <i
                                                        class="fa-solid 
                                                                        @switch($item->dokumenPublikasi->status_artikel)
                                                                            @case('Publish') fa-circle-check @break
                                                                            @case('Draft') fa-bookmark @break
                                                                            @default fa-question-circle
                                                                        @endswitch
                                                                me-2"></i>
                                                </span>
                                            </div>
                                        @else
                                            <span class="badge bg-danger"><i
                                                    class="fa-solid fa-circle-exclamation me-1"></i>Belum
                                                Upload</span>
                                    </td>
                            @endif
                            <td class="text-center">
                                @if ($item->dokumenPublikasi && $item->dokumenPublikasi->file_haki)
                                    <div class="d-flex justify-content-center align-items-center gap-2">

                                        <a href="{{ asset('storage/dokumen-publikasi/' . $item->dokumenPublikasi->file_haki) }}"
                                            class="btn btn-sm btn-outline-primary" target="_blank"><i
                                                class="fas fa-eye me-1"></i>Lihat
                                            File</a>
                                        <span data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="{{ $item->dokumenPublikasi->status_haki }}">
                                            <i
                                                class="fa-solid 
                                                                        @switch($item->dokumenPublikasi->status_haki)
                                                                            @case('Publish') fa-circle-check @break
                                                                            @case('Draft') fa-bookmark @break
                                                                            @default fa-question-circle
                                                                        @endswitch
                                                                me-2"></i>
                                        </span>
                                    </div>
                                @else
                                    <span class="badge bg-danger"><i class="fa-solid fa-circle-exclamation me-1"></i>Belum
                                        Upload</span>
                            </td>
                            @endif
                            <td class="text-center">
                                @if ($item->dokumenPublikasi && $item->dokumenPublikasi->file_bukti_publikasi)
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <a href="{{ asset('storage/dokumen-teknis/' . $item->dokumenPublikasi->file_bukti_publikasi) }}"
                                            class="btn btn-sm btn-outline-primary" target="_blank">
                                            <i class="fas fa-eye me-1"></i> Lihat File
                                        </a>

                                        <span data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="{{ $item->dokumenPublikasi->status_publikasi }}">
                                            <i
                                                class="fa-solid 
                                                                        @switch($item->dokumenPublikasi->status_publikasi)
                                                                            @case('Publish') fa-circle-check @break
                                                                            @case('Draft') fa-bookmark @break
                                                                            @case('Submited') fa-bookmark @break
                                                                            @default fa-question-circle
                                                                        @endswitch
                                                                me-2"></i>
                                        </span>
                                    </div>
                                @else
                                    <span class="badge bg-danger"><i class="fa-solid fa-circle-exclamation me-1"></i>Belum
                                        Upload</span>
                                @endif

                            </td>
                            <td class="text-center">
                                @if ($item->dokumenPublikasi && $item->dokumenPublikasi->link_artikel)
                                    <a href="{{ $item->dokumenPublikasi->link_artikel }}"
                                        class="btn btn-sm btn-outline-primary" target="_blank"><i
                                            class="fas fa-eye me-1"></i>Link Artikel</a>
                                @else
                                    <span class="badge bg-danger"><i class="fa-solid fa-circle-exclamation me-1"></i>Belum
                                        Upload</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($item->dokumenPublikasi && $item->dokumenPublikasi->status === 'Ditolak')
                                    <span class="badge bg-danger" tabindex="0" role="button" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal" style="cursor: pointer;">
                                        Ditolak
                                        <i class="fas fa-info-circle ms-1 text-white"></i>
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
                                                    {{ $item->dokumenPublikasi->komentar }}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @elseif(!$item->dokumenPublikasi)
                                    <span>Belum Ada Status</span>
                                @else
                                    {{ $item->dokumenPublikasi->status }}
                                @endif
                            </td>

                            @can('agree publication')
                                <td class="text-center">
                                    @if ($item->dokumenPublikasi)
                                        @if ($item->dokumenPublikasi->status === 'Ditolak')
                                            <button type="button" class="btn btn-sm btn-outline-success"
                                                data-bs-toggle="modal"
                                                data-bs-target="#approveModal{{ $item->dokumenPublikasi->id }}">
                                                <i class="fas fa-check me-1"></i> Terima
                                            </button>
                                            <x-confirm-modal modal-id="approveModal{{ $item->dokumenPublikasi->id }}"
                                                title="Konfirmasi Persetujuan"
                                                message="Apakah Anda yakin ingin menerima laporan akhir ini?"
                                                action-url="/dokumen-publikasi/approve/{{ $item->dokumenPublikasi->id }}"
                                                confirm-text="Ya, Setujui" />
                                        @elseif($item->dokumenPublikasi->status === 'Valid')
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#rejectModal{{ $item->dokumenPublikasi->id }}">
                                                <i class="fas fa-exclamation-triangle me-1"></i> Tolak
                                            </button>
                                            <x-reject-with-comment modal-id="rejectModal{{ $item->dokumenPublikasi->id }}"
                                                action-url="/dokumen-publikasi/reject/{{ $item->dokumenPublikasi->id }}"
                                                value="{{ $item->dokumenPublikasi->komentar }}" />
                                        @else
                                            <button type="button" class="btn btn-sm btn-outline-success"
                                                data-bs-toggle="modal"
                                                data-bs-target="#approveModal{{ $item->dokumenPublikasi->id }}">
                                                <i class="fas fa-check me-1"></i> Terima
                                            </button>
                                            <x-confirm-modal modal-id="approveModal{{ $item->dokumenPublikasi->id }}"
                                                title="Konfirmasi Persetujuan"
                                                message="Apakah Anda yakin ingin menerima laporan akhir ini?"
                                                action-url="/dokumen-publikasi/approve/{{ $item->dokumenPublikasi->id }}"
                                                confirm-text="Ya, Setujui" />
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#rejectModal{{ $item->dokumenPublikasi->id }}">
                                                <i class="fas fa-exclamation-triangle me-1"></i> Tolak
                                            </button>
                                            <x-reject-with-comment modal-id="rejectModal{{ $item->dokumenPublikasi->id }}"
                                                action-url="/dokumen-publikasi/reject/{{ $item->dokumenPublikasi->id }}"
                                                value="{{ $item->dokumenPublikasi->komentar }}" />
                                        @endif
                                    @endif

                                </td>
                            @endcan

                            </tr>

                        </tbody>
                        @endforeach

                    </table>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $dataAdmin->links() }}
                </div>
            </div>
        </div>

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
@endsection
