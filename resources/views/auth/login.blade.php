<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background: rgba(6, 77, 63, 1);

        }

        wave-container {
            position: relative;
            width: 100%;
            height: 250px;
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
            /* transform: scaleX(-1); */
        }

        .wave-container::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 10px;
            /* Sesuaikan tinggi efek */

            /* Gradient dari warna wave ke putih */
            background: linear-gradient(to bottom,
                    rgba(255, 255, 255, 0) 0%,
                    rgba(255, 255, 255, 1) 100%);
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
    </style>
</head>

<body>

    <div class="container d-flex justify-content-center align-items-center vh-100">

        <div class="row w-100 justify-content-center">
            <div class="col-md-10">
                <div class="card">
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
                        <p class="text-center fw-medium">Masuk Untuk Mengakses Akun Anda</p>

                        <form method="POST" class="pt-5 mx-5" action="{{ route('login.create') }}">
                            @csrf

                            <!-- Email Input -->
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Nama Pengguna atau Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}"
                                    placeholder="Masukkan Nama Pengguna atau Email" required>
                            </div>
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <!-- Password Input -->
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Kata Sandi</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Masukkan Kata Sandi" required>
                            </div>
                            @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <!-- Remember Me Checkbox -->
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Ingat Saya</label>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-block w-100 mt-3">Masuk</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="wave-container">
        <img class="wave right" src="/assets/vector2.svg" alt="Wave Right">
        <img class="wave left" src="/assets/vektor-login.png" alt="Wave Left">

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
