@extends('layout.app')
@section('content')
    <div class="w-100">
        <div class="card flex-fill">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Daftar Publikasi</h5>
                <a class="btn btn-primary" href="{{ route('publikasi.tambah') }}">Tambah Publikasi</a>
            </div>
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
            <table class="table table-hover my-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th class="d-none d-xl-table-cell">Title</th>
                        <th class="d-none d-xl-table-cell">Status</th>
                        <th>Aksi</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="d-none d-xl-table-cell">{{ $item->title }}</td>
                            <td class="badge text-bg-primary m-2">{{ $item->status }}</td>
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
                                <a href="/publikasi/detail/{{ $item->id }}" class="btn btn-primary">CEK</a>
                                @can('delete publication')
                                    <a href="/publikasi/delete/{{ $item->id }}" class="btn btn-danger">Delete</a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
