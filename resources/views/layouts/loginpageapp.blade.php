<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- ICON -->
    <link rel="icon" type="image/png" href="{{ asset('media/BUHS-icon.ico') }}">

    <title>{{ config('app.name', 'BU-Care') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    
    <!--style-->
    <link rel="stylesheet" href={{ asset('css/bootstrap.min.css') }}>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="{{ asset('js/jquery-3.6.4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
<style>
    html{
        margin: 0;
        padding: 0;
        overflow-x: hidden;
        width: 100%;
    }
    body {
        font-family: 'Nunito', sans-serif;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
        width: 100%;
    }
    .was-validated .form-control:valid {
        background-image: none;
        padding-right: 0.75em;
    }
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        /* display: none; <- Crashes Chrome on hover */
        -webkit-appearance: none;
        margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
    }
</style>
</head>

<body>
        <main class="py">
            @yield('content')
        </main>
</body>
</html>