@extends('layout.app')
@section('content')
    <div class="w-100">
        <div class="card flex-fill">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Daftar Publikasi</h5>
                <a class="btn btn-primary" href="{{ route('publikasi.tambah') }}">Tambah Publikasi</a>
            </div>
            @can('agree publication')
                <div class="card-header">
                    {{-- <h5 class="card-title mb-0">Latest Projects</h5> --}}
                    <form method="GET" action="{{ route('publikasi.search') }}">
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
                </div>
            @endcan
            <table class="table table-hover my-0">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th class="d-none d-xl-table-cell" style="width: 10%">Pembuat</th>
                        <th class="d-none d-xl-table-cell" style="width: 35%">Title</th>
                        <th class="d-none d-xl-table-cell" style="width: 10%">Thumbnail</th>
                        <th class="d-none d-xl-table-cell" style="width: 10%">Status</th>
                        <th style="width: 25%">Aksi</th>

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
                                        class="{{ $item->status === 'Belum valid' ? 'badge text-bg-warning' : 'badge text-bg-primary' }}">
                                        {{ $item->status }}</p>
                                </td>
                                <td>

                                    {{-- @if ($item->registration_validation->status === 'Belum valid') --}}
                                    @can('agree publication')
                                        @if ($item->status === 'Belum valid')
                                            <a href="{{ route('publikasi.approve', ['id' => $item->id]) }}"
                                                class="btn btn-success">Setujui</a>
                                        @endif
                                    @endcan

                                    {{-- @endif --}}
                                    <a href="/publikasi/edit/{{ $item->id }}" class="btn btn-warning">Edit</a>
                                    <a href="/publikasi/{{ $item->id }}" class="btn btn-primary">CEK</a>
                                    @can('delete publication')
                                        <a href="/publikasi/delete/{{ $item->id }}" class="btn btn-danger">Delete</a>
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
                                    class="{{ $item->status === 'Belum valid' ? 'badge text-bg-warning' : 'badge text-bg-primary' }}">
                                    {{ $item->status }}</p>
                            </td>

                            <td>

                                {{-- @if ($item->registration_validation->status === 'Belum valid') --}}
                                @can('agree publication')
                                    @if ($item->status === 'Belum valid')
                                        <a href="{{ route('publikasi.approve', ['id' => $item->id]) }}"
                                            class="btn btn-success">Setujui</a>
                                    @endif
                                @endcan

                                {{-- @endif --}}
                                <a href="/publikasi/edit/{{ $item->id }}" class="btn btn-warning">Edit</a>
                                <a href="/publikasi/{{ $item->id }}" class="btn btn-primary">CEK</a>
                                @can('delete publication')
                                    <a href="/publikasi/delete/{{ $item->id }}" class="btn btn-danger">Delete</a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    @endrole

                </tbody>
            </table>
        </div>
    </div>
@endsection
