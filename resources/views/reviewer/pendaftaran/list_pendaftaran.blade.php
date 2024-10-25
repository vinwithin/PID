@extends('layout.app')
@section('content')
    <h1 class="h3 mb-3">
        Daftar Pengajuan</h1>
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
                            <td>
                                @foreach ($item->penilaian as $penilaian)
                                    {{ $penilaian->nilai }}
                                    <br>
                                @endforeach
                            </td>
                            <td>
                                {{-- @foreach ($item->penilaian as $penilaian) --}}
                                    @if ($item->penilaian->where('user_id', auth()->user()->id)->isEmpty())
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#staticBackdrop">
                                            Beri Nilai
                                        </button>
                                    
                                        <div class="modal fade" id="staticBackdrop"
                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Beri Nilai
                                                        </h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="/reviewer/nilai/{{ $item->id }}">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="quantity"
                                                                    class="form-label font-weight-bold">Rentang 1 -
                                                                    100:</label>
                                                                <input type="number" id="quantity" name="nilai"
                                                                    min="1" max="100" class="form-control"
                                                                    placeholder="Enter quantity" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                            
                                        @endif

                                {{-- @endforeach --}}

                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
