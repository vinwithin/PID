@extends('layout.app')
@section('content')
    <div class="w-100">
        <div class="card">

            <div class="card-header">
                <h3>Publikasi Dokumen Teknis</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th style="width: 15%">Tim</th>
                            <th style="width: 10%">Konten</th>
                            <th style="width: 15%" class="text-center">Dokumen Manual/Panduan</th>
                            <th style="width: 15%" class="text-center">Bukti Ketercapaian Seminar atau Publikasi Artikel
                            </th>
                            <th style="width: 15%" class="text-center">Draft proposal PPK Ormawa untuk tahun berikutnya</th>
                            <th style="width: 15%" class="text-center">Dokumen Laporan Keuangan</th>
                            <th style="width: 15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataAdmin as $item)
                            <tr>
                                <td rowspan="2">{{ $loop->iteration }}</td>
                                <td rowspan="2" class="fw-bold text-center">Tim {{ $item->judul }}</td>
                                <td>Dokumen</td>
                                <td class="text-center">
                                    @if ($item->dokumenTeknis && $item->dokumenTeknis->file_manual)
                                        <a href="{{ asset('storage/dokumen-teknis/' . $item->dokumenTeknis->file_manual) }}"
                                            class="btn btn-warning" target="_blank">Lihat File</a>
                                    @else
                                        <span class="badge bg-danger">Belum Upload</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($item->dokumenTeknis && $item->dokumenTeknis->file_bukti_publikasi)
                                        <a href="{{ asset('storage/dokumen-teknis/' . $item->dokumenTeknis->file_bukti_publikasi) }}"
                                            class="btn btn-warning" target="_blank">Lihat File</a>
                                    @else
                                        <span class="badge bg-danger">Belum Upload</span>
                                    @endif
                                </td>
                                <td rowspan="2" class="text-center">
                                    @if ($item->dokumenTeknis && $item->dokumenTeknis->file_proposal)
                                        <a href="{{ asset('storage/dokumen-teknis/' . $item->dokumenTeknis->file_proposal) }}"
                                            class="btn btn-warning" target="_blank">Lihat File</a>
                                    @else
                                        <span class="badge bg-danger">Belum Upload</span>
                                    @endif
                                </td>
                                <td rowspan="2" class="text-center">
                                    @if ($item->dokumenTeknis && $item->dokumenTeknis->file_laporan_keuangan)
                                        <a href="{{ asset('storage/dokumen-teknis/' . $item->dokumenTeknis->file_laporan_keuangan) }}"
                                            class="btn btn-warning" target="_blank">Lihat File</a>
                                    @else
                                        <span class="badge bg-danger">Belum Upload</span>
                                    @endif
                                </td>
                                <td rowspan="2" class="text-center">
                                    @if ($item->dokumenTeknis)
                                        <a href="/dokumen-teknis/edit/{{ $item->dokumenTeknis->id }}"
                                            class="btn btn-primary">Edit</a>
                                    @else
                                        <span class="badge bg-secondary">Tidak Ada Dokumen</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td class="text-center">
                                    <span class="badge {{ $item->dokumenTeknis ? 'bg-primary' : 'bg-danger' }}">
                                        {{ $item->dokumenTeknis ? $item->dokumenTeknis->status_manual : 'Belum Upload' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $item->dokumenTeknis ? 'bg-primary' : 'bg-danger' }}">
                                        {{ $item->dokumenTeknis ? $item->dokumenTeknis->status_publikasi : 'Belum Upload' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
