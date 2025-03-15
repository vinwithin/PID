@extends('layout.app')
@section('title', 'Tambah Video')
@section('content')
    <div class="w-100">
        <div class="card">

            <div class="card-header">
                <h3>Pengumuman</h3>
            </div>
            <div class="card-body">
                <!-- Step Indicator -->


                <form method="POST" action="{{ route('kelola-konten.video.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="link_youtube" class="form-label">Link Youtube</label>
                        <input type="text" class="form-control" id="link_youtube" name="link_youtube" required>
                        <small class="text-muted">Contoh : https://www.youtube.com/watch?v=xoWqZqJcjOQ </small>

                    </div>


                    
                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="/announcement" class="btn btn-warning">Kembali</a>

                </form>
            </div>
        </div>
    </div>
@endsection
