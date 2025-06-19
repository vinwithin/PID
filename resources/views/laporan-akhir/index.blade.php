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
                         @role('admin|reviewer|dosen|super admin')
                             @include('laporan-akhir.admin.index')
                             @elserole('mahasiswa')
                             <div class="card-body p-0">

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
                                                        Dokumen Belum Diunggah
                                                     @endif

                                                     {{-- {{ $dokumen->status ?? 'Dokumen Belum Diunggah' }} --}}

                                                 </td>

                                                 <td class="text-center">
                                                     @if ($dokumen)
                                                         @if ($item->status === 'File & Ketercapaian' || $item->status === 'File')
                                                             <a href="/storage/{{ $dokumen->content }}"
                                                                 class="btn btn-outline-primary"><i
                                                                     class="fa-solid fa-eye"></i></a>
                                                         @elseif($item->status === 'Link')
                                                             <a href="{{ $dokumen->content }}"
                                                                 class="btn btn-outline-primary"><i
                                                                     class="fa-solid fa-eye"></i></a>
                                                         @endif
                                                     @endif
                                                     @if ($item->status === 'File & Ketercapaian')
                                                     {{-- {{dd($dataRegist)}} --}}

                                                         @if (isDeadlineActive('Laporan Akhir') && $dataRegist[0]->nim_ketua === auth()->user()->identifier)
                                                             <!-- Tombol dan modal jika status_publish == 'yes' -->
                                                        
                                                             @if ($dokumen)
                                                                 @if ($dokumen->status !== 'Valid')
                                                                     <button type="button" class="btn btn-outline-warning"
                                                                         data-bs-toggle="modal"
                                                                         data-bs-target="#modalFile&Ketercapaian-{{ $item->id }}">
                                                                         <i class="fa-solid fa-pen-to-square"></i>
                                                                     </button>
                                                                 @endif
                                                             @else
                                                                 <button type="button" class="btn btn-outline-success"
                                                                     data-bs-toggle="modal"
                                                                     data-bs-target="#modalFile&Ketercapaian-{{ $item->id }}">
                                                                     <i class="fa-solid fa-upload"></i>
                                                                 </button>
                                                             @endif
                                                         @else
                                                         @endif


                                                         <!-- Modal YES -->
                                                         <div class="modal fade"
                                                             id="modalFile&Ketercapaian-{{ $item->id }}" tabindex="-1"
                                                             aria-labelledby="modalLabelFile&Ketercapaian" aria-hidden="true">
                                                             <div class="modal-dialog modal-lg modal-dialog-centered">
                                                                 <div class="modal-content ">
                                                                     <div class="modal-header">
                                                                         <h5 class="modal-title"
                                                                             id="modalLabelFile&Ketercapaian"><i
                                                                                 class="fa-solid fa-upload me-2"></i>Unggah
                                                                             Dokumen</h5>
                                                                         <button type="button" class="btn-close"
                                                                             data-bs-dismiss="modal"></button>
                                                                     </div>
                                                                     <form
                                                                         action="{{ route('laporan-akhir.file-ketercapaian') }}"
                                                                         method="POST" enctype="multipart/form-data">
                                                                         @csrf
                                                                         <div class="modal-body">

                                                                             <div class="mb-4">
                                                                                 <input type="hidden" name="document_id"
                                                                                     value="{{ $item->id }}">

                                                                                 <label for="file_path"
                                                                                     class="form-label text-dark">Unggah
                                                                                     Dokumen {{ $item->name }}</label>
                                                                                 <input type="file"
                                                                                     class="form-control @error('file_path') is-invalid @enderror"
                                                                                     id="file_path" name="file_path"
                                                                                     accept=".pdf,.doc,.docx" required>
                                                                                 @error('file_path')
                                                                                     <div class="invalid-feedback">
                                                                                         {{ $message }}
                                                                                     </div>
                                                                                 @enderror
                                                                             </div>
                                                                             <div class="mb-4">
                                                                                 <label for="publish_status"
                                                                                     class="form-label">Status
                                                                                     Ketercapaian</label>
                                                                                 <select
                                                                                     class="form-select @error('publish_status') is-invalid @enderror"
                                                                                     name="publish_status" id="publish_status"
                                                                                     required>
                                                                                     <option value=""
                                                                                         selected="selected" hidden="hidden">
                                                                                         Pilih Status</option>
                                                                                     <option value="Publish">Publish</option>
                                                                                     <option value="Draft">Draft</option>
                                                                                 </select>
                                                                                 @error('publish_status')
                                                                                     <div class="invalid-feedback">
                                                                                         {{ $message }}
                                                                                     </div>
                                                                                 @enderror
                                                                             </div>

                                                                             <div class="modal-footer">
                                                                                 <button type="button" class="btn btn-danger"
                                                                                     data-bs-dismiss="modal">Batal</button>
                                                                                 <button type="submit"
                                                                                     class="btn btn-success">Simpan</button>
                                                                             </div>
                                                                     </form>

                                                                 </div>
                                                             </div>
                                                         </div>
                                                     @elseif ($item->status === 'File')
                                                         <!-- Tombol dan modal jika status_publish == 'no' -->
                                                         @if (isDeadlineActive('Laporan Akhir') && $dataRegist[0]->nim_ketua === auth()->user()->identifier)
                                                             @if ($dokumen)
                                                                 @if ($dokumen->status !== 'Valid')
                                                                     <button type="button" class="btn btn-outline-warning"
                                                                         data-bs-toggle="modal"
                                                                         data-bs-target="#modalFile{{ $item->id }}">
                                                                         <i class="fa-solid fa-pen-to-square"></i>
                                                                     </button>
                                                                 @endif
                                                             @else
                                                                 <button type="button" class="btn btn-outline-success"
                                                                     data-bs-toggle="modal"
                                                                     data-bs-target="#modalFile{{ $item->id }}">
                                                                     <i class="fa-solid fa-upload"></i>
                                                                 </button>
                                                             @endif
                                                         @else
                                                         @endif

                                                         <!-- Modal NO -->
                                                         <div class="modal fade" id="modalFile{{ $item->id }}"
                                                             tabindex="-1" aria-labelledby="modalLabelFile"
                                                             aria-hidden="true">
                                                             <div class="modal-dialog modal-lg modal-dialog-centered">
                                                                 <div class="modal-content ">
                                                                     <div class="modal-header">
                                                                         <h5 class="modal-title" id="modalLabelFile"><i
                                                                                 class="fa-solid fa-upload me-2"></i>Unggah
                                                                             Dokumen</h5>
                                                                         <button type="button" class="btn-close"
                                                                             data-bs-dismiss="modal"></button>
                                                                     </div>
                                                                     <form action="{{ route('laporan-akhir.file') }}"
                                                                         method="POST" enctype="multipart/form-data">
                                                                         @csrf
                                                                         <div class="modal-body">

                                                                             <div class="mb-4">
                                                                                 <input type="hidden" name="document_id"
                                                                                     value="{{ $item->id }}">

                                                                                 <label for="file_path"
                                                                                     class="form-label text-dark">Unggah
                                                                                     Dokumen {{ $item->name }}</label>
                                                                                 <input type="file"
                                                                                     class="form-control @error('file_path') is-invalid @enderror"
                                                                                     id="file_path" name="file_path"
                                                                                     accept=".pdf,.doc,.docx" required>
                                                                                 @error('file_path')
                                                                                     <div class="invalid-feedback">
                                                                                         {{ $message }}
                                                                                     </div>
                                                                                 @enderror
                                                                             </div>

                                                                             <div class="modal-footer">
                                                                                 <button type="button" class="btn btn-danger"
                                                                                     data-bs-dismiss="modal">Batal</button>
                                                                                 <button type="submit"
                                                                                     class="btn btn-success">Simpan</button>
                                                                             </div>
                                                                     </form>

                                                                 </div>
                                                             </div>
                                                         </div>
                                                     @elseif ($item->status === 'Link')
                                                         <!-- Tombol dan modal jika status_publish == 'no' -->
                                                         @if (isDeadlineActive('Laporan Akhir') && $dataRegist[0]->nim_ketua === auth()->user()->identifier)
                                                             @if ($dokumen)
                                                                 @if (!$dokumen->status !== 'Valid')
                                                                     <button type="button" class="btn btn-outline-warning"
                                                                         data-bs-toggle="modal"
                                                                         data-bs-target="#modalLink{{ $item->id }}">
                                                                         <i class="fa-solid fa-pen-to-square"></i>
                                                                     </button>
                                                                 @endif
                                                             @else
                                                                 <button type="button" class="btn btn-outline-success"
                                                                     data-bs-toggle="modal"
                                                                     data-bs-target="#modalLink{{ $item->id }}">
                                                                     <i class="fa-solid fa-upload"></i>
                                                                 </button>
                                                             @endif
                                                         @else
                                                         @endif

                                                         <!-- Modal NO -->
                                                         <div class="modal fade" id="modalLink{{ $item->id }}"
                                                             tabindex="-1" aria-labelledby="modalLabelLink"
                                                             aria-hidden="true">
                                                             <div class="modal-dialog modal-lg modal-dialog-centered">
                                                                 <div class="modal-content ">
                                                                     <div class="modal-header">
                                                                         <h5 class="modal-title" id="modalLabelLink"><i
                                                                                 class="fa-solid fa-upload me-2"></i>Unggah
                                                                             Dokumen</h5>
                                                                         <button type="button" class="btn-close"
                                                                             data-bs-dismiss="modal"></button>
                                                                     </div>
                                                                     <form action="{{ route('laporan-akhir.link') }}"
                                                                         method="POST" enctype="multipart/form-data">
                                                                         @csrf
                                                                         <div class="modal-body">

                                                                             <div class="mb-4">
                                                                                 <input type="hidden" name="document_id"
                                                                                     value="{{ $item->id }}">

                                                                                 <label for="link"
                                                                                     class="form-label text-dark">Unggah
                                                                                     {{ $item->name }}</label>
                                                                                 <input type="text"
                                                                                     class="form-control @error('link') is-invalid @enderror"
                                                                                     id="link" name="link" required>
                                                                                 @error('link')
                                                                                     <div class="invalid-feedback">
                                                                                         {{ $message }}
                                                                                     </div>
                                                                                 @enderror
                                                                             </div>


                                                                             <div class="modal-footer">
                                                                                 <button type="button" class="btn btn-danger"
                                                                                     data-bs-dismiss="modal">Batal</button>
                                                                                 <button type="submit"
                                                                                     class="btn btn-success">Simpan</button>
                                                                             </div>
                                                                     </form>

                                                                 </div>
                                                             </div>
                                                         </div>
                                                     @endif
                                                 </td>

                                             </tr>
                                         @endforeach
                                         <tr>
                                             <td>11</td>
                                             <td>Album</td>
                                             <td class="text-center">
                                                 @if ($data_album->isEmpty())
                                                     Dokumen Belum Diunggah
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
                                                     @if (isDeadlineActive('Laporan Akhir') && $dataRegist[0]->nim_ketua === Auth()->user()->identifier)
                                                         <button type="button" class="btn btn-outline-success"
                                                             data-bs-toggle="modal" data-bs-target="#modalAlbum">
                                                             <i class="fa-solid fa-upload"></i>
                                                         </button>
                                                         <div class="modal fade" id="modalAlbum" tabindex="-1"
                                                             aria-labelledby="modalLabelAlbum" aria-hidden="true">
                                                             <div
                                                                 class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                                                 <div class="modal-content ">
                                                                     <div class="modal-header">
                                                                         <h5 class="modal-title" id="modalLabelAlbum"><i
                                                                                 class="fa-solid fa-upload me-2"></i>Unggah
                                                                             Dokumen</h5>
                                                                         <button type="button" class="btn-close"
                                                                             data-bs-dismiss="modal"></button>
                                                                     </div>
                                                                     <form action="{{ route('laporan-akhir.album') }}"
                                                                         method="POST" enctype="multipart/form-data">
                                                                         @csrf
                                                                         <div class="modal-body">

                                                                             <div class="mb-4">
                                                                                 <label for="nama"
                                                                                     class="form-label text-center">Nama
                                                                                     Album</label>
                                                                                 <input type="text" class="form-control"
                                                                                     id="nama" name="nama">
                                                                             </div>
                                                                             <div class="mb-4">
                                                                                 <label for="album_photos"
                                                                                     class="form-label">Unggah Foto
                                                                                     Dokumentasi Kegiatan</label>
                                                                                 <input type="file" class="form-control"
                                                                                     id="album_photos" name="album_photos[]"
                                                                                     multiple accept="image/*">
                                                                                 <small class="text-muted">Minimal 3 file.
                                                                             </div>
                                                                         </div>
                                                                         <div class="modal-footer">
                                                                             <button type="button" class="btn btn-secondary"
                                                                                 data-bs-dismiss="modal">Batal</button>
                                                                             <button type="submit"
                                                                                 class="btn btn-primary">Simpan</button>
                                                                         </div>
                                                                     </form>

                                                                 </div>
                                                             </div>
                                                         </div>
                                                     @endif
                                                 @elseif($data_album[0]->status === 'Valid')
                                                     <a href="/laporan-akhir/album/{{ $data_album[0]->id }}"
                                                         class="btn btn-outline-primary"><i class="fa-solid fa-eye"></i></a>
                                                 @else
                                                     <a href="/laporan-akhir/album/{{ $data_album[0]->id }}"
                                                         class="btn btn-outline-primary"><i class="fa-solid fa-eye"></i></a>
                                                     @if (isDeadlineActive('Laporan Akhir') && $dataRegist[0]->nim_ketua === Auth()->user()->identifier)
                                                         <button type="button" class="btn btn-outline-warning"
                                                             data-bs-toggle="modal" data-bs-target="#modalAlbum">
                                                             <i class="fa-solid fa-upload"></i>
                                                         </button>
                                                         <div class="modal fade" id="modalAlbum" tabindex="-1"
                                                             aria-labelledby="modalLabelAlbum" aria-hidden="true">
                                                             <div
                                                                 class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                                                 <div class="modal-content ">
                                                                     <div class="modal-header">
                                                                         <h5 class="modal-title" id="modalLabelAlbum"><i
                                                                                 class="fa-solid fa-upload me-2"></i>Unggah
                                                                             Dokumen</h5>
                                                                         <button type="button" class="btn-close"
                                                                             data-bs-dismiss="modal"></button>
                                                                     </div>
                                                                     <form action="{{ route('laporan-akhir.album') }}"
                                                                         method="POST" enctype="multipart/form-data">
                                                                         @csrf
                                                                         <div class="modal-body">

                                                                             <div class="mb-4">
                                                                                 <label for="nama" class="form-label">Nama
                                                                                     Album</label>
                                                                                 <input type="text" class="form-control"
                                                                                     id="nama" name="nama">
                                                                             </div>
                                                                             <div class="mb-4">
                                                                                 <label for="album_photos"
                                                                                     class="form-label">Unggah Foto
                                                                                     Dokumentasi Kegiatan</label>
                                                                                 <input type="file" class="form-control"
                                                                                     id="album_photos" name="album_photos[]"
                                                                                     multiple accept="image/*">
                                                                                 <small class="text-muted text-start">Minimal 3
                                                                                     file.
                                                                             </div>
                                                                         </div>
                                                                         <div class="modal-footer">
                                                                             <button type="button" class="btn btn-secondary"
                                                                                 data-bs-dismiss="modal">Batal</button>
                                                                             <button type="submit"
                                                                                 class="btn btn-primary">Simpan</button>
                                                                         </div>
                                                                     </form>

                                                                 </div>
                                                             </div>
                                                         </div>
                                                     @endif
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
                                 {{-- @endif --}}

                             </div>
                         @endrole
                     </div>
                 </div>
             </div>
         </div>
     </div>
 @endsection
