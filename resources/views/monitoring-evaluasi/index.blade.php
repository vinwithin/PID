@extends('layout.app')
@section('title', 'Monev')
@section('content')
    {{-- <h1 class="h3 mb-3"><strong>Admin</strong> Dashboard</h1> --}}
    <div class="w-100">
        <div class="card">
            {{-- <div class="container-fluid px-4 py-4"> --}}
                <div class="card shadow-sm border-0">
                    @role('admin|reviewer|super admin')
                        <div class="card-header text-dark py-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="mb-0 text-dark">
                                    <i class="fas fa-clipboard-list me-3"></i>Monitoring dan Evaluasi Kelompok
                                </h3>
                                <div class="filter-toggle">
                                    <button class="btn btn-dark" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#filterSection" aria-expanded="false" aria-controls="filterSection">
                                        <i class="fas fa-filter me-2"></i>Filter
                                    </button>
                                </div>
                            </div>
                            {{-- <div class="collapse" id="filterSection">
                        <form method="GET" action="{{ route('pendaftaran.search') }}" class="mt-3">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label text-white-50">Filter berdasarkan status:</label>
                                    <div class="d-flex flex-wrap">
                                        @php
                                            $statuses = [
                                                'Belum valid' => 'Belum Valid',
                                                'valid' => 'Valid',
                                                'lolos' => 'Lolos Program',
                                            ];
                                        @endphp
                                        @foreach ($statuses as $value => $label)
                                            <div class="form-check me-3 mb-2">
                                                <input class="form-check-input" type="checkbox" name="filters[]"
                                                    value="{{ $value }}" id="filter{{ ucfirst($value) }}">
                                                <label class="form-check-label text-white"
                                                    for="filter{{ ucfirst($value) }}">
                                                    {{ $label }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-light">
                                            <i class="fas fa-check-circle me-2"></i>Terapkan Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div> --}}
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="">
                                        <tr>
                                            <th>Nama Ketua</th>
                                            <th class="d-none d-xl-table-cell">Fakultas</th>
                                            <th class="d-none d-md-table-cell">Judul</th>
                                            <th>Laporan Kemajuan</th>
                                            <th class="d-none d-md-table-cell">Juri</th>
                                            <th class="d-none d-md-table-cell">Status</th>
                                            <th class="text-center" style="width: 15%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($data as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="ms-2">
                                                            <div class="fw-bold">{{ $item->nama_ketua }}</div>
                                                            <small class="text-muted">{{ $item->nim_ketua }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="d-none d-xl-table-cell">{{ $item->fakultas->nama }}</td>

                                                <td class="d-none d-md-table-cell">{{ Str::limit($item->judul, 30) }}</td>
                                                <td class="d-none d-md-table-cell">
                                                    <a href="{{ asset('storage/laporan-kemajuan/' . $item->laporan_kemajuan->file_path) }}"
                                                        class="btn btn-sm btn-outline-info" target="_blank"><i
                                                            class="fas fa-eye me-1"></i>Lihat File</a>
                                                </td>
                                                <td class="d-none d-md-table-cell">
                                                    @foreach ($item->status_monev as $status)
                                                        <p>{{ $status->user->name }}</p>
                                                    @endforeach
                                                </td>
                                                <td class="d-none d-md-table-cell">
                                                    <span
                                                        class="badge 
                                        @switch($item->registration_validation->status)
                                            @case('Menunggu Monev') bg-warning @break
                                            @case('lolos') bg-success @break
                                            @default bg-secondary
                                        @endswitch
                                    ">
                                                        {{ isset($item->status_monev[0]) && !empty($item->status_monev[0]->status) ? $item->status_monev[0]->status : 'Menunggu Monev' }}

                                                    </span>
                                                </td>

                                                <td class="text-center">
                                                    {{-- <div class="btn-group" role="group"> --}}
                                                        <a href="/pendaftaran/detail/{{ $item->id }}"
                                                            class="btn btn-sm btn-outline-info">
                                                            <i class="fas fa-info-circle me-1"></i>Detail
                                                        </a>
                                                        @can('assign-juri monev')
                                                            @if ($item->status_monev->where('registration_id', $item->id)->isEmpty())
                                                                <a href="{{ route('monev.reviewer', ['id' => $item->id]) }}"
                                                                    class="btn btn-sm btn-outline-success">
                                                                    <i class="fa-solid fa-user-plus me-2"></i>Pilih Juri
                                                                </a>
                                                            @elseif (isset($total[$item->id]) && is_array($total[$item->id]))
                                                                <a href="/monitoring-evaluasi/detail/{{ $item->id }}"
                                                                    class="btn btn-sm btn-outline-primary">
                                                                    <i class="fas fa-eye me-1"></i>Lihat Nilai
                                                                </a>
                                                            @else
                                                                <a href="/monitoring-evaluasi/reviewer-monev/edit/{{ $item->id }}"
                                                                    class="btn btn-sm btn-outline-success">
                                                                    <i class="fa-solid fa-user-plus me-2"></i>Edit Juri
                                                                </a>
                                                            @endif
                                                        @endcan
                                                        @can('approve monev')
                                                            @if ($item->registration_validation->status === 'lolos')
                                                                <button type="button" class="btn btn-sm btn-outline-success"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#approveModal{{ $item->id }}">
                                                                    <i class="fas fa-check me-1"></i> Lanjutkan
                                                                </button>
                                                                <!-- Gunakan komponen modal -->
                                                                <x-confirm-modal modal-id="approveModal{{ $item->id }}"
                                                                    title="Konfirmasi Persetujuan"
                                                                    message="Apakah Anda yakin ingin menyetujui proposal ini?"
                                                                    action-url="/monitoring-evaluasi/approve/{{ $item->id }}"
                                                                    confirm-text="Ya, Setujui" />

                                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#rejectModal{{ $item->id }}">
                                                                    <i class="fas fa-exclamation-triangle me-1"></i> Tolak
                                                                </button>
                                                                <!-- Gunakan komponen modal -->
                                                                <x-confirm-modal modal-id="rejectModal{{ $item->id }}"
                                                                    title="Konfirmasi Persetujuan"
                                                                    message="Apakah Anda yakin ingin menolak proposal ini?"
                                                                    action-url="/monitoring-evaluasi/reject/{{ $item->id }}"
                                                                    confirm-text="Iya" />
                                                            @endif
                                                        @elsecan('read monev')
                                                            @if (isset($total[$item->id]) && is_array($total[$item->id]))
                                                                <a href="/monitoring-evaluasi/detail/{{ $item->id }}"
                                                                    class="btn btn-sm btn-outline-primary">
                                                                    <i class="fas fa-eye me-1"></i>Lihat Nilai
                                                                </a>
                                                            @else
                                                                <span class="badge bg-warning text-center">
                                                                    Belum Ada Nilai
                                                                </span>
                                                            @endif
                                                        @endcan
                                                    {{-- </div> --}}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center text-muted p-4">
                                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                                    <p>Tidak ada data pendaftaran</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center mt-4">
                                {{ $data->links() }}
                            </div>

                        </div>

                        @elserole('dosen')
                        <div class="card-header bg-primary text-white py-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="mb-0 text-light">
                                    <i class="fas fa-clipboard-list me-3"></i>Monitoring dan Evaluasi Kelompok
                                </h3>
                                <div class="filter-toggle">
                                    <button class="btn btn-light" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#filterSection" aria-expanded="false" aria-controls="filterSection">
                                        <i class="fas fa-filter me-2"></i>Filter
                                    </button>
                                </div>
                            </div>

                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table  table-hover mb-0">
                                    <thead >
                                        <tr>
                                            <th>Nama Ketua</th>
                                            <th class="d-none d-xl-table-cell">Fakultas</th>
                                            <th>Bidang</th>
                                            <th class="d-none d-md-table-cell">Judul</th>
                                            <th class="d-none d-md-table-cell">Status</th>
                                            <th class="text-center" style="width: 15%">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($dataNilai as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="ms-2">
                                                            <div class="fw-bold">{{ $item->nama_ketua }}</div>
                                                            <small class="text-muted">{{ $item->nim_ketua }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="d-none d-xl-table-cell">{{ $item->fakultas->nama }}</td>
                                                <td>
                                                    <span class="badge bg-success">{{ $item->bidang->nama }}</span>
                                                </td>
                                                <td class="d-none d-md-table-cell">{{ Str::limit($item->judul, 30) }}</td>
                                                <td class="d-none d-md-table-cell">
                                                    <span
                                                        class="badge 
                                            @switch($item->registration_validation->status)
                                                @case('Menunggu Monev') bg-warning @break
                                                @case('lolos') bg-success @break
                                                @default bg-secondary
                                            @endswitch
                                        ">
                                                        {{ isset($item->status_monev[0]) && !empty($item->status_monev[0]->status) ? $item->status_monev[0]->status : 'Menunggu Monev' }}

                                                    </span>
                                                </td>

                                                <td class="text-center">
                                                        @if ($item->score_monev->where('user_id', auth()->user()->id)->isEmpty())
                                                            <a href="/monitoring-evaluasi/nilai/{{ $item->id }}"
                                                                class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-star me-1"></i>Beri Nilai
                                                            </a>
                                                        @endif


                                                        @if (isset($total[$item->id]) && is_array($total[$item->id]))
                                                            <a href="/monitoring-evaluasi/detail/{{ $item->id }}"
                                                                class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-eye me-1"></i>Lihat Nilai
                                                            </a>
                                                        @endif


                                                        {{-- <a href="/monitoring-evaluasi/detail/{{ $item->id }}"
                                                            class="btn btn-sm btn-outline-info">
                                                            <i class="fas fa-info-circle me-1"></i>Detail
                                                        </a> --}}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center text-muted p-4">
                                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                                    <p>Tidak ada data pendaftaran</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $dataNilai->links() }}
                                </div>
                            </div>

                        </div>
                    @endcan
                </div>
            {{-- </div> --}}
        </div>
    </div>
@endsection
