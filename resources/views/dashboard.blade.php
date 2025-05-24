@extends('layout.app')
@section('title', 'Selamat Datang!')
@section('description', 'Program Inovasi Berbasis Kearifan Lokal')
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
        @if (session('success'))
            <x-success-modal :message="session('success')" />
        @endif
        @if (session('error'))
            <x-error-modal :message="session('error')" />
        @endif
        @if (session('pending_approval'))
            <!-- Modal -->
            <div class="modal fade" id="pendingApprovalModal" tabindex="-1" aria-labelledby="pendingApprovalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header text-dark">
                            <h5 class="modal-title" id="pendingApprovalLabel">
                                <i class="fas fa-exclamation-circle me-2"></i> Konfirmasi Anggota Tim
                            </h5>

                        </div>
                        <div class="modal-body">
                            <div class="d-flex flex-column align-items-center justify-content-center gap-2">
                                <img src="/assets/assets_confirm_mhs2.png" alt="confirm-image" style="max-width: 225px;">
                                <p class="text-center">Anda diundang dalam sebuah tim namun belum memberikan persetujuan.
                                    Silakan
                                    pilih
                                    untuk
                                    menyetujui
                                    atau menolak keikutsertaan Anda.</p>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <a href="/program/cek/{{ $data->id }}" class="btn btn-success">Lihat Detail <i
                                    class="fa-solid fa-arrow-right ml-2"></i></a>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Script untuk otomatis membuka modal -->
        @endif


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

                @if (!$pendingMember)
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card p-4 bg-secondary-subtle">
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
                            <div class="card p-4 bg-secondary-subtle">
                                <div class="d-flex align-items-center">
                                    <i class="fa-solid fa-user fa-2xl me-3"></i>
                                    <div>
                                        <h6 class="fw-bold">Dosen Pembimbing</h6>
                                        <p class="mb-0 text-muted">{{ $data->dospem->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card p-4 bg-secondary-subtle">
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
                            <div class="card p-4 bg-secondary-subtle">
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
                        <div class="card-header bg-white fw-bold text-dark fs-4">Teman Pro-Ide</div>
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
            @endif

        </div>
    @endrole
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var pendingModal = new bootstrap.Modal(document.getElementById('pendingApprovalModal'));
            pendingModal.show();
        });
    </script>
@endsection
