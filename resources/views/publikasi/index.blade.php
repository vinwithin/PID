@extends('layout.app')
@section('title', 'Publikasi Kegiatan')
@section('description', 'Publikasi Kegiatan')

@section('content')
    <div class="w-100">
        @if (session('success'))
            <x-success-modal :message="session('success')" />
        @endif
        @if (session('error'))
            <x-error-modal :message="session('error')" />
        @endif
        <div class="card flex-fill">
            @role('mahasiswa')
                <div class="card-header d-flex justify-content-end align-items-end">
                    <a class="btn btn-success" href="{{ route('publikasi.tambah') }}"><i class="fa-solid fa-plus me-2"></i>Tambah
                        Publikasi</a>
                </div>
            @endrole

            @can('agree publication')
                <div class="card-header d-flex justify-content-between align-items-center">
                    {{-- <h5 class="card-title mb-0">Latest Projects</h5> --}}
                    <form method="GET" action="{{ route('publikasi') }}">
                        <label class="form-label">Filter berdasarkan status:</label>
                        <div class="d-flex align-items-center">
                            <div class="form-check me-3">
                                <input class="form-check-input" type="checkbox" name="filters[]" value="Belum valid"
                                    id="filterManager">
                                <label class="form-check-label" for="filterManager">Belum Valid</label>
                            </div>
                            <div class="form-check me-3">
                                <input class="form-check-input" type="checkbox" name="filters[]" value="valid"
                                    id="filterEngineer">
                                <label class="form-check-label" for="filterEngineer">Valid</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Terapkan Filter</button>
                    </form>
                    <div class="d-flex flex-column justify-content-end align-items-end gap-3">
                        <a class="btn btn-success" href="{{ route('publikasi.tambah') }}"><i
                                class="fa-solid fa-plus me-2"></i>Tambah
                            Publikasi</a>
                        <form action="{{ route('publikasi') }}" method="GET" class="mb-3">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Cari kegiatan..."
                                    value="{{ request('search') }}">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-search"></i> Cari
                                </button>
                                <a href="{{ route('publikasi') }}" class="btn btn-success ms-2">Reset</a>

                            </div>
                        </form>
                    </div>
                </div>
            @endcan
            <table class="table table-hover my-0">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th class="d-none d-xl-table-cell" style="width: 10%">Pembuat</th>
                        <th class="d-none d-xl-table-cell" style="width: 35%">Judul</th>
                        <th class="d-none d-xl-table-cell" style="width: 15%">Thumbnail</th>
                        <th class="d-none d-xl-table-cell" style="width: 8%">Status</th>
                        <th style="width: 18%">Aksi</th>

                    </tr>
                </thead>
                <tbody>
                    @can('agree publication')
                        @foreach ($dataAll as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->registration->judul ?? 'Admin' }}</td>
                                <td class="d-none d-xl-table-cell">{{ $item->title }}</td>
                                <td class="d-none d-xl-table-cell"><img class="img-thumbnail"
                                        src="{{ asset('/storage/media/thumbnails/' . $item->thumbnail) }}" alt=""
                                        style="max-width: 80px; max-height:80px;"></td>
                                <td class="">
                                    <p
                                        class="badge 
                                                @switch($item->status)
                                                    @case('Belum valid') text-bg-warning @break
                                                    @case('valid') text-bg-primary @break
                                                    @case('Ditolak') text-bg-danger @break
                                                    @default text-bg-secondary
                                                @endswitch
                                            ">
                                        {{ $item->status }}
                                    </p>

                                </td>
                                <td>


                                    @can('agree publication')
                                        @if ($item->status === 'Belum valid')
                                            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                                data-bs-target="#approveModal{{ $item->id }}"><i class="fa-solid fa-check"></i>

                                            </button>
                                            <!-- Gunakan komponen modal -->
                                            <x-confirm-modal modal-id="approveModal{{ $item->id }}"
                                                title="Konfirmasi Persetujuan"
                                                message="Apakah Anda yakin ingin menyetujui artikel ini?"
                                                action-url="{{ route('publikasi.approve', ['id' => $item->id]) }}"
                                                confirm-text="Iya, Setujui" />
                                            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                                data-bs-target="#rejectModal{{ $item->id }}"><i
                                                    class="fa-solid fa-circle-xmark"></i>

                                            </button>
                                            <!-- Gunakan komponen modal -->
                                            <x-confirm-modal modal-id="rejectModal{{ $item->id }}"
                                                title="Konfirmasi Persetujuan"
                                                message="Apakah Anda yakin ingin menolak artikel ini?"
                                                action-url="{{ route('publikasi.reject', ['id' => $item->id]) }}"
                                                confirm-text="Iya, Tolak" />
                                        @endif
                                    @endcan


                                    <a href="/publikasi/edit/{{ $item->id }}" class="btn btn-outline-warning"><i
                                            class="fa-solid fa-pen"></i></a>
                                    <a href="/publikasi/{{ $item->id }}" class="btn btn-outline-primary"><i
                                            class="fa-solid fa-eye"></i></a>
                                    @can('delete publication')
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $item->id }}"><i class="fa-solid fa-trash"></i>

                                        </button>
                                        <!-- Gunakan komponen modal -->
                                        <x-confirm-modal modal-id="deleteModal{{ $item->id }}" title="Konfirmasi Persetujuan"
                                            message="Apakah Anda yakin ingin menghapus artikel ini?"
                                            action-url="/publikasi/delete/{{ $item->id }}" confirm-text="Iya, Setujui" />
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    @endcan

                    @role('mahasiswa')
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>Tim {{ $item->registration->judul }}</td>
                                <td class="d-none d-xl-table-cell">{{ $item->title }}</td>
                                <td class="d-none d-xl-table-cell"><img class="img-thumbnail"
                                        src="{{ asset('/storage/media/thumbnails/' . $item->thumbnail) }}" alt=""
                                        style="max-width: 80px"></td>
                                <td class="">
                                    <p
                                        class="badge 
                                                @switch($item->status)
                                                    @case('Belum valid') text-bg-warning @break
                                                    @case('valid') text-bg-primary @break
                                                    @case('Ditolak') text-bg-danger @break
                                                    @default text-bg-secondary
                                                @endswitch
                                            ">
                                        {{ $item->status }}
                                    </p>
                                </td>

                                <td>

                                    {{-- @if ($item->registration_validation->status === 'Belum valid') --}}


                                    {{-- @endif --}}
                                    <a href="/publikasi/edit/{{ $item->id }}" class="btn btn-warning"><i
                                            class="fa-solid fa-pen"></i></a>
                                    <a href="/publikasi/{{ $item->id }}" class="btn btn-primary"><i
                                            class="fa-solid fa-eye"></i></a>
                                    @can('delete publication')
                                        <a href="/publikasi/delete/{{ $item->id }}" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a>
                                    @endcan
                                </td>
                                <td></td>
                            </tr>
                        @endforeach
                    @endrole

                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-4">
                {{ $dataAll->links() }}
            </div>
        </div>
    </div>
@endsection
