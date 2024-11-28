@extends('layout.app')
@section('content')
    <div class="w-100">
        <div class="card">

            <div class="card-header">
                <h3>Publikasi Dokumen</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 10%">Konten</th>
                            <th style="width: 20%" class="text-center">File draf Artikel Berita Media Massa</th>
                            <th style="width: 20%" class="text-center">Bukti Ketercapaian HAKI (Sertifikat Haki/Draft Pendaftaran HAKI)</th>
                            <th style="width: 20%" class="text-center">Link Artikel</th>
                            <th style="width: 15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataAdmin as $item)
                            <tr>
                                <td >Dokumen</td>
                                <td class="text-center"><a href="{{ asset('storage/dokumen-publikasi/' . $item->file_artikel) }}" class="btn btn-warning" target="_blank">Lihat File</a></td>
                                <td class="text-center"><a href="{{ asset('storage/dokumen-publikasi/' . $item->file_haki) }}" class="btn btn-warning" target="_blank">Lihat File</a></td>
                                <td rowspan="2" class="text-center"><a href="{{$item->link_artikel}}" class="btn btn-warning" target="_blank">Link Artikel</a></td>
                                <td rowspan="2" class="text-center"><a href="/dokumen-publikasi/edit/{{$item->id}}" class="btn btn-primary">Edit</a></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td class="text-center"><span class="badge bg-primary">{{$item->status_artikel}}</span></td>
                                <td class="text-center"><span class="badge bg-primary">{{$item->status_haki}}</span></td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
