@extends('layout.app')
@section('content')
    <div class="w-100">
        <div class="card">
            <div class="container-fluid px-4 py-4">
                <div class="card shadow-sm border-0">

                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="mb-0 text-light">
                            <i class="fas fa-file-alt me-2"></i>Publikasi Dokumen Teknis
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th style="width: 15%">Tim</th>
                                    <th style="width: 20%" class="text-center">Link Tautan Video Youtube</th>
                                    <th style="width: 20%" class="text-center">Tautan Sosial Media</th>
                                    <th style="width: 20%" class="text-center">Link/tautan Google Drive dokumentasi kegiatan
                                    </th>
                                    <th style="width: 15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataAdmin as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="fw-bold text-center">Tim {{ $item->judul }}</td>
                                        <td class="text-center">
                                            @if ($item->dokumentasiKegiatan && $item->dokumentasiKegiatan->link_youtube)
                                                <a href="{{ $item->dokumentasiKegiatan->link_youtube }}"
                                                    class="btn btn-success" target="_blank">Link Youtube</a>
                                            @else
                                                <span class="badge bg-danger">Belum Upload</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($item->dokumentasiKegiatan && $item->dokumentasiKegiatan->link_social_media)
                                                <a href="{{ $item->dokumentasiKegiatan->link_social_media }}"
                                                    class="btn btn-success" target="_blank">Link Sosial Media</a>
                                            @else
                                                <span class="badge bg-danger">Belum Upload</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($item->dokumentasiKegiatan && $item->dokumentasiKegiatan->link_dokumentasi)
                                                <a href="{{ $item->dokumentasiKegiatan->link_dokumentasi }}"
                                                    class="btn btn-success" target="_blank">Link Dokumentasi</a>
                                            @else
                                                <span class="badge bg-danger">Belum Upload</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($item->dokumentasiKegiatan && $item->dokumentasiKegiatan->link_dokumentasi)
                                                <a href="/dokumentasi-kegiatan/{{ $item->dokumentasiKegiatan->id }}"
                                                    class="btn btn-primary">Lihat</a>
                                                <a href="/dokumentasi-kegiatan/edit/{{ $item->dokumentasiKegiatan->id }}"
                                                    class="btn btn-warning">Edit</a>
                                            @else
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
