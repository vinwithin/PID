@extends('layout.app')
@section('content')
    <div class="w-full px-4 py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="card-title mb-0 d-flex align-items-center">
                            <i class="fas fa-check-circle me-3"></i>Pilih Juri Monev Kelompok
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="bg-light p-3 rounded">
                                    <h5 class="text-primary mb-3">Detail Tim</h5>
                                    <dl class="row">
                                        <dt class="col-5">Nama Ketua Tim</dt>
                                        <dd class="col-7">{{ $data->nama_ketua }}</dd>

                                        <dt class="col-5">Nama Tim</dt>
                                        <dd class="col-7">{{ $data->nama_tim }}</dd>

                                        <dt class="col-5">Prodi Ketua</dt>
                                        <dd class="col-7">{{ $data->program_studi->nama }}</dd>

                                        <dt class="col-5">Fakultas Ketua</dt>
                                        <dd class="col-7">{{ $data->fakultas->nama }}</dd>

                                        <dt class="col-5">No HP Ketua</dt>
                                        <dd class="col-7">{{ $data->nohp_ketua }}</dd>

                                        <dt class="col-5">Ormawa Ketua</dt>
                                        <dd class="col-7">{{ $data->ormawa->nama }}</dd>
                                    </dl>
                                </div>
                                <form method="POST" action="/monitoring-evaluasi/reviewer-monev/update/{{ $data->id }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="reviewer_id" class="form-label">Pilih Juri</label>
                                        <select class="form-select" name="reviewer_id" id="reviewer_id" required>
                                            @if (!empty($reviewer) && isset($reviewer[0]))
                                                <option value="{{ $reviewer[0]->user_id }}" selected hidden>
                                                    {{ $reviewer[0]->user->name }}
                                                </option>
                                            @endif
                                        
                                            @foreach ($reviewer_monev as $rev)
                                                <option value="{{ $rev->id }}">{{ $rev->name }}</option>
                                            @endforeach
                                        </select>
                                        
                                    </div>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                    <a href="/monitoring-evaluasi" class="btn btn-primary">Kembali</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
