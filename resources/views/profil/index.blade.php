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
                    <div class="col-md-2 d-flex flex-column align-items-end">
                        <img src="/assets/profil.svg" class="rounded  mb-2" alt="Foto Profil" style="width: 150px; height:150px;">
                       
                    </div>
                    <div class="col-md-9 mt-3 ">
                        <dl class="row">
                            <dt class="col-3 text-dark mb-3"><i class="fa-solid fa-address-book"></i> {{!Auth::user()->hasRole('mahasiswa') ? 'NIP' : 'NIM'}} </dt>
                           
                            <dd class="col-7 text-dark mb-3">:   {{$data[0]->identifier}}</dd>
                            
                            <dt class="col-3 text-dark mb-3"><i class="fa-solid fa-user"></i> {{!Auth::user()->hasRole('mahasiswa') ? 'Nama' : 'Nama Mahasiswa'}} </dt>
                           
                            <dd class="col-7 text-dark mb-3">:   {{$data[0]->name}}</dd>
                            
                            <dt class="col-3 text-dark mb-3"><i class="fa-solid fa-envelope"></i> Email</dt>
                           
                            <dd class="col-7 text-dark mb-3">:   {{$data[0]->email}}</dd>
                        </dl>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
