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
    <title>PRO-IDE</title>
</head>

<body>
    <div class="wrapper">
        {{-- nav --}}
        @include('layout.guest.navbar')


        <section id="hero">
            <div class="hero d-flex align-items-center justify-content-between">
                <div class="content">
                    <h1>Program Inovasi Desa
                    </h1>
                    <h3>Pro IDE adalah kegiatan pembinaan dan pemberdayaan masyarakat yang dilakukan oleh
                        mahasiswa melalui Badan Eksekutif Mahasiswa (BEM), Unit Kegiatan Mahasiswa (UKM),
                        HImpunan Mahasiswa (HIMA), dan Organisasi Kemahasiswaan (OK). </h3>
                    <button>Tentang Kami <i class="fa-solid fa-arrow-right me-2"></i></button>
                </div>

                <div class="il-hero">
                    <img class="il-overlay-img" src="/assets/overlay-img.svg" alt="il-hero">
                    <img class="il-hero-img" src="/assets/il-hero.svg" alt="il-hero">
                </div>
            </div>
        </section>

    </div>

    <section class="announcement" id="announcement">
        <div class="announce">
            <div class="il-announce">
                <img src="/assets/orang.svg" alt="pengumuman">
            </div>
            <div class="content-announce">
                <h1>Pengumuman</h1>
                <div class="event-container">
                    <div class="event-card">
                        <div class="event-icon">
                            <i class="fa-regular fa-calendar-check"></i>
                        </div>
                        <h2>Pendaftaran</h2>
                        <p>Pendaftaran Pro-IDE Tahun 2024</p>
                        <span class="event-date">
                            <i class="fa-regular fa-calendar"></i> 1 - 20 Juni, 2024
                        </span>
                    </div>

                    <div class="event-card">
                        <div class="event-icon">
                            <i class="fa-solid fa-file-circle-check"></i>
                        </div>
                        <h2>Hasil Seleksi</h2>
                        <p>Hasil Seleksi Pro-IDE Tahun 2024</p>
                        <span class="event-date">
                            <i class="fa-regular fa-calendar"></i> 30 Juni, 2024
                        </span>
                    </div>

                    <div class="event-card">
                        <div class="event-icon">
                            <i class="fa-regular fa-file-lines"></i>
                        </div>
                        <h2>Upload Publikasi</h2>
                        <p>Upload Artikel Pro-IDE Tahun 2024</p>
                        <span class="event-date">
                            <i class="fa-regular fa-calendar"></i> 15 - 25 Agustus, 2024
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="publikasi" id="publikasi">
        <img class="overlay-publikasi" src="/assets/overlay-publikasi.svg" alt="">

        <main class="publikasi-content">
            {{-- <div class="container-fluid ">
                <div class="container-box p-4">
                    <h2 class="text-center fw-bold text-dark">PENGUMUMAN</h2>

                    <div class="row mt-4" id="container-card">
                        <!-- Card Pendaftaran -->

                        @if ($announce->isEmpty())
                            <div class="col-md-6">
                                <div class="card p-3" id="card-announce">
                                    <h3 class="card-title" id="card-title">Belum Ada Pengumuman</h3>
                                    <div class="announcement mt-3">

                                    </div>
                                </div>
                            </div>
                        @else
                            @foreach ($announce as $item)
                                <div class="col-md-6">
                                    <div class="card p-3" id="card-announce">
                                        <h3 class="card-title" id="card-title">{{ $item->title }}</h3>
                                        <div class="announcement mt-3">
                                            <p>{{ $item->content }}</p>
                                            <p><i class="fa fa-calendar"></i>
                                                <small>{{ $item->start_date }}</small> -
                                                <small>{{ $item->end_date }}</small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif


                        <!-- Card Hasil Seleksi -->

                    </div>

                </div>
            </div> --}}

            <div class="container-fluid mt-4">
                <div class="container-header">
                    <div class="container-title">
                        <h2 class="text-light fw-bold">Publikasi</h2>
                        <p class="text-light">Artikel Program Pro-IDe</p>
                    </div>
                    <div class="container-button">
                        <div class="circle"></div>
                        <a href="/daftar-publikasi" class="fw-semibold">
                            Selengkapnya <i class="fa-solid fa-arrow-right me-2"></i>
                        </a>
                    </div>
                </div>

                <div class="container-fluid mt-5">
                    <div class="d-flex gap-3 overflow-auto" id="scroll-container">
                        @foreach ($data as $item)
                            <div class="card flex-shrink-0" id="card-list"
                                onclick="window.location='{{ route('daftar-publikasi', $item->slug) }}'"
                                style="cursor: pointer; ">
                                <img src="{{ asset('/storage/media/thumbnails/' . $item->thumbnail) }}"
                                    class="user-image" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">{!! Str::title(Str::limit($item->title, 50)) !!}</h5>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="d-flex gap-4 mt-5 justify-content-center justify-content-md-start">
                    <div class="nav-button" id="left-btn">
                        <i class="fa-solid fa-arrow-left"></i>
                    </div>
                    <div class="nav-button" id="right-btn">
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </div>

            </div>

        </main>
    </section>
    <section class="video ">
        <main>
            <div class="row align-items-center text-center text-md-start justify-content-around">
                <!-- Video Section -->
                <div class="col-12 col-md-8 d-flex flex-column align-items-center">
                    <div class="row g-3 justify-content-center">
                        @foreach ($video as $item)
                            <div class="col-12 col-sm-6 col-md-4 d-flex justify-content-center">
                                <div class="card shadow-sm border-0 w-100" id="card-video">
                                    <div class="video-frame d-flex justify-content-center">
                                        <iframe class="w-100" height="" src="{{ $item->link_youtube }}" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                    </div>
                                    <div class="card-body text-start">
                                        <h6 class="mb-0">Judul</h6>
                                        <p class="text-muted">{{$item->registration}}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            
                <!-- Bagian Deskripsi & Tombol -->
                <div class="col-12 col-md-2 text-center text-md-start d-flex flex-column align-items-center align-items-md-start mt-4 mt-md-0" id="button-video">
                    <h2 class="fw-bold text-dark">Video</h2>
                    <p class="text-dark">Video hasil Program Pro-Ide</p>
                    <a href="/video" class="btn btn-outline-dark">
                        Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            
                <!-- Gambar -->
                <div class="col-12 col-md-1 d-flex justify-content-center justify-content-md-start il-video mt-4 mt-md-0">
                    <img class="il-overlay-video" src="/assets/Blob.svg" alt="il-hero">
                    <img class="il-hero-video" src="/assets/Group.svg" alt="il-hero">
                </div>
            </div>
            
            
        </main>
       
    </section>
    @include('layout.guest.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://kit.fontawesome.com/f10456a175.js" crossorigin="anonymous"></script>

    <script>
        feather.replace();
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".wave").forEach(img => {
                img.setAttribute("draggable", "false"); // Blokir drag
                img.addEventListener("mousedown", (e) => e.preventDefault()); // Blokir pemilihan
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const scrollContainer = document.getElementById('scroll-container');
            const leftButton = document.getElementById('left-btn');
            const rightButton = document.getElementById('right-btn');

            leftButton.addEventListener('click', function() {
                console.log("Left button clicked"); // Debugging
                scrollContainer.scrollBy({
                    left: -300,
                    behavior: 'smooth'
                });
            });

            rightButton.addEventListener('click', function() {
                console.log("Right button clicked"); // Debugging
                scrollContainer.scrollBy({
                    left: 300,
                    behavior: 'smooth'
                });
            });
        });
    </script>

</body>

</html>
