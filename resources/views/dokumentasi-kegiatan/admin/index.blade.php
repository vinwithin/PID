@extends('layout.app')
@section('content')
    <div class="w-100">
        <div class="card">

            <div class="card-header">
                <h3>Publikasi Dokumentasi Kegiatan</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 20%" class="text-center">Link Tautan Video Youtube</th>
                            <th style="width: 20%" class="text-center">Tautan Sosial Media</th>
                            <th style="width: 20%" class="text-center">Link/tautan Google Drive dokumentasi kegiatan</th>
                            <th style="width: 15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataAdmin as $item)
                            <tr>
                                <td >{{$loop->iteration}}</td>
                                <td rowspan="2" class="text-center"><a href="{{$item->link_youtube}}" class="btn btn-warning" target="_blank">Link Youtube</a></td>
                                <td rowspan="2" class="text-center"><a href="{{$item->link_social_media}}" class="btn btn-warning" target="_blank">Link Youtube</a></td>
                                <td rowspan="2" class="text-center"><a href="{{$item->link_dokumentasi}}" class="btn btn-warning" target="_blank">Link Youtube</a></td>
                                <td rowspan="2" class="text-center"><a href="/dokumentasi-kegiatan/edit/{{$item->id}}" class="btn btn-primary">Edit</a></td>
                            </tr>
                           
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
