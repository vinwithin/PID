@extends('layout.app')
@section('title', 'Tambah Pengguna')

@section('content')
    <div class="w-100">
        <div class="card">

            <div class="card-body">
                <form method="POST" action="/manage-users/create" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                            name="nama" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="/manage-users" class="btn btn-secondary">Kembali</a>

                </form>



            </div>
        </div>
    </div>

@endsection
