@extends('layout.app')
@section('title', 'Cek Pendaftaran')
@section('description', 'Kelola Pendaftaran')

@section('content')
    <div class="w-full px-4 py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">

                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="bg-success-subtle p-3 rounded-4">
                                    <h5 class="text-dark fw-bold mb-3">Detail Tim</h5>
                                    <dl class="row">
                                        <dt class="col-5">Nama Ketua Tim</dt>
                                        <dd class="col-7">{{ $data->nama_ketua }}</dd>

                                        <dt class="col-5">Nama Tim</dt>
                                        <dd class="col-7">{{ $data->judul }}</dd>

                                        <dt class="col-5">Prodi Ketua</dt>
                                        <dd class="col-7">{{ $data->program_studi->nama }}</dd>

                                        <dt class="col-5">Fakultas Ketua</dt>
                                        <dd class="col-7">{{ $data->fakultas->nama }}</dd>

                                        <dt class="col-5">No HP Ketua</dt>
                                        <dd class="col-7">{{ $data->nohp_ketua }}</dd>

                                        <dt class="col-5">Ormawa Ketua</dt>
                                        <dd class="col-7">{{ $data->ormawa->nama }}</dd>
                                        <dt class="col-5">Lokasi</dt>
                                        <dd class="col-7">
                                            {{ $data->lokasi->village . ', ' . $data->lokasi->district . ', ' . $data->lokasi->regency }}
                                        </dd>
                                        <dt class="col-5">Nama Dosen Pembimbing</dt>
                                        <dd class="col-7">
                                            {{ $data->dospem->name }}
                                        </dd>

                                    </dl>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-secondary mb-3">Dokumen Pendukung</h5>
                                <div class="d-flex flex-column gap-2">
                                    <a href="/storage/{{ $data->document_registration->sk_organisasi }}"
                                        class="btn btn-outline-secondary">
                                        <i class="fas fa-file-alt me-2"></i>SK Organisasi
                                    </a>
                                    <a href="/storage/{{ $data->document_registration->surat_kerjasama }}"
                                        class="btn btn-outline-secondary">
                                        <i class="fas fa-handshake me-2"></i>Surat Kerjasama
                                    </a>
                                    <a href="/storage/{{ $data->document_registration->surat_rekomendasi_pembina }}"
                                        class="btn btn-outline-secondary">
                                        <i class="fas fa-envelope-open-text me-2"></i>Surat Rekomendasi Pembina
                                    </a>
                                    <a href="/storage/{{ $data->document_registration->proposal }}"
                                        class="btn btn-outline-secondary">
                                        <i class="fas fa-file-contract me-2"></i>Proposal
                                    </a>
                                </div>

                            </div>
                        </div>


                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="bg-success-subtle p-3 rounded-4">
                                    <h5 class="text-dark fw-bold mb-3">Informasi Proyek</h5>
                                    <dl class="row">
                                        <dt class="col-4">Judul</dt>
                                        <dd class="col-8">{{ $data->judul }}</dd>

                                        @forelse ($data->reviewAssignments as $item)
                                            <dt class="col-4">Penilai {{ $loop->iteration }}</dt>
                                            <dd class="col-8">{{ $item->user->name }}</dd>
                                        @empty
                                            <dt class="col-4">Penilai</dt>
                                            <dd class="col-8">Belum ada penilai yang ditugaskan</dd>
                                        @endforelse

                                    </dl>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-primary mb-3">Status Validasi</h5>
                                <div
                                    class="alert {{ in_array($data->registration_validation->status, ['lolos', 'Lanjutkan Program', 'valid']) ? 'alert-success' : 'alert-warning' }} d-flex align-items-center">
                                    <i
                                        class="fas 
                                    @switch ($data->registration_validation->status) @case('Belum valid') fa-exclamation-triangle @break
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
                        <div class="card mb-4">
                            <div class="card-header bg-dark text-white">
                                <h5 class="mb-0 text-white">Daftar Anggota Tim</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>NIM</th>
                                                <th>Fakultas</th>
                                                <th>Program Studi</th>
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
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="text-start">
                            <a href="javascript:history.back()" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f4f6f9;
        }

        .card {
            border-radius: 10px;
        }

        .card-header {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        dl {
            margin-bottom: 0;
        }

        dt {
            color: #6c757d;
            font-weight: 500;
        }

        dd {
            font-weight: 600;
        }
    </style>
@endpush
