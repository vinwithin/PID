@extends('layout.app')
@section('content')
    <div class="w-100">
        <div class="card">
            <div class="card-header">
                <h3>Pendaftaran</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('mahasiswa.daftarProgram') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="step" id="currentStep" value="1">
                    <div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Ketua Tim</label>
                            <input type="text" class="form-control" id="name" name="nama_ketua" required>
                        </div>
                    </div>
                    <button type="submit" id="submitForm" class="btn btn-success">Submit</button>

                </form>
            </div>
        </div>
    </div>
@endsection
