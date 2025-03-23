
        <!-- Modal -->
        <div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content text-center p-4 rounded-3">
                    <button type="button" class="btn-close position-absolute end-0 m-3" data-bs-dismiss="modal"
                        aria-label="Close"></button>

                    <!-- Icon sukses -->
                    <div class="d-flex justify-content-center">
                        <div class="bg-danger rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 60px; height: 60px;">
                            <i class="fa-sharp fa-regular fa-circle-xmark fa-2xl"></i>
                        </div>
                    </div>

                    <!-- Judul -->
                    <h4 class="fw-bold mt-3">Failed</h4>

                    <!-- Pesan -->
                    <p class="text-muted px-4">
                        {{ $message }}
                    </p>

                    <!-- Tombol OK -->
                    <div class="d-grid">
                        <button type="button" class="btn btn-danger fw-bold py-2" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Script untuk menampilkan modal otomatis -->

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
        errorModal.show();
    });
</script>
