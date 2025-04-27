@extends('layout.app')
@section('title', 'Monitoring dan Evaluasi Kelompok')
@section('description', 'Monitoring dan Evaluasi ')
@section('content')
    {{-- <h1 class="h3 mb-3"><strong>Admin</strong> Dashboard</h1> --}}
    <div class="w-100">
        @if (session('success'))
            <x-success-modal :message="session('success')" />
        @endif
        @if (session('error'))
            <x-error-modal :message="session('error')" />
        @endif
        <div class="card">
            {{-- <div class="container-fluid px-4 py-4"> --}}
            <div class="card shadow-sm border-0">
                @role('admin|reviewer|super admin')
                    <div class="card-header text-dark ">
                        <div class="d-flex justify-content-end align-items-end">
                            <form action="{{ route('monev.index') }}" method="GET" class="">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari..."
                                        value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa fa-search"></i> Cari
                                    </button>
                                    <a href="{{ route('monev.index') }}" class="btn btn-success ms-2">Reset</a>
        
                                </div>
                            </form>
                        </div>
                        
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
                                                    @if (isset($total[$item->id]) && count($total[$item->id]) == 2 && $item->registration_validation->status !== 'Lanjutkan Program')
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
                    <div class="card-header  text-white ">
                        <div class="d-flex justify-content-end align-items-end">
                            
                            <form action="{{ route('monev.index') }}" method="GET" class="">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari..."
                                        value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa fa-search"></i> Cari
                                    </button>
                                    <a href="{{ route('monev.index') }}" class="btn btn-success ms-2">Reset</a>
        
                                </div>
                            </form>
                        </div>

                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table  table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Nama Ketua</th>
                                        <th class="d-none d-xl-table-cell">Fakultas</th>
                                        <th class="d-none d-md-table-cell">Judul</th>
                                        <th>Laporan Kemajuan</th>
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

                                            <td class="d-none d-md-table-cell">{{ Str::limit($item->judul, 30) }}</td>
                                            <td>
                                                <a href="{{ asset('storage/laporan-kemajuan/' . $item->laporan_kemajuan->file_path) }}"
                                                    class="btn btn-sm btn-outline-info" target="_blank"><i
                                                        class="fas fa-eye me-1"></i>Lihat File</a>
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
                                                <a href="/pendaftaran/detail/{{ $item->id }}"
                                                    class="btn btn-sm btn-outline-info">
                                                    <i class="fas fa-info-circle me-1"></i>Detail
                                                </a>
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
