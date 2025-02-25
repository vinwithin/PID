<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://unpkg.com/feather-icons"></script>
    {{-- <link rel="stylesheet" href="/css/style.css"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <title>PRO-IDE</title>
    <style>
        .navbar-custom {
            background-color: #1c3b2b;
            padding: 20px 0;
            height: 202px;
            position: relative;
            z-index: -1;
        }

        /* Wave Styling */
        .wave-container {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 80%;
            display: flex;
            justify-content: flex-end;
            /* height: auto; */
            pointer-events: none;
            z-index: -1;
            overflow: hidden;
            /* Mencegah overflow akibat overlap */
        }

        .wave {
            position: relative;

            bottom: 0;
            overflow: hidden;

        }

        .wave-left {
            width: auto;
            height: 182px;
            position: relative;
            margin-right: -55%;
            bottom: -50px;
            z-index: -1;
        }

        .wave-left img {
            bottom: -50px;
        }

        .wave-right {
            right: 0;
            overflow: hidden;
            z-index: 1;
            position: relative;
            width: auto;
            bottom: 0;
            height: 181px;

        }

        .wave-right img {
            bottom: 0;
        }

        /* Search Box Styling */
        .search-container {
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid white;
            border-radius: 20px;
            padding: 5px 15px;
            color: white;
            background: transparent;
        }

        .search-box {
            background: transparent;
            border: none;
            color: white;
            outline: none;
            width: 150px;
        }

        .search-box::placeholder {
            color: white;
            opacity: 0.7;
        }

        #card {
            position: relative;
            margin-top: -70px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                text-align: center;
            }

            .search-container {
                margin-top: 10px;
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<nav class="navbar navbar-expand-lg navbar-custom text-white">
    <div class="container d-flex justify-content-between align-items-center flex-wrap">
        <!-- Tombol Kembali & Judul -->
        <div class="d-flex ">
            <a href="#" class="text-white me-3 fs-4"><i data-feather="arrow-left"></i></a>
            <div>
                <h3 class="fw-bold mb-0">Publikasi</h3>
                <p class="mb-0">Publikasi</p>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="search-container">
            <input type="text" class="search-box" placeholder="Pencarian">
            <span>🔍</span>
        </div>

    </div>

    <!-- Wave Background -->
    <div class="wave-container">
        <div class="wave-left">
            <img class="" src="/assets/Vector 8.svg" alt="Wave Left">
        </div>
        <div class="wave-right">
            <img class="" src="/assets/Vector 8.svg" alt="Wave Right">

        </div>
    </div>
</nav>
<section class="container vh-100  py-4">

    <div class="card w-full p-4 shadow" id="card">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 g-4 justify-content-center">
            @foreach ($data as $item)
                <div class="col">
                    <div class="h-100 ">
                        <div class="row g-0">
                            <div class="col-4">
                                <div class="position-relative overflow-hidden">
                                    <img src="{{ asset('/storage/media/thumbnails/' . $item->thumbnail) }}"
                                        class="card-img-top img-fluid object-fit-cover"
                                        style="height: 119px; width:200px; filter: brightness(0.8);"
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
                                    <h5 class="card-title mb-2" style="font-size: 20px;">{!! Str::limit($item->title, 50) !!}</h5>
                                    {{-- <p class="card-text flex-grow-1 text-muted">
                                        {!! Str::limit($item->excerpt, 82) !!}
                                    </p> --}}
                                    {{-- <div>
                                        <a href="/publikasi/detail/{{ $item->slug }}"
                                            class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-external-link-alt me-2"></i>Baca Selengkapnya
                                        </a>
                                    </div> --}}

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
@include('layout.guest.footer')
<script>
    feather.replace();
</script>
</body>

</html>
