@extends('layout.app')
@section('content')
    <h1 class="h3 mb-3"><strong>Admin</strong> Dashboard</h1>
    <div class="w-100">
        <div class="card flex-fill">
            <div class="card-header">

                <h5 class="card-title mb-0">Latest Projects</h5>
            </div>
            <table class="table table-hover my-0">
                <thead>
                    <tr>
                        <th>Nama Ketua</th>
                        <th class="d-none d-xl-table-cell">NIM Ketua</th>
                        <th class="d-none d-xl-table-cell">Fakultas Ketua</th>
                        <th>Bidang</th>
                        <th class="d-none d-md-table-cell">Judul</th>
                        <th class="d-none d-md-table-cell">Status</th>
                        <th class="d-none d-md-table-cell">Nilai</th>
                        <th class="d-none d-md-table-cell">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->nama_ketua }}</td>
                            <td class="d-none d-xl-table-cell">{{ $item->nim_ketua }}</td>
                            <td class="d-none d-xl-table-cell">{{ $item->fakultas_ketua }}</td>
                            <td><span class="badge bg-success">{{ $item->bidang->nama }}</span></td>
                            <td class="d-none d-md-table-cell">{{ $item->judul }}</td>
                            <td class="d-none d-md-table-cell">{{ $item->registration_validation->status }}</td>
                            <td>
                                @foreach ($item->penilaian as $penilaian)
                                    {{ $penilaian->nilai }}
                                    <br>
                                @endforeach
                            </td>
                            <td>
                                {{-- <a href="" class="btn btn-warning"></a> --}}
                                @if ($item->registration_validation->status === 'Belum valid')
                                    <a href="{{ route('admin.approve', ['id' => $item->id]) }}"
                                        class="btn btn-success">Setujui</a>
                                @endif
                                <a href="" class="btn btn-primary">CEK</a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
