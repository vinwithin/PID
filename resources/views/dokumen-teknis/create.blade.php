@extends('layout.app')
@section('content')
    <div class="w-100">
        <div class="card">

            <div class="card-header">
                <h3>Publikasi Dokumen Teknis</h3>
            </div>
            <div class="card-body">
                <!-- Step Indicator -->


                <form id="editorForm" method="POST" action="{{ route('dokumen-teknis') }}" enctype="multipart/form-data">
                    @csrf
                    <p>Dokumen Manual/Panduan</p>
                    <div class="input-group mb-3">
                        <input type="file" class="form-control @error('file_manual') is-invalid @enderror"
                            id="file_manual" name="file_manual"
                            accept="application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                        <label class="input-group-text" for="file_manual">Upload File</label>
                        @error('file_manual')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="status_manual" class="form-label">Status Ketercapaian</label>
                        <select class="form-select" name="status_manual" id="status_manual" required>
                            <option value="" selected="selected" hidden="hidden">Pilih Status</option>
                            <option value="Publish">Publish</option>
                            <option value="Draft">Draft</option>
                        </select>
                    </div>
                    <p>Upload bukti ketercapaian seminar atau publikasi artikel</p>
                    <div class="input-group mb-3">
                        <input type="file" class="form-control @error('file_bukti_publikasi') is-invalid @enderror"
                            id="file_bukti_publikasi" name="file_bukti_publikasi"
                            accept="application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                        <label class="input-group-text" for="file_bukti_publikasi">Upload File</label>
                        @error('file_bukti_publikasi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="status_publikasi" class="form-label">Status Ketercapaian Luaran</label>
                        <select class="form-select" name="status_publikasi" id="status_publikasi" required>
                            <option value="" selected="selected" hidden="hidden">Pilih Status</option>
                            <option value="Publish">Publish</option>
                            <option value="Draft">Draft</option>
                            <option value="Draft">Submited</option>
                        </select>
                    </div>
                    <p>Upload Draft proposal PPK Ormawa untuk tahun berikutnya</p>
                    <div class="input-group mb-3">
                        <input type="file" class="form-control @error('file_proposal') is-invalid @enderror"
                            id="file_proposal" name="file_proposal"
                            accept="application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                        <label class="input-group-text" for="file_proposal">Upload File</label>
                        @error('file_proposal')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <p>Upload Dokumen Laporan Keuangan</p>
                    <div class="input-group mb-3">
                        <input type="file" class="form-control @error('file_laporan_keuangan') is-invalid @enderror"
                            id="file_laporan_keuangan" name="file_laporan_keuangan"
                            accept="application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                        <label class="input-group-text" for="file_laporan_keuangan">Upload File</label>
                        @error('file_laporan_keuangan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="/publikasi" class="btn btn-warning">Kembali</a>

                </form>
            </div>
        </div>
    </div>
@endsection
