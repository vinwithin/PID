@extends('layout.app')
@section('title', 'Edit Juri Seleksi')
@section('description', 'Kelola Pendaftaran ')
@section('content')
    <div class="w-100 ">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="bg-success-subtle p-3 rounded-4 ">
                                    <h5 class="text-primary mb-3">Detail Tim</h5>
                                    <dl class="row">
                                        <dt class="col-5">Nama Ketua Tim</dt>
                                        <dd class="col-7">{{ $data->nama_ketua }}</dd>

                                        <dt class="col-5">Nama Tim</dt>
                                        <dd class="col-7">{{ $data->judul }}</dd>

                                        <dt class="col-5">Prodi Ketua</dt>
                                        <dd class="col-7">{{ $data->program_studi->nama }}</dd>

                                        <dt class="col-5">Fakultas Ketua</dt>
                                        <dd class="col-7">{{ $data->fakultas->nama }}</dd>

                                        <dt class="col-5">No HP Ketua</dt>
                                        <dd class="col-7">{{ $data->nohp_ketua }}</dd>

                                        <dt class="col-5">Ormawa Ketua</dt>
                                        <dd class="col-7">{{ $data->ormawa->nama }}</dd>

                                        @forelse ($data->reviewAssignments as $item)
                                            <dt class="col-5">Juri {{ $loop->iteration }}</dt>
                                            <dd class="col-7">{{ $item->user->name }}</dd>
                                        @empty
                                            <dt class="col-5">Juri</dt>
                                            <dd class="col-7">Belum ada juri yang ditugaskan</dd>
                                        @endforelse
                                    </dl>
                                </div>
                                <form method="POST" action="/update-reviewer/{{ $data->id }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="reviewer_1" class="form-label fw-bold">Pilih Juri 1</label>
                                        <select class="form-select" name="reviewer_id[]" id="reviewer_1" required>
                                            <option value="{{$data->reviewAssignments[0]->user->id}}" selected>
                                                {{$data->reviewAssignments[0]->user->name}}</option>

                                            @foreach ($reviewer as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label for="reviewer_2" class="form-label fw-bold">Pilih Juri 2</label>
                                        <select class="form-select" name="reviewer_id[]" id="reviewer_2" required>
                                            <option value="{{$data->reviewAssignments[1]->user->id}}" selected>
                                                {{$data->reviewAssignments[1]->user->name}}</option>

                                            @foreach ($reviewer as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <a href="/pendaftaran" class="btn btn-secondary me-2">Kembali</a>
                                    <button type="submit" class="btn btn-primary">Submit</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
