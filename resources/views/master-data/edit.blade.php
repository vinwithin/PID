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
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                value="{{$data->name}}" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" value="{{$data->email}}"
                                disabled>
                        </div>
        

                        <label for="role" class="form-label">Pilih Role</label>
                        <select class="form-select" name="role" id="role" required>
                            @foreach ($dataRole as $role)
                                <option value="{{ $role->name }}" {{ $data->hasRole($role->name) ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>



                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="/manage-users" class="btn btn-secondary">Kembali</a>

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
