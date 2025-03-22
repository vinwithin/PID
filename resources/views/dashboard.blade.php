@extends('layout.app')
@section('content')
    @role('admin|reviewer|dosen|super admin')
        <div class="w-100 ">
            <div class="card p-3 border rounded-3 shadow-sm">
                <h4 class="fw-bold">
                    <i class="bi bi-calendar-event"></i> Informasi Penting!
                </h4>
                @foreach ($announce as $item)
                    <div class="bg-light p-2 rounded d-flex align-items-center mt-3">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <span>
                            {{ $item->title }} -
                            @if ($item->status === 'Tutup')
                                <strong>Kegiatan belum dibuka</strong>
                            @else
                                {{ \Carbon\Carbon::parse($item->start_date)->translatedFormat('d F Y') . ' - ' . \Carbon\Carbon::parse($item->end_date)->translatedFormat('d F Y') }}
                                <strong>Ayo cek sekarang!</strong>
                            @endif
                        </span>

                    </div>
                @endforeach



            </div>
        </div>


        @elserole('mahasiswa')
        <div class="w-100">
            <div class="card p-3 border rounded-3 shadow-sm">
                <h4 class="fw-bold">
                    <i class="bi bi-calendar-event"></i> Informasi Penting!
                </h4>

                @foreach ($announce as $item)
                    <div class="bg-light p-2 rounded d-flex align-items-center mt-3">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        <span>
                            {{ $item->title }} -
                            @if ($item->status === 'Tutup')
                                <strong>Kegiatan belum dibuka</strong>
                            @else
                                {{ \Carbon\Carbon::parse($item->start_date)->translatedFormat('d F Y') . ' - ' . \Carbon\Carbon::parse($item->end_date)->translatedFormat('d F Y') }}
                                <strong>Ayo cek sekarang!</strong>
                            @endif
                        </span>
                    </div>
                @endforeach
            </div>
            @if ($alreadyRegist)
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card p-3 bg-secondary-subtle">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-people-group fa-2xl me-3"></i>

                                <div>
                                    <h6 class="fw-bold">Ketua Tim</h6>
                                    <p class="mb-0 text-muted">{{ $data->nama_ketua }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card p-3 bg-secondary-subtle">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-user fa-2xl me-3"></i>
                                <div>
                                    <h6 class="fw-bold">Dosen Pembimbing</h6>
                                    <p class="mb-0 text-muted">{{ $data->nama_dosen_pembimbing }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card p-3 bg-secondary-subtle">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-sitemap fa-2xl me-3"></i>
                                <div>
                                    <h6 class="fw-bold">Nama Ormawa</h6>
                                    <p class="mb-0 text-muted">{{ $data->ormawa->nama }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card p-3 bg-secondary-subtle">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-pen-to-square fa-2xl me-2"></i>
                                <div>
                                    <h6 class="fw-bold">Status Pro-Ide</h6>
                                    <p class="mb-0 text-muted">{{ $data->registration_validation->status }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bagian Teman Pro-Ide -->
                <div class="card mt-4">
                    <div class="card-header bg-white fw-bold text-success fs-5">Teman Pro-Ide</div>
                    <div class="card-body">
                        <div class="row text-center">
                            @foreach ($data->teamMembers as $item)
                                <div class="col-4 col-md-2 mb-3">
                                    <div class="d-flex align-items-center">
                                        <img src="/assets/profil.svg" class="rounded-circle img-thumbnail" alt="Foto Teman"
                                            width="80" height="80">
                                        <div class="ms-3 text-start">
                                            <p class="fw-bold mb-1">{{ $item->nama }}</p>
                                            <p class="text-muted mb-0">{{ Str::title($item->identifier) }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                        </div>
                    </div>
                </div>
            @endif

        </div>
    @endrole
@endsection
