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
    <title>Document</title>
</head>

<body>
    <div class="wrapper">
        <nav class="navigasi">
            <a href="#home">Logo</a>
            <div class="navbar-extra">
                <a href="#" id="search"><i data-feather="search"></i></a>
                {{-- <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a> --}}
            </div>
        </nav>

        <section class="hero" id="home">
            <main class="content">
                <h1>Pro-IDe Universitas Jambi</h1>
                <h3>Program Inovasi Berbasis</h3>
                <h3>Kearifan Lokal Desa</h3>
                <div>
                    <a href="/login" class="btn btn-primary">Login</a>
                </div>
            </main>
        </section>
    </div>

    <section class="publikasi" id="publikasi">
        <main class="publikasi-content">
           <div class="mb-8">    
            <h1>Pro-IDe</h1>
            <p>Pro IDE adalah kegiatan pembinaan dan pemberdayaan masyarakat yang dilakukan oleh
                mahasiswa melalui Badan Eksekutif Mahasiswa (BEM), Unit Kegiatan Mahasiswa (UKM),
                HImpunan Mahasiswa (HIMA), dan Organisasi Kemahasiswaan (OK). Program yang sangat bermanfaat baik untuk
                memajukan desa dan masyarakatnya, juga di
                desain sebagai bagian dari implementasi Kebijakan Merdeka Belajar Kampus Merdeka (MBKM).
                Mahasiswa yang tergabung dalam ORMAWA memiliki hak mengikuti pembelajaran di luar
                program studinya dapat memanfaatkan program ini, melalui berbagai aktivitas membangun desa
                yang dapat di rekognisi menjadi kegiatan akademik. </p>
            </div>
            <div class="card mt-2">
                <div class="d-flex justify-content-between align-items-baseline px-4 ">
                    <p class="badge text-bg-secondary">Publikasi Kegiatan Pro-Ide</p>
                    <a href="">Lihat Lainnya</a>
                </div>
                <div class="container swiper mt-4">
                    <div class="slider-wrapper">
                        <div class="card-list swiper-wrapper">
                            <div class="card-item swiper-slide">
                                <img src="images/img-1.jpg" alt="User Image" class="user-image">
                                <h2 class="user-name">James Wilson</h2>
                            </div>
                            <div class="card-item swiper-slide">
                                <img src="images/img-1.jpg" alt="User Image" class="user-image">
                                <h2 class="user-name">James Wilson</h2>
                            </div>
                            <div class="card-item swiper-slide">
                                <img src="images/img-1.jpg" alt="User Image" class="user-image">
                                <h2 class="user-name">James Wilson</h2>
                            </div>
                            <div class="card-item swiper-slide">
                                <img src="images/img-1.jpg" alt="User Image" class="user-image">
                                <h2 class="user-name">James Wilson</h2>
                            </div>
                            <div class="card-item swiper-slide">
                                <img src="images/img-1.jpg" alt="User Image" class="user-image">
                                <h2 class="user-name">James Wilson</h2>
                            </div>
                           
                        </div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-slide-button swiper-button-prev"></div>
                        <div class="swiper-slide-button swiper-button-next"></div>
                    </div>
                </div>
            </div>

        </main>

    </section>
    <footer class="bg-secondary p-4">
        <div class="container d-flex justify-content-between">
            <div class="row g-4">
                <div class="col">
                    <img class="img-thumbnail rounded-circle" src="/img/photos/unsplash-1.jpg" alt=""
                        style="width: 15rem; height: 15rem; object-fit: cover;">
                </div>
                <div class="col ">
                    <h3 class="fw-bold border-bottom">Link Utama</h3>
                    <div class="d-flex flex-column mb-3 ">
                        <a href="#" class="text-white py-1">WEB UNJA</a>
                        <a href="#" class="text-white py-1">PORTAL GERBANG UNJA</a>
                        <a href="#" class="text-white py-1">SISTEM INFORMASI AKADEMIK</a>
                        <a href="#" class="text-white py-1">PERPUSTAKAAN</a>
                    </div>


                </div>
                <div class="col">
                    <h3 class="fw-bold border-bottom">Kontak Kami</h3>
                    <div class="d-flex flex-row g-8 ">
                        <p class="text-white mb-0 me-2">Alamat</p>
                        <p class="text-white mb-0">Jl. Raya Jambi - Muara Bulian Km. 15, Mendalo Indah, Jambi Luar
                            Kota,
                            Jambi 36361</p>
                    </div>
                    <div class="d-flex flex-row align-items-center mt-2">
                        <p class="text-white mb-0 me-2">Email</p>
                        <p class="text-white mb-0">lptik@unja.ac.id</p>
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
                    slidesPerView: 4
                }
            }
        });
    </script>
</body>

</html>
