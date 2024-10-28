@extends('layout.app')
@section('content')
    <h1 class="h3 mb-3"><strong>Admin</strong> Dashboard</h1>
    <div class="w-100">
        <div class="card flex-fill">
            <div class="card-header">
                <a class="btn btn-primary" href="{{route('mahasiswa.publikasi.tambah')}}">Tambah Publikasi</a>
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
                            <td class="d-none d-xl-table-cell">{{ $item->status }}</td>
                            <td>
                               
                                {{-- @if ($item->registration_validation->status === 'Belum valid') --}}
                                    <a href="{{ route('admin.approve', ['id' => $item->id]) }}"
                                        class="btn btn-success">Setujui</a>
                                {{-- @endif --}}
                                <a href="/publikasi/edit/{{$item->id}}" class="btn btn-warning">Edit</a>
                                <a href="/publikasi/detail/{{$item->id}}" class="btn btn-primary">CEK</a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
