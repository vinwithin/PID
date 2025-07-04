@extends('layout.app')
@section('title', 'Kelola Video')
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
    </style>
    <div class="w-100">
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
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal"
                            aria-label="Close">Tutup</button>

                    </div>
                </div>
            </div>
        </div>
        @if (session('success'))
            <x-success-modal :message="session('success')" />
        @endif
        @if (session('error'))
            <x-error-modal :message="session('error')" />
        @endif
        <div class="card flex-fill">

            <div class="card-header d-flex justify-content-between align-items-center">

                <a class="btn btn-success" href="/kelola-konten/video/create"><i class="fa-solid fa-plus me-2"></i>Tambah
                    Video</a>

            </div>
            <table class="table table-hover my-0 table-custom">
                <thead>
                    <tr>
                        <th style="width: 10%">No</th>
                        <th class="d-none d-xl-table-cell" style="width: 20%">Pembuat</th>
                        <th class="d-none d-xl-table-cell" style="width: 30%">Link Youtube</th>
                        <th class="d-none d-xl-table-cell">Visibilitas</th>
                        <th style="width: 15%" class="text-center">Aksi</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="d-none d-xl-table-cell">{{ $item->created_by }}




                            </td>
                            <td class="d-none d-xl-table-cell">
                                <iframe width="180" height="100" src="{{ $item->link_youtube }}" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen title="Embedded YouTube Video" class="youtube-embed"
                                    onerror="this.onerror=null;this.src='//www.youtube.com/embed/invalidVideoId';this.outerHTML='<div class=\'text-danger\'>Video tidak tersedia</div>';"></iframe>

                            </td>
                            <td class="d-none d-xl-table-cell">
                                <div class="form-check form-switch custom-toggle">
                                    {{-- @dd($item->link_youtube); --}}

                                    <input class="form-check-input toggle-switch" type="checkbox"
                                        id="switch-{{ $item->id }}" data-id="{{ $item->id }}"
                                        @if ($item->visibilitas === 'on') checked @endif>
                                    <label class="form-check-label" for="switch-{{ $item->id }}">
                                        {{ $item->visibilitas === 'on' ? 'On' : 'Off' }}
                                    </label>


                                </div>
                                <!-- Input tersembunyi untuk menyimpan link_youtube -->
                                <input type="hidden" id="link-youtube-{{ $item->id }}"
                                    value="{{ $item->link_youtube }}">
                            </td>
                            @role('admin')
                                <td class="text-center">
                                    <a href="/kelola-konten/video/edit/{{ $item->id }}" class="btn btn-outline-warning">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $item->id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                    <x-confirm-modal modal-id="deleteModal{{ $item->id }}" title="Konfirmasi Persetujuan"
                                        message="Apakah Anda yakin ingin menghapus album ini?"
                                        action-url="/kelola-konten/video/delete/{{ $item->id }}"
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
                const status = isChecked ? 'On' : 'Off'; // Tentukan status
                const linkYoutube = $('#link-youtube-' + itemId).val(); // Ambil link_youtube dari input

                // Kirim data ke server menggunakan AJAX
                $.ajax({
                    url: '/update-status-video', // Route untuk update status
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // CSRF token untuk keamanan
                        id: itemId,
                        status: status,
                        link_youtube: linkYoutube // Kirim link_youtube ke server
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
