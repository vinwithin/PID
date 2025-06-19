@extends('layout.app')
@section('title', 'Laporan Akhir')
@section('description', 'Dokumen Laporan Akhir')
@section('content')
    <div class="w-100">
        @if (session('success'))
            <x-success-modal :message="session('success')" />
        @endif
        @if (session('error'))
            <x-error-modal :message="session('error')" />
        @endif
        <div class="card">

            <div class="container-fluid px-4 ">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="text-end">
                        <button class="btn btn-dark" type="button" data-bs-toggle="collapse" data-bs-target="#filterSection"
                            aria-expanded="false" aria-controls="filterSection">
                            <i class="fas fa-filter me-2"></i>Filter
                        </button>
                    </div>
                    <form action="{{ route('laporan-akhir') }}" method="GET" class="">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari.."
                                value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-search"></i> Cari
                            </button>
                            <a href="{{ route('laporan-akhir') }}" class="btn btn-primary ms-2">Atur Ulang</a>

                        </div>
                    </form>
                </div>
                <div class="collapse mt-3" id="filterSection">
                    <div class="card card-body border shadow-sm">
                        <form method="GET" action="{{ route('laporan-akhir') }}">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-4">
                                    <label for="tahun" class="form-label text-dark fw-semibold">Tahun
                                        Pendaftaran:</label>
                                    <select name="tahun" id="tahun" class="form-select">
                                        <option value="">Semua Tahun</option>
                                        @foreach (range(date('Y'), 2020) as $year)
                                            <option value="{{ $year }}"
                                                {{ request('tahun') == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-dark ">
                                        <i class="fas fa-filter me-1"></i> Terapkan Filter
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="">
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th style="width: 15%" class="text-start">Tim</th>
                                    <th style="width: 15%" class="text-start">Nama Ketua
                                    </th>
                                    <th style="width: 15%" class="text-start">Dosen Pembimbing
                                    </th>

                                    <th style="width: 15%" class="text-start">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dataAdmin as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="fw-bold text-start">{{ $item->registration->judul }}</td>
                                        <td class="text-start">{{ $item->registration->nama_ketua }}</td>
                                        <td class="fw-bold text-start">{{ $item->registration->dospem->name }}</td>
                                        <td class="fw-bold text-start">
                                            <a href="/laporan-akhir/detail/{{ $item->team_id }}"
                                                class="btn btn-outline-success">
                                                <i class="fa-solid fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="fa-solid fa-circle-exclamation me-2"></i>Data laporan akhir belum
                                            tersedia.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $dataAdmin->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection
