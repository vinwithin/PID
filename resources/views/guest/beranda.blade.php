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
            <h1>Pro-IDe</h1>
            <p>Pro IDE adalah kegiatan pembinaan dan pemberdayaan masyarakat yang dilakukan oleh
                mahasiswa melalui Badan Eksekutif Mahasiswa (BEM), Unit Kegiatan Mahasiswa (UKM),
                HImpunan Mahasiswa (HIMA), dan Organisasi Kemahasiswaan (OK). Program yang sangat bermanfaat baik untuk
                memajukan desa dan masyarakatnya, juga di
                desain sebagai bagian dari implementasi Kebijakan Merdeka Belajar Kampus Merdeka (MBKM).
                Mahasiswa yang tergabung dalam ORMAWA memiliki hak mengikuti pembelajaran di luar
                program studinya dapat memanfaatkan program ini, melalui berbagai aktivitas membangun desa
                yang dapat di rekognisi menjadi kegiatan akademik. </p>
            <div class="card">
                <div class="d-flex justify-content-between align-items-baseline px-4 ">
                    <p class="badge text-bg-secondary">Publikasi Kegiatan Pro-Ide</p>
                    <a href="">Lihat Lainnya</a>
                </div>

                <div class="row mx-2 pb-4">
                    <div class="col">
                        <div class="card small-card">
                            <img src="..." class="card-img-top small-img" alt="...">
                            <div class="card-body">
                                <h6 class="card-title">Card title</h6>
                                <p class="card-text small-text">This card has supporting text below as a natural lead-in
                                    to additional content.</p>

                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card small-card">
                            <img src="..." class="card-img-top small-img" alt="...">
                            <div class="card-body">
                                <h6 class="card-title">Card title</h6>
                                <p class="card-text small-text">This card has supporting text below as a natural lead-in
                                    to additional content.</p>

                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card small-card">
                            <img src="..." class="card-img-top small-img" alt="...">
                            <div class="card-body">
                                <h6 class="card-title">Card title</h6>
                                <p class="card-text small-text">This card has supporting text below as a natural lead-in
                                    to additional content.</p>

                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card small-card">
                            <img src="..." class="card-img-top small-img" alt="...">
                            <div class="card-body">
                                <h6 class="card-title">Card title</h6>
                                <p class="card-text small-text">This card has supporting text below as a natural lead-in
                                    to additional content.</p>

                            </div>
                        </div>
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
                        <p class="text-white mb-0">Jl. Raya Jambi - Muara Bulian Km. 15, Mendalo Indah, Jambi Luar Kota,
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
</body>

</html>
