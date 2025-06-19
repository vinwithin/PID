@extends('layout.app')
@section('title', 'Tambah Pengguna')

@section('content')
    <div class="w-100">
        <div class="card">

            <div class="card-body">
                <form method="POST" action="/manage-users/create" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" placeholder="Masukkan nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="identifier" class="form-label">NIM/NIP</label>
                        <input type="text" class="form-control @error('identifier') is-invalid @enderror" id="identifier"
                            name="identifier" placeholder="Masukkan NIM/NIP" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" placeholder="Masukkan email" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Pilih Role</label>
                        <select class="form-select" name="role" id="role" required>
                            <option value="" selected="selected" hidden="hidden">Pilih Role</option>

                            @foreach ($data as $role)
                                <option value="{{ $role->name }}">
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <input type="text" class="form-control @error('password') is-invalid @enderror" id="password"
                            name="password" placeholder="Masukkan kata sandi" required>
                    </div>


                    <a href="/manage-users" class="btn btn-secondary me-2">Kembali</a>
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
