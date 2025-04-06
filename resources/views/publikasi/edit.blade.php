@extends('layout.app')
@section('title', 'Edit Artikel')
@section('content')
    {{-- <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.2.0/ckeditor5.css" /> --}}
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    {{-- <link rel="stylesheet" href="../../css/ckeditor5.css"> --}}


    <div class="w-100">
        <div class="modal fade" id="fileSizeModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Peringatan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Ukuran file terlalu besar! Maksimal 2MB.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">

           
            <div class="card-body">
                <!-- Step Indicator -->


                <form id="editorForm" method="POST" action="/publikasi/update/{{ $data->id }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $data->title }}"
                            required>
                    </div>
                    <div class="input-group mb-3">
                        <input type="file" onchange="loadFile(event)"
                            class="form-control @error('thumbnail') is-invalid @enderror" id="thumbnail" name="thumbnail"
                            accept="image/png, image/jpeg, image/jpg">
                        <label class="input-group-text" for="thumbnail">Upload Thumbnails</label>
                        @error('thumbnail')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <div id="editor">
                            {!! $data->content !!}
                        </div>
                    </div>

                    <textarea class="form-control" id="hiddenContent" placeholder="Enter the Description" rows="5" name="content"
                        style="display: none"></textarea>

                    <a href="/publikasi" class="btn btn-secondary me-2">Kembali</a>
                    <button type="submit" class="btn btn-primary">Kirim</button>


                </form>
            </div>
        </div>
    </div>
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script> --}}
    <script src="//cdn.quilljs.com/1.2.2/quill.min.js"></script>
    <script src="/js/image-resize.min.js"></script>

    <script>
        // Inisialisasi Quill
        const quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                imageResize: {
                    displaySize: true
                },
                toolbar: {
                    container: [
                        [{
                            header: [1, 2, false]
                        }],
                        ['bold', 'italic', 'underline'],
                        [{
                            'color': []
                        }, {
                            'background': []
                        }],
                        [{
                            'align': []
                        }],
                        ['image', 'code-block']
                    ],
                    handlers: {
                        image: imageHandler
                    }
                }
            }
        });

        // Handler untuk upload gambar
        function imageHandler() {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/png, image/jpg, image/jpeg');
            input.click();

            input.onchange = () => {
                const file = input.files[0];

                // Validasi ukuran file (opsional)
                if (file.size > 2000000) { // 5MB
                    var modal = new bootstrap.Modal(document.getElementById('fileSizeModal'));
                    modal.show();
                    event.target.value = '';
                    return;
                }

                const reader = new FileReader();

                reader.onload = () => {
                    const range = quill.getSelection(true);
                    quill.insertEmbed(range.index, 'image', reader.result);
                    quill.setSelection(range.index + 1);

                    // Update textarea setiap kali ada perubahan
                    updateTextarea();
                };

                reader.readAsDataURL(file);
            };
        }

        // Fungsi untuk update textarea
        function updateTextarea() {
            const content = quill.root.innerHTML;
            document.getElementById('hiddenContent').value = content;
        }

        // Update textarea setiap kali konten berubah
        quill.on('text-change', function() {
            updateTextarea();
        });

        // Handler untuk form submission
        document.getElementById('editorForm').onsubmit = function(e) {
            // Pastikan textarea terupdate dengan konten terbaru
            updateTextarea();

            // Log konten untuk debugging (opsional)
            console.log('Submitting content:', document.getElementById('hiddenContent').value);

            // Form akan submit secara normal ke backend
            return true;
        };
    </script>
@endsection
