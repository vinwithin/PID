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
        @can('create logbook')
            <div class="card">
                <div class="container-fluid px-4 ">
                    <div class="card-header d-flex justify-content-between align-items-center">

                        <a class="btn btn-primary" href="{{ route('logbook.tambah') }}"><i
                                class="fa-solid fa-file-circle-plus me-2"></i>Tambah Logbook</a>

                        <form action="{{ route('logbook') }}" method="GET" class="">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Cari.."
                                    value="{{ request('search') }}">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-search"></i> Cari
                                </button>
                                <a href="{{ route('laporan-kemajuan') }}" class="btn btn-success ms-2">Reset</a>

                            </div>
                        </form>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="">
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th style="width: 10%" class="text-start">Tanggal</th>
                                        <th style="width: 30%" class="text-start">Deskripsi Kegiatan
                                        </th>
                                        <th style="width: 15%" class="text-start">Bukti Kegiatan
                                        </th>
                                        <th style="width: 10%" class="text-start">Status
                                        </th>
                                        <th style="width: 10%" class="text-start">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="fw-bold text-start">{{ $item->date }}</td>

                                            <td class="text-start">
                                                {{ $item->description }}
                                            </td>
                                            <td class="fw-bold text-start">
                                                {{ $item->link_bukti }}
                                            </td>
                                            <td class="fw-bold text-start">
                                                <span
                                                    class="badge 
                                                @switch($item->status)
                                                    @case('Menunggu Validasi') bg-warning @break
                                                    @case('Valid') bg-success @break
                                                    @default bg-danger
                                                @endswitch">
                                                    @if (!empty($item->logbook_validations->status))
                                                        {{ $item->logbook_validations->status === 'Valid' ? 'Divalidasi Admin' : 'Ditolak Admin' }}
                                                    @else
                                                        @if ($item->status === 'Valid')
                                                            Divalidasi Dosen Pembimbing
                                                        @elseif($item->status === 'Ditolak')
                                                            Ditolak Dosen Pembimbing
                                                        @else
                                                            {{ $item->status }}
                                                        @endif
                                                    @endif
                                            </td>
                                            <td class="fw-bold
                                                    text-start">
                                                @if (!empty($item->logbook_validations->status))
                                                    @if ($item->logbook_validations->status === 'Valid')
                                                        Tidak Ada Aksi
                                                    @else
                                                        <a href="/logbook/edit/{{ $item->id }}"
                                                            class="btn btn-outline-warning"><i
                                                                class="fa-solid fa-pen me-2"></i>Edit</a>
                                                    @endif
                                                @else
                                                    <a href="/logbook/edit/{{ $item->id }}"
                                                        class="btn btn-outline-warning"><i
                                                            class="fa-solid fa-pen me-2"></i>Edit</a>
                                                @endif
                                            </td>



                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        @elsecan('validate logbook')
            @include('logbook.admin.index')
        @endcan

    </div>
    <script></script>
@endsection
