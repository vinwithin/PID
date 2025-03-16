<style>
    footer {
        position: relative;
        z-index: 9999;
    }

    @media (max-width: 991.98px) {
        #image {
            width: 150px !important;
            /* Atur ukuran yang lebih kecil */
            height: 150px !important;
        }
    }

    @media (max-width: 450px) {
        #image {
            width: 150px !important;
            /* Atur ukuran yang lebih kecil */
            height: 150px !important;
        }
    }
</style>
<footer class="p-4 d-flex justify-content-center text-md-start" style="bottom: 0; background: rgba(195, 191, 182, 1);">
    <div class="container my-auto">
        <div class="row row-cols-1 row-cols-md-3 g-4 d-flex justify-content-center text-md-start">
            <div class="col text-center text-md-start">
                <img class="rounded-circle" src="/assets/footer.png" id="image" alt=""
                    style="width: 269px; height: 269px; object-fit: cover;">
            </div>
            <div class="col text-center text-md-start">
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
            <div class="col text-center text-md-start">
                <h3 class="fw-bold border-bottom border-black text-dark py-3">KONTAK KAMI </h3>
                <div class="d-flex flex-column" id="kontak-kami">
                    <p class="text-dark mb-0 fs-5"><strong>Alamat:</strong> Jl. Raya Jambi - Muara Bulian Km. 15,
                        Mendalo Indah, Jambi Luar Kota, Jambi 36361</p>
                    <p class="text-dark mb-0 fs-5 mt-2"><strong>Email:</strong> lptik@unja.ac.id</p>
                </div>
            </div>
        </div>
    </div>
</footer>
