@extends('layout.app')
@section('title', 'Pengaturan Pengguna')
@section('description', 'Pengaturan ')

@section('content')
    <style>
        dt {
            font-size: 18px;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-weight: 400;
            line-height: 120%;
        }

        dd {
            font-size: 18px;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-weight: 400;
            line-height: 120%;
        }
    </style>
    <div class="w-100">
        <div class="card flex-fill">
            <div class="card shadow-sm p-4">
                <div class="row ">
                    <div class="col-md-2 d-flex flex-column align-items-end">
                        <div class="d-flex flex-column  align-items-center">
                            <img src="{{ Auth::user()->foto_profil ? asset('storage/' . Auth::user()->foto_profil) : asset('assets/profil.svg') }}"
                                class="rounded  mb-2" alt="Foto Profil" style="width: 150px; height:150px;">
                            <!-- Tombol Ganti Foto -->
                            <button type="button" class="btn btn-xl btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalGantiFoto">
                                Ganti Foto
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="modalGantiFoto" tabindex="-1" aria-labelledby="modalGantiFotoLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <form action="{{ route('update.foto') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalGantiFotoLabel">Ganti Foto Profil</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Tutup"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <!-- Preview -->
                                                <img id="modalPreviewFoto"
                                                    src="{{ asset(Auth::user()->foto_profil ? 'storage/' . Auth::user()->foto_profil : 'assets/profil.svg') }}"
                                                    class="rounded mb-2" alt="Preview Foto"
                                                    style="width: 150px; height: 150px; object-fit: cover;">

                                                <!-- Input File -->
                                                <input type="file" name="foto_profil" accept="image/*"
                                                    class="form-control" onchange="previewModalGambar(this)" required>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Unggah</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>



                    </div>

                    <div class="col-md-9 mt-3 ">
                        <dl class="row">
                            <dt class="col-3 text-dark mb-3"><i class="fa-solid fa-address-book"></i>
                                {{ !Auth::user()->hasRole('mahasiswa') ? 'NIP' : 'NIM' }} </dt>

                            <dd class="col-7 text-dark mb-3">: {{ $data[0]->identifier }}</dd>

                            <dt class="col-3 text-dark mb-3"><i class="fa-solid fa-user"></i>
                                {{ !Auth::user()->hasRole('mahasiswa') ? 'Nama' : 'Nama Mahasiswa' }} </dt>

                            <dd class="col-7 text-dark mb-3">: {{ $data[0]->name }}</dd>

                            <dt class="col-3 text-dark mb-3"><i class="fa-solid fa-envelope"></i> Email</dt>

                            <dd class="col-7 text-dark mb-3">: {{ $data[0]->email }}</dd>
                        </dl>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        function previewModalGambar(input) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('modalPreviewFoto').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
