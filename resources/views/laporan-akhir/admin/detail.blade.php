 @extends('layout.app')
 @section('title', 'Laporan Akhir')
 @section('description', 'Dokumen Laporan Akhir')

 @section('content')
     <div class="w-full container-fluid">
         @if (session('success'))
             <x-success-modal :message="session('success')" />
         @endif
         @if (session('error'))
             <x-error-modal :message="session('error')" />
         @endif
         <div class="row">
             <div class="col-12">
                 <div class="card shadow-sm border-0">
                     <div class="container-fluid px-4 py-4">

                         <div class="card-body p-2">

                             <table class="table table-bordered">
                                 <thead class="bg-dark">
                                     <tr>
                                         <th style="width: 5%" class="text-white">No</th>
                                         <th style="width: 45%" class="text-center text-white">Judul</th>
                                         <th style="width: 25%" class="text-center text-white">Status</th>
                                         <th style="width: 25%" class="text-center text-white">Aksi
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

                                     @foreach ($document_types as $item)
                                         @php
                                             $dokumen = $data->firstWhere('document_type_id', $item->id);
                                         @endphp
                                         <tr>
                                             <td>{{ $loop->iteration }}</td>
                                             <td>
                                                 @if ($dokumen)
                                                     @if ($item->status === 'File & Ketercapaian')
                                                         <div class="d-flex justify-content-start gap-2">
                                                             {{ $item->name }}

                                                             @php
                                                                 switch ($dokumen->publish_status) {
                                                                     case 'Publish':
                                                                         $badgeClass = 'badge bg-success';
                                                                         break;
                                                                     case 'Draft':
                                                                         $badgeClass = 'badge bg-warning text-dark';
                                                                         break;
                                                                     default:
                                                                         $badgeClass = 'badge bg-secondary';
                                                                         break;
                                                                 }
                                                             @endphp

                                                             <span class="{{ $badgeClass }}" data-bs-toggle="tooltip"
                                                                 data-bs-placement="top"
                                                                 title="{{ $dokumen->publish_status }}">
                                                                 {{ $dokumen->publish_status }}
                                                             </span>

                                                         </div>
                                                     @else
                                                         {{ $item->name }}
                                                     @endif
                                                 @else
                                                     {{ $item->name }}
                                                 @endif
                                             </td>


                                             <td class="text-center">
                                                 @if ($dokumen)
                                                     @if ($dokumen->status === 'Ditolak')
                                                         <span class="badge bg-danger" tabindex="0" role="button"
                                                             data-bs-toggle="modal"
                                                             data-bs-target="#exampleModal{{ $dokumen->id }}"
                                                             style="cursor: pointer;">
                                                             Ditolak
                                                             <i class="fas fa-info-circle ms-1 text-white"></i>
                                                         </span>


                                                         <!-- Scrollable modal -->
                                                         <div class="modal fade" id="exampleModal{{ $dokumen->id }}"
                                                             tabindex="-1"
                                                             aria-labelledby="exampleModalLabel{{ $dokumen->id }}"
                                                             aria-hidden="true">
                                                             <div class="modal-dialog modal-dialog-scrollable">
                                                                 <div class="modal-content">
                                                                     <div class="modal-header">
                                                                         <h1 class="modal-title fs-5"
                                                                             id="exampleModalLabel{{ $dokumen->id }}">
                                                                             Komentar
                                                                             Dokumen</h1>
                                                                         <button type="button" class="btn-close"
                                                                             data-bs-dismiss="modal"
                                                                             aria-label="Close"></button>
                                                                     </div>
                                                                     <div class="modal-body text-start">
                                                                         {{ $dokumen->komentar }}
                                                                     </div>
                                                                     <div class="modal-footer">
                                                                         <button type="button" class="btn btn-secondary"
                                                                             data-bs-dismiss="modal">Close</button>
                                                                     </div>
                                                                 </div>
                                                             </div>
                                                         </div>
                                                     @else
                                                         @php
                                                             switch ($dokumen->status) {
                                                                 case 'Belum Valid':
                                                                     $badgeClass = 'badge bg-warning';
                                                                     break;
                                                                 case 'Valid':
                                                                     $badgeClass = 'badge bg-success';
                                                                     break;
                                                                 default:
                                                                     $badgeClass = 'badge bg-secondary';
                                                                     break;
                                                             }
                                                         @endphp
                                                         <span class="{{ $badgeClass }}">
                                                             {{ $dokumen->status }}

                                                         </span>
                                                     @endif
                                                 @else
                                                     <span class="badge bg-danger">Belum Upload</span>
                                                 @endif
                                             </td>

                                             <td class="text-center">
                                                 @if ($dokumen)
                                                     @if ($item->status === 'File & Ketercapaian' || $item->status === 'File')
                                                         <a href="/storage/{{ $dokumen->content }}"
                                                             class="btn btn-outline-primary"><i
                                                                 class="fa-solid fa-eye "></i></a>
                                                     @elseif($item->status === 'Link')
                                                         <a href="{{ $dokumen->content }}"
                                                             class="btn btn-outline-primary"><i
                                                                 class="fa-solid fa-eye "></i></a>
                                                     @endif

                                                     @can('approve final report')
                                                         @if ($dokumen->status === 'Ditolak')
                                                             <button type="button" class="btn btn-outline-success"
                                                                 data-bs-toggle="modal"
                                                                 data-bs-target="#approveModal{{ $dokumen->id }}">
                                                                 <i class="fas fa-check"></i> 
                                                             </button>
                                                             <x-confirm-modal modal-id="approveModal{{ $dokumen->id }}"
                                                                 title="Konfirmasi Persetujuan"
                                                                 message="Apakah Anda yakin ingin menerima laporan akhir ini?"
                                                                 action-url="/laporan-akhir/approve/{{ $dokumen->id }}"
                                                                 confirm-text="Ya, Setujui" />
                                                         @elseif($dokumen->status === 'Valid')
                                                         @else
                                                             <button type="button" class="btn btn-outline-success"
                                                                 data-bs-toggle="modal"
                                                                 data-bs-target="#approveModal{{ $dokumen->id }}">
                                                                 <i class="fas fa-check"></i> 
                                                             </button>
                                                             <x-confirm-modal modal-id="approveModal{{ $dokumen->id }}"
                                                                 title="Konfirmasi Persetujuan"
                                                                 message="Apakah Anda yakin ingin menerima laporan akhir ini?"
                                                                 action-url="/laporan-akhir/approve/{{ $dokumen->id }}"
                                                                 confirm-text="Ya, Setujui" />
                                                             <button type="button" class="btn btn-outline-danger"
                                                                 data-bs-toggle="modal"
                                                                 data-bs-target="#rejectModal{{ $dokumen->id }}">
                                                                <i class="fa-solid fa-xmark"></i>
                                                             </button>
                                                             <x-reject-with-comment modal-id="rejectModal{{ $dokumen->id }}"
                                                                 title="Laporan Akhir"
                                                                 action-url="/laporan-akhir/reject/{{ $dokumen->id }}"
                                                                 value="{{ $dokumen->komentar }}" />
                                                         @endif
                                                     @endcan
                                                 @else
                                                     <span class="badge bg-danger">Belum Upload</span>
                                                 @endif

                                             </td>

                                         </tr>
                                     @endforeach
                                     <tr>
                                         <td>11</td>
                                         <td>Album</td>
                                         <td class="text-center">
                                             @if ($data_album->isEmpty())
                                                 <span class="badge bg-danger">Belum Upload</span>
                                             @elseif ($data_album[0]->status === 'Ditolak')
                                                 <span class="badge bg-danger" tabindex="0" role="button"
                                                     data-bs-toggle="modal"
                                                     data-bs-target="#exampleModal{{ $data_album[0]->id }}"
                                                     style="cursor: pointer;">
                                                     Ditolak
                                                     <i class="fas fa-info-circle ms-1 text-white"></i>
                                                 </span>


                                                 <!-- Scrollable modal -->
                                                 <div class="modal fade" id="exampleModal{{ $data_album[0]->id }}"
                                                     tabindex="-1"
                                                     aria-labelledby="exampleModalLabel{{ $data_album[0]->id }}"
                                                     aria-hidden="true">
                                                     <div class="modal-dialog modal-dialog-scrollable">
                                                         <div class="modal-content">
                                                             <div class="modal-header">
                                                                 <h1 class="modal-title fs-5"
                                                                     id="exampleModalLabel{{ $data_album[0]->id }}">
                                                                     Komentar
                                                                     Dokumen</h1>
                                                                 <button type="button" class="btn-close"
                                                                     data-bs-dismiss="modal" aria-label="Close"></button>
                                                             </div>
                                                             <div class="modal-body text-start">
                                                                 {{ $data_album[0]->komentar }}
                                                             </div>
                                                             <div class="modal-footer">
                                                                 <button type="button" class="btn btn-secondary"
                                                                     data-bs-dismiss="modal">Close</button>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                             @else
                                                 @php
                                                     switch ($data_album[0]->status) {
                                                         case 'Belum Valid':
                                                             $badgeClass = 'badge bg-warning';
                                                             break;
                                                         case 'Valid':
                                                             $badgeClass = 'badge bg-success';
                                                             break;
                                                         default:
                                                             $badgeClass = 'badge bg-secondary';
                                                             break;
                                                     }
                                                 @endphp
                                                 <span class="{{ $badgeClass }}">
                                                     {{ $data_album[0]->status }}

                                                 </span>
                                             @endif
                                         </td>
                                         <td class="text-center">
                                             @if ($data_album->isEmpty())
                                                 <span class="badge bg-danger">Belum Upload</span>
                                             @else
                                                 <a href="/laporan-akhir/album/{{ $data_album[0]->id }}"
                                                     class="btn btn-outline-primary"><i
                                                         class="fa-solid fa-eye "></i></a>

                                                 @can('approve final report')
                                                     @if ($data_album[0]->status === 'Ditolak')
                                                         <button type="button" class="btn btn-outline-success"
                                                             data-bs-toggle="modal"
                                                             data-bs-target="#approveModal{{ $data_album[0]->id }}">
                                                             <i class="fas fa-check"></i> 
                                                         </button>
                                                         <x-confirm-modal modal-id="approveModal{{ $data_album[0]->id }}"
                                                             title="Konfirmasi Persetujuan"
                                                             message="Apakah Anda yakin ingin menerima laporan akhir ini?"
                                                             action-url="/laporan-akhir/album/approve/{{ $data_album[0]->id }}"
                                                             confirm-text="Ya, Setujui" />
                                                     @elseif($data_album[0]->status === 'Valid')
                                                     @else
                                                         <button type="button" class="btn btn-outline-success"
                                                             data-bs-toggle="modal"
                                                             data-bs-target="#approveModal{{ $data_album[0]->id }}">
                                                             <i class="fas fa-check"></i> 
                                                         </button>
                                                         <x-confirm-modal modal-id="approveModal{{ $data_album[0]->id }}"
                                                             title="Konfirmasi Persetujuan"
                                                             message="Apakah Anda yakin ingin menerima laporan akhir ini?"
                                                             action-url="/laporan-akhir/album/approve/{{ $data_album[0]->id }}"
                                                             confirm-text="Ya, Setujui" />
                                                         <button type="button" class="btn btn-outline-danger"
                                                             data-bs-toggle="modal"
                                                             data-bs-target="#rejectModal{{ $data_album[0]->id }}">
                                                            <i class="fa-solid fa-xmark"></i>
                                                         </button>
                                                         <x-reject-with-comment modal-id="rejectModal{{ $data_album[0]->id }}"
                                                             title="Laporan Akhir"
                                                             action-url="/laporan-akhir/album/reject/{{ $data_album[0]->id }}"
                                                             value="{{ $data_album[0]->komentar }}" />
                                                     @endif
                                                 @endcan

                                             @endif


                                         </td>
                                     </tr>

                                 </tbody>
                             </table>
                             <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel"
                                 aria-hidden="true">
                                 <div class="modal-dialog">
                                     <div class="modal-content">
                                         <div class="modal-header">
                                             <h5 class="modal-title" id="statusModalLabel"><i
                                                     class="fa-solid fa-circle-info "></i>Pemberitahuan</h5>
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
                             {{-- @endif --}}

                         </div>
                         <a href="/laporan-akhir" class="btn btn-secondary">
                             <i class="fas fa-arrow-left me-2"></i>Kembali
                         </a>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 @endsection
