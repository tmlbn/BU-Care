<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BU-Care') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.6.4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    <script src="https://use.fontawesome.com/03f8a0ebd4.js"></script>

    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

    <!--style-->
    @vite(['resources/sass/app.scss'])
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/design.css') }}">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        .bg-whitetoblue{
            background-color: white;
            background-image: linear-gradient(to right, white 33.3%, #f1731f 33.3%, #f1731f 66.6%, #009edf 66.6%);
        }

        @media (max-width: 700px) {
            .bg-whitetoblue {
                background-image: none;
            }
        }

        .nav-link.dropdown-toggle::before {
            display: none;
        }

        .nav-link.active {
            color: #007bff !important;
            border-bottom: 2px solid #007bff !important;            
        }

        .nav-link {
            color: #30455c;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #007bff;            
        }

        .textOrange{
            color: #f1731f !important;
        }

        .btn-orange{
            color: white;
            border: 2px solid white;
        }

        .btn-orange:hover{
            color: black;
            background: #f1731f;
            border: 2px solid #f1731f;
        }
    </style>

</head>
    <body class="antialiased">
        <header class="text-gray-600 body-font">
            <div class="container-fluid">
                <div class="row items-center bg-whitetoblue py-3">
                    <div class="col-md-4">
                        <a class="mb-4 md:mb-0 mt-4 ms-5" href="{{ route('home') }}">
                            <img src="{{ asset('media/BU-Carelogo1.png') }}" alt="" class="img-fluid" style="height: 60px;">
                        </a>
                    </div>
                    <div class="col-md-4 text-center my-auto mx-auto">
                        <nav class="my-auto md:ml-4 md:py-1 md:pl-4 flex flex-wrap">
                            <div class="row justify-content-sm-center mx-auto">
                                <div class="col-md-auto col-sm-2">
                                    <a class="nav-link fs-5 {{ Route::currentRouteName() === 'home' ? 'active' : '' }} text-decoration-none" href="{{ route('home') }}">Home</a>
                                </div>
                                <div class="col-md-auto col-sm-2">
                                    <a class="nav-link fs-5 {{ Route::currentRouteName() === 'contacts' ? 'active' : '' }} text-decoration-none" href="#">Contact</a>
                                </div>
                                <div class="col-md-auto col-sm-3">
                                    <a class="nav-link fs-5 {{ Route::currentRouteName() === 'appointments' ? 'active' : '' }} text-decoration-none" href="#">Set Appointment</a>
                                </div>
                                <div class="col-md-auto col-sm-2">
                                    <a class="nav-link fs-5 {{ Route::currentRouteName() === 'about' ? 'active' : '' }} text-decoration-none" href="#">About</a>
                                </div>
                            </div>
                        </nav>
                    </div>                    
                    <div class="col-md-4 d-flex justify-content-end my-auto">
                        <nav class="mb-1 md:ml-4 md:py-1 md:pl-4 me-5">
                            <a href="{{ route('login') }}">
                                <button type="button" class="btn btn-orange rounded">Login</button>
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
        </header>
        @yield('content')    
    </body>
</html>