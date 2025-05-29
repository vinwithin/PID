{{-- resources/views/registration/create.blade.php --}}
@extends('layout.app')
@section('title', 'Edit Pendaftaran')
@section('description', 'Edit')

@section('content')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- 2. Load Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- 3. Load Select2 JS AFTER jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        .step {
            display: none;
        }

        .step.active {
            display: block;
        }

        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .step-indicator div {
            flex: 1;
            text-align: center;
            padding: 10px;
            border-bottom: 3px solid rgba(188, 225, 148, 1);
            color: rgba(188, 225, 148, 1);

        }

        .step-indicator .active {
            border-bottom: 3px solid black;
            font-weight: bold;
            color: black;
        }

        .hidden {
            display: none !important;
        }

        .modal {
            display: none;
            /* Sembunyikan modal secara default */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close-button {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close-button:hover,
        .close-button:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>


    <div class="w-100">
        <!-- Modal -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true" aria-labelledby="successModalLabel">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content text-center p-4 rounded-3">
                    <button type="button" class="btn-close position-absolute end-0 m-3" data-bs-dismiss="modal"
                        aria-label="Close" id="modalHeaderClose"></button>

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
                        Pendaftaran Anda telah berhasil diubah!
                    </p>

                    <!-- Tombol OK -->
                    <div class="d-grid">
                        <button type="button" class="btn btn-success" id="modalFooterClose">Tutup</button>

                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="successModalLabel">Perubahan Berhasil</h5>
                        <button type="button" class="btn btn-success" id="modalHeaderClose" aria-label="Close"></button>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body text-center">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                        <p class="mt-3">Pendaftaran Anda telah berhasil diubah!</p>
                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="modalFooterClose">Tutup</button>
                    </div>


                </div>
            </div>
        </div>  --}}

        <!-- Modal Gagal Register -->
        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="statusModalLabel">Pemberitahuan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="errorMessage">Terjadi kesalahan saat pendaftaran. Silakan coba lagi.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">

            <div class="card-body">
                <!-- Step Indicator -->
                <div class="step-indicator">
                    <div id="step1Indicator" class="active">Step 1: Informasi Tim</div>
                    <div id="step2Indicator">Step 2: Anggota Tim</div>
                    <div id="step3Indicator">Step 3: Informasi Dosen Pembimbing</div>
                    <div id="step4Indicator">Step 4: Dokumen Persyaratan </div>
                </div>

                <form id="registrationForm" method="POST" action="/updateProgram/{{ $data->id }}"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="step" id="currentStep" value="1">
                    <!-- Step 1 -->
                    <div class="step active">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Nama Ketua Tim</label>
                            <input type="text" class="form-control" id="name" name="nama_ketua"
                                value="{{ $data->nama_ketua }}" readonly required>
                        </div>
                        <div class="mb-3">
                            <label for="nim" class="form-label fw-bold">NIM Ketua Tim</label>
                            <input type="text" class="form-control" id="nim" name="nim_ketua"
                                value="{{ $data->nim_ketua }}" readonly required>
                        </div>
                        <div class="mb-3">
                            <label for="fakultas" class="form-label fw-bold">Fakultas</label>
                            <select class="form-select" name="fakultas_ketua" id="fakultas" required>
                                <option value="{{ $data->fakultas->id }}" selected="selected" hidden="hidden">
                                    {{ $data->fakultas->nama }}</option>
                                @foreach ($fakultas as $item)
                                    @if ($item->id != $data->fakultas->id)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="program_studi" class="form-label fw-bold">Program Studi</label>
                            <select class="form-select" name="program_studi" id="program_studi"
                                style="width: 100%; padding: 0.5rem; border: 1px solid #ced4da; border-radius: 0.25rem; background-color: #fff;"
                                required>
                                <option value="{{ $data->program_studi->id }}">{{ $data->program_studi->nama }}</option>

                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nohp" class="form-label fw-bold">No.hp Ketua Tim</label>
                            <input type="text" class="form-control  @error('nohp_ketua') is-invalid @enderror"
                                id="nohp" name="nohp_ketua" value="{{ $data->nohp_ketua }}" required>
                            @error('nohp_ketua')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="ormawa" class="form-label fw-bold">Ormawa</label>
                            <select class="form-select" name="nama_ormawa" id="ormawa" required>
                                <option value="{{ $data->ormawa->id }}" selected="selected" hidden="hidden">
                                    {{ $data->ormawa->nama }}</option>
                                @foreach ($ormawa as $item)
                                    @if ($item->id != $data->ormawa->id)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="judul" class="form-label fw-bold">Judul</label>
                            <input type="text" class="form-control  @error('judul') is-invalid @enderror"
                                id="judul" name="judul" value="{{ $data->judul }}" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="bidang" class="form-label fw-bold">Bidang</label>
                            <select class="form-select" name="bidang_id" id="bidang" required>
                                <option value="{{ $data->bidang->id }}" selected="selected" hidden="hidden">
                                    {{ $data->bidang->nama }}</option>
                                @foreach ($bidang as $item)
                                    @if ($item->id != $data->bidang->id)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <p class="fw-bold">Pilih Lokasi</p>
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="regency_name">Kabupaten:</label>
                            <select class="form-select" id="regency_name" name="regency_name">
                                <option value="{{ $data->lokasi->id }}" selected="selected">{{ $data->lokasi->regency }}
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">

                            <label class="form-label fw-bold" for="district_name">Kecamatan:</label>
                            <select class="form-select" id="district_name" name="district_name" disabled>
                                <option value="{{ $data->lokasi->id }}" selected="selected">
                                    {{ $data->lokasi->district }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold" for="village_name">Desa:</label>
                            <select class="form-select" id="village_name" name="village_name" disabled>
                                <option value="{{ $data->lokasi->id }}" selected="selected">{{ $data->lokasi->village }}
                                </option>
                            </select>
                        </div>
                        {{-- <button type="button" id="next" class="btn btn-primary" onclick="nextStep()">Next</button> --}}
                    </div>

                    <!-- Step 2 -->
                    <div class="step">
                        <div id="team-members">
                            @foreach ($data->teamMembers as $index => $member)
                                <div class="team-member">
                                    <div class="row g-2">
                                        <div class="col-lg-2 mb-3">
                                            <label for="nim_{{ $index }}" class="form-label fw-bold">NIM</label>
                                            <input type="text" id="nim_{{ $index }}"
                                                name="anggota_tim[{{ $index }}][identifier]" class="form-control"
                                                value="{{ old('anggota_tim.' . $index . '.identifier', $member->identifier) }}"
                                                readonly>
                                        </div>
                                        <div class="col-lg-2 mb-3">
                                            <label for="nama_{{ $index }}" class="form-label fw-bold">Nama</label>
                                            <input type="text" id="nama_{{ $index }}"
                                                name="anggota_tim[{{ $index }}][nama]" class="form-control"
                                                value="{{ old('anggota_tim.' . $index . '.nama', $member->nama) }}"
                                                readonly>
                                        </div>
                                        <div class="col-lg-2 mb-3">
                                            <label for="fakultas_{{ $index }}"
                                                class="form-label fw-bold">Fakultas</label>
                                            <select class="form-select" name="anggota_tim[{{ $index }}][fakultas]"
                                                id="fakultas_{{ $index }}" required>
                                                <option value="" hidden="hidden">Pilih Fakultas</option>
                                                @foreach ($fakultas as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ old('anggota_tim.' . $index . '.fakultas', $member->fakultas) == $item->id ? 'selected' : '' }}>
                                                        {{ $item->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-2 mb-3">
                                            <label for="prodi_{{ $index }}" class="form-label fw-bold">Program
                                                Studi</label>
                                            <select class="form-select" name="anggota_tim[{{ $index }}][prodi]"
                                                id="prodi_{{ $index }}" required>
                                                <option value="" hidden="hidden">Pilih Program Studi</option>
                                                @foreach ($program_studi as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ old('anggota_tim.' . $index . '.prodi', $member->prodi) == $item->id ? 'selected' : '' }}>
                                                        {{ $item->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-2 mb-3">
                                            <label for="jabatan_{{ $index }}"
                                                class="form-label fw-bold">Jabatan</label>
                                            <input type="text" id="jabatan_{{ $index }}"
                                                name="anggota_tim[{{ $index }}][jabatan]" class="form-control"
                                                value="{{ old('anggota_tim.' . $index . '.jabatan', $member->jabatan) }}"
                                                readonly>
                                        </div>
                                        @if ($index > 0)
                                            <div class="col-lg-2 mb-3 d-flex align-items-end">
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                    onclick="removeMember(this)"><i class="fa-regular fa-trash"></i></button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach


                        </div>
                        <p class="text-muted">Minimal 3 Anggota Tim dan Maksimal 13 Anggota Tim</p>

                        <button type="button" class="btn btn-sm btn-success rounded mb-2" onclick="addTeamMember()"><i
                                class="fa-solid fa-plus me-2"></i>Tambah Anggota</button><br>

                    </div>

                    <!-- Step 3 -->
                    <div class="step">
                        <div style="margin-bottom: 1rem;">
                            <label for="nama_dosen_pembimbing_val"
                                style="font-weight: bold; display: block; margin-bottom: 0.5rem;">
                                Nama Dosen Pembimbing
                            </label>
                            <select id="nama_dosen_pembimbing_val" name="nama_dosen_pembimbing_val"
                                style="width: 100%; padding: 0.5rem; border: 1px solid #ced4da; border-radius: 0.25rem; background-color: #fff;">
                                <option value="{{ $data->nama_dosen_pembimbing }}">{{ $data->dospem->name }}
                                </option>
                            </select>
                        </div>



                        <div class="mb-3">
                            <label for="nohp_dosen_pembimbing" class="form-label fw-bold">No.hp Dosen
                                Pembimbing</label>
                            <input type="text"
                                class="form-control @error('nohp_dosen_pembimbing') is-invalid @enderror"
                                id="nohp_dosen_pembimbing" name="nohp_dosen_pembimbing"
                                value="{{ $data->nohp_dosen_pembimbing }}" required>
                            @error('nohp_dosen_pembimbing')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- <button type="button" class="btn btn-secondary" onclick="prevStep()">Back</button> --}}
                    </div>
                    {{-- step 4 --}}
                    <div class="step">
                        <p class="fw-bold">Surat Keputusan Organisasi</p>
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" id="sk_organisasi" name="sk_organisasi"
                                accept="pdf">
                            <label class="form-label" for="sk_organisasi"></label>
                            @error('sk_organisasi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <p class="fw-bold">Surat pernyataan kerja sama dari khalayak sasaran yang diketahui oleh kepala
                            desa</p>
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" id="surat_kerjasama" name="surat_kerjasama"
                                accept="pdf">
                            <label class="form-label" for="surat_kerjasama"></label>
                            @error('surat_kerjasama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <p class="fw-bold">Surat kesediaan dosen pendamping untuk membimbing kegiatan Pro IDE</p>
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" id="surat_rekomendasi_pembina"
                                name="surat_rekomendasi_pembina" accept="pdf">
                            <label class="form-label" for="surat_rekomendasi_pembina"></label>
                            @error('surat_rekomendasi_pembina')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <p class="fw-bold">Proposal Pro-IDe</p>
                        <div class="input-group mb-3">
                            <input type="file" class="form-control" id="proposal" name="proposal" accept="pdf">
                            <label class="form-label" for="proposal"></label>
                            @error('proposal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        {{-- <button type="button" class="btn btn-secondary" onclick="prevStep()">Back</button>
                        <button type="button" id="next" class="btn btn-primary" onclick="nextStep()">Next</button> --}}
                    </div>
                    <button type="button" id="prevStep" class="btn btn-secondary mt-2">Kembali</button>
                    <button type="button" id="next" class="btn btn-primary mt-2">Selanjutnya</button>
                    <button type="submit" id="submitForm" class="btn btn-primary mt-2">Kirim</button>
                    <a class="btn btn-warning mt-2" href="/daftarProgram">Keluar</a>

                </form>
            </div>

        </div>
    </div>

    {{-- <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script> --}}



    <script>
        let currentStep = 1;
        const totalSteps = 4;
        let valueStep = document.getElementById('currentStep').value;
        const steps = document.querySelectorAll('.step');
        const indicators = [
            document.getElementById('step1Indicator'),
            document.getElementById('step2Indicator'),
            document.getElementById('step3Indicator'),
            document.getElementById('step4Indicator')
        ];

        function showStep(step) {
            currentStep = step; // Update currentStep sesuai dengan parameter
            document.getElementById('currentStep').value = currentStep;

            // Tampilkan step yang aktif
            steps.forEach((el, index) => {
                el.classList.toggle('active', index === currentStep - 1); // step dimulai dari 1, bukan 0
            });

            // Update indikator step
            indicators.forEach((el, index) => {
                el.classList.toggle('active', index === currentStep - 1); // step dimulai dari 1, bukan 0
            });
        }

        function updateVisibility() {
            document.getElementById('prevStep').classList.toggle('hidden', currentStep === 1);
            document.getElementById('next').classList.toggle('hidden', currentStep === totalSteps);
            document.getElementById('submitForm').classList.toggle('hidden', currentStep !== totalSteps);
        }

        document.getElementById('prevStep').addEventListener('click', () => {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
                updateVisibility();
            }
        });

        document.getElementById('next').addEventListener('click', async () => {
            // Validasi langkah saat ini
            console.log(valueStep);
            const formData = new FormData(document.getElementById('registrationForm'));
            formData.append('step', currentStep);


            const response = await fetch('{{ route('mahasiswa.step') }}', {
                method: 'POST',
                body: formData
            });

            if (response.ok) {
                if (currentStep < totalSteps) {
                    currentStep++; // Increment langkah
                    showStep(currentStep);
                    updateVisibility();
                }
            } else {
                const data = await response.json();
                var modalElement = document.getElementById("errorModal");
                // Ubah hanya isi pesan error, bukan seluruh modal
                document.getElementById("errorMessage").textContent = data.message ||
                    'Pendaftaran gagal. Silakan coba lagi.';
                // Tampilkan modal dengan Bootstrap 5
                var modalInstance = new bootstrap.Modal(modalElement);
                modalInstance.show();
            }

        });
        document.getElementById('registrationForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            if (confirm('Apakah Anda yakin ingin mengirimkan perubahan proposal?')) {
                const formData = new FormData(e.target);

                // Debug: Cek apakah FormData terisi dengan benar
                for (let [key, value] of formData.entries()) {
                    console.log(`${key}: ${value}`);
                }


                const response = await fetch(e.target.action, {
                    method: 'POST',
                    body: formData
                });

                if (response.ok) {
                    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                    successModal.show();
                } else {
                    const data = await response.json();
                    var modalElement = document.getElementById("errorModal");
                    // Ubah hanya isi pesan error, bukan seluruh modal
                    document.getElementById("errorMessage").textContent = data.message ||
                        'Pendaftaran gagal. Silakan coba lagi.';
                    // Tampilkan modal dengan Bootstrap 5
                    var modalInstance = new bootstrap.Modal(modalElement);
                    modalInstance.show();
                }

            }
        });

        document.getElementById('modalHeaderClose').addEventListener('click', function() {
            window.location.href = '/dashboard';
        });

        document.getElementById('modalFooterClose').addEventListener('click', function() {
            window.location.href = '/dashboard';
        });



        // Menutup modal ketika klik di luar modal
        window.addEventListener('click', (event) => {
            const modal = document.getElementById('successModal');
            if (event.target == modal) {
                modal.style.display = 'none';
                window.location.href = '/dashboard';

            }
        });
        updateVisibility();
    </script>
    <script>
        let memberCount = {{ count($data->teamMembers) }};
        const fakultas = @json($fakultas);
        const programStudi = @json($program_studi);



        function addTeamMember() {
            if (memberCount >= 13) {
                alert('Maximum 13 team members allowed');
                return;
            }

            const template = `
            <div class="team-member">
                <div class="row g-2">
                    <div class="col-lg-2 mb-3">
                        <label for="nim" class="form-label fw-bold">NIM</label>
                         <input type="text" id="nim" name="anggota_tim[${memberCount}][identifier]" class="form-control">
                    </div>
                    <div class="col-lg-2 mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text"  id="nama" name="anggota_tim[${memberCount}][nama]" class="form-control" readonly>
                    </div>     
                    <div class="col-lg-2 mb-3">
                        <label for="fakultas" class="form-label">Fakultas</label>
                        <select class="form-select" name="anggota_tim[${memberCount}][fakultas]" id="fakultas" required>
                            <option value="" selected="selected" hidden="hidden">Pilih Fakultas</option>
                            ${fakultas.map(item => `<option value="${item.id}">${item.nama}</option>`).join('')}
                        </select>
                    </div>
                    <div class="col-lg-2 mb-3">
                        <label for="prodi" class="form-label">Program Studi</label>
                        <select class="form-select" name="anggota_tim[${memberCount}][prodi]" id="prodi" required>
                            <option value="" selected="selected" hidden="hidden">Pilih Program Studi</option>
                            ${programStudi.map(item => `<option value="${item.id}">${item.nama}</option>`).join('')}
                        </select>
                    </div>
                    <div class="col-lg-2 mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <input type="text" name="anggota_tim[${memberCount}][jabatan]" value="Anggota" class="form-control">
                    </div>
                    <div class="col-lg-2 mb-3 d-flex align-items-end">
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeMember(this)"><i class="fa-regular fa-trash"></i></button>
                    </div>
                </div>
            </div>
        `;

            document.getElementById('team-members').insertAdjacentHTML('beforeend', template);
            memberCount++;
        }

        function removeMember(button) {
            const teamMember = button.closest('.team-member');
            if (teamMember) {
                teamMember.remove();
            }
            memberCount--;
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle untuk semua input NIM yang ada dan yang akan ditambahkan
            document.body.addEventListener('input', function(e) {
                if (e.target && e.target.id === 'nim') {
                    handleNimSearch(e.target);
                }
            });
        });

        function handleNimSearch(nimInput) {
            const parentDiv = nimInput.closest('.team-member');
            const namaInput = parentDiv.querySelector('#nama');

            // Dapatkan nilai NIM
            const nim = nimInput.value.trim();

            // Hanya lakukan pencarian jika NIM memiliki panjang yang cukup
            if (nim.length >= 5) { // Sesuaikan dengan panjang minimum NIM
                // Tambahkan loading indicator
                nimInput.classList.add('loading');

                // Persiapkan headers
                const headers = {
                    'Content-Type': 'application/json'
                };

                // Tambahkan CSRF token jika tersedia
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (csrfToken) {
                    headers['X-CSRF-TOKEN'] = csrfToken.content;
                }

                // Lakukan AJAX request
                fetch(`/search-users?nim=${nim}`, {
                        method: 'GET',
                        headers: headers
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status && data.name) {
                            // Isi otomatis field nama
                            namaInput.value = data.name;
                            showSuccess('Data ditemukan', parentDiv, 'alert-success');

                        } else {
                            // Reset field jika data tidak ditemukan
                            namaInput.value = '';
                            // Tampilkan pesan error
                            if (data.is_registered) {
                                showError('NIM sudah mendaftar program, daftarkan mahasiswa lain', parentDiv,
                                    'alert-warning');
                            } else {
                                showError('Data mahasiswa tidak ditemukan, daftarkan mahasiswa lain', parentDiv,
                                    'alert-danger');
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showError('Terjadi kesalahan saat mencari data');
                    })
                    .finally(() => {
                        // Hapus loading indicator
                        nimInput.classList.remove('loading');
                    });
            } else {
                // Reset field jika NIM terlalu pendek
                namaInput.value = '';
            }
        }

        // Fungsi untuk menampilkan error
        function showError(message, parentElement, className = 'alert-danger') {
            // Hapus error yang sudah ada
            removeError(parentElement);

            const errorDiv = document.createElement('div');
            errorDiv.className = `alert ${className} mt-2 error-message`;
            errorDiv.textContent = message;

            // Tambahkan pesan error baru
            parentElement.appendChild(errorDiv);

            // Hapus pesan error setelah beberapa detik
            setTimeout(() => {
                errorDiv.remove();
            }, 5000);
        }

        function showSuccess(message, parentElement, className = 'alert-success') {
            // Hapus error yang sudah ada
            removeError(parentElement);

            const errorDiv = document.createElement('div');
            errorDiv.className = `alert ${className} mt-2 error-message`;
            errorDiv.textContent = message;

            // Tambahkan pesan error baru
            parentElement.appendChild(errorDiv);

            // Hapus pesan error setelah beberapa detik
            setTimeout(() => {
                errorDiv.remove();
            }, 5000);
        }

        function removeError(parentElement) {
            const existingError = parentElement.querySelector('.error-message');
            if (existingError) {
                existingError.remove();
            }
        }


        // Tambahkan CSS untuk loading indicator
        const style = document.createElement('style');
        style.textContent = `
            .loading {
                background-image: url('data:image/gif;base64,R0lGODlhEAAQAPIAAP///wAAAMLCwkJCQgAAAGJiYoKCgpKSkiH/C05FVFNDQVBFMi4wAwEAAAAh/hpDcmVhdGVkIHdpdGggYWpheGxvYWQuaW5mbwAh+QQJCgAAACwAAAAAEAAQAAADMwi63P4wyklrE2MIOggZnAdOmGYJRbExwroUmcG2LmDEwnHQLVsYOd2mBzkYDAdKa+dIAAAh+QQJCgAAACwAAAAAEAAQAAADNAi63P5OjCEgG4QMu7DmikRxQlFUYDEZIGBMRVsaqHwctXXf7WEYB4Ag1xjihkMZsiUkKhIAIfkECQoAAAAsAAAAABAAEAAAAzYIujIjK8pByJDMlFYvBoVjHA70GU7xSUJhmKtwHPAKzLO9HMaoKwJZ7Rf8AYPDDzKpZBqfvwQAIfkECQoAAAAsAAAAABAAEAAAAzMIumIlK8oyhpHsnFZfhYumCYUhDAQxRIdhHBGqRoKw0R8DYlJd8z0fMDgsGo/IpHI5TAAAIfkECQoAAAAsAAAAABAAEAAAAzIIunInK0rnZBTwGPNMgQwmdsNgXGJUlIWEuR5oWUIpz8pAEAMe6TwfwyYsGo/IpFKSAAAh+QQJCgAAACwAAAAAEAAQAAADMwi6IMKQORfjdOe82p4wGccc4CEuQradylesojEMBgsUc2G7sDX3lQGBMLAJibufbSlKAAAh+QQJCgAAACwAAAAAEAAQAAADMgi63P7wCRHZnFVdmgHu2nFwlWCI3WGc3TSWhUFGxTAUkGCbtgENBMJAEJsxgMLWzpEAACH5BAkKAAAALAAAAAAQABAAAAMyCLrc/jDKSatlQtScKdceCAjDII7HcQ4EMTCpyrCuUBjCYRgHVtqlAiB1YhiCnlsRkAAAOwAAAAAAAAAAAA==');
                background-repeat: no-repeat;
                background-position: right center;
                background-size: 20px 20px;
            }
        `;
        document.head.appendChild(style);
    </script>

    <script>
        $(document).ready(function() {
            // Tambahkan hidden input di bawah setiap select
            $('#regency_name').after(
                '<input type="hidden" name="regency" id="regency" value="{{ $data->lokasi->regency }}">');
            $('#district_name').after(
                '<input type="hidden" name="district" id="district" value="{{ $data->lokasi->district }}">');
            $('#village_name').after(
                '<input type="hidden" name="village" id="village" value="{{ $data->lokasi->village }}"">');

            $('#nama_dosen_pembimbing_val').after(
                `<input type="hidden" name="nama_dosen_pembimbing" id="nama_dosen_pembimbing" value="{{ $data->nama_dosen_pembimbing }}">`
            );

            $('#program_studi').after(
                `<input type="hidden" name="prodi_ketua" id="prodi_ketua" value="{{ $data->prodi_ketua }}">`
            );

            $("#regency_name").select2({
                placeholder: 'Pilih Kabupaten',
                allowClear: true,
                ajax: {
                    url: "/api/regencies/jambi",
                    dataType: 'json',
                    delay: 250,
                    cache: true,
                    processResults: function(data) {
                        return {
                            results: data.map(function(item) {
                                return {
                                    id: item.id,
                                    text: item.name
                                };
                            })
                        };
                    },
                    error: handleApiError('kabupaten')
                }
            }).on('change', function() {
                // Perbarui hidden input dengan nama yang dipilih
                const selectedOption = $(this).find(':selected');
                $('#regency').val(selectedOption.text());

                // Reset dan nonaktifkan dropdown berikutnya
                const districtSelect = $("#district_name");
                const villageSelect = $("#village_name");

                districtSelect.val(null).trigger('change').prop('disabled', true);
                villageSelect.val(null).trigger('change').prop('disabled', true);

                if (!$(this).val()) {
                    $('#regency').val('');
                    return;
                }

                // Aktifkan dropdown kecamatan
                districtSelect.prop('disabled', false);
                districtSelect.select2({
                    placeholder: 'Pilih Kecamatan',
                    allowClear: true,
                    ajax: {
                        url: `/api/districts/${$(this).val()}`,
                        dataType: 'json',
                        delay: 250,
                        cache: true,
                        processResults: function(data) {
                            return {
                                results: data.map(item => ({
                                    id: item.id,
                                    text: item.name
                                }))
                            };
                        },
                        error: handleApiError('kecamatan')
                    }
                });
            });

            // Handle District Change
            $("#district_name").on('change', function() {
                // Perbarui hidden input dengan nama kecamatan
                const selectedOption = $(this).find(':selected');
                $('#district').val(selectedOption.text());

                // Reset dan nonaktifkan dropdown desa
                const villageSelect = $("#village_name");
                villageSelect.val(null).trigger('change').prop('disabled', true);

                if (!$(this).val()) {
                    $('#district').val('');
                    return;
                }

                // Aktifkan dropdown desa
                villageSelect.prop('disabled', false);
                villageSelect.select2({
                    placeholder: 'Pilih Desa/Kelurahan',
                    allowClear: true,
                    ajax: {
                        url: `/api/villages/${$(this).val()}`,
                        dataType: 'json',
                        delay: 250,
                        cache: true,
                        processResults: function(data) {
                            return {
                                results: data.map(item => ({
                                    id: item.id,
                                    text: item.name
                                }))
                            };
                        },
                        error: handleApiError('desa/kelurahan')
                    }
                });
            });

            // Handle Village Change
            $("#village_name").on('change', function() {
                // Perbarui hidden input dengan nama desa
                const selectedOption = $(this).find(':selected');
                $('#village').val(selectedOption.text());

                if (!$(this).val()) {
                    $('#village').val('');
                }
            });

            $("#nama_dosen_pembimbing_val").select2({
                placeholder: "Pilih Dosen Pembimbing",
                allowClear: true,
                ajax: {
                    url: "/get-dosen",
                    dataType: "json",
                    delay: 250,
                    cache: true,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.name
                                };
                            })
                        };
                    }
                }
            }).on('change', function() {
                // Perbarui hidden input dengan nama yang dipilih
                $('#nama_dosen_pembimbing').val($(this).val());

                if (!$(this).val()) {
                    $('#nama_dosen_pembimbing').val('');
                }
            });

            $("#program_studi").select2({
                placeholder: "Pilih Program Studi",
                allowClear: true,
                ajax: {
                    url: "/get-prodi",
                    dataType: "json",
                    delay: 250,
                    cache: true,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.nama
                                };
                            })
                        };
                    }
                }
            }).on('change', function() {
                // Perbarui hidden input dengan nama yang dipilih
                $('#prodi_ketua').val($(this).val());

                if (!$(this).val()) {
                    $('#prodi_ketua').val('');
                }
            });

            // Utility function to handle API errors
            function handleApiError(context) {
                return function(jqXHR, textStatus, errorThrown) {
                    console.error(`Error loading ${context}:`, textStatus, errorThrown);
                    alert(`Gagal memuat data ${context}. Silakan coba lagi.`);
                }
            }
        });
    </script>
@endsection
