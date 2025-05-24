@extends('layout.app')
@section('title', 'Edit Data')

@section('content')
    <div class="w-100">
        <div class="card">

            <div class="card-body">
                <form method="POST" action="/manage-users/update/{{ $data->id }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                                value="{{ $data->name }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="identifier" class="form-label">NIM/NIP</label>
                            <input type="text" class="form-control @error('identifier') is-invalid @enderror"
                                id="identifier" name="identifier" value="{{ $data->identifier }}">
                            @error('identifier')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email"
                                value="{{ $data->email }}">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        <label for="role" class="form-label">Pilih Role</label>
                        <select class="form-select" name="role" id="role" name="role" required>
                            @foreach ($dataRole as $role)
                                <option value="{{ $role->name }}" {{ $data->hasRole($role->name) ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>



                    <a href="/manage-users" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Kirim</button>


                </form>



            </div>
        </div>
    </div>
    <script>
        document.getElementById('btnTambahAlbum').addEventListener('click', function() {
            // Tampilkan input album foto
            document.getElementById('inputAlbumContainer').classList.remove('d-none');
            document.getElementById('inputFotoContainer').classList.remove('d-none');
            // this.classList.add('d-none'); // Sembunyikan tombol setelah diklik
        });
    </script>

@endsection
