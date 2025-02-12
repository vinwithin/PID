@extends('layout.app')
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
        <div class="card flex-fill">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Daftar Album</h5>
            </div>
            <table class="table table-striped table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 8%">No</th>
                        <th class="d-none d-md-table-cell" style="width: 10%">Pembuat</th>
                        <th class="d-none d-md-table-cell" style="width: 30%">Artikel</th>
                        <th class="d-none d-md-table-cell" style="width: 30%">Judul Artikel</th>
                        <th class="d-none d-md-table-cell">Visibilitas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
            
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="d-none d-md-table-cell fw-bold text-primary">
                                Tim {{ $item->registration->judul }}
                            </td>
                            <td>
                                <div class="rounded shadow-sm p-1 ">
                                    @if ($item->file_artikel)
                                        <iframe src="{{ asset('storage/dokumen-publikasi/' . $item->file_artikel) }}"
                                            width="220" height="170" class="border rounded"
                                            style="box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);">
                                        </iframe>
                                    @else
                                        <p class="text-muted text-center m-0" style="font-size: 0.9rem;">
                                            Tidak ada file tersedia
                                        </p>
                                    @endif
                                </div>
                            </td>
                            <td class="fw-semibold">
                                {{ $item->judul_artikel }}
                            </td>
                     


                        <td class="d-none d-md-table-cell">
                            <div class="form-check form-switch custom-toggle">


                                <input class="form-check-input toggle-switch" type="checkbox"
                                    id="switch-{{ $item->id }}" data-id="{{ $item->id }}"
                                    @if ($item->visibilitas == 'yes') ) checked @endif>
                                <label class="form-check-label" for="switch-{{ $item->id }}">
                                    {{ $item->visibilitas == 'yes' ? 'On' : 'Off' }}
                                </label>


                            </div>
                        </td>
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
                // const linkYoutube = $('#link-youtube-' + itemId).val(); // Ambil link_youtube dari input

                // Kirim data ke server menggunakan AJAX
                $.ajax({
                    url: '/update-status-artikel', // Route untuk update status
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // CSRF token untuk keamanan
                        id: itemId,
                        status: status,
                        // status: linkYoutube // Kirim link_youtube ke server
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update label status
                            $('#switch-' + itemId).next('label').text(status);
                            alert('Status berhasil diperbarui!');
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
