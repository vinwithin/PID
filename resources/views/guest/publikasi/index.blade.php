@extends('layout.guest.index')
@section('content')
    <section class="container vh-100  py-4">
        <div class="row">
            <div class="col-12">
                <h1 class="display-6 text-center text-primary mb-3">
                    <i class="fas fa-book-open me-3"></i>Publikasi Terbaru
                </h1>
                <p class="text-center text-muted lead mb-5">
                    Temukan informasi dan artikel terkini dari kami
                </p>
            </div>
        </div>
        <div class="card w-full p-4 shadow">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 g-4 justify-content-center">
                @foreach ($data as $item)
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <div class="row g-0">
                                <div class="col-4">
                                    <div class="position-relative overflow-hidden">
                                        <img src="{{ asset('/storage/media/thumbnails/' . $item->thumbnail) }}"
                                            class="card-img-top img-fluid object-fit-cover"
                                            style="height: 200px; filter: brightness(0.8);"
                                            alt="{{ $item->title }} Thumbnail">
                                        <div class="card-img-overlay d-flex align-items-end p-3">
                                            <span class="badge bg-primary rounded-pill">
                                                <i class="fas fa-calendar-alt me-2"></i>
                                                {{ $item->created_at->format('d M Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title mb-2">{!! Str::limit($item->title, 50) !!}</h5>
                                        <p class="card-text flex-grow-1 text-muted">
                                            {!! Str::limit($item->excerpt, 82) !!}
                                        </p>
                                        <div>
                                            <a href="/publikasi/detail/{{ $item->slug }}"
                                                class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-external-link-alt me-2"></i>Baca Selengkapnya
                                            </a>
                                        </div>

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
        </div>
    </section>
@endsection
