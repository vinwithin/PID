@extends('layout.app')
@section('title', 'Dokumen Publikasi')
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
                                <th style="width: 15%" class="text-center">Konten</th>
                                <th style="width: 15%" class="text-center">File draf Artikel Berita Media Massa</th>
                                <th style="width: 15%" class="text-center">Bukti Ketercapaian HAKI (Sertifikat
                                    Haki/Draft Pendaftaran HAKI)</th>
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
                                    <td rowspan="2" class="text-center">{{ $loop->iteration }}</td>
                                    <td rowspan="2" class="fw-bold text-center">Tim {{ $item->judul }}</td>
                                    <td>Dokumen</td>
                                    <td class="text-center">
                                        @if ($item->dokumenPublikasi && $item->dokumenPublikasi->file_artikel)
                                            <a href="{{ asset('storage/dokumen-publikasi/' . $item->dokumenPublikasi->file_artikel) }}"
                                                class="btn btn-sm btn-outline-primary" target="_blank"><i
                                                    class="fas fa-eye me-1"></i>Lihat File</a>
                                    </td>
                                @else
                                    <span class="badge bg-danger"><i class="fa-solid fa-circle-exclamation me-1"></i>Belum
                                        Upload</span>
                            @endif
                            <td class="text-center">
                                @if ($item->dokumenPublikasi && $item->dokumenPublikasi->file_haki)
                                    <a href="{{ asset('storage/dokumen-publikasi/' . $item->dokumenPublikasi->file_haki) }}"
                                        class="btn btn-sm btn-outline-primary" target="_blank"><i
                                            class="fas fa-eye me-1"></i>Lihat
                                        File</a>
                            </td>
                        @else
                            <span class="badge bg-danger"><i class="fa-solid fa-circle-exclamation me-1"></i>Belum
                                Upload</span>
                            @endif
                            <td rowspan="2" class="text-center">
                                @if ($item->dokumenPublikasi && $item->dokumenPublikasi->link_artikel)
                                    <a href="{{ $item->dokumenPublikasi->link_artikel }}"
                                        class="btn btn-sm btn-outline-primary" target="_blank"><i
                                            class="fas fa-eye me-1"></i>Link Artikel</a>
                            </td>
                        @else
                            <span class="badge bg-danger"><i class="fa-solid fa-circle-exclamation me-1"></i>Belum
                                Upload</span>
                            @endif
                            <td rowspan="2" class="text-center">
                                {{ $item->dokumenPublikasi->status ?? 'Belum ada status' }}
                            </td>

                            @can('agree publication')
                                <td rowspan="2" class="text-center">
                                    @if ($item->dokumenPublikasi)
                                        @if ($item->dokumenPublikasi->status === 'Ditolak')
                                            <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal"
                                                data-bs-target="#approveModal{{ $item->dokumenPublikasi->id }}">
                                                <i class="fas fa-check me-1"></i> Terima
                                            </button>
                                            <x-confirm-modal modal-id="approveModal{{ $item->dokumenPublikasi->id }}"
                                                title="Konfirmasi Persetujuan"
                                                message="Apakah Anda yakin ingin menerima laporan akhir ini?"
                                                action-url="/dokumen-publikasi/approve/{{ $item->dokumenPublikasi->id }}"
                                                confirm-text="Ya, Setujui" />
                                        @elseif($item->dokumenPublikasi->status === 'Valid')
                                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#rejectModal{{ $item->dokumenPublikasi->id }}">
                                                <i class="fas fa-exclamation-triangle me-1"></i> Tolak
                                            </button>
                                            <x-confirm-modal modal-id="rejectModal{{ $item->dokumenPublikasi->id }}"
                                                title="Konfirmasi Persetujuan"
                                                message="Apakah Anda yakin ingin menolak laporan akhir ini?"
                                                action-url="/dokumen-publikasi/reject/{{ $item->dokumenPublikasi->id }}"
                                                confirm-text="Ya, Tolak" />
                                        @else
                                            <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal"
                                                data-bs-target="#approveModal{{ $item->dokumenPublikasi->id }}">
                                                <i class="fas fa-check me-1"></i> Terima
                                            </button>
                                            <x-confirm-modal modal-id="approveModal{{ $item->dokumenPublikasi->id }}"
                                                title="Konfirmasi Persetujuan"
                                                message="Apakah Anda yakin ingin menerima laporan akhir ini?"
                                                action-url="/dokumen-publikasi/approve/{{ $item->dokumenPublikasi->id }}"
                                                confirm-text="Ya, Setujui" />
                                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                                data-bs-target="#rejectModal{{ $item->dokumenPublikasi->id }}">
                                                <i class="fas fa-exclamation-triangle me-1"></i> Tolak
                                            </button>
                                            <x-confirm-modal modal-id="rejectModal{{ $item->dokumenPublikasi->id }}"
                                                title="Konfirmasi Persetujuan"
                                                message="Apakah Anda yakin ingin menolak laporan akhir ini?"
                                                action-url="/dokumen-publikasi/reject/{{ $item->dokumenPublikasi->id }}"
                                                confirm-text="Ya, Tolak" />
                                        @endif
                                    @endif

                                </td>
                            @endcan

                            </tr>
                            <tr>
                                <td>Status</td>
                                <td class="text-center">
                                    <span class="badge {{ $item->dokumenPublikasi ? 'bg-primary' : 'bg-danger' }}">
                                        {{ $item->dokumenPublikasi ? $item->dokumenPublikasi->status_artikel : 'Belum Upload' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $item->dokumenPublikasi ? 'bg-primary' : 'bg-danger' }}">
                                        {{ $item->dokumenPublikasi ? $item->dokumenPublikasi->status_haki : 'Belum Upload' }}
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
