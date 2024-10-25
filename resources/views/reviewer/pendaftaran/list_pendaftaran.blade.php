@extends('layout.app')
@section('content')
    <h1 class="h3 mb-3">Daftar Pengajuan</h1>
    <div class="w-100">
        <div class="card flex-fill">
            <div class="card-header">

                <h5 class="card-title mb-0">Latest Projects</h5>
            </div>
            <table class="table table-hover my-0">
                <thead>
                    <tr>
                        <th>Nama Ketua</th>
                        <th class="d-none d-xl-table-cell">NIM Ketua</th>
                        <th class="d-none d-xl-table-cell">Fakultas Ketua</th>
                        <th>Bidang</th>
                        <th class="d-none d-md-table-cell">Judul</th>
                        <th class="d-none d-md-table-cell">Nilai</th>
                        <th class="d-none d-md-table-cell">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item) 
                    <tr>
                        <td>{{$item->nama_ketua}}</td>
                        <td class="d-none d-xl-table-cell">{{$item->nim_ketua}}</td>
                        <td class="d-none d-xl-table-cell">{{$item->fakultas_ketua}}</td>
                        <td><span class="badge bg-success">{{$item->bidang->nama}}</span></td>
                        <td class="d-none d-md-table-cell">{{$item->judul}}</td>
                        <td></td>
                        <td>
                            {{-- <a href="" class="btn btn-warning"></a> --}}
                            <a href="" class="btn btn-success">Beri Nilai</a>
                            
                        </td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
@endsection
