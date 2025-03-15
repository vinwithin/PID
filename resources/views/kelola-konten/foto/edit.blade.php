@extends('layout.app')
@section('title', 'Edit Album')
@section('content')
    <div class="w-100">
        <div class="card">

            <div class="card-body">
                <form method="POST" action="/kelola-konten/foto/update/{{$data->id}}" enctype="multipart/form-data">
                    @csrf
                    <!-- Input file yang tersembunyi secara default -->
                    <div class="mb-3 ">
                        <label for="nama_album" class="form-label">Nama Album</label>
                        <input type="text" class="form-control" id="nama" name="nama_album" value="{{$data->nama}}">
                    </div>
                    <div class="mb-3 ">
                        <label for="album_photos" class="form-label">Unggah Foto Dokumentasi Kegiatan</label>
                        <input type="file" class="form-control" id="album_photos" name="album_photos[]" multiple
                            accept="image/*">
                        <small class="text-muted">Minimal 3 file.
                    </div>

                    <a href="/kelola-konten/foto" class="btn btn-warning">Kembali</a>
                    <button type="submit" class="btn btn-success">Submit</button>

                </form>



            </div>
        </div>
    </div>
    <script></script>

@endsection
