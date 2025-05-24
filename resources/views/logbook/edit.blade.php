@extends('layout.app')
@section('title', 'Unggah Log Book')
@section('description', 'Log Book')
@section('content')
    <div class="w-100">
        <div class="card">

            <div class="card-header">
                <h3>Log Book</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="/logbook/update/{{$data->id}}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="date">Tanggal</label>
                        <input type="date" class="form-control @error('date') is-invalid @enderror"
                            id="date" name="date" value="{{ $data->date }}">
                        @error('date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi Kegiatan</label>
                        <textarea 
                          class="form-control rounded-2 shadow-sm @error('description') is-invalid @enderror" 
                          id="description" 
                          name="description" 
                          rows="5" 
                          placeholder="Tulis deskripsi kegiatan harian di sini...">{{$data->description}}</textarea>
                          @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="link_bukti" class="form-label">Link Bukti</label>
                        <input type="text" class="form-control @error('link_bukti') is-invalid @enderror" id="link_bukti" name="link_bukti" value="{{ $data->link_bukti }}" required>
                        @error('link_bukti')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    

                    <a href="/logbook" class="btn btn-secondary me-2">Kembali</a>
                    <button type="submit" class="btn btn-primary">Kirim</button>

                </form>

            </div>
        </div>
    </div>
@endsection
