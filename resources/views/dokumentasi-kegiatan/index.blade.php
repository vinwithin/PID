@extends('layout.app')
@section('title', 'Dokumentasi Kegiatan')
@section('content')
    <style>
        .modal {
            display: none;
            /* Sembunyikan modal secara default */
            /* position: fixed; */
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
        <div class="card">
            <div class="container-fluid px-4 py-4">

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
                                <th style="width: 20%" class="text-center">Link Tautan Video Youtube</th>
                                <th style="width: 20%" class="text-center">Tautan Sosial Media</th>
                                <th style="width: 20%" class="text-center">Link/tautan Google Drive dokumentasi kegiatan
                                </th>
                                <th style="width: 15%" class="text-center">Status</th>
                                <th style="width: 15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td rowspan="2" class="text-center"><a href="{{ $item->link_youtube }}"
                                            class="btn btn-warning" target="_blank"><i class="fas fa-eye me-1"></i>Link
                                            Youtube</a></td>
                                    <td rowspan="2" class="text-center"><a href="{{ $item->link_social_media }}"
                                            class="btn btn-warning" target="_blank"><i class="fas fa-eye me-1"></i>Link
                                            Sosial Media</a></td>
                                    <td rowspan="2" class="text-center"><a href="{{ $item->link_dokumentasi }}"
                                            class="btn btn-warning" target="_blank"><i class="fas fa-eye me-1"></i>Link
                                            Google Drive</a></td>
                                    <td rowspan="2" class="text-center" id="status">
                                        {{ $item->status }}
                                    </td>
                                    <td rowspan="2" class="text-center"><a
                                            href="/dokumentasi-kegiatan/edit/{{ $item->id }}"
                                            class="btn btn-primary">Edit</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Modal -->
                    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="statusModalLabel">Pemberitahuan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Status dokumen Anda ditolak. Silakan periksa kembali.
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
@endsection
