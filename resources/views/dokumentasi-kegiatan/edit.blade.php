@extends('layout.app')
@section('content')
    <div class="w-100">
        <div class="card">

            <div class="card-header">
                <h3>Publikasi Dokumentasi Kegiatan</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="/dokumentasi-kegiatan/update/{{$data->id}}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="link_youtube" class="form-label">Link Tautan Video Youtube</label>
                        <input type="text" class="form-control" id="link_youtube" name="link_youtube" required>
                    </div>
                    <div class="mb-3">
                        <label for="link_social_media" class="form-label">Tautan Sosial Media</label>
                        <input type="text" class="form-control" id="link_social_media" name="link_social_media" required>
                    </div>
                    <div class="mb-3">
                        <label for="link_dokumentasi" class="form-label">Link/tautan Google Drive dokumentasi
                            kegiatan</label>
                        <input type="text" class="form-control" id="link_dokumentasi" name="link_dokumentasi" required>
                    </div>


                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="/dokumentasi-kegiatan" class="btn btn-warning">Kembali</a>

                </form>

            </div>
        </div>
    </div>
@endsection
