@extends('layout.app')
@section('title', 'Dokumen Publikasi')
@section('description', 'Laporan Akhir')


@section('content')
    <style>
        .modal {
            display: none;
            /* Sembunyikan modal secara default */
            /* position: fixed; */
            /* z-index: 1; */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close-button {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close-button:hover,
        .close-button:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
    <div class="w-100">
        @if (session('success'))
            <x-success-modal :message="session('success')" />
        @endif
        @if (session('error'))
            <x-error-modal :message="session('error')" />
        @endif
        <div class="card">
            <div class="container-fluid px-4 py-4">

                <div class="card-body p-0">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>

                                <th style="width: 15%" class="text-center">File draf Artikel Berita Media Massa</th>
                                <th style="width: 15%" class="text-center">Bukti Ketercapaian HAKI (Sertifikat
                                    Haki/Draft Pendaftaran HAKI)</th>
                                <th style="width: 15%" class="text-center">Bukti Ketercapaian Seminar atau Publikasi Artikel
                                </th>
                                <th style="width: 15%" class="text-center">Link Artikel</th>
                                <th style="width: 10%" class="text-center">Status</th>
                                <th style="width: 15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center gap-2">

                                            <a href="{{ asset('storage/dokumen-publikasi/' . $item->file_artikel) }}"
                                                class="btn btn-outline-info" target="_blank"><i
                                                    class="fas fa-eye me-1"></i>Lihat
                                                File</a>
                                            <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="{{ $item->status_artikel }}">
                                                <i
                                                    class="fa-solid 
                                                                @switch($item->status_artikel)
                                                                    @case('Publish') fa-circle-check @break
                                                                    @case('Draft') fa-bookmark @break
                                                                    @default fa-question-circle
                                                                @endswitch
                                                        me-2"></i>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center gap-2">

                                            <a href="{{ asset('storage/dokumen-publikasi/' . $item->file_haki) }}"
                                                class="btn btn-outline-info" target="_blank"><i
                                                    class="fas fa-eye me-1"></i>Lihat
                                                File</a>
                                            <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="{{ $item->status_haki }}">
                                                <i
                                                    class="fa-solid 
                                                                @switch($item->status_haki)
                                                                    @case('Publish') fa-circle-check @break
                                                                    @case('Draft') fa-bookmark @break
                                                                    @default fa-question-circle
                                                                @endswitch
                                                        me-2"></i>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <a href="{{ asset('storage/dokumen-publikasi/' . $item->file_bukti_publikasi) }}"
                                                class="btn btn-sm btn-outline-primary" target="_blank">
                                                <i class="fas fa-eye me-1"></i> Lihat File
                                            </a>

                                            <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="{{ $item->status_publikasi }}">
                                                <i
                                                    class="fa-solid 
                                                                    @switch($item->status_publikasi)
                                                                        @case('Publish') fa-circle-check @break
                                                                        @case('Draft') fa-bookmark @break
                                                                        @default fa-question-circle
                                                                    @endswitch
                                                            me-2"></i>
                                            </span>
                                        </div>


                                    </td>
                                    <td class="text-center"><a href="{{ $item->link_artikel }}" class="btn btn-outline-info"
                                            target="_blank"><i class="fas fa-eye me-1"></i>Link
                                            Artikel</a></td>
                                    <td class="text-center" id="status">
                                        @if ($item && $item->status === 'Ditolak')
                                            <span class="badge bg-danger" tabindex="0" role="button"
                                                data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                style="cursor: pointer">
                                                Ditolak
                                                <i class="fas fa-info-circle ms-1 text-white"></i>
                                            </span>
                                            <!-- Scrollable modal -->
                                            <div class="modal fade" id="exampleModal" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Komentar
                                                                Dokumen
                                                            </h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-start">
                                                            {{ $item->komentar }}
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            {{ $item->status }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($item && $item->status === 'Valid')
                                            Tidak Ada Aksi
                                        @else
                                            <a href="/dokumen-publikasi/edit/{{ $item->id }}"
                                                class="btn btn-outline-warning"> <i
                                                    class="fa-solid fa-pen-to-square me-2"></i>Edit</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="statusModalLabel"><i
                                            class="fa-solid fa-circle-info me-2"></i>Pemberitahuan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Dokumen anda ditolak karena belum sesuai.
                                    Klik "i" untuk melihat detail.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var status = document.getElementById("status").innerText.trim().toLowerCase();
            console.log("Status dokumen:", status); // Debugging

            if (status === "ditolak") {
                var modalElement = document.getElementById("statusModal");
                var modalInstance = new bootstrap.Modal(modalElement);
                modalInstance.show();
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltipTriggerList.forEach(function(tooltipTriggerEl) {
                new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
@endsection
