<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="/assets/unja.png">
    <script src="https://unpkg.com/feather-icons"></script>
    {{-- <link rel="stylesheet" href="/css/style.css"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <title>PRO-IDE</title>
    <style>
        .navbar-custom {
            background-color: #1c3b2b;
            /* padding: 20px 0; */
            height: 12.6rem;
            position: relative;
            z-index: 0;
            padding: 1.5rem 6%;

        }

        /* Wave Styling */
        .wave-container {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 90%;
            display: flex;
            justify-content: flex-end;
            /* height: auto; */
            z-index: -1;
            overflow: hidden;
            user-select: none;
            /* Mencegah pemilihan */
            pointer-events: none;
            /* Mencegah overflow akibat overlap */
        }

        .wave {
            position: relative;
            user-select: none;
            /* Mencegah pemilihan */
            pointer-events: none;
            bottom: 0;
            overflow: hidden;
        }

        .wave-left {
            width: auto;
            height: 11rem;
            position: relative;
            overflow: hidden;
            left: 0;
            margin-right: -55%;
            bottom: -40px;
            z-index: -1;
        }

        .wave-left img {
            bottom: -40px;
            width: 1000px;

        }

        .wave-right {
            right: 0;
            /* overflow: hidden; */
            z-index: 1;
            position: relative;
            width: auto;
            bottom: -10px;
            height: 11rem;

        }

        .wave-right img {
            bottom: 0;
            width: 1000px;

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

        #card-title {
            font-size: 1rem;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-weight: 600;
            line-height: 120%;
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

            #card-title {
                font-size: 14px !important;
                font-family: "Plus Jakarta Sans", sans-serif;
                font-weight: 600;
                line-height: 120%;
            }
        }

        @media (max-width: 1366px) {
            html {
                font-size: 75%;
            }

            #card-title {
                font-size: 14px !important;
                font-family: "Plus Jakarta Sans", sans-serif;
                font-weight: 600;
                line-height: 120%;
            }

        }

        @media (max-width: 991.98px) {
            #card-title {
                font-size: 14px !important;
                font-family: "Plus Jakarta Sans", sans-serif;
                font-weight: 600;
                line-height: 120%;
            }
        }

        /* Tablet */
        @media (max-width: 758px) {
            html {
                font-size: 62.5%;
            }

            #card-title {
                font-size: 14px !important;
                font-family: "Plus Jakarta Sans", sans-serif;
                font-weight: 600;
                line-height: 120%;
            }
        }

        /* Mobile Phone */
        @media (max-width: 450px) {
            html {
                font-size: 52%;
            }

            .navbar-custom {
                background-color: #1c3b2b;
                /* padding: 20px 0; */
                height: 182px;
                position: relative;
                z-index: 0;
            }

            #card-title {
                font-size: 12px !important;
                font-family: "Plus Jakarta Sans", sans-serif;
                font-weight: 600;
                line-height: 120%;
            }

        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-custom text-white">
        <div class="container d-flex justify-content-between align-items-center flex-wrap">
            <!-- Tombol Kembali & Judul -->
            <div class="d-flex ">
                <a href="/" class="text-white me-3 fs-4"><i data-feather="arrow-left"></i></a>


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
    
    <section class="container py-4" style="padding: 1.5rem 6%;">
        <div class="card w-full p-5 shadow" id="card">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 g-4 justify-content-center">
                @foreach ($data as $item)
                    <div class="col">
                        <div class="h-100 ">
                            <div class="row g-0"
                                onclick="window.location='{{ route('daftar-publikasi', $item->slug) }}'"
                                style="cursor: pointer;">
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
                                        <h5 class="card-title" id="card-title">{!! Str::title(Str::limit($item->title, 50)) !!}</h5>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-5">
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
