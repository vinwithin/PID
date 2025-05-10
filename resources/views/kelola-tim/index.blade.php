@extends('layout.app')
@section('title', 'Daftar Proposal')
@section('description', 'Kelola Tim Pendamping')
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

            <div class="card-header  text-dark py-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="text-dark">
                        <i class="fas fa-clipboard-list me-2"></i> Kelola Tim Pendamping
                    </h3>
                    <form action="{{ route('kelola.tim.pendamping') }}" method="GET" class="">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari..."
                                value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-search"></i> Cari
                            </button>
                            <a href="{{ route('kelola.tim.pendamping') }}" class="btn btn-success ms-2">Reset</a>

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
                                            @switch($item->status_supervisor)
                                                @case('pending') bg-warning @break
                                                @case('rejected') bg-danger @break
                                                @case('approved') bg-success @break
                                                @default bg-secondary
                                            @endswitch
                                        ">
                                            {{ $item->status_supervisor }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group" role="group">


                                            @php
                                                $status = $item->status_supervisor;
                                            @endphp

                                            @if ($status === 'approved')
                                                
                                            @elseif($status === 'rejected')
                                                <button type="button" class="btn btn-sm btn-outline-success"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#approveModal{{ $item->id }}">
                                                    <i class="fas fa-check me-1"></i> Terima
                                                </button>

                                                <x-confirm-modal modal-id="approveModal{{ $item->id }}"
                                                    title="Konfirmasi Persetujuan"
                                                    message="Apakah Anda yakin ingin menyetujui registrasi ini?"
                                                    action-url="/kelola-tim-pendamping/approved/{{ $item->id }}"
                                                    confirm-text="Iya" />
                                            @else
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#rejectModal{{ $item->id }}">
                                                    <i class="fas fa-exclamation-triangle me-1"></i> Tolak
                                                </button>

                                                <x-confirm-modal modal-id="rejectModal{{ $item->id }}"
                                                    title="Konfirmasi Persetujuan"
                                                    message="Apakah Anda yakin ingin menolak registrasi ini?"
                                                    action-url="/kelola-tim-pendamping/rejected/{{ $item->id }}"
                                                    confirm-text="Iya" />
                                                <button type="button" class="btn btn-sm btn-outline-success"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#approveModal{{ $item->id }}">
                                                    <i class="fas fa-check me-1"></i> Terima
                                                </button>

                                                <x-confirm-modal modal-id="approveModal{{ $item->id }}"
                                                    title="Konfirmasi Persetujuan"
                                                    message="Apakah Anda yakin ingin menyetujui registrasi ini?"
                                                    action-url="/kelola-tim-pendamping/approved/{{ $item->id }}"
                                                    confirm-text="Iya" />
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
        </div>
    </div>
@endsection
