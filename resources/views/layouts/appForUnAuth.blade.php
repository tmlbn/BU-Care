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

        .door-icon:hover {
            transform: rotateY(180deg);
        }

        .door-icon:before {
            transition: opacity 0.5s ease;
        }

        .door-icon:hover:before {
            content: "\f307";
            font-family: "bootstrap-icons";
            opacity: 0;
        }

        .door-icon:hover:before {
            opacity: 1;
        }
        .nav-link.dropdown-toggle::before {
            display: none;
        }
    </style>

</head>
<body class="antialiased">
    <header class="text-gray-600 body-font">
        <div class="container-fluid">
            <div class="row items-center bg-whitetoblue py-3">
                <div class="col-md-4">
                    <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0 mt-4 ms-5">
                        <img src="{{ asset('media/BU-Carelogo1.png') }}" alt="" class="img-fluid" style="width:35%;">
                    </a>
                </div>
                <div class="col-md-4 text-center">
                    <nav class="my-auto md:ml-4 md:py-1 md:pl-4 flex flex-wrap">
                        <a class="me-5 transition ease-in-out duration-300 hover:text-slate-50 fs-5" href="#">Home</a>
                        <a class="me-5 transition ease-in-out duration-300 hover:text-slate-50 fs-5" href="#">Contact</a>
                        <a class="me-5 transition ease-in-out duration-300 hover:text-slate-50 fs-5" href="#">Set Appointment</a>
                        <a class="me-1 transition ease-in-out duration-300 hover:text-slate-50 fs-5" href="#">About</a>
                    </nav>
                </div>
                <div class="col-md-4 d-flex justify-content-end">
                    <nav class="mb-1 md:ml-4 md:py-1 md:pl-4 me-5">
                        @if (Auth::check())
                        <li class="nav-item dropdown">
                            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex flex-row">
                                <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle fs-5" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="white-space: nowrap; color:white;">
                                            {{ Auth()->user()->first_name }} 
                                            @if (Auth::user()->hasMedRecord)
                                                @if (Auth::user()->hasValidatedRecord)
                                                    <i class="bi bi-patch-check" style="color:#f1731f; margin-top:-2px !important;" data-toggle="tooltip" data-container="body" data-bs-placement="top" title="Validated Medical Record"></i>
                                                @else
                                                    <i class="bi bi-file-earmark-medical" style="color:#f1731f; margin-top:30px !important;" data-toggle="tooltip" data-container="body" data-bs-placement="top" title="Submitted Medical Record"></i>
                                                @endif
                                            @endif
                                        </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item" href="#">Profile</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="dropdown-item" style="{{ Auth::user()->hasMedRecord ? 'display:none;' : '' }}" href="{{ route('medicalForm.show') }}">Submit My Medical Form</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">My Appointments History</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
        
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </li>
                            </ul>
                        </li>
                        @else
                        <a href="{{ route('login') }}">
                            <!--<span><p class="fs-3">Login</p></span> -->
                            <i class="bi bi-door-closed door-icon fs-2" style="color:#f1731f;" data-toggle="tooltip" data-bs-placement="top" title="Login"></i>
                        </a>
                        @endif
                    </nav>
                </div>
      </header>

    @yield('content')


    @include('layouts.partial.footer')


    
</body>
</html>