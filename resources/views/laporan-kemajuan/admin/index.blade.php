@extends('layout.app')
@section('title', 'Dokumen Laporan Kemajuan')
@section('description', 'Laporan Kemajuan')
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

                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="text-end">
                        <button class="btn btn-dark" type="button" data-bs-toggle="collapse" data-bs-target="#filterSection"
                            aria-expanded="false" aria-controls="filterSection">
                            <i class="fas fa-filter me-2"></i>Filter
                        </button>
                    </div>

                    <form action="{{ route('laporan-kemajuan') }}" method="GET" class="">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari tim..."
                                value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-search"></i> Cari
                            </button>
                            <a href="{{ route('laporan-kemajuan') }}" class="btn btn-primary ms-2">Atur Ulang</a>

                        </div>
                    </form>
                </div>
                <div class="collapse mt-3" id="filterSection">
                    <div class="card card-body border shadow-sm">
                        <form method="GET" action="{{ route('laporan-kemajuan') }}">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-4">
                                    <label for="tahun" class="form-label text-dark fw-semibold">Tahun
                                        Pendaftaran:</label>
                                    <select name="tahun" id="tahun" class="form-select">
                                        <option value="">Semua Tahun</option>
                                        @foreach (range(date('Y'), 2020) as $year)
                                            <option value="{{ $year }}"
                                                {{ request('tahun') == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-dark ">
                                        <i class="fas fa-filter me-1"></i> Terapkan Filter
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered">
                        <thead class="">
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 25%" class="text-center">Tim</th>
                                <th style="width: 10%" class="text-center">File
                                </th>
                                <th style="width: 10%" class="text-center">Status
                                </th>
                                @can('approve laporan kemajuan')
                                    <th style="width: 15%" class="text-center">Aksi</th>
                                @endcan

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataAdmin as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-bold text-start">Tim {{ $item->judul }}</td>

                                    <td class="text-center">
                                        @if ($item->laporan_kemajuan && $item->laporan_kemajuan->file_path)
                                            <a href="{{ asset('storage/laporan-kemajuan/' . $item->laporan_kemajuan->file_path) }}"
                                                class="btn btn-outline-primary" target="_blank"><i
                                                    class="fas fa-eye"></i></a>
                                        @else
                                            <span class="badge bg-danger">Belum Upload</span>
                                        @endif
                                    </td>
                                    <td class="fw-bold text-center">
                                        @if ($item->laporan_kemajuan && $item->laporan_kemajuan->status === 'Ditolak')
                                            <span class="badge bg-danger" tabindex="0" role="button"
                                                data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                style="cursor: pointer;">
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
                                                            {{ $item->laporan_kemajuan->komentar }}
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            @if ($item->laporan_kemajuan && $item->laporan_kemajuan->file_path)
                                                @php
                                                    switch ($item->laporan_kemajuan->status) {
                                                        case 'Belum Valid':
                                                            $badgeClass = 'badge bg-warning';
                                                            break;
                                                        case 'Valid':
                                                            $badgeClass = 'badge bg-success';
                                                            break;
                                                        default:
                                                            $badgeClass = 'badge bg-secondary';
                                                            break;
                                                    }
                                                @endphp
                                                <span class="{{ $badgeClass }}">
                                                    {{ $item->laporan_kemajuan->status }}
                                                </span>
                                            @else
                                                <span class="badge bg-danger">Belum Upload</span>
                                            @endif
                                        @endif
                                    </td>


                                    @can('approve laporan kemajuan')
                                        <td class="text-center">

                                            @if (
                                                $item->laporan_kemajuan &&
                                                    $item->laporan_kemajuan->file_path &&
                                                    $item->registration_validation->status !== 'Lanjutkan Program')
                                                @if ($item->laporan_kemajuan->status === 'Valid')
                                                    <a href="/pendaftaran/detail/{{ $item->id }}"
                                                        class="btn btn-outline-info">
                                                        <i class="fa-solid fa-circle-info"></i>
                                                    </a>
                                                @elseif($item->laporan_kemajuan->status === 'Ditolak')
                                                    <button type="button" class="btn btn-outline-success"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#approveModal{{ $item->id }}">
                                                        <i class="fas fa-check"></i> 
                                                    </button>
                                                    <!-- Gunakan komponen modal -->
                                                    <x-confirm-modal modal-id="approveModal{{ $item->id }}"
                                                        title="Konfirmasi Persetujuan"
                                                        message="Apakah Anda yakin ingin menerima laporan ini?"
                                                        action-url="/laporan-kemajuan/approve/{{ $item->laporan_kemajuan->id }}"
                                                        confirm-text="Iya" />
                                                @else
                                                    <button type="button" class="btn btn-outline-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#rejectModal{{ $item->id }}">
                                                        <i class="fas fa-exclamation-triangle"></i> 
                                                    </button>
                                                    <!-- Gunakan komponen modal -->
                                                    <x-reject-with-comment modal-id="rejectModal{{ $item->id }}"
                                                        title="Laporan Kemajuan"
                                                        action-url="/laporan-kemajuan/reject/{{ $item->laporan_kemajuan->id }}"
                                                        value="{{ $item->laporan_kemajuan->komentar }}" />

                                                    <button type="button" class="btn btn-outline-success"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#approveModal{{ $item->id }}">
                                                        <i class="fas fa-check"></i> 
                                                    </button>
                                                    <!-- Gunakan komponen modal -->
                                                    <x-confirm-modal modal-id="approveModal{{ $item->id }}"
                                                        title="Konfirmasi Persetujuan"
                                                        message="Apakah Anda yakin ingin menerima laporan ini?"
                                                        action-url="/laporan-kemajuan/approve/{{ $item->laporan_kemajuan->id }}"
                                                        confirm-text="Iya" />
                                                @endif
                                            @elseif($item->registration_validation->status === 'Lanjutkan Program')
                                                <a href="/pendaftaran/detail/{{ $item->id }}"
                                                    class="btn btn-outline-info">
                                                    <i class="fa-solid fa-circle-info"></i>
                                                </a>
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
    <script></script>
@endsection
