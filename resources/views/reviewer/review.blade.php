@extends('layout.app')
@section('content')
    <div class="w-100">
        <div class="card">
            <div class="card-header">
                <h3>Penilaian</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="/reviewer/nilai/{{$data->id}}" enctype="multipart/form-data">
                    @csrf
                    <div>
                        @foreach ($penilaian as $item)
                            <div class="mb-3">
                                <p class="fw-bold">{{ $item->nama }}</p>
                                @foreach ($item->sub_kriteria_penilaian as $data)
                                    <label for="{{$data->id}}" class="form-label">{{ $data->nama }}</label>
                                    <input type="text" class="form-control" id="{{$data->id}}" name="nilai[{{$data->id}}]" required>
                                    <br>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>

                </form>
            </div>
        </div>
    </div>
@endsection
