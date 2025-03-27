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
    <title>Document</title>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow p-4" style="max-width: 500px; width: 100%;">
            <div class="card-body text-center">
                <h2 class="fw-bold">Verifikasi Email</h2>
                <p class="text-muted">Sebelum melanjutkan, silakan periksa email Anda untuk tautan verifikasi.</p>

                @if (session('resent'))
                    <div class="alert alert-success">
                        Tautan verifikasi baru telah dikirim ke email Anda.
                    </div>
                @endif

                <form method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100">Kirim Ulang Email Verifikasi</button>
                </form>

                <p class="mt-3">
                    Jika Anda mengalami masalah, hubungi <a href="mailto:support@pro-ide.com">support@pro-ide.com</a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
