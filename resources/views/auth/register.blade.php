<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="/assets/unja.png">

    <title>Pro-IDe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background: rgba(6, 77, 63, 1);

        }

        wave-container {
            position: relative;
            width: 100%;
            height: 200px;
            /* Sesuaikan tinggi gelombang */
            bottom: 0;

            overflow: hidden;
        }

        .wave {
            position: absolute;
            width: 100%;
            z-index: -1;
            height: auto;
            bottom: 0;
        }

        .wave.left {
            left: 0;

            /* z-index:1; */
        }

        .wave.right {
            left: 0;
            width: 70%;
            /* transform: scaleX(-1); */
        }



        .card {
            width: 1032px;
            height: 605px;
            background: rgba(255, 255, 255, 1);
            border-radius: 20px;

        }

        .form-control {
            background: rgba(240, 240, 240, 1);
            border: Mixed solid rgba(0, 0, 0, 1);
        }

        .btn {
            background: rgba(6, 77, 63, 1);
            color: white;

        }

        @media (max-width: 992px) {
            .card {
                max-width: 500px;
                margin: auto;
            }

            .wave {
                display: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
            }
        }

        @media (max-width: 576px) {
            .card {
                max-width: 400px;
                margin: auto;
            }

            /* Untuk layar HP */
            .wave-container {
                display: none !important;
            }

            .wave {
                display: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
            }
        }

        @media (max-width: 450px) {

            /*  */
            .wave-container {
                display: hidden !important;
            }

            .wave {
                display: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
            }
        }
    </style>
</head>

<body>

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="row ">
            <div class="col-12 col-md-10 col-lg-6">
                <div class="card shadow-lg p-4">
                    @if (session()->has('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session()->has('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="card-body">
                        <h4 class="text-center fw-bold fs-2 mt-3">Selamat Datang</h4>
                        <p class="text-center fw-medium">Daftar Akun Anda</p>
                        <form method="POST" action="{{ route('register.create') }}">
                            @csrf

                            <!-- Email Input -->
                            <div class="form-group mb-2">
                                <label for="username">Username</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="username" name="name" value="{{ old('name') }}" required>
                            </div>
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group mb-2">
                                <label for="nim">NIM</label>
                                <input type="text" class="form-control @error('nim') is-invalid @enderror"
                                    id="nim" name="nim" value="{{ old('nim') }}" required>
                            </div>
                            @error('nim')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group mb-2">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" required>
                            </div>
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <!-- Password Input -->
                            <div class="form-group mb-2">
                                <label for="password">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" value="{{ old('password') }}" required>
                            </div>
                            @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group mb-2">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password_confirmation" name="password_confirmation"
                                    value="{{ old('password') }}" required>
                            </div>

                            <!-- Remember Me Checkbox -->


                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary w-100 mt-3">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="wave-container d-none d-md-block">
            <img class="wave right" src="/assets/vector2.svg" alt="Wave Right">
            <img class="wave left" src="/assets/vektor-login.png" alt="Wave Left">
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        < script >
            function hideWaveOnSmallScreens() {
                if (window.innerWidth <= 992) { // Target layar notepad & HP
                    document.querySelectorAll(".wave").forEach(el => el.style.display = "none");
                }
            }

        hideWaveOnSmallScreens(); // Jalankan saat halaman dimuat

        window.addEventListener("resize", hideWaveOnSmallScreens); // Jalankan saat ukuran layar berubah
    </script>
    </script>
</body>

</html>
