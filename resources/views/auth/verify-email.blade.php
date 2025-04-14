<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="/assets/unja.png">

    <title>Pro-IDe - Verifikasi Email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background: rgba(6, 77, 63, 1);
            color: #fff;
        }
        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .btn-primary {
            background: #000DFF;
            border: none;
        }
        .btn-primary:hover {
            background: #6B73FF;
        }
        .text-muted {
            color: #6c757d !important;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-lg p-4" style="max-width: 500px; width: 100%;">
            <div class="card-body text-center">
                <img src="/assets/email-verification.jpg" alt="Verifikasi Email" class="mb-3" width="200">
                <h2 class="fw-bold text-dark">Verifikasi Email</h2>
                <p class="text-muted">Sebelum melanjutkan, silakan periksa email Anda untuk tautan verifikasi.</p>

                @if (session('resent'))
                    <div class="alert alert-success">
                        Tautan verifikasi baru telah dikirim ke email Anda.
                    </div>
                @endif

                <form method="POST" action="{{route('verification.send')}}">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100">Kirim Ulang Email Verifikasi</button>
                </form>

                <p class="mt-3 text-dark">
                    Jika Anda mengalami masalah, hubungi <a href="admin@proide.unja.ac.id" class="text-primary">admin@proide.unja.ac.id</a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
