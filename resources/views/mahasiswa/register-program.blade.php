{{-- resources/views/registration/create.blade.php --}}
@extends('layout.app')

@section('content')
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
                                <label for="prodi" class="form-label">Prodi Ketua Tim</label>
                                <input type="text" class="form-control" id="prodi" name="prodi_ketua" required>
                            </div>
                            <div class="mb-3">
                                <label for="fakultas" class="form-label">Fakultas Ketua Tim</label>
                                <input type="text" class="form-control" id="fakultas" name="fakultas_ketua" required>
                            </div>
                            <div class="mb-3">
                                <label for="nohp" class="form-label">No.hp Ketua Tim</label>
                                <input type="text" class="form-control" id="nohp" name="nohp_ketua" required>
                            </div>
                            <div class="mb-3">
                                <label for="ormawa" class="form-label">Nama ORMAWA</label>
                                <input type="text" class="form-control" id="ormawa" name="nama_ormawa" required>
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
                        <button type="button" id="prevStep" class="btn btn-secondary">Back</button>
                        <button type="button" id="next" class="btn btn-primary">Next</button>
                        <button type="submit" id="submitForm" class="btn btn-success">Submit</button>

                    </form>
                </div>
            @else
                <div class="alert alert-info"
                    style="display: flex; align-items: center; padding: 10px; border: 1px solid #007bff; border-radius: 5px; background-color: #e7f3ff; color: #007bff;">
                    <i class="fas fa-check-circle" style="font-size: 24px; margin-right: 10px;"></i>
                    <span>You have already registered. Please check your dashboard for more information.</span>
                </div>
            @endif
        </div>
    </div>

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



        // Optional form submission handler
        // document.getElementById('registrationForm').addEventListener('submit', function(event) {
        //     event.preventDefault();

        //     // Gather all form data
        //     const formData = new FormData(this);

        //     // Example output in console (replace with your form handling logic)
        //     for (let [name, value] of formData.entries()) {
        //         console.log(`${name}: ${value}`);
        //     }

        //     alert('Form Submitted Successfully!');
        // });
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
@endsection
