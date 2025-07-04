@extends('layout.app')
@section('title', 'Pengumuman')
@section('description', 'Kelola Pengumuman')
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

                @can('manage role')
                    <a class="btn btn-success" href="{{ route('announcement.tambah') }}"><i
                            class="fa-solid fa-plus me-2"></i>Tambah Pengumuman</a>
                @endcan
            </div>
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th class="d-none d-md-table-cell"style="width: 10%">Pembuat</th>
                        <th class="d-none d-md-table-cell" style="width: 15%">Title</th>
                        <th class="d-none d-md-table-cell" style="width: 30%">Konten</th>
                        <th class="d-none d-md-table-cell" style="width: 10%">Status</th>
                        <th class="d-none d-md-table-cell" style="width: 20%">Waktu</th>
                        <th class="d-none d-md-table-cell" style="width: 30%">Aksi</th>
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
                                {{ $item->category }}
                            </td>
                            <td class="d-none d-md-table-cell">
                                {{ $item->title }}
                            </td>
                            <td class="d-none d-md-table-cell">
                                @php
                                    $status = strtolower($item->status); // Biar fleksibel, tidak case sensitive
                                @endphp

                                @if ($status === 'tutup')
                                    <span class="badge bg-light text-dark">Tutup</span>
                                @else
                                    <span class="badge bg-success text-white">{{ ucfirst($status) }}</span>
                                @endif

                            </td>
                            <td class="d-none d-md-table-cell">
                                {{ \Carbon\Carbon::parse($item->start_date)->translatedFormat('d F Y') . ' - ' . \Carbon\Carbon::parse($item->end_date)->translatedFormat('d F Y') }}
                            </td>


                            <td class="d-none d-md-table-cell">

                                <a href="/announcement/edit/{{ $item->id }}" class="btn btn-outline-warning">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                @can('manage role')
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteModal{{ $item->id }}"><i class="fa-solid fa-trash"></i>

                                    </button>
                                    <!-- Gunakan komponen modal -->
                                    <x-confirm-modal modal-id="deleteModal{{ $item->id }}" title="Konfirmasi Persetujuan"
                                        message="Apakah Anda yakin ingin menghapus pengumuman ini?"
                                        action-url="/announcement/destroy/{{ $item->id }}" confirm-text="Iya, Setujui" />
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- <div class="d-flex justify-content-center mt-4">
                {{ $data->links() }}
            </div> --}}
        </div>
    </div>
@endsection
