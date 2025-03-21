@extends('layout.app')
@section('title', 'Dokumentasi Kegiatan')

@section('content')
    <div class="w-100">
        <div class="card">
            <div class="container-fluid px-4 ">
                <div class="card-header d-flex justify-content-end align-items-end">
                    <form action="{{ route('dokumentasi-kegiatan') }}" method="GET" class="">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari tim..."
                                value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-search"></i> Cari
                            </button>
                            <a href="{{ route('dokumentasi-kegiatan') }}" class="btn btn-success ms-2">Reset</a>

                        </div>
                    </form>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 10%">Tim</th>
                                <th style="width: 15%" class="text-center">Link Tautan Video Youtube</th>
                                <th style="width: 15%" class="text-center">Tautan Sosial Media</th>
                                <th style="width: 15%" class="text-center">Link/tautan Google Drive dokumentasi kegiatan
                                </th>
                                <th style="width: 15%" class="text-center">Album</th>
                                <th style="width: 10%" class="text-center">Status</th>
                                @can('agree publication')
                                    <th style="width: 15%" class="text-center">Aksi</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataAdmin as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-bold text-center">Tim {{ $item->judul }}</td>
                                    <td class="text-center">
                                        @if ($item->dokumentasiKegiatan && $item->dokumentasiKegiatan->link_youtube)
                                            <a href="{{ $item->dokumentasiKegiatan->link_youtube }}"
                                                class="btn btn-sm btn-outline-primary" target="_blank"><i
                                                    class="fas fa-eye me-1"></i>Link Youtube</a>
                                        @else
                                            <span class="badge bg-danger">Belum Upload</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($item->dokumentasiKegiatan && $item->dokumentasiKegiatan->link_social_media)
                                            <a href="{{ $item->dokumentasiKegiatan->link_social_media }}"
                                                class="btn btn-sm btn-outline-primary" target="_blank"><i
                                                    class="fas fa-eye me-1"></i>Link Sosial Media</a>
                                        @else
                                            <span class="badge bg-danger">Belum Upload</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($item->dokumentasiKegiatan && $item->dokumentasiKegiatan->link_dokumentasi)
                                            <a href="{{ $item->dokumentasiKegiatan->link_dokumentasi }}"
                                                class="btn btn-sm btn-outline-primary" target="_blank"><i
                                                    class="fas fa-eye me-1"></i>Link Dokumentasi</a>
                                        @else
                                            <span class="badge bg-danger">Belum Upload</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($item->dokumentasiKegiatan && $item->dokumentasiKegiatan->link_dokumentasi)
                                            <a href="/dokumentasi-kegiatan/album/{{ $item->dokumentasiKegiatan->id }}"
                                                class="btn btn-sm btn-outline-primary"><i class="fas fa-eye me-1"></i>Lihat
                                                Album</a>
                                        @else
                                            <span class="badge bg-danger">Belum Upload</span>
                                        @endif

                                    </td>
                                    <td class="text-center">
                                        {{ $item->dokumentasiKegiatan->status ?? 'Belum ada status' }}
                                    </td>
                                    @can('agree publication')
                                        <td class="text-center">
                                            @if ($item->dokumentasiKegiatan)
                                                @if ($item->dokumentasiKegiatan->status === 'Valid')
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#rejectModal{{ $item->dokumentasiKegiatan->id }}">
                                                        <i class="fas fa-exclamation-triangle me-1"></i> Tolak
                                                    </button>
                                                    <x-confirm-modal modal-id="rejectModal{{ $item->dokumentasiKegiatan->id }}"
                                                        title="Konfirmasi Persetujuan"
                                                        message="Apakah Anda yakin ingin menolak laporan akhir ini?"
                                                        action-url="/dokumentasi-kegiatan/reject/{{ $item->dokumentasiKegiatan->id }}"
                                                        confirm-text="Ya, Tolak" />
                                                @elseif($item->dokumentasiKegiatan->status === 'Ditolak')
                                                    <button type="button" class="btn btn-sm btn-outline-success"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#approveModal{{ $item->dokumentasiKegiatan->id }}">
                                                        <i class="fas fa-check me-1"></i> Terima
                                                    </button>
                                                    <x-confirm-modal
                                                        modal-id="approveModal{{ $item->dokumentasiKegiatan->id }}"
                                                        title="Konfirmasi Persetujuan"
                                                        message="Apakah Anda yakin ingin menerima laporan akhir ini?"
                                                        action-url="/dokumentasi-kegiatan/approve/{{ $item->dokumentasiKegiatan->id }}"
                                                        confirm-text="Ya, Setujui" />
                                                @else
                                                    <button type="button" class="btn btn-sm btn-outline-success"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#approveModal{{ $item->dokumentasiKegiatan->id }}">
                                                        <i class="fas fa-check me-1"></i> Terima
                                                    </button>
                                                    <x-confirm-modal
                                                        modal-id="approveModal{{ $item->dokumentasiKegiatan->id }}"
                                                        title="Konfirmasi Persetujuan"
                                                        message="Apakah Anda yakin ingin menerima laporan akhir ini?"
                                                        action-url="/dokumentasi-kegiatan/approve/{{ $item->dokumentasiKegiatan->id }}"
                                                        confirm-text="Ya, Setujui" />

                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#rejectModal{{ $item->dokumentasiKegiatan->id }}">
                                                        <i class="fas fa-exclamation-triangle me-1"></i> Tolak
                                                    </button>
                                                    <x-confirm-modal modal-id="rejectModal{{ $item->dokumentasiKegiatan->id }}"
                                                        title="Konfirmasi Persetujuan"
                                                        message="Apakah Anda yakin ingin menolak laporan akhir ini?"
                                                        action-url="/dokumentasi-kegiatan/reject/{{ $item->dokumentasiKegiatan->id }}"
                                                        confirm-text="Ya, Tolak" />
                                                @endif
                                            @else
                                            @endif
                                        </td>
                                    @endcan
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
