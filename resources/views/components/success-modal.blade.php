
        <!-- Modal -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content text-center p-4 rounded-3">
                    <button type="button" class="btn-close position-absolute end-0 m-3" data-bs-dismiss="modal"
                        aria-label="Close"></button>

                    <!-- Icon sukses -->
                    <div class="d-flex justify-content-center">
                        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">
                            <i class="fa-solid fa-circle-check fa-2xl text-white"></i>
                        </div>
                    </div>

                    <!-- Judul -->
                    <h4 class="fw-bold mt-3 text-success">Berhasil!</h4>

                    <!-- Pesan -->
                    <p class="text-muted px-4">
                        {{ $message }}
                    </p>

                    <!-- Tombol OK -->
                    <div class="d-grid">
                        <button type="button" class="btn btn-success fw-bold py-2" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Script untuk menampilkan modal otomatis -->

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    });
</script>
