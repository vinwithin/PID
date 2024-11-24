{{-- resources/views/registration/create.blade.php --}}
@extends('layout.app')

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
            border-bottom: 3px solid #ccc;
        }

        .step-indicator .active {
            border-bottom: 3px solid #007bff;
            font-weight: bold;
        }

        .hidden {
            display: none !important;
        }

        .modal {
            display: none;
            /* Sembunyikan modal secara default */
            position: fixed;
            z-index: 1;
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
    <div id="successModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close-button" id="closeModal">&times;</span>
            <h2>Registration Successful</h2>
            <p>Your registration has been submitted successfully!</p>
        </div>
    </div>

    <div class="w-100">
        <div class="card">
            @if (!$registrationExists)
                <div class="card-header">
                    <h3>Pendaftaran</h3>
                </div>
                <div class="card-body">
                    <!-- Step Indicator -->
                    <div class="step-indicator">
                        <div id="step1Indicator" class="active">Step 1: Informasi Tim</div>
                        <div id="step2Indicator">Step 2: Persyaratan Dokumen</div>
                        <div id="step3Indicator">Step 3: Anggota Tim</div>
                        <div id="step4Indicator">Step 4: Dosen Pembimbing Informasi</div>
                    </div>

                    <form id="registrationForm" method="POST" action="{{ route('mahasiswa.daftarProgram') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="step" id="currentStep" value="1">
                        <!-- Step 1 -->
                        <div class="step active">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Ketua Tim</label>
                                <input type="text" class="form-control" id="name" name="nama_ketua" required>
                            </div>
                            <div class="mb-3">
                                <label for="nim" class="form-label">NIM Ketua Tim</label>
                                <input type="text" class="form-control" id="nim" name="nim_ketua" required>
                            </div>
                            <div class="mb-3">
                                <label for="fakultas" class="form-label">Fakultas</label>
                                <select class="form-select" name="fakultas_ketua" id="fakultas" required>
                                    <option value="" selected="selected" hidden="hidden">Pilih Kategori</option>
                                    @foreach ($fakultas as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="program_studi" class="form-label">Program Studi</label>
                                <select class="form-select" name="prodi_ketua" id="program_studi" required>
                                    <option value="" selected="selected" hidden="hidden">Pilih Kategori</option>
                                    @foreach ($program_studi as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="nohp" class="form-label">No.hp Ketua Tim</label>
                                <input type="text" class="form-control" id="nohp" name="nohp_ketua" required>
                            </div>
                            <div class="mb-3">
                                <label for="ormawa" class="form-label">Ormawa</label>
                                <select class="form-select" name="nama_ormawa" id="ormawa" required>
                                    <option value="" selected="selected" hidden="hidden">Pilih Kategori</option>
                                    @foreach ($ormawa as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="judul" class="form-label">Judul</label>
                                <input type="text" class="form-control" id="judul" name="judul" required>
                            </div>
                            <div class="mb-3">
                                <label for="bidang" class="form-label">Bidang</label>
                                <select class="form-select" name="bidang_id" id="bidang" required>
                                    <option value="" selected="selected" hidden="hidden">Pilih Kategori</option>
                                    @foreach ($bidang as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <p>Pilih Lokasi</p>
                            <div class="mb-1">
                                <label for="province">Provinsi:</label>
                                <select class="form-select" id="province" name="province"
                                    aria-label="Default select example" required>
                                   
                                </select>
                            </div>
                            <div class="mb-1">
                                <label for="regency">Kabupaten:</label>
                                <select class="form-select" id="regency" name="regency" disabled>
                                    <option value="">Pilih Kabupaten</option>
                                </select>
                            </div>
                            <div class="mb-1">

                                <label for="district">Kecamatan:</label>
                                <select class="form-select" id="district" name="district" disabled>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>
                            <div class="mb-1">
                                <label for="village">Desa:</label>
                                <select class="form-select" id="village" name="village" disabled>
                                    <option value="">Pilih Desa</option>
                                </select>
                            </div>
                            {{-- <button type="button" id="next" class="btn btn-primary" onclick="nextStep()">Next</button> --}}
                        </div>

                        <!-- Step 2 -->
                        <div class="step">
                            <p>Surat Keputusan Organisasi</p>
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
                            <p>Surat pernyataan kerja sama dari khalayak sasaran yang diketahui oleh kepala desa</p>
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
                            <p>Surat kesediaan dosen pendamping untuk membimbing kegiatan Pro IDE</p>
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
                            <p>Proposal Pro-IDe</p>
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
                            {{-- <button type="button" class="btn btn-secondary" onclick="prevStep()">Back</button>
                        <button type="button" id="next" class="btn btn-primary" onclick="nextStep()">Next</button> --}}
                        </div>

                        <!-- step 3 -->
                        <div class="step">
                            <div id="team-members">
                                <div class="team-member">
                                    <div class="row g-2">
                                        <div class="col-lg-2 mb-3">
                                            <label for="nama" class="form-label">Nama</label>
                                            <input type="text" id="nama" name="anggota_tim[0][nama]"
                                                class="form-control">
                                        </div>
                                        <div class="col-lg-2 mb-3">
                                            <label for="nim" class="form-label">NIM</label>
                                            <input type="text" id="nim" name="anggota_tim[0][nim]"
                                                class="form-control">
                                        </div>
                                        <div class="col-lg-2 mb-3">
                                            <label for="prodi" class="form-label">Prodi</label>
                                            <input type="text" id="prodi" name="anggota_tim[0][prodi]"
                                                class="form-control">
                                        </div>
                                        <div class="col-lg-2 mb-3">
                                            <label for="fakultas" class="form-label">Fakultas</label>
                                            <input type="text" id="fakultas" name="anggota_tim[0][fakultas]"
                                                class="form-control">
                                        </div>
                                        <div class="col-lg-2 mb-3">
                                            <label for="jabatan" class="form-label">Jabatan</label>
                                            <input type="text" id="jabatan" name="anggota_tim[0][jabatan]"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <button type="button" onclick="addTeamMember()">Add Member</button><br>

                        </div>

                        <!-- Step 4 -->
                        <div class="step">
                            <div class="mb-3">
                                <label for="nama_dosen_pembimbing" class="form-label">Nama Dosen Pembimbing</label>
                                <input type="text" class="form-control" id="nama_dosen_pembimbing"
                                    name="nama_dosen_pembimbing" required>
                            </div>
                            <div class="mb-3">
                                <label for="nidn_dosen_pembimbing" class="form-label">NIDN Dosen Pembimbing</label>
                                <input type="text" class="form-control" id="nidn_dosen_pembimbing"
                                    name="nidn_dosen_pembimbing" required>
                            </div>
                            <div class="mb-3">
                                <label for="nohp_dosen_pembimbing" class="form-label">No.hp Dosen Pembimbing</label>
                                <input type="text" class="form-control" id="nohp_dosen_pembimbing"
                                    name="nohp_dosen_pembimbing" required>
                            </div>
                            {{-- <button type="button" class="btn btn-secondary" onclick="prevStep()">Back</button> --}}
                        </div>
                        <button type="button" id="prevStep" class="btn btn-secondary mt-2">Back</button>
                        <button type="button" id="next" class="btn btn-primary mt-2">Next</button>
                        <button type="submit" id="submitForm" class="btn btn-success">Submit</button>

                    </form>
                </div>
            @else
                <div class="w-100">
                    <div class="card flex-fill">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Status Pendaftaran</h5>
                        </div>
                        <table class="table table-hover my-0">
                            <thead>
                                <tr>
                                    <th>Nama Ketua</th>
                                    <th class="d-none d-xl-table-cell">NIM Ketua</th>
                                    <th class="d-none d-xl-table-cell">Fakultas Ketua</th>
                                    <th>Bidang</th>
                                    <th class="d-none d-md-table-cell">Judul</th>
                                    <th class="d-none d-md-table-cell">Status</th>
                                    <th class="d-none d-md-table-cell">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $item->nama_ketua }}</td>
                                        <td class="d-none d-xl-table-cell">{{ $item->nim_ketua }}</td>
                                        <td class="d-none d-xl-table-cell">{{ $item->fakultas_ketua }}</td>
                                        <td><span class="badge bg-success">{{ $item->bidang->nama }}</span></td>
                                        <td class="d-none d-md-table-cell">{{ $item->judul }}</td>
                                        <td><span
                                                class="badge text-bg-warning">{{ $item->registration_validation->status === 'valid' ? 'valid dan menunggu penilaian' : $item->registration_validation->status }}</span>
                                        </td>
                                        <td> <a href="/program/cek/{{ $item->id }}" class="btn btn-primary">Cek</a>
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
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

        // function nextStep() {
        //     if (currentStep < steps.length - 1) {
        //         currentStep++;
        //         showStep(currentStep);
        //         updateVisibility();
        //     }
        // }

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
                alert(data.message || 'Validation failed. Please check your inputs.');
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
                    alert(data.message || 'Submission failed. Please try again.');
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

        function addTeamMember() {
            if (memberCount >= 13) {
                alert('Maximum 13 team members allowed');
                return;
            }

            const template = `
        <div class="team-member">
            <div class="row g-2">
                <div class="col-lg-2 mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="anggota_tim[${memberCount}][nama]" class="form-control">
                </div>
                <div class="col-lg-2 mb-3">
                    <label for="nim" class="form-label">NIM</label>
                    <input type="text" name="anggota_tim[${memberCount}][nim]" class="form-control">
                </div>
                <div class="col-lg-2 mb-3">
                    <label for="prodi" class="form-label">Prodi</label>
                    <input type="text" name="anggota_tim[${memberCount}][prodi]" class="form-control">
                </div>
                <div class="col-lg-2 mb-3">
                    <label for="fakultas" class="form-label">Fakultas</label>
                    <input type="text" name="anggota_tim[${memberCount}][fakultas]" class="form-control">
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
        $(document).ready(function() {
            // Utility function to initialize Select2
            function initializeSelect2(elementId, placeholder) {
                return $(`#${elementId}`).select2({
                    placeholder: placeholder,
                    allowClear: true,
                    width: '100%'
                });
            }

            // Utility function to handle API errors
            function handleApiError(context) {
                return function(jqXHR, textStatus, errorThrown) {
                    console.error(`Error loading ${context}:`, textStatus, errorThrown);
                    alert(`Gagal memuat data ${context}. Silakan coba lagi.`);
                }
            }

            // Initialize Province dropdown
            $("#province").select2({
                placeholder: 'Pilih Provinsi',
                allowClear: true,
                ajax: {
                    url: "/api/provinces",
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
                    error: handleApiError('provinsi')
                }
            });

            // Initialize other dropdowns (initially disabled)
            initializeSelect2('regency', 'Pilih Kabupaten');
            initializeSelect2('district', 'Pilih Kecamatan');
            initializeSelect2('village', 'Pilih Desa/Kelurahan');

            // Handle Province Change
            $("#province").on('change', function() {
                const provinceId = $(this).val();
                const regencySelect = $("#regency");

                // Reset and disable dependent dropdowns
                ['regency', 'district', 'village'].forEach(type => {
                    $(`#${type}`).val(null).trigger('change').prop('disabled', true);
                });

                if (!provinceId) return;

                // Enable and configure regency dropdown
                regencySelect.prop('disabled', false);
                regencySelect.select2({
                    placeholder: 'Pilih Kabupaten',
                    allowClear: true,
                    ajax: {
                        url: `/api/regencies/${provinceId}`,
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
                        error: handleApiError('kabupaten')
                    }
                });
            });

            // Handle Regency Change
            $("#regency").on('change', function() {
                const regencyId = $(this).val();
                const districtSelect = $("#district");

                // Reset and disable dependent dropdowns
                ['district', 'village'].forEach(type => {
                    $(`#${type}`).val(null).trigger('change').prop('disabled', true);
                });

                if (!regencyId) return;

                // Enable and configure district dropdown
                districtSelect.prop('disabled', false);
                districtSelect.select2({
                    placeholder: 'Pilih Kecamatan',
                    allowClear: true,
                    ajax: {
                        url: `/api/districts/${regencyId}`,
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
            $("#district").on('change', function() {
                const districtId = $(this).val();
                const villageSelect = $("#village");

                // Reset and disable village dropdown
                villageSelect.val(null).trigger('change').prop('disabled', true);

                if (!districtId) return;

                // Enable and configure village dropdown
                villageSelect.prop('disabled', false);
                villageSelect.select2({
                    placeholder: 'Pilih Desa/Kelurahan',
                    allowClear: true,
                    ajax: {
                        url: `/api/villages/${districtId}`,
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
        });
    </script>
@endsection
