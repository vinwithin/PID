@extends('layout.app')
@section('title', 'Cek Pendaftaran')
@section('description', 'Daftar Pro-IDe')
@section('content')
    @php
        $statuses = ['Belum valid', 'valid', 'lolos', 'Lanjutkan Program'];
        $currentStep = array_search($data->registration_validation->status, $statuses);
    @endphp

    <div class=" w-full container-fluid ">
        {{-- @if (session('pending_approval'))
            <!-- Modal -->
            <div class="modal fade" id="pendingApprovalModal" tabindex="-1" aria-labelledby="pendingApprovalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-warning text-dark">
                            <h5 class="modal-title" id="pendingApprovalLabel">
                                <i class="fas fa-exclamation-circle"></i> Konfirmasi Anggota Tim
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            Anda diundang dalam sebuah tim namun belum memberikan persetujuan. Silakan pilih
                            untuk
                            menyetujui
                            atau menolak keikutsertaan Anda.
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('mahasiswa.approve') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check"></i> Terima
                                </button>
                            </form>
                            <form action="{{ route('mahasiswa.reject') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-times"></i> Tolak
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var myModal = new bootstrap.Modal(document.getElementById('pendingApprovalModal'));
                    myModal.show();
                });
            </script>
            <!-- Script untuk otomatis membuka modal -->
        @endif --}}
        <div class="card shadow-sm border-0">

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="bg-success-subtle p-3 rounded-4 mb-3">
                            <h6 class="text-dark fw-bold mb-3">Detail Tim</h6>
                            <dl class="row">
                                <dt class="col-5 text-muted">Nama Ketua Tim</dt>
                                <dd class="col-7">{{ $data->nama_ketua }}</dd>

                                <dt class="col-5 text-muted">Prodi Ketua</dt>
                                <dd class="col-7">{{ $data->program_studi->nama }}</dd>

                                <dt class="col-5 text-muted">Fakultas Ketua</dt>
                                <dd class="col-7">{{ $data->fakultas->nama }}</dd>

                                <dt class="col-5 text-muted">No HP Ketua</dt>
                                <dd class="col-7">{{ $data->nohp_ketua }}</dd>

                                <dt class="col-5 text-muted">Nama Ormawa</dt>
                                <dd class="col-7">{{ $data->ormawa->nama }}</dd>


                            </dl>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-success-subtle p-3 rounded-4 mb-3">

                            <h6 class="text-dark fw-bold mb-3">Informasi Proyek</h6>
                            <dl class="row">
                                <dt class="col-4 text-muted">Judul</dt>
                                <dd class="col-8">{{ $data->judul }}</dd>

                                <dt class="col-4 text-muted">Bidang</dt>
                                <dd class="col-8">{{ $data->bidang->nama }}</dd>

                                <dt class="col-4">Lokasi</dt>
                                <dd class="col-8">
                                    {{ $data->lokasi->village . ', ' . $data->lokasi->district . ', ' . $data->lokasi->regency }}
                                </dd>
                                <dt class="col-4">Nama Dosen Pembimbing</dt>
                                <dd class="col-8">
                                    {{ $data->dospem->name }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header bg-dark text-white">
                        <h6 class="mb-0 text-white fw-bold">Daftar Anggota Tim</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>NIM</th>
                                        <th>Fakultas</th>
                                        <th>Program Studi</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data->teamMembers as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->identifier }}</td>
                                            <td>{{ $item->fakultas_model->nama }}</td>
                                            <td>{{ $item->program_studi->nama }}</td>
                                            <td class="text-center">
                                                @if ($item->status === 'approve')
                                                    <i class="fas fa-check-circle text-success" title="Disetujui"></i>
                                                @elseif ($item->status === 'reject')
                                                    <i class="fas fa-times-circle text-danger" title="Ditolak"></i>
                                                @elseif ($item->status === 'pending')
                                                    <i class="fas fa-exclamation-circle text-warning" title="Menunggu"></i>
                                                @else
                                                    <span>{{ $item->status }}</span> {{-- fallback jika status tidak dikenali --}}
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h5 class="text-dark fw-bold mb-3">Dokumen Pendukung</h5>
                        <div class="d-flex flex-column gap-2">
                            <div class="d-flex justify-content-between gap-2 btn btn-outline-secondary">
                                <a href="/storage/{{ $data->document_registration->sk_organisasi }}"
                                    class="d-flex align-items-center text-secondary flex-grow-1 text-start">
                                    <i class="fas fa-file-alt me-2"></i>SK Organisasi
                                </a>
                                <a href="/storage/{{ $data->document_registration->sk_organisasi }}" target="_blank"
                                    class="btn btn-outline-secondary">
                                    Lihat File
                                </a>
                            </div>

                            <div class="d-flex justify-content-between gap-2 btn btn-outline-secondary">
                                <a href="/storage/{{ $data->document_registration->surat_kerjasama }}"
                                    class="d-flex align-items-center text-secondary flex-grow-1 text-start">
                                    <i class="fas fa-handshake me-2"></i>Surat Kerjasama
                                </a>
                                <a href="/storage/{{ $data->document_registration->surat_kerjasama }}" target="_blank"
                                    class="btn btn-outline-secondary">
                                    Lihat File
                                </a>
                            </div>

                            <div class="d-flex justify-content-between gap-2 btn btn-outline-secondary">
                                <a href="/storage/{{ $data->document_registration->surat_rekomendasi_pembina }}"
                                    class="d-flex align-items-center text-secondary flex-grow-1 text-start">
                                    <i class="fas fa-envelope-open-text me-2"></i>Surat Rekomendasi Pembina
                                </a>
                                <a href="/storage/{{ $data->document_registration->surat_rekomendasi_pembina }}"
                                    target="_blank" class="btn btn-outline-secondary">
                                    Lihat File
                                </a>
                            </div>

                            <div class="d-flex justify-content-between gap-2 btn btn-outline-secondary">
                                <a href="/storage/{{ $data->document_registration->proposal }}"
                                    class="d-flex align-items-center text-secondary flex-grow-1 text-start">
                                    <i class="fas fa-file-contract me-2"></i>Proposal
                                </a>
                                <a href="/storage/{{ $data->document_registration->proposal }}" target="_blank"
                                    class="btn btn-outline-secondary">
                                    Lihat File
                                </a>
                            </div>
                        </div>


                    </div>
                    <div class="col-md-6">
                        <h5 class="text-dark fw-bold mb-3">Proses Kegiatan</h5>
                        <div class="bg-success-subtle p-3 rounded shadow">
                            <p class="fs-5 fw-semibold text-secondary">
                                Anda sedang berada di tahap:
                                @switch($data->status)
                                    @case('draft')
                                        <span class="text-primary">Menunggu Persetujuan Anggota Tim</span>
                                    @break

                                    @case('submit')
                                        @switch($data->registration_validation->status)
                                            @case('Belum valid')
                                                <span class="text-primary">Seleksi Administrasi</span>
                                            @break

                                            @case('Tidak Lolos')
                                                <span class="text-primary">Proposal Anda Ditolak</span>
                                            @break

                                            @case('valid')
                                                <span class="text-primary">Seleksi Proposal</span>
                                            @break

                                            @case('lolos')
                                                <span class="text-primary">Pelaksanaan Kegiatan Pro-IDe</span>
                                            @break

                                            @case('Hentikan Program')
                                                <span class="text-primary">Proposal Anda Tidak Bisa Dilanjutkan</span>
                                            @break

                                            @case('Lanjutkan Program')
                                                <span class="text-primary">Pelaksanaan Kegiatan Pro-IDe dengan Pendanaan Penuh</span>
                                            @break
                                        @endswitch
                                    @break

                                @endswitch
                            </p>

                            @if ($data->registration_validation->status == 'Belum valid')
                                <p class="small text-muted">Silakan tunggu hasil seleksi administrasi.</p>
                            @elseif($data->registration_validation->status == 'valid')
                                <p class="small text-muted">Silakan tunggu hasil seleksi. Penilaian proposal</p>
                            @elseif($data->registration_validation->status == 'Tidak Lolos')
                                <p class="small text-muted">Proposal anda ditolak! Silahkan mendaftar lagi tahun depan</p>
                            @elseif($data->registration_validation->status == 'lolos')
                                <p class="small text-muted">Tim anda telah lolos Pro-IDe, segera lakukan pekerjaan di desa
                                </p>
                            @elseif($data->registration_validation->status == 'Lanjutkan Program')
                                <p class="small text-muted">Tim anda telah lolos monitoring dan evaluasi.</p>
                            @elseif($data->registration_validation->status == 'Hentikan Program')
                                <p class="small text-muted">Tim anda telah tidak lolos monitoring dan evaluasi.</p>
                            @endif
                        </div>

                        <h5 class="text-dark fw-bold mt-3">Status Validasi</h5>
                        <div
                            class="alert {{ in_array($data->registration_validation->status, ['lolos', 'Lanjutkan Program', 'valid']) ? 'alert-success' : 'alert-warning' }} d-flex align-items-center">
                            <i
                                class="fas 
                            @switch ($data->registration_validation->status) @case('Belum valid') fa-exclamation-triangle @break
                                @case('Tidak Lolos') fa-exclamation-triangle @break
                                @case('valid') fa-check-circle @break
                                @case('Lanjutkan Program') fa-check-circle @break
                                @case('lolos') fa-check-circle @break @endswitch
                        me-2"></i>
                            <span>
                                {{ $data->registration_validation->status === 'lolos'
                                    ? 'Lolos Validator: ' . $data->registration_validation->validator_id
                                    : $data->registration_validation->status }}
                            </span>
                        </div>
                    </div>


                </div>
                @if ($pendingMember)
                    <div class="text-center mt-3">
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#rejectModal{{ $pendingMember->id }}">
                            <i class="fa-solid fa-triangle-exclamation me-2"></i> Tolak
                        </button>

                        <x-confirm-modal modal-id="rejectModal{{ $pendingMember->id }}" title="Konfirmasi Persetujuan"
                            message="Apakah Anda yakin ingin menolak persetujuan tim ini?"
                            action-url="/reject/{{ $pendingMember->id }}" confirm-text="Ya, Tolak" />
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#approveModal{{ $pendingMember->id }}">
                            <i class="fa-solid fa-circle-check me-2"></i> Terima
                        </button>
                        <x-confirm-modal modal-id="approveModal{{ $pendingMember->id }}" title="Konfirmasi Persetujuan"
                            message="Apakah Anda yakin ingin memberikan persetujuan tim ini?"
                            action-url="/approve/{{ $pendingMember->id }}" confirm-text="Ya, Setujui" />

                    </div>
                @endif

                <div class="text-center mt-3">

                    <a href="/daftarProgram" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        body {
            background-color: #f4f6f9;
        }

        .card {
            border-radius: 8px;
            overflow: hidden;
        }

        .card-header {
            padding: 0.75rem 1.25rem;
        }

        dl dt {
            font-weight: 500;
        }

        dl dd {
            font-weight: 600;
        }
    </style>
@endpush
