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
    <title>PRO-IDE</title>
    <style>
        .navbar-custom {
            background-color: #1c3b2b;

            height: 202px;
            position: relative;
            padding: 1.5rem 6%;
            z-index: 0;
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

        .card-body p {
            font-size: 1rem;
            font-family: "Plus Jakarta Sans", sans-serif;
            font-weight: 400;
            line-height: 120%;
            text-align: justify !important;
        }

        img {
            display: block;
            margin: auto;
            max-width: 85%;
            height: 500px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
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

        @media (max-width: 1366px) {
            html {
                font-size: 75%;
            }

            .card-header h1 {
                font-size: 22px !important;

            }

            .card-body p {
                font-size: 16px;
                font-family: "Plus Jakarta Sans", sans-serif;
                font-weight: 400;
                line-height: 120%;
                text-align: start !important;
            }
        }

        /* Tablet */
        @media (max-width: 758px) {
            html {
                font-size: 62.5%;
            }

            .card-header h1 {
                font-size: 20px !important;

            }

            .card-body p {
                font-size: 14px;
                font-family: "Plus Jakarta Sans", sans-serif;
                font-weight: 400;
                line-height: 120%;
                text-align: start !important;
            }
        }

        /* Mobile Phone */
        @media (max-width: 450px) {
            html {
                font-size: 52%;
            }

            .card-header h1 {
                font-size: 20px !important;

            }

            .card-body p {
                font-size: 14px;
                font-family: "Plus Jakarta Sans", sans-serif;
                font-weight: 400;
                line-height: 120%;
                text-align: start !important;
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
                    <h3 class="fw-bold mb-0">Berita</h3>
                    <p class="mb-0">Berita</p>
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
   
    <section class="container  py-4" style="padding: 1.5rem 6%;">
        <div class="card w-full p-5 shadow" id="card">
            <div class="card-header text-center mb-4 bg-transparent border-0">
                <h1 style="font-family: Plus Jakarta Sans, sans-serif; font-weight:600; font-size:1.5rem;">
                    {{ $data->title }}</h1>
            </div>
            <div class="card-body">
                <div class="image mb-5">
                    <img src="/storage/{{ $data->thumbnail }}" alt="foto berita">

                </div>
                <p class="px-5">
                    {{ $data->content }}
                </p>
            </div>
            @if ($data->updated_at)
                <div class="card-footer bg-light text-muted text-center py-3">
                    <small>
                        <i class="fas fa-clock me-2"></i>
                        Terakhir diperbarui: {{ $data->updated_at->format('d M Y H:i') }}
                    </small>
                </div>
            @endif
        </div>
    </section>
    @include('layout.guest.footer')
    <script>
        feather.replace();
    </script>
</body>

</html>
