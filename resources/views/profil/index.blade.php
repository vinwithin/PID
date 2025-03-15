@extends('layout.app')
@section('title', 'Pengaturan Pengguna')

@section('content')
    <style>
        dt {
            font-size: 18px;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-weight: 400;
            line-height: 120%;
        }
        dd {
            font-size: 18px;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-weight: 400;
            line-height: 120%;
        }
    </style>
    <div class="w-100">
        <div class="card flex-fill">
            <div class="card shadow-sm p-4">
                <div class="row ">
                    <div class="col-md-3 d-flex flex-column align-items-center">
                        <img src="/assets/profil.svg" class="rounded img-fluid mb-2" alt="Foto Profil">
                        <button class="btn btn-success">Ganti Foto</button>
                    </div>
                    <div class="col-md-9 mt-3">
                        <dl class="row">
                            <dt class="col-5 text-muted mb-2"><i class="fa-solid fa-address-book"></i> NIM </dt>
                            <dd class="col-7 text-muted mb-2">{{$data[0]->nim}}</dd>

                            <dt class="col-5 text-muted mb-2"><i class="fa-solid fa-user"></i> Nama Mahasiswa</dt>
                            <dd class="col-7 text-muted mb-2">{{$data[0]->name}}</dd>

                            <dt class="col-5 text-muted mb-2"><i class="fa-solid fa-envelope"></i> Email</dt>
                            <dd class="col-7 text-muted mb-2">{{$data[0]->email}}</dd>
                        </dl>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
