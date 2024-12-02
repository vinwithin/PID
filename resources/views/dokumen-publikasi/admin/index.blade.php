@extends('layout.app')
@section('content')
    <div class="w-100">
        <div class="card">
            <div class="container-fluid px-4 py-4">
                <div class="card shadow-sm border-0">

                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h3 class="mb-0 text-light">
                            <i class="fas fa-file-alt me-2"></i>Publikasi Dokumen
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%" class="text-center">No</th>
                                    <th style="width: 15%" class="text-center">Tim</th>
                                    <th style="width: 15%" class="text-center">Konten</th>
                                    <th style="width: 15%" class="text-center">File draf Artikel Berita Media Massa</th>
                                    <th style="width: 15%" class="text-center">Bukti Ketercapaian HAKI (Sertifikat
                                        Haki/Draft Pendaftaran HAKI)</th>
                                    <th style="width: 15%" class="text-center">Link Artikel</th>
                                    <th style="width: 15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataAdmin as $item)
                                    <tr>
                                        <td rowspan="2" class="text-center">{{ $loop->iteration }}</td>
                                        <td rowspan="2" class="fw-bold text-center">Tim {{ $item->judul }}</td>
                                        <td>Dokumen</td>
                                        <td class="text-center">
                                            @if ($item->dokumenPublikasi && $item->dokumenPublikasi->file_artikel)
                                                <a href="{{ asset('storage/dokumen-publikasi/' . $item->dokumenPublikasi->file_artikel) }}"
                                                    class="btn btn-success" target="_blank">Lihat File</a>
                                        </td>
                                    @else
                                        <span class="badge bg-danger">Belum Upload</span>
                                @endif
                                <td class="text-center">
                                    @if ($item->dokumenPublikasi && $item->dokumenPublikasi->file_haki)
                                        <a href="{{ asset('storage/dokumen-publikasi/' . $item->dokumenPublikasi->file_haki) }}"
                                            class="btn btn-success" target="_blank">Lihat File</a>
                                </td>
                            @else
                                <span class="badge bg-danger">Belum Upload</span>
                                @endif
                                <td rowspan="2" class="text-center">
                                    @if ($item->dokumenPublikasi && $item->dokumenPublikasi->link_artikel)
                                        <a href="{{ $item->dokumenPublikasi->link_artikel }}" class="btn btn-success"
                                            target="_blank">Link Artikel</a>
                                </td>
                            @else
                                <span class="badge bg-danger">Belum Upload</span>
                                @endif
                                <td rowspan="2" class="text-center">
                                    @if ($item->dokumenTeknis)
                                        <a href="/dokumen-publikasi/{{ $item->dokumenPublikasi->id }}"
                                            class="btn btn-primary">Lihat</a>

                                        <a href="/dokumen-publikasi/edit/{{ $item->dokumenPublikasi->id }}"
                                            class="btn btn-warning">Edit</a>
                                    @else
                                    @endif
                                </td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td class="text-center">
                                        <span class="badge {{ $item->dokumenPublikasi ? 'bg-primary' : 'bg-danger' }}">
                                            {{ $item->dokumenPublikasi ? $item->dokumenPublikasi->status_artikel : 'Belum Upload' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge {{ $item->dokumenPublikasi ? 'bg-primary' : 'bg-danger' }}">
                                            {{ $item->dokumenPublikasi ? $item->dokumenPublikasi->status_haki : 'Belum Upload' }}
                                        </span>
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
