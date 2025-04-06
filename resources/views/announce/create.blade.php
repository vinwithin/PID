@extends('layout.app')
@section('title', 'Tambah Pengumuman')
@section('content')
    <div class="w-100">
        <div class="card">

            <div class="card-header">
                <h3>Pengumuman</h3>
            </div>
            <div class="card-body">
                <!-- Step Indicator -->


                <form method="POST" action="{{ route('announcement.tambah') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="category" class="form-label">Kategori</label>
                        <input type="text" class="form-control  @error('category') is-invalid @enderror" id="category"
                            name="category" required>
                        @error('category')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold">Title</label>
                        <input type="text" class="form-control  @error('title') is-invalid @enderror" id="title"
                            name="title" required>
                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Tanggal Mulai -->
                    <div class="mb-3">
                        <label for="status" class="form-label fw-bold">Status</label>
                        <select class="form-control  @error('status') is-invalid @enderror" id="status" name="status"
                            required onchange="toggleDateFields()">
                            <option value="Buka">Buka</option>
                            <option value="Tutup">Tutup</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Tanggal Mulai -->
                    <div class="mb-3">
                        <label for="start_date" class="form-label fw-bold">Tanggal Mulai</label>
                        <input type="date" class="form-control  @error('start_date') is-invalid @enderror"
                            id="start_date" name="start_date" required>
                        @error('start_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Tanggal Berakhir -->
                    <div class="mb-3">
                        <label for="end_date" class="form-label fw-bold">Tanggal Berakhir</label>
                        <input type="date" class="form-control  @error('end_date') is-invalid @enderror" id="end_date"
                            name="end_date">
                        @error('end_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <a href="/announcement" class="btn btn-secondary me-2">Kembali</a>
                    <button type="submit" class="btn btn-primary">Kirim</button>

                </form>
            </div>
        </div>
    </div>
    <script>
        function toggleDateFields() {
            let status = document.getElementById("status").value;
            let startDate = document.getElementById("start_date");
            let endDate = document.getElementById("end_date");

            if (status === "Tutup") {
                startDate.value = "";
                startDate.disabled = true;
                endDate.value = "";
                endDate.disabled = true;
            } else {
                startDate.disabled = false;
                endDate.disabled = false;
            }
        }

        // Panggil fungsi saat halaman dimuat untuk menangani default value
        document.addEventListener("DOMContentLoaded", toggleDateFields);
    </script>

@endsection
