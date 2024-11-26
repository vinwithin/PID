@extends('layout.app')
@section('content')
    <div class="w-100">
        <div class="card">

            <div class="card-header">
                <h3>Publikasi Dokumen</h3>
            </div>
            <div class="card-body">
                <!-- Step Indicator -->


                <form id="editorForm" method="POST" action="{{ route('publikasi.tambah') }}" enctype="multipart/form-data">
                    @csrf
                    <p>Upload File draf artikel berita media massa</p>
                    <div class="input-group mb-3">
                        <input type="file" class="form-control @error('file_artikel') is-invalid @enderror"
                            id="file_artikel" name="file_artikel"
                            accept="application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                        <label class="input-group-text" for="file_artikel">Upload File</label>
                        @error('file_artikel')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="status_artikel" class="form-label">Status Ketercapaian</label>
                        <select class="form-select" name="status_artikel" id="status_artikel" required>
                            <option value="" selected="selected" hidden="hidden">Pilih Status</option>
                            <option value="Publish">Publish</option>
                            <option value="Draft">Draft</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="link_artikel" class="form-label">Link Artikel</label>
                        <input type="text" class="form-control" id="link_artikel" name="link_artikel" required>
                    </div>
                    <p>Bukti Ketercapaian HAKI (Sertifikat Haki/Draft Pendaftaran HAKI)</p>
                    <div class="input-group mb-3">
                        <input type="file" class="form-control @error('file_haki') is-invalid @enderror"
                            id="file_haki" name="file_haki"
                            accept="application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                        <label class="input-group-text" for="file_haki">Upload File</label>
                        @error('file_haki')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="status_haki" class="form-label">Status Ketercapaian Luaran</label>
                        <select class="form-select" name="status_haki" id="status_haki" required>
                            <option value="" selected="selected" hidden="hidden">Pilih Status</option>
                            <option value="Publish">Terdaftar</option>
                            <option value="Draft">Draft</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="/publikasi" class="btn btn-warning">Kembali</a>

                </form>
            </div>
        </div>
    </div>
@endsection
