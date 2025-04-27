<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/x-icon" href="/assets/unja.png">
    <meta name="description" content="Pro-IDe Universitas Jambi">
    <meta name="author" content="Pro-IDe">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords"
        content="Pro-IDe, Universitas Jambi, Pro-IDe Universitas Jambi, UNJA, PKM, UKM, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="canonical" href="https://demo-basic.adminkit.io/" />

    <title>PRO-IDE</title>

    <link href="/css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="wrapper">
      @include('layout.aside')

        <div class="main">
            @include('layout.navbar', ['title' => View::yieldContent('title'), 'description' => View::yieldContent('description')])

            <main class="content">
                <div class="container-fluid p-0">

                    @yield('content')
                    
                </div>
            </main>

           @include('layout.footer')
        </div>
    </div>

    <script src="/js/app.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> --}}
    <script src="https://kit.fontawesome.com/f10456a175.js" crossorigin="anonymous"></script>

</body>

</html>
