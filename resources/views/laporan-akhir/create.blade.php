@extends('layout.app')
@section('title', 'Publikasi Dokumentasi Publikasi')
@section('description', 'Dokumen Publikasi')
@section('content')
    <div class="w-100">
        <div class="card">

            <div class="card-header">
                <h3>Publikasi Dokumen</h3>
            </div>
            <div class="card-body">
                <form id="editorForm" method="POST" action="{{ route('laporan-akhir') }}" enctype="multipart/form-data">
                    @csrf
                    @foreach ($document_types as $index => $item)
                        {{-- Hidden ID Dokumen --}}
                        <input type="hidden" name="document_id[{{ $index }}]" value="{{ $item->id }}">

                        {{-- Upload File --}}
                        @if ($item->status === 'File & Ketercapaian')
                            <p>{{ $item->name }}</p>

                            <div class="input-group mb-3">
                                <input type="file"
                                    class="form-control @error('file_path.' . $index) is-invalid @enderror"
                                    id="file_path{{ $index }}" name="file_path[{{ $index }}]"
                                    accept="application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                                <label class="input-group-text" for="file_path{{ $index }}">Upload File</label>
                                @error('file_path.' . $index)
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Status Ketercapaian jika status === yes --}}

                            <div class="mb-3">
                                <label for="publish_status{{ $index }}" class="form-label">Status
                                    Ketercapaian</label>
                                <select class="form-select" name="publish_status[{{ $index }}]"
                                    id="publish_status{{ $index }}" required>
                                    <option value="" selected hidden>Pilih Status</option>
                                    <option value="Publish">Publish</option>
                                    <option value="Draft">Draft</option>
                                </select>
                            </div>
                        @elseif($item->status === 'File')
                            <div class="input-group mb-3">
                                <input type="file"
                                    class="form-control @error('file_path.' . $index) is-invalid @enderror"
                                    id="file_path{{ $index }}" name="file_path[{{ $index }}]"
                                    accept="application/pdf, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                                <label class="input-group-text" for="file_path_{{ $index }}">Upload File</label>
                                @error('file_path.' . $index)
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        @elseif($item->status === 'Link')
                            <div class="mb-3">
                                <label for="link{{$index}}" class="form-label">{{ $item->name }}</label>
                                <input type="text" class="form-control" id="link{{$index}}" name="link{{$index}}" required>
                                @if ($item->name === 'Tautan video YouTube')
                                    <small class="text-muted">Contoh : https://www.youtube.com/watch?v=xoWqZqJcjOQ </small>
                                @endif
                            </div>
                        @endif
                    @endforeach
                    <div class="mb-3 d-none" id="inputAlbumContainer">
                        <label for="nama" class="form-label">Nama Album</label>
                        <input type="text" class="form-control" id="nama" name="nama">
                    </div>
                    <div class="mb-3 d-none" id="inputFotoContainer">
                        <label for="album_photos" class="form-label">Unggah Foto Dokumentasi Kegiatan</label>
                        <input type="file" class="form-control" id="album_photos" name="album_photos[]" multiple
                            accept="image/*">
                        <small class="text-muted">Minimal 3 file.
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="/dokumen-teknis" class="btn btn-secondary">Kembali</a>


                </form>


            </div>
        </div>
    </div>
@endsection
