@extends('layout.app')
@section('title', 'Edit Pengumuman')
@section('content')
    <div class="w-100">
        <div class="card">

            <div class="card-header">
                <h3>Pengumuman</h3>
            </div>
            <div class="card-body">
                <!-- Step Indicator -->


                <form method="POST" action="/announcement/update/{{$data->id}}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="category" class="form-label">Kategori</label>
                        <input type="text" class="form-control" id="category" name="category" value="{{$data->category}}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{$data->title}}" required>
                    </div>

                    <!-- Tanggal Mulai -->
                    <div class="mb-3">
                        <label for="start_date" class="form-label fw-bold">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{$data->start_date}}" required>
                    </div>

                    <!-- Tanggal Berakhir -->
                    <div class="mb-3">
                        <label for="end_date" class="form-label fw-bold">Tanggal Berakhir</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{$data->end_date}}">
                    </div>
            
        

                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="/announcement" class="btn btn-warning">Kembali</a>

                </form>
            </div>
        </div>
    </div>
@endsection
