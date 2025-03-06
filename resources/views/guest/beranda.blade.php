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
                    Himpunan Mahasiswa (HIMA), dan Organisasi Kemahasiswaan (OK). </h3>


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
            </div>


            <div class="container-fluid mt-4">
                <div class="container-title my-5">
                    <h2 class="text-center fw-bold text-dark">PUBLIKASI</h2>
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
            <div class="video-container">
                <div class="row flex-nowrap">
                    @foreach ($video as $item)
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="album-card">
                                <iframe width="397" height="222" src="{{ $item->link_youtube }}" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="more-button my-5">
                <a href="/video">Selengkapnya<i data-feather="arrow-right"></i></a>
            </div>
        </main>
    </section>
    
    <footer class="p-4 d-flex justify-content-center" style="bottom: 0; background: rgba(195, 191, 182, 1);">
        <div class="container my-auto">
            <div class="row row-cols-1 row-cols-md-3  g-4 d-flex justify-content-center">
                <div class="col">
                    <img class=" rounded-circle" src="/assets/footer.png" alt=""
                        style="width: 269px; height: 269px; object-fit: cover;">
                </div>
                <div class="col ">
                    <h3 class="fw-bold border-bottom text-dark border-black py-3">LINK UTAMA</h3>
                    <div class="d-flex flex-column mb-3" id="link-utama">
                        <a href="#" class="text-dark py-1 fs-5 text-decoration-none">WEB UNJA</a>
                        <a href="#" class="text-dark py-1 fs-5 text-decoration-none">PORTAL GERBANG UNJA</a>
                        <a href="#" class="text-dark py-1 fs-5 text-decoration-none">SISTEM INFORMASI AKADEMIK</a>
                        <a href="#" class="text-dark py-1 fs-5 text-decoration-none">PERPUSTAKAAN</a>
                        <a href="#" class="text-dark py-1 fs-5 text-decoration-none">LABORATORIUM</a>
                        <a href="#" class="text-dark py-1 fs-5 text-decoration-none">REPOSITORY</a>
                    </div>
    
    
                </div>
                <div class="col">
                    <h3 class="fw-bold border-bottom border-black text-dark py-3">KONTAK KAMI </h3>
                    <div class="d-flex flex-row g-8 " id="kontak-kami">
                        <p class="text-dark mb-0 me-2 fs-5 text-decoration-none">Alamat</p>
                        <p class="text-dark mb-0 fs-5 text-decoration-none">Jl. Raya Jambi - Muara Bulian Km. 15, Mendalo Indah, Jambi Luar
                            Kota,
                            Jambi 36361</p>
                    </div>
                    <div class="d-flex flex-row align-items-center mt-2" id="kontak-kami">
                        <p class="text-dark mb-0 me-4 fs-5 text-decoration-none">Email</p>
                        <p class="text-dark mb-0 fs-5 text-decoration-none">lptik@unja.ac.id</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        feather.replace();
    </script>
    
</body>

</html>
