@extends('layout.app')
@section('content')
    <h1 class="h3 mb-3"><strong>Admin</strong> Dashboard</h1>
    <div class="w-100">
        <div class="card flex-fill">
            @role('admin')
                <div class="card-header">

                    {{-- <h5 class="card-title mb-0">Latest Projects</h5> --}}
                    <form method="GET" action="{{ route('pendaftaran.search') }}">
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
                            <div class="form-check me-3">
                                <input class="form-check-input" type="checkbox" name="filters[]" value="lolos tahap 3"
                                    id="filterAnalyst1">
                                <label class="form-check-label" for="filterAnalyst1">Lolos Tahap 3</label>
                            </div>
                            <div class="form-check me-3">
                                <input class="form-check-input" type="checkbox" name="filters[]" value="lolos program"
                                    id="filterAnalyst2">
                                <label class="form-check-label" for="filterAnalyst2">Lolos Program</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Terapkan Filter</button>
                    </form>
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
                            <th class="d-none d-md-table-cell">Total Nilai</th>
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
                                    @if (isset($totalId[$item->id]) && is_array($totalId[$item->id]) && count($totalId[$item->id]) > 0)
                                        @foreach ($totalId[$item->id] as $val => $value)
                                            <ul>
                                                <li>{{ $value }} </li>
                                            </ul>
                                        @endforeach
                                    @else
                                        <p class="">Belum Ada Nilai</p>
                                    @endif


                                </td>
                                <td>
                                    @if ($item->registration_validation->status === 'Belum valid')
                                        <a href="{{ route('admin.approve', ['id' => $item->id]) }}"
                                            class="btn btn-success">Setujui</a>
                                    @elseif ($item->registration_validation->status === 'valid')
                                        <a href="" class="btn btn-success">Tahap 3</a>
                                    @endif
                                    @can('assessing proposal')
                                        @if ($item->proposal_score->where('user_id', auth()->user()->id)->isEmpty())
                                            <a href="/reviewer/nilai/{{ $item->id }}" class="btn btn-primary">Beri Nilai</a>
                                        @endif
                                    @endcan

                                    @if (isset($totalId[$item->id]) && is_array($totalId[$item->id]) && count($totalId[$item->id]) > 0)

                                        <a href="/pendaftaran/detail-nilai/{{ $item->id }}" class="btn btn-warning">Cek
                                            Nilai</a>
                                    @endif

                                    <a href="/pendaftaran/detail/{{ $item->id }}" class="btn btn-primary">CEK</a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                @elserole('reviewer')
                <div class="card-header">

                    {{-- <h5 class="card-title mb-0">Latest Projects</h5> --}}
                    <form method="GET" action="{{ route('pendaftaran.search') }}">
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
                            <div class="form-check me-3">
                                <input class="form-check-input" type="checkbox" name="filters[]" value="lolos tahap 3"
                                    id="filterAnalyst1">
                                <label class="form-check-label" for="filterAnalyst1">Lolos Tahap 3</label>
                            </div>
                            <div class="form-check me-3">
                                <input class="form-check-input" type="checkbox" name="filters[]" value="lolos program"
                                    id="filterAnalyst2">
                                <label class="form-check-label" for="filterAnalyst2">Lolos Program</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Terapkan Filter</button>
                    </form>
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
                            <th class="d-none d-md-table-cell">Total Nilai</th>
                            <th class="d-none d-md-table-cell">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataNilai as $item)
                            <tr>
                                <td>{{ $item->nama_ketua }}</td>
                                <td class="d-none d-xl-table-cell">{{ $item->nim_ketua }}</td>
                                <td class="d-none d-xl-table-cell">{{ $item->fakultas_ketua }}</td>
                                <td><span class="badge bg-success">{{ $item->bidang->nama }}</span></td>
                                <td class="d-none d-md-table-cell">{{ $item->judul }}</td>
                                <td class="d-none d-md-table-cell">{{ $item->registration_validation->status }}</td>
                                <td>
                                    @foreach ($totalId[$item->id] as $val => $value)
                                        <ul>
                                            <li>{{ $value }}</li>
                                        </ul>
                                    @endforeach

                                </td>
                                <td>
                                    {{-- <a href="" class="btn btn-warning"></a> --}}
                                    @if ($item->proposal_score->where('user_id', auth()->user()->id)->isEmpty())
                                        <a href="/reviewer/nilai/{{ $item->id }}" class="btn btn-primary">Beri Nilai</a>
                                    @endif

                                    @if (!empty($totalId))
                                        <a href="/pendaftaran/detail-nilai/{{ $item->id }}" class="btn btn-warning">Cek
                                            Nilai</a>
                                    @endif
                                    <a href="/pendaftaran/detail/{{ $item->id }}" class="btn btn-primary">CEK</a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            @endrole

        </div>
    </div>
@endsection
