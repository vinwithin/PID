@extends('layout.app')
@section('content')
    <div class="w-100">
        <div class="card">

            <div class="card-header">
                <h3>Publikasi Dokumentasi Kegiatan</h3>
            </div>
            <div class="card-body">
                @role('admin')
                    @include('dokumentasi-kegiatan.admin.index')
                @elserole('mahasiswa')
                    @if (!$dokumenExist)
                        <form id="editorForm" method="POST" action="{{ route('dokumentasi-kegiatan') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="link_youtube" class="form-label">Link Tautan Video Youtube</label>
                                <input type="text" class="form-control" id="link_youtube" name="link_youtube" required>
                            </div>
                            <div class="mb-3">
                                <label for="link_social_media" class="form-label">Tautan Sosial Media</label>
                                <input type="text" class="form-control" id="link_social_media" name="link_social_media"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="link_dokumentasi" class="form-label">Link/tautan Google Drive dokumentasi
                                    kegiatan</label>
                                <input type="text" class="form-control" id="link_dokumentasi" name="link_dokumentasi"
                                    required>
                            </div>


                            <button type="submit" class="btn btn-success">Submit</button>

                        </form>
                    @else
                        @include('dokumentasi-kegiatan.index')
                    @endif
                @endrole


            </div>
        </div>
    </div>
@endsection
