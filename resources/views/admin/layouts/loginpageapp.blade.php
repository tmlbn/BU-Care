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
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <script src="https://use.fontawesome.com/03f8a0ebd4.js"></script>
    
    <!--style-->
    <link rel="stylesheet" href={{ asset('css/bootstrap.min.css') }}>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss'])
    <script src="{{ asset('js/jquery-3.6.4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

</head>
<style>
    body {
        font-family: 'Nunito', sans-serif;
    }
</style>

<body>
        <main class="py">
            @yield('content')
        </main>
</body>
</html>