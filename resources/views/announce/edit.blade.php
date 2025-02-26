@extends('layout.app')
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
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{$data->title}}" required>
                    </div>


                    <div class="mb-3">
                        <label for="content" class="form-label fw-bold">Deskripsi</label>
                        <textarea class="form-control" id="content" name="content" rows="5" placeholder="Masukkan deskripsi pengumuman">{{$data->content}}</textarea>
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
                    <div class="mb-3">
                        <label for="status" class="form-label fw-bold">Status:</label>
                        <select id="status" name="status" class="form-control" required>
                            <option value="" selected>Pilih Status</option>
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                          
                        </select>
                    </div>
        

                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="/announcement" class="btn btn-warning">Kembali</a>

                </form>
            </div>
        </div>
    </div>
@endsection
