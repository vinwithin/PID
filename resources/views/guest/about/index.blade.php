@extends('layout.guest.index')
@section('content')
    <link rel="stylesheet" href="/css/about.css">
    <section id="hero " style=" padding: 1.5rem 8%;">
        <div class="container-fluid d-flex justify-content-center align-items-center hero-wrapper">
            <div class="card d-flex flex-row justify-content-around align-items-center card-about" style="gap: 40px;">
                <div class="d-flex flex-column justify-content-center p-5">
                    <h1>Program Inovasi Desa</h1>
                    <p>“Mengembangkan potensi ORMAWA yang komunikatif, kolaboratif, inovatif dan kritis
                        dalam untuk membangun Desa yang unggul.”</p>
                </div>

                <div class="img-about">
                    <img src="/assets/hero-about-me.svg" alt="">
                </div>
            </div>
        </div>
    </section>
    <section id="about-me" style=" padding: 1.5rem 8%;">
        <div class="container-fluid d-flex flex-column justify-content-center align-items-center">
            <h1 class="text-center" id="text-about">Tentang Kami</h1>
            <div class="card card-aboutme">
                <p>Program Inovasi Desa (Pro-IDe) Universitas Jambi berfokus pada pemberdayaan masyarakat desa
                    melalui keterlibatan aktif mahasiswa. Sebagai respons terhadap tantangan pembangunan masyarakat,
                    Pro-IDe memberikan ruang bagi mahasiswa untuk menerapkan pengetahuan dan keterampilan dalam konteks
                    nyata.
                    Dengan dukungan dari Badan Eksekutif Mahasiswa (BEM) dan organisasi kemahasiswaan lainnya.
                    Program ini mendukung prinsip Merdeka Belajar Kampus Merdeka (MBKM) dalam membekali mahasiswa dengan
                    pengalaman
                    lapangan. program ini bertujuan untuk menciptakan sinergi antara pendidikan dan pengabdian masyarakat,
                    menghasilkan dampak konstruktif bagi keberlanjutan desa.</p>
            </div>
        </div>
    </section>
    <section id="misi-tujuan-section">
        <div class="container-fluid">
            <h1 class="text-center mb-4 " id="misi-tujuan">Misi dan Tujuan</h1>

            <div class="d-flex flex-row justify-content-between align-items-center" id="hero-misi-tujuan"
                style="gap: 80px;">
                <img src="/assets/hero-misi-tujuan.svg" alt="Hero Misi dan Tujuan" style="max-width: 330px; height: auto;">

                <div class="d-flex flex-column" style="gap: 20px;">
                    <div class="card px-4 py-2" style="box-shadow: 10px 40px 50px 0px #038C341A;">
                        <h2 id="misi-title"><i class="fa-regular fa-file-lines me-2"></i>Misi</h2>
                        <ol id="misi">
                            <li>Meningkatkan kapasitas UNJA dalam menguatkan Organisasi Kemahasiswaan.</li>
                            <li>Membangun dan menerapkan karakter positif, empatik, peduli, ulet, kreatif, bertanggung jawab
                                melalui organisasi mahasiswa.</li>
                            <li>Menemukan dan mengembangkan potensi desa untuk pembinaan dan pemberdayaan masyarakat.</li>
                            <li>Membangun kerjasama yang baik antara organisasi mahasiswa, pemerintah daerah, mitra
                                pembangunan desa swasta, dan masyarakat.</li>
                            <li>Membangun kemandirian masyarakat dan keberlanjutan.</li>
                            <li>Mengembangkan kegiatan kemahasiswaan di desa yang dapat dikonversi sebagai mata kuliah.</li>
                        </ol>
                    </div>

                    <div class="card px-4 py-2" style="box-shadow: 10px 40px 50px 0px #038C341A;">
                        <h2 id="tujuan-title"><i class="fa-regular fa-file-circle-check"></i>Tujuan</h2>
                        <ol id="tujuan">
                            <li>Membantu mengatasi permasalahan di desa dengan meningkatkan kesadaran, wawasan,
                                keterampilan, dan inovasi kekinian.</li>
                            <li>Menerapkan konsep pembinaan dan pemberdayaan masyarakat melalui inovasi teknologi secara
                                kolaboratif dan multidisipliner.</li>
                            <li>Membangun kemitraan dengan stakeholder terkait dalam mewujudkan program.</li>
                            <li>Menjadikan lokasi Pro IDE sebagai desa binaan kampus yang berkelanjutan.</li>
                            <li>Meningkatkan Organisasi Kemahasiswaan menjadi organisasi berkarakter Pancasila, berprinsip
                                bela negara, dan sebagai inisiator pembangunan.</li>
                            <li>Menjadi sarana rekomendasi kepada perguruan tinggi untuk mengonversi kegiatan Pro IDE
                                sebagai mata kuliah.</li>
                        </ol>
                    </div>
                </div>

            </div>
        </div>

    </section>
    <section id="panduan-section">
        <div class="container-fluid">
            <div class="overlay-panduan">
                <img src="/assets/circle-about.png" alt="">
            </div>
            <div class="row align-items-center justify-content-center">

                <!-- KIRI: Cards -->
                <div class="col-md-6">
                    <h1 class="text-panduan">Panduan dan Template Laporan</h1>
                    <div class="row row-cols-2 row-cols-md-2 g-4">
                        <div class="col">
                            <div class="card" id="card-panduan">
                                <div class="card-body d-flex justify-content-start align-items-center gap-2">
                                    <div class="icon d-flex justify-content-center align-items-center">
                                        <i class="fa-regular fa-file-lines"></i>
                                    </div>

                                    <a href="/panduan/panduan.pdf" class="card-template">Panduan Pro-IDe</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card" id="card-panduan">
                                <div class="card-body d-flex justify-content-center align-items-center gap-2">
                                    <div class="icon d-flex justify-content-center align-items-center">
                                        <i class="fa-regular fa-file-lines"></i>
                                    </div>
                                    <a class="card-template">Template Laporan Kemajuan</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card" id="card-panduan">
                                <div class="card-body d-flex justify-content-center align-items-center gap-2">
                                    <div class="icon d-flex justify-content-center align-items-center">
                                        <i class="fa-regular fa-file-lines"></i>
                                    </div>
                                    <a class="card-template">Template Laporan Kegiatan</a>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card" id="card-panduan">
                                <div class="card-body d-flex justify-content-center align-items-center gap-2">
                                    <div class="icon d-flex justify-content-center align-items-center">
                                        <i class="fa-regular fa-file-lines"></i>
                                    </div>
                                    <a class="card-template">Template Laporan Keuangan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KANAN: Handphone -->
                <div class="col-md-6 d-flex justify-content-end position-relative">
                    <img src="/assets/element-2.svg" alt="" class="element-panduan">
                    <div class="handphone-container">
                        <img src="/assets/handphone.png" alt="Handphone" class="handphone">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
