@extends('layout.guest.index')
@section('content')
    <section class="list-publikasi rounded container-fluid" style="box-shadow: 4px 4px 4px 0px rgba(0, 0, 0, 0.25);">
        <div class="row row-cols-1 row-cols-md-2 g-4 justify-content-center">
            @foreach ($data as $item)
            <div class="col">
                <div class="card h-100">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="{{ asset('/storage/media/thumbnails/' . $item->thumbnail) }}"
                                 class="card-img-top p-2"
                                 alt="Thumbnail"
                                 style="max-width: 100%; height: 150px; object-fit: cover;">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->title }}</h5>
                                <p class="card-text">{!! $item->excerpt !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-4 w-100">
            {{ $data->links() }}
        </div>
        
    </section>
@endsection
