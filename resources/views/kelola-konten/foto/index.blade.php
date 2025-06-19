@extends('layout.app')
@section('title', 'Konten Galeri')
@section('description', 'Kelola Konten')
@section('content')
    <style>
        /* Custom styling for larger toggle */
        .custom-toggle .form-check-input {
            width: 3rem;
            height: 1.5rem;
            background-size: 1rem;
            margin-left: -2.5rem;
        }


        .custom-toggle .form-check-label {
            margin-left: 1.8rem;
            font-size: 1.1rem;
            font-weight: bold;
        }

        /* Styling untuk tabel */
        .table-custom {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
        }

        .table-custom tbody td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        .table-custom tbody tr:hover {
            background-color: #f5f5f5;
            /* Efek hover pada baris */
        }

        /* Styling untuk tombol toggle */

        .custom-toggle .form-check-label {
            margin-left: 10px;
        }

        /* Styling untuk iframe YouTube */
        .youtube-embed {
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }


        .overlay {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .card:hover .overlay {
            opacity: 1;
            /* Menampilkan overlay saat card dihover */
        }

        .overlay h5,
        .overlay p {
            color: white;
            /* Pastikan teks berwarna putih */
            z-index: 2;
            /* Pastikan teks di atas overlay */
        }

        .badge {
            font-size: 0.8rem;
            padding: 0.5em 0.75em;
            z-index: 3;
            /* Pastikan badge di atas overlay */
        }
    </style>
    <div class="w-100">
        @if (session('success'))
            <x-success-modal :message="session('success')" />
        @endif
        @if (session('error'))
            <x-error-modal :message="session('error')" />
        @endif
        <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true" aria-labelledby="successModalLabel">
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
                    <h4 class="fw-bold mt-3 text-success">Berhasil!</h4>

                    <!-- Pesan -->
                    <p class="text-muted px-4">
                        Status berhasil diperbarui!
                    </p>

                    <!-- Tombol OK -->
                    <div class="d-grid">
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal" aria-label="Close">Tutup</button>

                    </div>
                </div>
            </div>
        </div>
        <div class="card flex-fill">

            <div class="card-header d-flex justify-content-start align-items-start">
                <a class="btn btn-success" href="/kelola-konten/foto/create"><i class="fa-solid fa-plus me-2"></i>Tambah Album</a>

            </div>
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 10%">No</th>
                        <th class="d-none d-md-table-cell"style="width: 25%">Pembuat</th>
                        <th class="d-none d-md-table-cell" style="width: 30%">Album</th>
                        <th class="d-none d-md-table-cell" style="width: 20%">Visibilitas</th>
                        <th style="width: 15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>

                            <td>{{ $loop->iteration }}</td>
                            <td class="d-none d-md-table-cell">Tim
                                {{ !empty($item->registration) ? $item->registration->judul : 'Admin' }}</td>
                            <td>
                                <div class="card border-0 shadow-sm position-relative overflow-hidden custom-card"
                                    style="max-width: 220px; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                                    <!-- Gambar Latar Belakang -->
                                    <img src="{{ asset('/assets/Desktop.svg') }}" class="card-img-top"
                                        alt="Gambar Tim" style="height: 150px; object-fit: cover; filter: grayscale(30%);">

                                    <!-- Overlay -->
                                    <a href="/kelola-konten/foto/detail/{{ $item->id }}"
                                        class="overlay position-absolute top-0 start-0 w-75 h-75 d-flex flex-column justify-content-center align-items-center text-white text-decoration-none"
                                        style="background: rgba(0, 0, 0, 0.6); opacity: 0; transition: opacity 0.3s ease-in-out; border-radius: 10px;">
                                        <h5 class="fw-bold text-white mb-2 fs-4">{{ $item->nama }}</h5>
                                        <span class="btn btn-light btn-sm px-3 py-2 shadow-sm rounded-pill">
                                            Lihat Detail
                                        </span>
                                    </a>


                                    <!-- Badge untuk Informasi Tambahan -->
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <span class="badge bg-primary">Aktif</span>
                                    </div>
                                </div>
                            </td>





                            <td class="d-none d-md-table-cell">
                                <div class="form-check form-switch custom-toggle">


                                    <input class="form-check-input toggle-switch" type="checkbox"
                                        id="switch-{{ $item->id }}" data-id="{{ $item->id }}"
                                        @if ($item->status == 'valid') ) checked @endif>
                                    <label class="form-check-label" for="switch-{{ $item->id }}">
                                        {{ $item->status == 'valid' ? 'On' : 'Off' }}
                                    </label>


                                </div>

                                <input type="hidden" id="link-youtube-{{ $item->id }}" value="{{ $item->status }}">
                            </td>

                            @role('admin')
                                <td class="text-center">
                                    <a href="/kelola-konten/foto/edit/{{ $item->id }}"
                                        class="btn btn-outline-warning">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $item->id }}">
                                        <i class="fa-solid fa-trash"></i> 
                                    </button>
                                    <x-confirm-modal modal-id="deleteModal{{ $item->id }}" title="Konfirmasi Persetujuan"
                                        message="Apakah Anda yakin ingin menghapus album ini?"
                                        action-url="/kelola-konten/foto/delete/{{ $item->id }}"
                                        confirm-text="Ya, Setujui" />

                                </td>
                            @endrole

                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-4">
                {{ $data->links() }}
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Event listener untuk toggle switch
            $('.toggle-switch').change(function() {
                const itemId = $(this).data('id'); // Ambil ID item
                const isChecked = $(this).is(':checked'); // Cek status toggle (On/Off)
                const condition = isChecked ? 'On' : 'Off'; // Tentukan status
                // const linkYoutube = $('#link-youtube-' + itemId).val(); // Ambil link_youtube dari input

                // Kirim data ke server menggunakan AJAX
                $.ajax({
                    url: '/update-status-foto', // Route untuk update status
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // CSRF token untuk keamanan
                        id: itemId,
                        condition: condition,
                        // status: linkYoutube // Kirim link_youtube ke server
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update label status
                            $('#switch-' + itemId).next('label').text(status);
                            const successModal = new bootstrap.Modal(document.getElementById(
                                'successModal'));
                            successModal.show();
                        } else {
                            alert('Gagal memperbarui status.');
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan saat mengirim data.');
                    }
                });
            });
        });
    </script>
@endsection
