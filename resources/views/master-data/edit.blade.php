@extends('layout.app')
@section('title', 'Edit Data')

@section('content')
    <div class="w-100">
        <div class="card">

            <div class="card-body">
                <form method="POST" action="/manage-users/update/{{ $data->id }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <p>Nama : {{$data->name}}</p>
                        <p>Role : {{$data->getRoleNames()[0]}}</p>
                        <label for="role" class="form-label">Pilih Role</label>
                        <select class="form-select" name="role" id="role" required>
                            @foreach ($dataRole as $role)
                                <option value="{{ $role->name }}" {{ $data->hasRole($role->name) ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>



                    </div>


                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="/manage-users" class="btn btn-warning">Kembali</a>

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
