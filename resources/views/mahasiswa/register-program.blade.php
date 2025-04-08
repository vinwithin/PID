{{-- resources/views/registration/create.blade.php --}}
@extends('layout.app')
@section('title', 'Pendaftaran')

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
        {{-- success modal --}}
        <div id="successModal" class="modal">
            <div class="modal-content">
                <span class="close-button" id="closeModal">&times;</span>
                <h2>Registration Successful</h2>
                <p>Your registration has been submitted successfully!</p>
            </div>
        </div>
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

            @if (!$registrationExists)

                <div class="card-body">
                    <!-- Step Indicator -->
                    <div class="step-indicator">
                        <div id="step1Indicator" class="active">Step 1: Informasi Tim</div>
                        <div id="step2Indicator">Step 2: Anggota Tim</div>
                        <div id="step3Indicator">Step 3: Dosen Pembimbing Informasi</div>
                        <div id="step4Indicator">Step 4: Persyaratan Dokumen</div>
                    </div>

                    <form id="registrationForm" method="POST" action="{{ route('mahasiswa.daftarProgram') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="step" id="currentStep" value="1">
                        <!-- Step 1 -->
                        <div class="step active">
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Nama Ketua Tim</label>
                                <input type="text" class="form-control" id="name" name="nama_ketua"
                                    value="{{ auth()->user()->name }}" readonly required>
                            </div>
                            <div class="mb-3">
                                <label for="nim" class="form-label fw-bold">NIM Ketua Tim</label>
                                <input type="text" class="form-control" id="nim" name="nim_ketua"
                                    value="{{ auth()->user()->identifier }}" readonly required>
                            </div>
                            <div class="mb-3">
                                <label for="fakultas" class="form-label fw-bold">Fakultas</label>
                                <select class="form-select" name="fakultas_ketua" id="fakultas" required>
                                    <option value="" selected="selected" hidden="hidden">Pilih Kategori</option>
                                    @foreach ($fakultas as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="program_studi" class="form-label fw-bold">Program Studi</label>
                                <select class="form-select" name="prodi_ketua" id="program_studi" required>
                                    <option value="" selected="selected" hidden="hidden">Pilih Kategori</option>
                                    @foreach ($program_studi as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="nohp" class="form-label fw-bold">No.hp Ketua Tim</label>
                                <input type="text" class="form-control  @error('nohp_ketua') is-invalid @enderror"
                                    id="nohp" name="nohp_ketua"
                                    value="{{ old('nohp_ketua', session('registration_step1.nohp_ketua')) }}" required>
                                @error('nohp_ketua')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="ormawa" class="form-label fw-bold">Ormawa</label>
                                <select class="form-select" name="nama_ormawa" id="ormawa" required>
                                    <option value="" selected="selected" hidden="hidden">Pilih Kategori</option>
                                    @foreach ($ormawa as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="judul" class="form-label fw-bold">Judul</label>
                                <input type="text" class="form-control  @error('judul') is-invalid @enderror"
                                    id="judul" name="judul"
                                    value="{{ old('judul', session('registration_step1.judul')) }}" required>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="bidang" class="form-label fw-bold">Bidang</label>
                                <select class="form-select" name="bidang_id" id="bidang" required>
                                    <option value="" selected="selected" hidden="hidden">Pilih Kategori</option>
                                    @foreach ($bidang as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <p class="fw-bold">Pilih Lokasi</p>
                            <div class="mb-3">
                                <label class="form-label fw-bold" for="regency_name">Kabupaten:</label>
                                <select class="form-select" id="regency_name" name="regency_name">
                                    <option value="">Pilih Kabupaten</option>
                                </select>
                            </div>
                            <div class="mb-3">

                                <label class="form-label fw-bold" for="district_name">Kecamatan:</label>
                                <select class="form-select" id="district_name" name="district_name" disabled>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold" for="village_name">Desa:</label>
                                <select class="form-select" id="village_name" name="village_name" disabled>
                                    <option value="">Pilih Desa</option>
                                </select>
                            </div>
                            {{-- <button type="button" id="next" class="btn btn-primary" onclick="nextStep()">Next</button> --}}
                        </div>

                        <!-- step 2 -->
                        <div class="step">
                            <div id="team-members">
                                <div class="team-member">
                                    <div class="row g-2">
                                        <div class="col-lg-2 mb-3">
                                            <label for="nim" class="form-label fw-bold">NIM</label>
                                            <input type="text" id="nim" name="anggota_tim[0][identifier]"
                                                class="form-control" value="{{ auth()->user()->identifier }}" readonly>
                                        </div>
                                        <div class="col-lg-2 mb-3">
                                            <label for="nama" class="form-label fw-bold">Nama</label>
                                            <input type="text" id="nama" name="anggota_tim[0][nama]"
                                                class="form-control" value="{{ auth()->user()->name }}"
                                                readonly>
                                        </div>
                                        <div class="col-lg-2 mb-3">
                                            <label for="fakultas" class="form-label fw-bold">Fakultas</label>
                                            <select class="form-select" name="anggota_tim[0][fakultas]" id="fakultas"
                                                required>
                                                <option value="" selected="selected" hidden="hidden">Pilih Fakultas
                                                </option>
                                                @foreach ($fakultas as $item)
                                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-2 mb-3">
                                            <label for="prodi" class="form-label fw-bold">Program Studi</label>
                                            <select class="form-select" name="anggota_tim[0][prodi]" id="prodi"
                                                required>
                                                <option value="" selected="selected" hidden="hidden">Pilih Program
                                                    Studi</option>
                                                @foreach ($program_studi as $item)
                                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-2 mb-3">
                                            <label for="jabatan" class="form-label fw-bold">Jabatan</label>
                                            <input type="text" id="jabatan" name="anggota_tim[0][jabatan]"
                                                class="form-control" value="Ketua" readonly>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <button type="button" onclick="addTeamMember()">Add Member</button><br>

                        </div>

                        <!-- Step 3 -->
                        <div class="step">
                            <div style="margin-bottom: 1rem;">
                                <label for="nama_dosen_pembimbing_val" style="font-weight: bold; display: block; margin-bottom: 0.5rem;">
                                    Nama Dosen Pembimbing
                                </label>
                                <select id="nama_dosen_pembimbing_val" name="nama_dosen_pembimbing_val" 
                                    style="width: 100%; padding: 0.5rem; border: 1px solid #ced4da; border-radius: 0.25rem; background-color: #fff;">
                                    <option value="">Pilih Dosen</option>
                                </select>
                            </div>


                            <div class="mb-3">
                                <label for="nohp_dosen_pembimbing" class="form-label fw-bold">No.hp Dosen
                                    Pembimbing</label>
                                <input type="text"
                                    class="form-control @error('nohp_dosen_pembimbing') is-invalid @enderror"
                                    id="nohp_dosen_pembimbing" name="nohp_dosen_pembimbing" required>
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
                                    accept="pdf" required>
                                <label class="input-group-text" for="sk_organisasi">Unggah</label>
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
                                    accept="pdf" required>
                                <label class="input-group-text" for="surat_kerjasama">Unggah</label>
                                @error('surat_kerjasama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <p class="fw-bold">Surat kesediaan dosen pendamping untuk membimbing kegiatan Pro IDE</p>
                            <div class="input-group mb-3">
                                <input type="file" class="form-control" id="surat_rekomendasi_pembina"
                                    name="surat_rekomendasi_pembina" accept="pdf" required>
                                <label class="input-group-text" for="surat_rekomendasi_pembina">Unggah</label>
                                @error('surat_rekomendasi_pembina')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <p class="fw-bold">Proposal Pro-IDe</p>
                            <div class="input-group mb-3">
                                <input type="file" class="form-control" id="proposal" name="proposal"
                                    accept="pdf" required>
                                <label class="input-group-text" for="proposal">Unggah</label>
                                @error('proposal')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <button type="button" id="prevStep" class="btn btn-secondary mt-2">Kembali</button>
                        <button type="button" id="next" class="btn btn-primary mt-2">Selanjutnya</button>
                        <button type="submit" id="submitForm" class="btn btn-success">Submit</button>

                    </form>
                </div>
            @else
                <div class="container-fluid px-4 py-4">
                    @if (session('success'))
                        <x-success-modal :message="session('success')" />
                    @endif
                    @if (session('error'))
                        <x-error-modal :message="session('error')" />
                    @endif
                    <div class="card-header text-dark d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 text-dark">Status Pendaftaran</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Nama Ketua</th>
                                        <th class="d-none d-xl-table-cell">NIM</th>
                                        <th class="d-none d-xl-table-cell">Fakultas</th>
                                        <th>Bidang</th>
                                        <th class="d-none d-md-table-cell">Judul Proyek</th>
                                        <th>Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $index => $item)
                                        <tr>
                                            <td class="text-center fw-bold">{{ $index + 1 }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-primary text-white me-3 d-flex align-items-center justify-content-center"
                                                        style="width: 40px; height: 40px;">
                                                        {{ substr($item->nama_ketua, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <div>{{ $item->nama_ketua }}</div>
                                                        <small class="text-muted d-xl-none">{{ $item->nim_ketua }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="d-none d-xl-table-cell">{{ $item->nim_ketua }}</td>
                                            <td class="d-none d-xl-table-cell">{{ $item->fakultas->nama }}</td>
                                            <td>
                                                <span class="badge bg-success">{{ $item->bidang->nama }}</span>
                                            </td>
                                            <td class="d-none d-md-table-cell">
                                                <div class="text-truncate" style="max-width: 200px;">
                                                    {{ $item->judul }}
                                                </div>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge {{ $item->registration_validation->status === 'valid' ? 'bg-warning text-dark' : 'bg-danger' }}">
                                                    {{ $item->registration_validation->status === 'valid' ? 'Valid & Menunggu' : $item->registration_validation->status }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="/program/cek/{{ $item->id }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye me-1"></i>Cek
                                                </a>
                                                @if (
                                                    !in_array($item->registration_validation->status, [
                                                        'valid',
                                                        'tidak valid',
                                                        'lolos',
                                                        'Lanjutkan Program',
                                                        'Hentikan Program',
                                                    ]))
                                                    @if ($item->nama_ketua === Auth()->user()->name)
                                                        <a href="/editProgram/{{ $item->id }}"
                                                            class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-pen me-1"></i>Edit
                                                        </a>
                                                    @endif
                                                @endif


                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>


                </div>


                @push('styles')
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
                    <style>
                        body {
                            background-color: #f4f6f9;
                        }

                        .table-responsive {
                            max-height: 600px;
                            overflow-y: auto;
                        }

                        .table thead {
                            position: sticky;
                            top: 0;
                            background-color: #f8f9fa;
                            z-index: 10;
                        }

                        .text-truncate {
                            white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;
                        }
                    </style>
                @endpush
            @endif
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

            if (confirm('Are you sure you want to submit the registration?')) {
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
                    document.getElementById('successModal').style.display = 'block';
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
        document.getElementById('closeModal').addEventListener('click', () => {
            document.getElementById('successModal').style.display = 'none';
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
        let memberCount = 1;
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
                        <input type="text" name="anggota_tim[${memberCount}][jabatan]" class="form-control">
                    </div>
                    <div class="col-lg-2 mb-3 d-flex align-items-end">
                        <button type="button" class="btn btn-danger" onclick="removeMember(this)">Remove</button>
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
                                showError('NIM sudah Mendaftar Program', parentDiv, 'alert-warning');
                            } else {
                                showError('Data mahasiswa tidak ditemukan', parentDiv, 'alert-danger');
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
            }, 3000);
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
            }, 3000);
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
            $('#regency_name').after('<input type="hidden" name="regency" id="regency">');
            $('#district_name').after('<input type="hidden" name="district" id="district">');
            $('#village_name').after('<input type="hidden" name="village" id="village">');

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

            // Utility function to handle API errors
            function handleApiError(context) {
                return function(jqXHR, textStatus, errorThrown) {
                    console.error(`Error loading ${context}:`, textStatus, errorThrown);
                    alert(`Gagal memuat data ${context}. Silakan coba lagi.`);
                }
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#nama_dosen_pembimbing').select2({
                placeholder: "Pilih Dosen Pembimbing",
                allowClear: true,
                ajax: {
                    url: "/get-dosen",
                    dataType: "json",
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.name,
                                    text: item.name
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
        });
    </script>
@endsection
