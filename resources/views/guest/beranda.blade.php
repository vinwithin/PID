<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <title>Document</title>
</head>

<body>
    <div class="wrapper">
        {{-- nav --}}
        @include('layout.guest.navbar')


        <section class="hero" id="home">
            <main class="content pt-4">
                <h1 style="font-family: Plus Jakarta Sans, sans-serif; font-weight:800;">PRO-IDE
                </h1>
                <h3 style="font-family: Plus Jakarta Sans, sans-serif; font-weight:600;">Pro IDE adalah kegiatan
                    pembinaan dan pemberdayaan masyarakat yang dilakukan oleh
                    mahasiswa melalui Badan Eksekutif Mahasiswa (BEM), Unit Kegiatan Mahasiswa (UKM),
                    HImpunan Mahasiswa (HIMA), dan Organisasi Kemahasiswaan (OK). </h3>


            </main>

        </section>
        <div class="wave-container">
            <img class="wave right" src="/assets/wave.svg" alt="Wave Right">
            <img class="wave left" src="/assets/wave.svg" alt="Wave Left">

        </div>
    </div>

    <section class="publikasi" id="publikasi">

        <main class="publikasi-content">
            <div class="container-fluid ">
                <div class="container-box p-4">
                    <h2 class="text-center fw-bold text-success">PENGUMUMAN</h2>

                    <div class="row mt-4" id="container-card">
                        <!-- Card Pendaftaran -->
                        <div class="col-md-6">
                            <div class="card p-3" id="card-announce">
                                <h3 class="card-title" id="card-title">Pendaftaran</h3>
                                <div class="announcement mt-3">
                                    <p><i class="fa fa-calendar"></i> Pendaftaran Pro-IDE Tahun 2023 - <small>Juni,
                                            2023</small></p>
                                    <p><i class="fa fa-calendar"></i> Pendaftaran Pro-IDE Tahun 2024 - <small>Juni,
                                            2024</small></p>
                                </div>
                            </div>
                        </div>

                        <!-- Card Hasil Seleksi -->
                        <div class="col-md-6">
                            <div class="card p-3" id="card-announce">
                                <h3 class="card-title" id="card-title">Hasil Seleksi</h3>
                                <div class="announcement mt-3">
                                    <p><i class="fa fa-calendar"></i> Hasil Seleksi Pro-IDE Tahun 2023 - <small>Juni,
                                            2023</small></p>
                                    <p><i class="fa fa-calendar"></i> Hasil Seleksi Pro-IDE Tahun 2024 - <small>Juni,
                                            2024</small></p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <div class="container-fluid mt-4">
                <div class="container-title my-5">
                    <h2 class="text-center fw-bold text-success">PUBLIKASI</h2>
                </div>
                <div class="row row-cols-1 row-cols-md-4 row-gap-5  g-2">
                    @foreach ($data as $item)
                        <div class="col" id="card-list">
                            <div class="card" id="card-item">
                                <img src="{{ asset('/storage/media/thumbnails/' . $item->thumbnail) }}"
                                    class="user-image" alt="...">
                                <div class="card-body" id="card-name">
                                    <h5 class="card-title">{!! Str::limit($item->title, 50) !!}</h5>

                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

            </div>
            <div class="more-button my-5">
                <a href="/daftar-publikasi">Selengkapnya<i data-feather="arrow-right"></i></a>
            </div>
        </main>
    </section>
    <section class="video ">
        <main>
            <h1 class="text-dark text-center fw-bold text-success mb-5">VIDEO</h1>
            <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
                <!-- Video Cards -->
                @foreach ($video as $item)
                    <div class="col">
                        <div class="album-card">
                            <iframe width="397" height="222" src="{{ $item->link_youtube }}" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen title="Embedded YouTube Video" class="youtube-embed"
                                onerror="this.onerror=null;this.src='//www.youtube.com/embed/invalidVideoId';this.outerHTML='<div class=\'text-danger\'>Video tidak tersedia</div>';"></iframe>

                        </div>
                    </div>
                @endforeach
            </div>
            <div class="more-button my-5">
                <a href="">Selengkapnya<i data-feather="arrow-right"></i></a>
            </div>
        </main>
    </section>
    {{-- <section class="artikel vh-100">
        <main class="">
            <h1 class="mb-5">Artikel Kegiatan Pro-IDe</h1>
            <div class="row row-cols-1 row-cols-md-4 g-4">

                <!-- Card 1 -->
                @foreach ($artikel as $item)
                    <div class="col">
                        <div class="card p-4">
                            <div class="icon-wrapper">
                                <i class="align-middle" data-feather="book"></i>
                            </div>
                            <h5 class="card-title">{{ $item->judul_artikel }}</h5>
                            <p class="card-text">{{ $item->status_artikel }}</p>
                            <a href="#" class="btn btn-outline-primary mt-2">Lihat Selengkapnya</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </main>
    </section> --}}
    {{-- footer --}}
    @include('layout.guest.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        feather.replace();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.slider-wrapper', {
            loop: true,
            grabCursor: true,
            spaceBetween: 30,
            // Pagination bullets
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                dynamicBullets: true
            },
            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            // Responsive breakpoints
            breakpoints: {
                0: {
                    slidesPerView: 1
                },
                768: {
                    slidesPerView: 2
                },
                1024: {
                    slidesPerView: 3
                },
                1336: {
                    slidesPerView: 5
                }
            }
        });
    </script>
</body>

</html>
