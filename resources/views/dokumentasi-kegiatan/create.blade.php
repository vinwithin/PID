@extends('layout.app')
@section('content')
    <div class="w-100">
        <div class="card">

            <div class="card-header">
                <h3>Publikasi Dokumentasi Kegiatan</h3>
            </div>
            <div class="card-body">
                @role('admin|reviewer|dosen|super admin')
                    @include('dokumentasi-kegiatan.admin.index')
                    @elserole('mahasiswa')
                    @if (!$dokumenExist)
                        <form method="POST" action="{{ route('dokumentasi-kegiatan') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="link_youtube" class="form-label">Link Tautan Video Youtube</label>
                                <input type="text" class="form-control" id="link_youtube" name="link_youtube" required>
                                <small class="text-muted">Contoh : https://www.youtube.com/watch?v=xoWqZqJcjOQ </small>

                            </div>
                            <div class="mb-3">
                                <label for="link_social_media" class="form-label">Tautan Sosial Media</label>
                                <input type="text" class="form-control" id="link_social_media" name="link_social_media"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="link_dokumentasi" class="form-label">Link/tautan Google Drive dokumentasi
                                    kegiatan</label>
                                <input type="text" class="form-control" id="link_dokumentasi" name="link_dokumentasi"
                                    required>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm mb-3" id="btnTambahAlbum">
                                + Tambah Foto
                            </button><br>

                            <!-- Input file yang tersembunyi secara default -->
                            <div class="mb-3 d-none" id="inputAlbumContainer">
                                <label for="nama_album" class="form-label">Nama Album</label>
                                <input type="text" class="form-control" id="nama" name="nama_album">
                            </div>
                            <div class="mb-3 d-none" id="inputFotoContainer">
                                <label for="album_photos" class="form-label">Unggah Foto Dokumentasi Kegiatan</label>
                                <input type="file" class="form-control" id="album_photos" name="album_photos[]" multiple
                                    accept="image/*">
                                <small class="text-muted">Minimal 3 file.
                            </div>


                            <button type="submit" class="btn btn-success">Submit</button>

                        </form>
                    @else
                        @include('dokumentasi-kegiatan.index')
                    @endif
                @endrole


            </div>
        </div>
    </div>
    <script>
        document.getElementById('btnTambahAlbum').addEventListener('click', function() {
            // Tampilkan input album foto
            document.getElementById('inputAlbumContainer').classList.remove('d-none');
            document.getElementById('inputFotoContainer').classList.remove('d-none');
            // this.classList.add('d-none'); // Sembunyikan tombol setelah diklik
        });
    </script>

@endsection
