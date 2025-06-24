@extends('layout.app')
@section('title', 'Kelola Video')
@section('description', 'Kelola Konten')
@section('content')
    <div class="w-100">
        <div class="card">


            <div class="card-body">
                <!-- Step Indicator -->
                <h1 class="fw-bold mb-3">Video</h1>


                <form method="POST" action="/kelola-konten/video/update/{{ $data->id }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="link_youtube" class="form-label">Link Youtube</label>
                        <input type="text" class="form-control" id="link_youtube" name="link_youtube"
                            value="{{ $data->link_youtube }}" required>
                        <small class="text-muted">Contoh : https://www.youtube.com/watch?v=xoWqZqJcjOQ </small>

                    </div>


                    <a href="/kelola-konten/video" class="btn btn-secondary me-2">Kembali</a>
                    <button type="submit" class="btn btn-primary">Kirim</button>

                </form>
            </div>
        </div>
    </div>
@endsection
