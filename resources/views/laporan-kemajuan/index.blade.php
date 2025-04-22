{{-- resources/views/registration/create.blade.php --}}
@extends('layout.app')
@section('title', 'Laporan Kemajuan')
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
        <div class="card">
            @role('admin|reviewer|dosen|super admin')
                @include('laporan-kemajuan.admin.index')

                @elserole('mahasiswa')
                <!-- Modal Success -->
                <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content text-center p-4 rounded-3">
                            <button type="button" class="btn-close position-absolute end-0 m-3" data-bs-dismiss="modal"
                                aria-label="Close"></button>

                            <!-- Icon sukses -->
                            <div class="d-flex justify-content-center">
                                <div class="bg-success rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 60px; height: 60px;">
                                    <i class="fa-solid fa-circle-check fa-2xl text-white"></i>
                                </div>
                            </div>

                            <!-- Judul -->
                            <h4 class="fw-bold mt-3">Success</h4>

                            <!-- Pesan -->
                            <p class="text-muted px-4" id="successMessage"></p>

                            <!-- Tombol OK -->
                            <div class="d-grid">
                                <button type="button" class="btn btn-success fw-bold py-2" data-bs-dismiss="modal">OK</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid px-4 py-4">

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 35%">Nama</th>
                                        <th class="d-none d-xl-table-cell text-center" style="width: 35%">Nama File</th>
                                        <th class="d-none d-xl-table-cell text-center" style="width: 35%">Status</th>
                                        <th class="d-none d-xl-table-cell text-center" style="width: 30%">File</th>


                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td class="text-center fw-bold">Laporan Kemajuan Kelompok</td>
                                        <td class="text-center fw-bold" id="fileName">
                                            {{ count($data) > 0 ? $data[0]->file_path : 'Data tidak tersedia' }}

                                        </td>
                                        <td class="text-center fw-bold" id="status">
                                            @if (count($data) > 0)
                                                @if ($data[0]->laporan_kemajuan && $data[0]->status === 'Ditolak')
                                                    <span class="badge bg-danger">
                                                        Ditolak
                                                        <i class="fas fa-info-circle ms-1 text-white" tabindex="0"
                                                            role="button" data-bs-toggle="modal"
                                                            data-bs-target="#exampleModal"></i>
                                                    </span>

                                                    <!-- Scrollable modal -->
                                                    <div class="modal fade" id="exampleModal" tabindex="-1"
                                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-scrollable">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Komentar
                                                                        Dokumen</h1>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-start">
                                                                    {{ $data[0]->komentar }}
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    {{ $data[0]->status }}
                                                @endif
                                            @else
                                                <span>Data Tidak Tersedia</span>
                                            @endif

                                        </td>

                                        <td class="text-center fw-bold">
                                            <form id="uploadForm" enctype="multipart/form-data">
                                                @csrf
                                                <input type="file" id="fileInput" name="file" class="d-none">
                                                @if (empty($data) || !isset($data[0]->file_path))
                                                    <button type="button" id="uploadButton" class="btn btn-primary">Upload
                                                        File</button>
                                                @else
                                                    <button type="button" id="uploadButton" class="btn btn-primary">Ganti
                                                        File</button>
                                                @endif

                                            </form>
                                        </td>

                                    </tr>

                                </tbody>
                            </table>
                        </div>
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
            @endrole

            @push('styles')
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
                <style>
                    body {
                        background-color: #f4f6f9;
                    }

                    .table-responsive {
                        max-height: 600px;
                        overflow-y: auto;
                    }

                    .table thead {
                        position: sticky;
                        top: 0;
                        background-color: #f8f9fa;
                        z-index: 10;
                    }

                    .text-truncate {
                        white-space: nowrap;
                        overflow: hidden;
                        text-overflow: ellipsis;
                    }
                </style>
            @endpush

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#uploadButton").click(function() {
                $("#fileInput").click();
            });

            $("#fileInput").change(function() {
                let file = this.files[0];
                if (file) {
                    $("#fileName").text("File: " + file.name);
                    $("#uploadButton").text("Ganti File");

                    let formData = new FormData();
                    formData.append("file", file);
                    formData.append("_token", "{{ csrf_token() }}");

                    $.ajax({
                        url: "{{ route('laporan-kemajuan.store') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            document.getElementById("successMessage").innerText = response
                                .message;
                            // Tampilkan modal Bootstrap
                            var successModal = new bootstrap.Modal(document.getElementById(
                                'successModal'));
                            successModal.show();
                        },
                        error: function(xhr) {
                            alert("Upload gagal. Pastikan format file sesuai.");
                        }
                    });
                }
            });
        });
    </script>
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
