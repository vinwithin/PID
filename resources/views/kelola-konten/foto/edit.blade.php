@extends('layout.app')
@section('title', 'Konten Galeri')
@section('description', 'Kelola Konten')
@section('content')
    <div class="w-100">
        <div class="card">

            <div class="card-body">
                <h1 class="fw-bold mb-3">Galeri</h1>

                <form method="POST" action="/kelola-konten/foto/update/{{ $data->id }}" enctype="multipart/form-data">
                    @csrf
                    <!-- Input file yang tersembunyi secara default -->
                    <div class="mb-3 ">
                        <label for="nama_album" class="form-label">Nama Album</label>
                        <input type="text" class="form-control" id="nama" name="nama_album"
                            value="{{ $data->nama }}">
                    </div>
                    <div class="mb-3 ">
                        <label for="album_photos" class="form-label">Unggah Foto Dokumentasi Kegiatan</label>
                        <input type="file" class="form-control" id="album_photos" name="album_photos[]" multiple
                            accept="image/*">
                        <small class="text-muted">Minimal 3 file.
                    </div>

                    <a href="/kelola-konten/foto" class="btn btn-secondary me-2">Kembali</a>
                    <button type="submit" class="btn btn-primary">Kirim</button>

                </form>



            </div>
        </div>
    </div>
    <script></script>

@endsection
