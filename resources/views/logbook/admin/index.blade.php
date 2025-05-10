@extends('layout.app')
@section('title', 'Daftar Log Book')
@section('description', 'Log Book')
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
                <div class="card-header d-flex justify-content-end align-items-end">

                    <form action="{{ route('logbook') }}" method="GET" class="">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari.."
                                value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-search"></i> Cari
                            </button>
                            <a href="{{ route('logbook') }}" class="btn btn-success ms-2">Reset</a>

                        </div>
                    </form>
                </div>
                @role('admin')
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
                                                <a href="/logbook/detail/{{ $item->team_id }}" class="btn btn-outline-success">
                                                    <i class="fa-solid fa-eye me-2"></i>Detail</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                <i class="fa-solid fa-circle-exclamation me-2"></i>Data logbook belum tersedia.
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
                @elserole('dosen')
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
                                    @forelse ($dataDospem as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="fw-bold text-start">{{ $item->registration->judul }}</td>
                                            <td class="text-start">{{ $item->registration->nama_ketua }}</td>
                                            <td class="fw-bold text-start">{{ $item->registration->dospem->name }}</td>
                                            <td class="fw-bold text-start">
                                                <a href="/logbook/detail/{{ $item->team_id }}" class="btn btn-outline-success">
                                                    <i class="fa-solid fa-eye me-2"></i>Detail</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                <i class="fa-solid fa-circle-exclamation me-2"></i>Data logbook belum tersedia.
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
                @endrole
            </div>
        </div>
    </div>
@endsection
