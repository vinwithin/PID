@extends('layout.app')
@section('content')
    <div class="w-100">
        <div class="card flex-fill">
            <div class="card-header">
                <h5 class="card-title mb-0">Cek Pendaftaran</h5>
            </div>
            <div class="card-body">
                <p><strong>Nama Ketua Tim:</strong></p>
                <p>{{ $data->nama_ketua }}</p>

                <p><strong>Nama Tim:</strong></p>
                <p>{{ $data->nama_tim }}</p>

                <p><strong>Prodi Ketua:</strong></p>
                <p>{{ $data->program_studi->nama }}</p>

                <p><strong>Fakultas Ketua:</strong></p>
                <p>{{ $data->fakultas->nama }}</p>

                <p><strong>No hp Ketua:</strong></p>
                <p>{{ $data->nohp_ketua }}</p>

                <p><strong>Nama Ormawa Ketua:</strong></p>
                <p>{{ $data->ormawa->nama }}</p>

                <p><strong>Judul :</strong></p>
                <p>{{ $data->judul }}</p>

                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th colspan="5" class="text-center">DAFTAR TIM</th>
                        </tr>
                    </thead>
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
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->nama}}</td>
                            <td>{{$item->nim}}</td>
                            <td>{{$item->fakultas_model->nama}}</td>
                            <td>{{$item->program_studi->nama}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <p><strong>SK Organisasi :</strong></p>
                <a href="/storage/{{ $data->sk_organisasi }}" class="btn btn-warning">Lihat File</a>

                <p><strong>File Surat Kerjasama :</strong></p>
                <a class="btn btn-warning" href="/storage/{{ $data->surat_kerjasama }}">Lihat File</a>

                <p><strong>File Surat Rekomendasi Pembina:</strong></p>
                <a class="btn btn-warning" href="/storage/{{ $data->surat_rekomendasi_pembina }}">Lihat File</a>

                <p><strong>File Proposal:</strong></p>
                <a class="btn btn-warning" href="/storage/{{ $data->proposal }}">Lihat File</a>

                <p class="mt-2"><strong>Status Validasi:</strong></p>
                <p class="text-warning">
                    {{ $data->registration_validation->status === 'lolos' ? $data->registration_validation->status . 'validator => ' . $data->registration_validation->validator_id :  $data->registration_validation->status}}</p>
                <a href="/pendaftaran" class="btn btn-primary">Kembali</a>

            </div>

        </div>
    </div>
@endsection
