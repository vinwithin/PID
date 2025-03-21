@extends('layout.app')
@section('content')
    @php
        $statuses = ['Belum valid', 'valid', 'lolos', 'Lanjutkan Program'];
        $currentStep = array_search($data->registration_validation->status, $statuses);
    @endphp
    <div class=" w-full container-fluid ">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Cek Pendaftaran</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded mb-3">
                            <h6 class="text-primary mb-3">Informasi Ketua Tim</h6>
                            <dl class="row">
                                <dt class="col-5 text-muted">Nama Ketua Tim</dt>
                                <dd class="col-7">{{ $data->nama_ketua }}</dd>

                                <dt class="col-5 text-muted">Nama Tim</dt>
                                <dd class="col-7">{{ $data->judul }}</dd>

                                <dt class="col-5 text-muted">Prodi Ketua</dt>
                                <dd class="col-7">{{ $data->program_studi->nama }}</dd>

                                <dt class="col-5 text-muted">Fakultas Ketua</dt>
                                <dd class="col-7">{{ $data->fakultas->nama }}</dd>

                                <dt class="col-5 text-muted">No HP Ketua</dt>
                                <dd class="col-7">{{ $data->nohp_ketua }}</dd>


                            </dl>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded mb-3">
                            <h6 class="text-primary mb-3">Informasi Proyek</h6>
                            <dl class="row">
                                <dt class="col-4 text-muted">Judul</dt>
                                <dd class="col-8">{{ $data->judul }}</dd>

                                <dt class="col-4 text-muted">Nama Ormawa</dt>
                                <dd class="col-8">{{ $data->ormawa->nama }}</dd>

                                <dt class="col-4 text-muted">Bidang</dt>
                                <dd class="col-8">{{ $data->bidang->nama }}</dd>

                                <dt class="col-4">Lokasi</dt>
                                <dd class="col-8">
                                    {{ $data->lokasi->village . ', ' . $data->lokasi->district . ', ' . $data->lokasi->regency }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="mb-0">Daftar Tim</h6>
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

                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0 text-primary">Dokumen Pendukung</h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        SK Organisasi
                                        <a href="/storage/{{ $data->document_registration->sk_organisasi }}"
                                            class="btn btn-sm btn-outline-primary" target="_blank">
                                            Lihat File
                                        </a>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Surat Kerjasama
                                        <a href="/storage/{{ $data->document_registration->surat_kerjasama }}"
                                            class="btn btn-sm btn-outline-primary" target="_blank">
                                            Lihat File
                                        </a>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Surat Rekomendasi Pembina
                                        <a href="/storage/{{ $data->document_registration->surat_rekomendasi_pembina }}"
                                            class="btn btn-sm btn-outline-primary" target="_blank">
                                            Lihat File
                                        </a>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Proposal
                                        <a href="/storage/{{ $data->document_registration->proposal }}"
                                            class="btn btn-sm btn-outline-primary" target="_blank">
                                            Lihat File
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5 class="text-primary mb-3">Proses Kegiatan</h5>
                        <div class="bg-white p-4 rounded shadow">
                            <p class="fs-5 fw-semibold text-secondary">
                                Anda sedang berada di tahap:
                                @switch($data->registration_validation->status)
                                    @case('Belum Valid')
                                        <span class="text-primary">Seleksi Administrasi</span>
                                        @break
                                    @case('valid')
                                        <span class="text-primary">Seleksi Proposal</span>
                                        @break
                                    @case('lolos')
                                        <span class="text-primary">Pelaksanaan Kegiatan Pro-IDe</span>
                                        @break
                                    @case('Lanjutkan Program')
                                        <span class="text-primary">Pelaksanaan Kegiatan Pro-IDe dengan Pendanaan Penuh</span>
                                        @break
                                @endswitch
                            </p>

                            @if ($data->registration_validation->status == 'Belum Valid')
                                <p class="small text-muted">Silakan tunggu hasil seleksi administrasi.</p>
                            @elseif($data->registration_validation->status == 'valid')
                                <p class="small text-muted">Silakan tunggu hasil seleksi. Penilaian proposal</p>
                            @elseif($data->registration_validation->status == 'lolos')
                                <p class="small text-muted">Tim anda telah lolos Pro-IDe, segera lakukan pekerjaan di desa
                                </p>
                            @elseif($data->registration_validation->status == 'Lanjutkan Program')
                                <p class="small text-muted">Tim anda telah lolos monitoring dan evaluasi.</p>
                            @endif
                        </div>

                        <h5 class="text-primary mb-3">Status Validasi</h5>
                        <div
                            class="alert {{ $data->registration_validation->status === 'lolos' || 'Lanjutkan Program' || 'valid' ? 'alert-success' : 'alert-warning' }} d-flex align-items-center">
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

                <div class="text-center mt-3">
                    <a href="/daftarProgram" class="btn btn-secondary">
                        Kembali
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
