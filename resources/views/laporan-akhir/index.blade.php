 @extends('layout.app')
 @section('title', 'Nilai Proposal')
 @section('description', 'Kelola Pendaftaran')

 @section('content')
     <div class="w-full container-fluid">
         <div class="row">
             <div class="col-12">
                 <div class="card shadow-sm border-0">
                     <div class="container-fluid px-4 py-4">

                         <div class="card-body p-0">
                             <table class="table table-bordered">
                                 <thead class="bg-dark">
                                     <tr>
                                         <th style="width: 5%" class="text-white">No</th>
                                         <th style="width: 15%" class="text-center text-white">Judul</th>
                                         <th style="width: 15%" class="text-center text-white">Status</th>
                                         <th style="width: 15%" class="text-center text-white">Aksi
                                         </th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @php
                                         $documents = [
                                             'Dokumen manual',
                                             'Draf proposal PPK Ormawa untuk tahun berikutnya',
                                             'Dokumen Laporan Keuangan',
                                         ];
                                     @endphp

                                     @foreach ($data as $index => $item)
                                         <tr>
                                             <td>{{ $index + 1 }}</td>
                                             <td>{{ $documents[$index] }}</td>
                                             <td>{{ $item->status }}</td>
                                         </tr>
                                     @endforeach
                                     {{-- <tr>
                                         <td>{{ $loop->iteration }}</td>
                                         <td class="text-center">
                                             <div class="d-flex justify-content-center align-items-center gap-2">

                                                 <a href="{{ asset('storage/dokumen-publikasi/' . $item->file_artikel) }}"
                                                     class="btn btn-outline-info" target="_blank"><i
                                                         class="fas fa-eye me-1"></i>Lihat
                                                     File</a>
                                                 <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                     title="{{ $item->status_artikel }}">
                                                     <i
                                                         class="fa-solid 
                                                                @switch($item->status_artikel)
                                                                    @case('Publish') fa-circle-check @break
                                                                    @case('Draft') fa-bookmark @break
                                                                    @default fa-question-circle
                                                                @endswitch
                                                        me-2"></i>
                                                 </span>
                                             </div>
                                         </td>
                                         <td class="text-center">
                                             <div class="d-flex justify-content-center align-items-center gap-2">

                                                 <a href="{{ asset('storage/dokumen-publikasi/' . $item->file_haki) }}"
                                                     class="btn btn-outline-info" target="_blank"><i
                                                         class="fas fa-eye me-1"></i>Lihat
                                                     File</a>
                                                 <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                     title="{{ $item->status_haki }}">
                                                     <i
                                                         class="fa-solid 
                                                                @switch($item->status_haki)
                                                                    @case('Publish') fa-circle-check @break
                                                                    @case('Draft') fa-bookmark @break
                                                                    @default fa-question-circle
                                                                @endswitch
                                                        me-2"></i>
                                                 </span>
                                             </div>
                                         </td>
                                         <td class="text-center">
                                             <div class="d-flex justify-content-center align-items-center gap-2">
                                                 <a href="{{ asset('storage/dokumen-publikasi/' . $item->file_bukti_publikasi) }}"
                                                     class="btn btn-sm btn-outline-primary" target="_blank">
                                                     <i class="fas fa-eye me-1"></i> Lihat File
                                                 </a>

                                                 <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                     title="{{ $item->status_publikasi }}">
                                                     <i
                                                         class="fa-solid 
                                                                    @switch($item->status_publikasi)
                                                                        @case('Publish') fa-circle-check @break
                                                                        @case('Draft') fa-bookmark @break
                                                                        @default fa-question-circle
                                                                    @endswitch
                                                            me-2"></i>
                                                 </span>
                                             </div>


                                         </td>
                                         <td class="text-center"><a href="{{ $item->link_artikel }}"
                                                 class="btn btn-outline-info" target="_blank"><i
                                                     class="fas fa-eye me-1"></i>Link
                                                 Artikel</a></td>
                                         <td class="text-center" id="status">
                                             @if ($item && $item->status === 'Ditolak')
                                                 <span class="badge bg-danger" tabindex="0" role="button"
                                                     data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                     style="cursor: pointer">
                                                     Ditolak
                                                     <i class="fas fa-info-circle ms-1 text-white"></i>
                                                 </span>
                                                 <!-- Scrollable modal -->
                                                 <div class="modal fade" id="exampleModal" tabindex="-1"
                                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                     <div class="modal-dialog modal-dialog-scrollable">
                                                         <div class="modal-content">
                                                             <div class="modal-header">
                                                                 <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                                     Komentar
                                                                     Dokumen
                                                                 </h1>
                                                                 <button type="button" class="btn-close"
                                                                     data-bs-dismiss="modal" aria-label="Close"></button>
                                                             </div>
                                                             <div class="modal-body text-start">
                                                                 {{ $item->komentar }}
                                                             </div>
                                                             <div class="modal-footer">
                                                                 <button type="button" class="btn btn-secondary"
                                                                     data-bs-dismiss="modal">Close</button>

                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                             @else
                                                 {{ $item->status }}
                                             @endif
                                         </td>
                                         <td class="text-center">
                                             @if ($item && $item->status === 'Valid')
                                                 Tidak Ada Aksi
                                             @else
                                                 <a href="/dokumen-publikasi/edit/{{ $item->id }}"
                                                     class="btn btn-outline-warning"> <i
                                                         class="fa-solid fa-pen-to-square me-2"></i>Edit</a>
                                             @endif
                                         </td>
                                     </tr> --}}

                                 </tbody>
                             </table>
                             <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel"
                                 aria-hidden="true">
                                 <div class="modal-dialog">
                                     <div class="modal-content">
                                         <div class="modal-header">
                                             <h5 class="modal-title" id="statusModalLabel"><i
                                                     class="fa-solid fa-circle-info me-2"></i>Pemberitahuan</h5>
                                             <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                 aria-label="Close"></button>
                                         </div>
                                         <div class="modal-body">
                                             Dokumen anda ditolak karena belum sesuai.
                                             Klik "i" untuk melihat detail.
                                         </div>
                                         <div class="modal-footer">
                                             <button type="button" class="btn btn-secondary"
                                                 data-bs-dismiss="modal">Tutup</button>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 @endsection
