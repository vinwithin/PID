@extends('layout.app')
@section('title', 'Tambah Berita')
@section('content')
    <div class="w-100">
        <div class="card">

            <div class="card-body">
                <!-- Step Indicator -->


                <form method="POST" action="/berita/update/{{$data->id}}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{$data->title}}" required>
                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <div class="form-floating">
                            <textarea class="form-control @error('content') is-invalid @enderror" placeholder="Leave a comment here"
                                id="floatingTextarea2" style="height: 100px" name="content">{{$data->content}}</textarea>
                            <label for="floatingTextarea2">Deskripsi</label>
                            @error('content')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>

                    <!-- Tanggal Mulai -->
                    <p>Unggah Foto</p>
                    <div class="input-group mb-3">
                        <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" id="thumbnail"
                            name="thumbnail" accept="image/png, image/jpeg, image/jpg">
                        <label class="input-group-text" for="thumbnail"></label>
                        @error('thumbnail')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Tanggal Berakhir -->
                   
                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="/berita" class="btn btn-warning">Kembali</a>

                </form>
            </div>
        </div>
    </div>
@endsection
