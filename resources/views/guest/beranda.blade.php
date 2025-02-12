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
        <nav class="navigasi">
            <a class="btn btn-secondary" href="#home">Logo</a>
            <a href="" class="fw-bold">Tentang Kami</a>
            <a href="" class="fw-bold">Publikasi</a>
            <a href="" class="fw-bold">Hubungi Kami</a>
            <div class="navbar-extra">
                <div class="input-group border">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Cari..."
                        name="cari">
                    <div class="input-group-append ">
                        <button class="btn btn-light" type="button">
                            <i data-feather="search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </nav>


        <section class="hero" id="home">
            <main class="content pt-4">
                <h1 style="font-family: Plus Jakarta Sans, sans-serif; font-weight:800; line-height:72px;">Pro-IDe UNJA
                </h1>
                <h3 style="font-family: Plus Jakarta Sans, sans-serif; font-weight:600;">Program Inovasi Berbasis</h3>
                <h3 style="font-family: Plus Jakarta Sans, sans-serif; font-weight:600;">Kearifan Lokal Desa</h3>
                <div class="mt-5">
                    <a href="/login" class="btn btn-success px-5"
                        style="font-family: Plus Jakarta Sans, sans-serif; font-weight:600;">Masuk</a>
                </div>
            </main>
        </section>
    </div>

    <section class="publikasi" id="publikasi">
        <main class="publikasi-content">
            <div class="mb-8">
                <h1 style="font-family: Plus Jakarta Sans, sans-serif; font-weight:800;">Pro-IDe</h1>
                <p style="font-family: Plus Jakarta Sans, sans-serif;">Pro IDE adalah kegiatan pembinaan dan
                    pemberdayaan masyarakat yang dilakukan oleh
                    mahasiswa melalui Badan Eksekutif Mahasiswa (BEM), Unit Kegiatan Mahasiswa (UKM),
                    HImpunan Mahasiswa (HIMA), dan Organisasi Kemahasiswaan (OK). Program yang sangat bermanfaat baik
                    untuk
                    memajukan desa dan masyarakatnya, juga di
                    desain sebagai bagian dari implementasi Kebijakan Merdeka Belajar Kampus Merdeka (MBKM).
                    Mahasiswa yang tergabung dalam ORMAWA memiliki hak mengikuti pembelajaran di luar
                    program studinya dapat memanfaatkan program ini, melalui berbagai aktivitas membangun desa
                    yang dapat di rekognisi menjadi kegiatan akademik. </p>
            </div>
            <div class="card" style="margin-top: 4rem !important;">
                <div class="d-flex justify-content-between align-items-baseline px-4 ">
                    <p class="badge text-bg-secondary">Publikasi Kegiatan Pro-Ide</p>
                    <a href="/daftar-publikasi" class="text-decoration-none text-dark">Lihat Lainnya</a>
                </div>
                <div class="container-fluid swiper mt-4 w-full">
                    <div class="slider-wrapper">
                        <div class="card-list swiper-wrapper">
                            @foreach ($data as $item)
                                <div class="card-item swiper-slide">
                                    <img src="{{ asset('/storage/media/thumbnails/' . $item->thumbnail) }}"
                                        alt="User Image" class="user-image ">
                                    <h2 class="user-name  ">{!! Str::limit($item->title, 50) !!}</h2>
                                    <a class="message-button" href="publikasi/detail/{{ $item->slug }}">Lihat
                                        Selengkapnya</a>

                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-slide-button swiper-button-prev"></div>
                        <div class="swiper-slide-button swiper-button-next"></div>
                    </div>
                </div>
            </div>
        </main>
    </section>
    <section class="video vh-100">
        <main>
            <h1 class="">Galeri Kegiatan Pro-IDe</h1>
            <ul class="nav nav-tabs justify-content-center mt-4" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#foto" role="tab">Foto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#video" role="tab">Video</a>
                </li>
            </ul>

            <div class="tab-content mt-4">
                <div class="tab-pane fade show active" id="foto" role="tabpanel">
                    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
                        <!-- Album Cards -->
                        @foreach ($foto as $item)
                            <div class="col">
                                <div class="album-card">
                                    <img src="/storage/{{$item->album_photos[0]->path_photos}}" alt="">
                                    <div class="album-title text-dark">{{$item->nama}}</div>
                                    <div class="album-date"><i class="bi bi-calendar"></i> 9 Juli 2024</div>
                                </div>
                            </div>
                        @endforeach
                       
                    </div>
                </div>
                <div class="tab-pane fade" id="video" role="tabpanel">
                    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
                        <!-- Video Cards -->
                         @foreach ($video as $item)
                            <div class="col">
                                <div class="album-card">
                                    <iframe width="375" height="220" src="{{ $item->link_youtube }}"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen title="Embedded YouTube Video" class="youtube-embed"
                                        onerror="this.onerror=null;this.src='//www.youtube.com/embed/invalidVideoId';this.outerHTML='<div class=\'text-danger\'>Video tidak tersedia</div>';"></iframe>
                                    <div class="album-title">Nama album</div>
                                    <div class="album-date"><i class="bi bi-calendar"></i> 9 Juli 2024</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </main>
    </section>
    <section class="artikel vh-100">
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
                        <h5 class="card-title">{{$item->judul_artikel}}</h5>
                        <p class="card-text">{{$item->status_artikel}}</p>
                        <a href="#" class="btn btn-outline-primary mt-2">Lihat Selengkapnya</a>
                    </div>
                </div>
                @endforeach
            </div>
        </main>
    </section>
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
