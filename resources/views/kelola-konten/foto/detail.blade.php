@extends('layout.app')

@section('content')
    <div class="container-fluid px-4 py-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h3 class="mb-0 text-light">
                    <i class="fas fa-file-alt me-2"></i>Album
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach ($data as $item)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <img src="/storage/{{ $item->album_photos[0]->path_photos }}" class="card-img-top" alt="{{ $item->nama }}">
                                <div class="card-body">
                                    <h5 class="card-title text-center">{{ $item->nama }}</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection