@extends('layout.app')
@section('content')
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.2.0/ckeditor5.css" />

    <div class="w-100">
        <div class="card">

            <div class="card-header">
                <h3>Pendaftaran</h3>
            </div>
            <div class="card-body">
                <!-- Step Indicator -->


                <form id="registrationForm" method="POST" action="{{ route('mahasiswa.publikasi.tambah') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div id="editor">
                        <p>Hello from CKEditor 5!</p>
                    </div>

                    <button type="submit" id="submitForm" class="btn btn-success">Submit</button>

                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
    
    <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ),
            {
                ckfinder:{
                    uploadUrl: "{{ route('upload.image', ['_token' => csrf_token() ]) }}",
                }
            } )
            .catch( error => {
                console.error( error );
            } );
    </script>
    

@endsection
