@extends('layout.app')
@section('title', 'Berita')
@section('description', 'Kelola Berita')
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
        <div class="card flex-fill">
            <div class="card-header d-flex justify-content-between align-items-center">
                <a class="btn btn-success" href="/berita/create"><i class="fa-solid fa-plus me-2"></i>Tambah Berita</a>
                <form action="{{ route('berita') }}" method="GET" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari berita..."
                            value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="fa fa-search"></i> Cari
                        </button>
                        <a href="{{ route('berita') }}" class="btn btn-success ms-2">Reset</a>

                    </div>
                </form>

            </div>
            @if (request('search'))
                <p class="text-muted">Hasil pencarian untuk: <strong>{{ request('search') }}</strong></p>
            @endif

            <table class="table table-striped table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%">No</th>
                        <th class="d-none d-md-table-cell"style="width: 10%">Pembuat</th>
                        <th class="d-none d-md-table-cell" style="width: 40%">Judul</th>
                       
                        <th class="d-none d-md-table-cell" style="width: 25%">Thumbnails</th>
                        <th class="d-none d-md-table-cell" style="width: 25%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>

                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $item->user[0]->name }}
                            </td>
                            <td class="d-none d-md-table-cell">
                                {{ $item->title }}
                            </td>
                           
                            <td class="d-none d-xl-table-cell"><img class="img-thumbnail"
                                    src="/storage/{{ $item->thumbnail }}" alt=""
                                    style="max-width: 80px; max-height:80px;">
                            </td>


                            <td class="d-none d-md-table-cell">

                        
                                <a href="/berita/edit/{{ $item->id }}" class="btn btn-outline-warning">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $item->id }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                <!-- Gunakan komponen modal -->
                                <x-confirm-modal modal-id="deleteModal{{ $item->id }}" title="Konfirmasi Persetujuan"
                                    message="Apakah Anda yakin ingin menghapus berita ini?"
                                    action-url="/berita/delete/{{ $item->id }}" confirm-text="Iya, Setujui" />



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
@endsection
