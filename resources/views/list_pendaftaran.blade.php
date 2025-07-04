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
                <div class="card-header text-dark py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-end">
                            <button class="btn btn-dark" type="button" data-bs-toggle="collapse" data-bs-target="#filterSection"
                                aria-expanded="false" aria-controls="filterSection">
                                <i class="fas fa-filter me-2"></i>Filter
                            </button>
                            <a href="/pendaftaran/export" class="btn btn-outline-primary fw-bold"
                                style="box-shadow: 2px 2px 1px 0px rgba(0, 0, 0, 0.25);"><i
                                    class="fa-regular fa-file-excel me-2"></i>Cetak Excel</a>
                        </div>
                        <form action="{{ route('pendaftaran.search') }}" method="GET" class="">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Cari..."
                                    value="{{ request('search') }}">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-search"></i> Cari
                                </button>
                                <a href="{{ route('pendaftaran') }}" class="btn btn-primary ms-2">Atur Ulang</a>

                            </div>
                        </form>
                    </div>

                    <div class="collapse mt-3" id="filterSection">
                        <div class="card card-body border shadow-sm">
                            <form method="GET" action="{{ route('pendaftaran.search') }}">
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
                                                @case('valid') bg-success @break
                                                @case('lolos') bg-primary @break
                                                @default bg-secondary
                                            @endswitch
                                        ">
                                                {{ $item->registration_validation->status }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if ($item->total_proposal_scores->isNotEmpty())
                                                <span class="badge bg-primary">
                                                    {{ $item->total_proposal_scores->sum('total') }}
                                                </span>
                                            @else
                                                <span class="badge bg-light text-dark">Belum Dinilai</span>
                                            @endif

                                        </td>
                                        <td class="text-center">
                                            @can('approve proposal')
                                                @if ($item->registration_validation->status === 'valid')
                                                    @if ($item->reviewAssignments->where('registration_id', $item->id)->isEmpty())
                                                        <a href="{{ route('pilih-reviewer', ['id' => $item->id]) }}"
                                                            class="btn btn-outline-success" data-bs-toggle="tooltip"
                                                            title="Pilih Penilai">
                                                            <i class="fa-solid fa-user-plus"></i>
                                                        </a>
                                                    @elseif(!isset($totalId[$item->id]))
                                                        <a href="/edit-reviewer/{{ $item->id }}"
                                                            class="btn btn-outline-success" data-bs-toggle="tooltip"
                                                            title="Pilih Penilai">
                                                            <i class="fa-solid fa-user-plus"></i>
                                                        </a>
                                                    @endif
                                                @elseif ($item->registration_validation->status === 'Belum valid')
                                                    <!-- Tombol untuk membuka modal -->
                                                    <button type="button" class="btn  btn-outline-success" data-bs-toggle="modal"
                                                        data-bs-target="#approveModal{{ $item->id }}" data-bs-toggle="tooltip"
                                                        title="Validasi">
                                                        <i class="fa-solid fa-circle-check"></i>
                                                    </button>

                                                    <!-- Gunakan komponen modal -->
                                                    <x-confirm-modal modal-id="approveModal{{ $item->id }}"
                                                        title="Konfirmasi Persetujuan"
                                                        message="Apakah Anda yakin ingin menyetujui proposal ini?"
                                                        action-url="/proposal/approve/{{ $item->id }}"
                                                        confirm-text="Ya, Setujui" />

                                                    <button type="button" class="btn  btn-outline-warning" data-bs-toggle="modal"
                                                        data-bs-target="#rejectModal{{ $item->id }}" data-bs-toggle="tooltip"
                                                        title="Tolak">
                                                        <i class="fa-solid fa-circle-xmark"></i>
                                                    </button>

                                                    <!-- Gunakan komponen modal -->
                                                    <x-confirm-modal modal-id="rejectModal{{ $item->id }}"
                                                        title="Konfirmasi Persetujuan"
                                                        message="Apakah Anda yakin ingin menolak proposal ini?"
                                                        action-url="/proposal/reject/{{ $item->id }}"
                                                        confirm-text="Ya, Setujui" />
                                                @elseif($item->registration_validation->status === 'Tidak Lolos')
                                                    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                                        data-bs-target="#approveModal{{ $item->id }}"
                                                        data-bs-toggle="tooltip" title="Validasi">
                                                        <i class="fas fa-check"></i>
                                                    </button>

                                                    <!-- Gunakan komponen modal -->
                                                    <x-confirm-modal modal-id="approveModal{{ $item->id }}"
                                                        title="Konfirmasi Persetujuan"
                                                        message="Apakah Anda yakin ingin menyetujui proposal ini?"
                                                        action-url="/proposal/approve/{{ $item->id }}"
                                                        confirm-text="Ya, Setujui" />
                                                @endif
                                                @if (
                                                    $item->registration_validation->status === 'valid' &&
                                                        isset($totalId[$item->id]) &&
                                                        count($totalId[$item->id]) === 2)
                                                    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                                        data-bs-target="#lolosModal{{ $item->id }}" data-bs-toggle="tooltip"
                                                        title="Lolos">
                                                        <i class="fas fa-award"></i>
                                                    </button>
                                                    <x-confirm-modal modal-id="lolosModal{{ $item->id }}"
                                                        title="Konfirmasi Persetujuan"
                                                        message="Apakah Anda yakin ingin meloloskan proposal ini?"
                                                        action-url="/approve-to-program/{{ $item->id }}"
                                                        confirm-text="Ya, Setujui" />
                                                    <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
                                                        data-bs-target="#rejectModal{{ $item->id }}" data-bs-toggle="tooltip"
                                                        title="Tidak Lolos">
                                                        <i class="fa-solid fa-xmark"></i>
                                                    </button>

                                                    <!-- Gunakan komponen modal -->
                                                    <x-confirm-modal modal-id="rejectModal{{ $item->id }}"
                                                        title="Konfirmasi Persetujuan"
                                                        message="Apakah Anda yakin ingin menolak proposal ini?"
                                                        action-url="/proposal/reject/{{ $item->id }}"
                                                        confirm-text="Ya, Setujui" />
                                                @endif
                                            @endcan

                                            @if (isset($totalId[$item->id]) && is_array($totalId[$item->id]) && count($totalId[$item->id]) > 0)
                                                <a href="/pendaftaran/detail-nilai/{{ $item->id }}"
                                                    class="btn btn-outline-primary" data-bs-toggle="tooltip"
                                                    title="Lihat Nilai">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                            @endif
                                            <a href="/pendaftaran/detail/{{ $item->id }}" class="btn btn-outline-info"
                                                data-bs-toggle="tooltip" title="Lihat Detail">
                                                <i class="fa-solid fa-circle-info"></i>
                                            </a>

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
                        <div class="text-end">
                            <button class="btn btn-dark" type="button" data-bs-toggle="collapse"
                                data-bs-target="#filterSection" aria-expanded="false" aria-controls="filterSection">
                                <i class="fas fa-filter me-2"></i>Filter
                            </button>
                        </div>
                        <form action="{{ route('pendaftaran.search') }}" method="GET" class="">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Cari..."
                                    value="{{ request('search') }}">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-search"></i> Cari
                                </button>
                                <a href="{{ route('pendaftaran') }}" class="btn btn-primary ms-2">Atur Ulang</a>

                            </div>
                        </form>
                    </div>

                    <div class="collapse mt-3" id="filterSection">
                        <div class="card card-body border shadow-sm">
                            <form method="GET" action="{{ route('pendaftaran.search') }}">
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
                                            @switch($item->reviewAssignments->firstWhere('reviewer_id', auth()->id())->status)
                                                @case('Menunggu Review') bg-warning @break
                                                @case('Selesai Direview') bg-success @break
                                                @default bg-secondary
                                            @endswitch
                                        ">
                                                {{ $item->reviewAssignments->firstWhere('reviewer_id', auth()->id())->status }}
                                            </span>
                                        </td>
                                        @php
                                            $total_scores = $item->total_proposal_scores->firstWhere(
                                                'user_id',
                                                Auth::user()->id,
                                            );
                                        @endphp
                                        <td class="text-center">
                                            @if ($total_scores)
                                                <span class="badge bg-primary">
                                                    {{ $total_scores->total }}
                                                </span>
                                            @else
                                                <span class="badge bg-light text-dark">Belum Dinilai</span>
                                            @endif
                                        </td>
                                        @php
                                            $sudahLihat = \App\Models\ReviewAccessProposal::where(
                                                'reviewer_id',
                                                auth()->id(),
                                            )
                                                ->where('pendaftaran_id', $item->id)
                                                ->exists();
                                        @endphp
                                        <td class="text-center">
                                            @if (isDeadlineActive('Penilaian Proposal'))
                                                @if ($item->proposal_score->where('user_id', auth()->user()->id)->isEmpty())
                                                    <a href="/reviewer/nilai/{{ $item->id }}"
                                                        class="btn btn-outline-primary {{ $sudahLihat ? '' : 'disabled' }}"
                                                        style="{{ $sudahLihat ? '' : 'pointer-events: none; opacity: 0.5;' }}"
                                                        aria-disabled="{{ $sudahLihat ? 'false' : 'true' }}"
                                                        data-bs-toggle="tooltip" title="Beri Nilai">
                                                        <i class="fas fa-star"></i>
                                                    </a>
                                                @endif
                                            @endif

                                            @if (isset($totalId[$item->id][auth()->user()->name]))
                                                <a href="/pendaftaran/detail-nilai/{{ $item->id }}"
                                                    class="btn btn-outline-primary" data-bs-toggle="tooltip"
                                                    title="Lihat Nilai">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endif

                                            <a href="/pendaftaran/detail/{{ $item->id }}" class="btn btn-outline-info "
                                                data-bs-toggle="tooltip" title="Lihat Detail">
                                                <i class="fas fa-info-circle"></i>
                                            </a>

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
