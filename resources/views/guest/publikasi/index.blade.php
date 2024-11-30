@extends('layout.guest.index')
@section('content')
    <section class="list-publikasi  py-4">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 g-4 justify-content-center">
            @foreach ($data as $item)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="row g-0">
                            <div class="col-4">
                                <img src="{{ asset('/storage/media/thumbnails/' . $item->thumbnail) }}"
                                    class="card-img-top p-2 w-100 h-100 object-fit-cover" alt="{{ $item->title }} Thumbnail">
                            </div>
                            <div class="col-8">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title mb-2">{!! Str::limit($item->title, 50) !!}</h5>
                                    <p class="card-text flex-grow-1 text-muted">
                                        {!! Str::limit($item->excerpt, 82) !!}
                                    </p>
                                    <a href="/publikasi/detail/{{$item->slug}}"
                                        class="btn btn-primary btn-sm align-self-start mt-auto w-25 ">
                                        <i data-feather="external-link" class="me-2"></i>Cek
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $data->links() }}
        </div>
    </section>
@endsection
