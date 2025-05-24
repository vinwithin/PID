@extends('layout.app')

@section('title', 'Album')
@section('content')
    <div class="w-full">

        <div class="container-fluid px-4 py-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="row">
                        @foreach ($data as $item)
                            @foreach ($item->album_photos as $items)
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100 shadow-sm">
                                        <img src="/storage/{{ $items->path_photos }}" class="card-img-top"
                                            alt="{{ $item->nama }}">

                                        <div class="card-body">
                                            <h5 class="card-title text-center">{{ $item->nama }}</h5>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                    <a href="/laporan-akhir" class="btn btn-warning">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection
