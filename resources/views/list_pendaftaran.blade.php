@extends('layout.app')
@section('title', 'Daftar Proposal')
@section('description', 'Kelola Pendaftaran')
@section('content')
    {{-- <h1 class="h3 mb-3"><strong>Admin</strong> Dashboard</h1> --}}
    <div class="w-100" id="conntainer-card">
        @if (session('success'))
            <x-success-modal :message="session('success')" />
        @endif
        @if (session('error'))
            <x-error-modal :message="session('error')" />
        @endif
        <div class="card">
            @role('admin|super admin')
                <div class="card-header  text-dark py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="text-dark">
                            <i class="fas fa-clipboard-list me-3"></i>
                        </h3>
                        <div class="filter-toggle">
                            <button class="btn btn-dark" type="button" data-bs-toggle="collapse" data-bs-target="#filterSection"
                                aria-expanded="false" aria-controls="filterSection">
                                <i class="fas fa-filter me-2"></i>Filter
                            </button>
                        </div>
                    </div>
                    <div class="collapse" id="filterSection">
                        <form method="GET" action="{{ route('pendaftaran.search') }}" class="mt-3">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label text-dark-50">Filter berdasarkan status:</label>
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
                                                <label class="form-check-label text-dark" for="filter{{ ucfirst($value) }}">
                                                    {{ $label }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-dark">
                                            <i class="fas fa-check-circle me-2"></i>Terapkan Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Nama Ketua</th>
                                    <th class="d-none d-xl-table-cell">Fakultas</th>
                                    <th>Bidang</th>
                                    <th class="d-none d-md-table-cell">Judul</th>
                                    <th class="d-none d-md-table-cell">Status</th>
                                    <th class="text-center">Total Nilai</th>
                                    <th class="text-center">Aksi</th>
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
                                        <td>
                                            <span class="badge bg-success">{{ $item->bidang->nama }}</span>
                                        </td>
                                        <td class="d-none d-md-table-cell">{{ Str::limit($item->judul, 30) }}</td>
                                        <td class="d-none d-md-table-cell">
                                            <span
                                                class="badge 
                                            @switch($item->registration_validation->status)
                                                @case('Belum valid') bg-warning @break
                                                @case('valid') bg-primary @break
                                                @case('lolos') bg-success @break
                                                @default bg-secondary
                                            @endswitch
                                        ">
                                                {{ $item->registration_validation->status }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if (isset($totalId[$item->id]) && is_array($totalId[$item->id]) && count($totalId[$item->id]) > 0)
                                                <span class="badge bg-info">
                                                    {{ array_sum($totalId[$item->id]) }}
                                                </span>
                                            @else
                                                <span class="badge bg-light text-dark">Belum Dinilai</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                @can('approve proposal')
                                                    @if ($item->registration_validation->status === 'valid')
                                                        @if ($item->reviewAssignments->where('registration_id', $item->id)->isEmpty())
                                                            <a href="{{ route('pilih-reviewer', ['id' => $item->id]) }}"
                                                                class="btn btn-sm btn-outline-success">
                                                                <i class="fa-solid fa-user-plus me-2"></i>Pilih Juri
                                                            </a>
                                                        @elseif(!isset($totalId[$item->id]))
                                                            <a href="/edit-reviewer/{{ $item->id }}"
                                                                class="btn btn-sm btn-outline-success">
                                                                <i class="fa-solid fa-user-plus me-2"></i>Edit Juri
                                                            </a>
                                                        @endif
                                                    @elseif ($item->registration_validation->status === 'Belum valid')
                                                        <!-- Tombol untuk membuka modal -->
                                                        <button type="button" class="btn btn-sm btn-outline-success"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#approveModal{{ $item->id }}">
                                                            <i class="fas fa-check me-1"></i> Setujui
                                                        </button>

                                                        <!-- Gunakan komponen modal -->
                                                        <x-confirm-modal modal-id="approveModal{{ $item->id }}"
                                                            title="Konfirmasi Persetujuan"
                                                            message="Apakah Anda yakin ingin menyetujui proposal ini?"
                                                            action-url="{{ route('approve', ['id' => $item->id]) }}"
                                                            confirm-text="Ya, Setujui" />

                                                        <button type="button" class="btn btn-sm btn-outline-warning"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#rejectModal{{ $item->id }}">
                                                            <i class="fas fa-check me-1"></i> Tolak
                                                        </button>

                                                        <!-- Gunakan komponen modal -->
                                                        <x-confirm-modal modal-id="rejectModal{{ $item->id }}"
                                                            title="Konfirmasi Persetujuan"
                                                            message="Apakah Anda yakin ingin menolak proposal ini?"
                                                            action-url="{{ route('reject', ['id' => $item->id]) }}"
                                                            confirm-text="Ya, Setujui" />
                                                    @elseif($item->registration_validation->status === 'Tidak Lolos')
                                                        <button type="button" class="btn btn-sm btn-outline-success"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#approveModal{{ $item->id }}">
                                                            <i class="fas fa-check me-1"></i> Setujui
                                                        </button>

                                                        <!-- Gunakan komponen modal -->
                                                        <x-confirm-modal modal-id="approveModal{{ $item->id }}"
                                                            title="Konfirmasi Persetujuan"
                                                            message="Apakah Anda yakin ingin menyetujui proposal ini?"
                                                            action-url="{{ route('approve', ['id' => $item->id]) }}"
                                                            confirm-text="Ya, Setujui" />
                                                    @endif
                                                    @if (
                                                        $item->registration_validation->status === 'valid' &&
                                                            isset($totalId[$item->id]) &&
                                                            count($totalId[$item->id]) === 2)
                                                        <button type="button" class="btn btn-sm btn-outline-success"
                                                            data-bs-toggle="modal" data-bs-target="#lolosModal{{ $item->id }}">
                                                            <i class="fas fa-award me-1"></i> Lolos
                                                        </button>
                                                        <x-confirm-modal modal-id="lolosModal{{ $item->id }}"
                                                            title="Konfirmasi Persetujuan"
                                                            message="Apakah Anda yakin ingin meloloskan proposal ini?"
                                                            action-url="/approve-to-program/{{ $item->id }}"
                                                            confirm-text="Ya, Setujui" />
                                                    @endif
                                                @endcan
                                                @can('assessing proposal')
                                                    @if ($item->proposal_score->where('user_id', auth()->user()->id)->isEmpty())
                                                        <a href="/reviewer/nilai/{{ $item->id }}"
                                                            class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-star me-1"></i>Beri Nilai
                                                        </a>
                                                    @endif
                                                @endcan
                                                @if (isset($totalId[$item->id]) && is_array($totalId[$item->id]) && count($totalId[$item->id]) > 0)
                                                    <a href="/pendaftaran/detail-nilai/{{ $item->id }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye me-1"></i>Lihat Nilai
                                                    </a>
                                                @endif
                                                <a href="/pendaftaran/detail/{{ $item->id }}"
                                                    class="btn btn-sm btn-outline-info">
                                                    <i class="fas fa-info-circle me-1"></i>Detail
                                                </a>
                                            </div>
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
                            {{ $data->links() }}
                        </div>

                    </div>
                </div>
                @elserole('reviewer|dosen')
                <div class="card-header text-white py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="mb-0 text-dark">
                            <i class="fas fa-clipboard-list me-3"></i>Daftar Pendaftaran
                        </h3>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Nama Ketua</th>
                                    <th class="d-none d-xl-table-cell">Fakultas</th>
                                    <th>Bidang</th>
                                    <th class="d-none d-md-table-cell">Judul</th>
                                    <th class="d-none d-md-table-cell">Status Review</th>
                                    <th class="text-center">Nilai Anda</th>
                                    <th class="text-center">Aksi</th>
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
                                            @switch($item->reviewAssignments[0]->status)
                                                @case('Menunggu Review') bg-warning @break
                                                @case('Selesai Direview') bg-success @break
                                                @default bg-secondary
                                            @endswitch
                                        ">
                                                {{ $item->reviewAssignments[0]->status }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if (isset($totalId[$item->id]) && is_array($totalId[$item->id]) && count($totalId[$item->id]) > 0)
                                                <span class="badge bg-primary">
                                                    {{ $totalId[$item->id][auth()->user()->name] ?? '-' }}
                                                </span>
                                            @else
                                                <span class="badge bg-light text-dark">Belum Dinilai</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                @if ($item->proposal_score->where('user_id', auth()->user()->id)->isEmpty())
                                                    <a href="/reviewer/nilai/{{ $item->id }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-star me-1"></i>Beri Nilai
                                                    </a>
                                                @endif

                                                @if (isset($totalId[$item->id]) && is_array($totalId[$item->id]) && count($totalId[$item->id]) > 0)
                                                    <a href="/pendaftaran/detail-nilai/{{ $item->id }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye me-1"></i>Lihat Nilai
                                                    </a>
                                                @endif

                                                <a href="/pendaftaran/detail/{{ $item->id }}"
                                                    class="btn btn-sm btn-outline-info">
                                                    <i class="fas fa-info-circle me-1"></i>Detail
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted p-4">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <p>Tidak ada proposal untuk direview</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $dataNilai->links() }}
                    </div>

                </div>
            @endrole
        </div>
    </div>
@endsection
