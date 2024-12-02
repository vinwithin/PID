@extends('layout.app')
@section('content')
<div class="w-full px-4 py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="card-title mb-0 d-flex align-items-center">
                        <i class="fas fa-check-circle me-3"></i>Cek Pendaftaran
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="bg-light p-3 rounded">
                                <h5 class="text-primary mb-3">Detail Tim</h5>
                                <dl class="row">
                                    <dt class="col-5">Nama Ketua Tim</dt>
                                    <dd class="col-7">{{ $data->nama_ketua }}</dd>

                                    <dt class="col-5">Nama Tim</dt>
                                    <dd class="col-7">{{ $data->nama_tim }}</dd>

                                    <dt class="col-5">Prodi Ketua</dt>
                                    <dd class="col-7">{{ $data->program_studi->nama }}</dd>

                                    <dt class="col-5">Fakultas Ketua</dt>
                                    <dd class="col-7">{{ $data->fakultas->nama }}</dd>

                                    <dt class="col-5">No HP Ketua</dt>
                                    <dd class="col-7">{{ $data->nohp_ketua }}</dd>

                                    <dt class="col-5">Ormawa Ketua</dt>
                                    <dd class="col-7">{{ $data->ormawa->nama }}</dd>
                                </dl>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light p-3 rounded">
                                <h5 class="text-primary mb-3">Informasi Proyek</h5>
                                <dl class="row">
                                    <dt class="col-4">Judul</dt>
                                    <dd class="col-8">{{ $data->judul }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0">Daftar Tim</h5>
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
                                            <td>{{ $item->nim }}</td>
                                            <td>{{ $item->fakultas_model->nama }}</td>
                                            <td>{{ $item->program_studi->nama }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">Dokumen Pendukung</h5>
                            <div class="d-flex flex-column gap-2">
                                <a href="/storage/{{ $data->sk_organisasi }}" class="btn btn-outline-primary">
                                    <i class="fas fa-file-alt me-2"></i>SK Organisasi
                                </a>
                                <a href="/storage/{{ $data->surat_kerjasama }}" class="btn btn-outline-primary">
                                    <i class="fas fa-handshake me-2"></i>Surat Kerjasama
                                </a>
                                <a href="/storage/{{ $data->surat_rekomendasi_pembina }}" class="btn btn-outline-primary">
                                    <i class="fas fa-envelope-open-text me-2"></i>Surat Rekomendasi Pembina
                                </a>
                                <a href="/storage/{{ $data->proposal }}" class="btn btn-outline-primary">
                                    <i class="fas fa-file-contract me-2"></i>Proposal
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-primary mb-3">Status Validasi</h5>
                            <div class="alert {{ $data->registration_validation->status === 'lolos' ? 'alert-success' : 'alert-warning' }} d-flex align-items-center">
                                <i class="fas {{ $data->registration_validation->status === 'lolos' ? 'fa-check-circle' : 'fa-exclamation-triangle' }} me-2"></i>
                                <span>
                                    {{ $data->registration_validation->status === 'lolos' 
                                        ? 'Lolos Validator: ' . $data->registration_validation->validator_id 
                                        : $data->registration_validation->status }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <a href="/pendaftaran" class="btn btn-secondary">
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