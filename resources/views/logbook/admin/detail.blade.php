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


                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="">
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th style="width: 10%" class="text-start">Tim</th>
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
                            @role('dosen')
                                <tbody>
                                    @foreach ($data_dospem as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="fw-bold text-start">Tim {{ $item->registration->judul }}</td>
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
                                                    {{ $item->status }}
                                            </td>
                                            <td class="fw-bold text-start">

                                                @if ($item->status === 'Valid')
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        data-bs-toggle="modal" data-bs-target="#rejectModal{{ $item->id }}">
                                                        <i class="fas fa-exclamation-triangle me-1"></i> Tolak
                                                    </button>
                                                    <x-confirm-modal modal-id="rejectModal{{ $item->id }}"
                                                        title="Konfirmasi Persetujuan"
                                                        message="Apakah Anda yakin ingin menolak logbook ini?"
                                                        action-url="/logbook/reject/dospem/{{ $item->id }}"
                                                        confirm-text="Iya" />
                                                @elseif($item->status === 'Ditolak')
                                                    <button type="button" class="btn btn-sm btn-outline-success"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#approveModal{{ $item->id }}">
                                                        <i class="fas fa-check me-1"></i> Terima
                                                    </button>
                                                    <!-- Gunakan komponen modal -->
                                                    <x-confirm-modal modal-id="approveModal{{ $item->id }}"
                                                        title="Konfirmasi Persetujuan"
                                                        message="Apakah Anda yakin ingin menerima logbook ini?"
                                                        action-url="/logbook/approve/dospem/{{ $item->id }}"
                                                        confirm-text="Iya" />
                                                @else
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#rejectModal{{ $item->id }}">
                                                        <i class="fas fa-exclamation-triangle me-1"></i> Tolak
                                                    </button>
                                                    <!-- Gunakan komponen modal -->
                                                    <x-confirm-modal modal-id="rejectModal{{ $item->id }}"
                                                        title="Konfirmasi Persetujuan"
                                                        action-url="/logbook/reject/dospem/{{ $item->id }}"
                                                        message="Apakah Anda yakin ingin menolak logbook ini?"
                                                        confirm-text="Iya" />

                                                    <button type="button" class="btn btn-sm btn-outline-success"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#approveModal{{ $item->id }}">
                                                        <i class="fas fa-check me-1"></i> Terima
                                                    </button>
                                                    <!-- Gunakan komponen modal -->
                                                    <x-confirm-modal modal-id="approveModal{{ $item->id }}"
                                                        title="Konfirmasi Persetujuan"
                                                        message="Apakah Anda yakin ingin menerima logbook ini?"
                                                        action-url="/logbook/approve/dospem/{{ $item->id }}"
                                                        confirm-text="Iya" />
                                                @endif
                                            </td>



                                        </tr>
                                    @endforeach
                                </tbody>
                                @elserole('admin')
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="fw-bold text-start">Tim {{ $item->registration->judul }}</td>
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
                                                    {{ optional($item->logbook_validations)->status ?? '-' }}


                                            </td>

                                            <td class="fw-bold text-start">

                                                @php
                                                    $status = optional($item->logbook_validations)->status;
                                                @endphp

                                                @if ($status === 'Valid')
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#rejectModal{{ $item->id }}">
                                                        <i class="fas fa-exclamation-triangle me-1"></i> Tolak
                                                    </button>
                                                    <x-confirm-modal modal-id="rejectModal{{ $item->id }}"
                                                        title="Konfirmasi Penolakan"
                                                        message="Apakah Anda yakin ingin menolak logbook ini?"
                                                        action-url="/logbook/reject/admin/{{ $item->id }}"
                                                        confirm-text="Iya" />
                                                @elseif ($status === 'Ditolak')
                                                    <button type="button" class="btn btn-sm btn-outline-success"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#approveModal{{ $item->id }}">
                                                        <i class="fas fa-check me-1"></i> Terima
                                                    </button>
                                                    <x-confirm-modal modal-id="approveModal{{ $item->id }}"
                                                        title="Konfirmasi Persetujuan"
                                                        message="Apakah Anda yakin ingin menerima logbook ini?"
                                                        action-url="/logbook/approve/admin/{{ $item->id }}"
                                                        confirm-text="Iya" />
                                                @else
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#rejectModal{{ $item->id }}">
                                                        <i class="fas fa-exclamation-triangle me-1"></i> Tolak
                                                    </button>
                                                    <x-confirm-modal modal-id="rejectModal{{ $item->id }}"
                                                        title="Konfirmasi Penolakan"
                                                        message="Apakah Anda yakin ingin menolak logbook ini?"
                                                        action-url="/logbook/reject/admin/{{ $item->id }}"
                                                        confirm-text="Iya" />

                                                    <button type="button" class="btn btn-sm btn-outline-success"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#approveModal{{ $item->id }}">
                                                        <i class="fas fa-check me-1"></i> Terima
                                                    </button>
                                                    <x-confirm-modal modal-id="approveModal{{ $item->id }}"
                                                        title="Konfirmasi Persetujuan"
                                                        message="Apakah Anda yakin ingin menerima logbook ini?"
                                                        action-url="/logbook/approve/admin/{{ $item->id }}"
                                                        confirm-text="Iya" />
                                                @endif

                                            </td>



                                        </tr>
                                    @endforeach
                                </tbody>
                            @endrole
                        </table>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $data->links() }}
                </div>
                <a href="/logbook" class="btn btn-secondary ml-2">Kembali</a>

            </div>
        </div>
    </div>
@endsection
