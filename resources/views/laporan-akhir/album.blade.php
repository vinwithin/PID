@extends('layout.app')
@section('title', 'Publikasi Dokumentasi Kegiatan')
@section('description', 'Dokumentasi Kegiatan')
@section('content')
    <div class="w-100">
        <div class="card">

            <div class="card-header">
                <h3>Publikasi Dokumentasi Kegiatan</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('dokumentasi-kegiatan') }}" enctype="multipart/form-data">
                    @csrf
        
                    <!-- Input file yang tersembunyi secara default -->
                    <div class="mb-3 d-none" id="inputAlbumContainer">
                        <label for="nama" class="form-label">Nama Album</label>
                        <input type="text" class="form-control" id="nama" name="nama">
                    </div>
                    <div class="mb-3 d-none" id="inputFotoContainer">
                        <label for="album_photos" class="form-label">Unggah Foto Dokumentasi Kegiatan</label>
                        <input type="file" class="form-control" id="album_photos" name="album_photos[]" multiple
                            accept="image/*">
                        <small class="text-muted">Minimal 3 file.
                    </div>


                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="/dokumentasi-kegiatan" class="btn btn-secondary">Kembali</a>


                </form>



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
