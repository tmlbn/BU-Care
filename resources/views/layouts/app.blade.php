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

        /* Navbar color scheme */
        .main-navbar {
        background-color: white;
        background-image: linear-gradient(to right, white 33.3%, #f1731f 33.3%, #f1731f 66.6%, #009edf 66.6%);
        }
    
        /* Brand image */
    
        .navbar-nav {
        margin: 0 auto;
        }
    
        .nav-link {
        color: white;
        }
    
        /* Disabled medical form */
        .nav-link.disabled {
        color: rgba(255, 255, 255, 0.5);
        }
    
        .navbar{
            position: sticky;
            top: 0;
            z-index: 1000;
        }
    
        .main-navbar{
        border-bottom: 1px solid #ccc;
        }
        .main-navbar .top-navbar{
            padding-top: 5px;
            padding-bottom: 5px;
        }
        .main-navbar .top-navbar .brand-name{
            color: #fff;
        }
        .main-navbar .top-navbar .nav-link{
            color: #fff;
            font-size: 16px;
            font-weight: 500;
        }
        .main-navbar .top-navbar .dropdown-menu{
            padding: 0px 0px;
            border-radius: 0px;
        }
        .main-navbar .top-navbar .dropdown-menu .dropdown-item{
            padding: 8px 16px;
            border-bottom: 1px solid #ccc;
            font-size: 14px;
        }
        .main-navbar .top-navbar .dropdown-menu .dropdown-item i{
            width: 20px;
            text-align: center;
            color: #2874f0;
            font-size: 14px;
        }
        .main-navbar .navbar{
            padding: 0px;
            background-color: #ddd;
        }
        .main-navbar .navbar .nav-item .nav-link{
            padding: 8px 20px;
            color: #000;
            font-size: 15px;
        }

        .text-responsive{
            color:black;
        }
        @media (max-width: 650px) {
            .text-responsive{
                color: white;
            }
        }
    
        @media only screen and (min-width: 800px) {
            .main-navbar .top-navbar .nav-link{
                font-size: 12px;
                padding: 8px 10px;
            }
            .main-navbar img{
                height:50%;
            }
        }
        @media only screen and (max-width: 150%) {
            .vr {
                display: none;
            }
        }
    
        a.inactive {
            color: #007bff;
            transition: color 0.3s ease;
        }
    
        a.inactive:hover{
            color: #f1731f;
        }
        
        a.nav-link.active {
            color: #f1731f !important;
            border-bottom: 2px solid #f1731f;
        }   
        .textOrange{
            color: #f1731f !important;
        }
    
        .dropdown-menu {
            transition: transform 0.3s ease-in-out 0.3s; /* added delay of 0.1s */
            transform: translateY(-10px);
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            float: left;
            min-width: 10rem;
            padding: 0.5rem 0;
            margin: 0.125rem 0 0;
            font-size: 1rem;
            color: #212529;
            text-align: left;
            list-style: none;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: 0.25rem;
        }
    
        .dropdown-menu.show {
            transform: translateY(0);
            display: block;
        }
           
    </style>
</head>

<body>
    <div class="main-navbar shadow-sm">
        <div class="top-navbar">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-2 d-none d-sm-none d-md-block d-lg-block ms-5 my-1" style="height:45px; width:170px;">
                        <img src="{{ asset('media/BU-Carelogo1.png') }}" alt="" class="img-fluid" style="height:90%;">
                    </div>
                </div>
            </div>
        </div>
    </div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand d-block d-sm-block d-md-none d-lg-none" href="#">
                    <img src="{{ asset('media/BU-Carelogo1.png') }}" alt="" style="height:40px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link fs-5 {{ Route::currentRouteName() === 'home' ? 'active' : 'inactive' }}" href="{{ route('home') }}">HOME</a>
                        </li>
                        <li class="nav-item mr-4">
                            <a class="nav-link fs-5 {{ Route::currentRouteName() === 'setAppointment.show' ? 'active' : 'inactive' }}" href="{{ route('setAppointment.show') }}">SET APPOINTMENT</a>
                        </li>
                        <li class="pt-2 mt-1">
                            <div class="vr pt-4"></div>
                        </li>
                        <li class="nav-item dropdown">
                            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex flex-row">
                                <li class="nav-item dropdown d-flex align-items-center">
                                    <a class="nav-link dropdown-toggle text-primary fs-5" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="white-space: nowrap;">
                                        {{ Auth()->user()->first_name }}
                                        @if (Auth::user()->hasMedRecord)
                                                @if (Auth::user()->hasValidatedRecord)
                                                    <i class="bi bi-patch-check" style="color:#f1731f;" data-toggle="tooltip" data-container="body" data-bs-placement="top" title="Validated Medical Record"></i>
                                                @else
                                                    <i class="bi bi-file-earmark-medical" style="color:#f1731f;" data-toggle="tooltip" data-container="body" data-bs-placement="top" title="Submitted Medical Record"></i>
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
                    </ul>
                </div>
            </div>
        </nav>

        @if(session('fail'))
            <div class="alert alert-danger text-center d-flex align-items-center justify-content-center">
                {{ session('fail') }}
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-danger">
                {{ session('success') }}
            </div>
        @endif
        @if(session('alreadySubmitted'))
            <div class="alert alert-danger">
                {{ session('alreadySubmitted') }}
            </div>
        @endif

        <main class="py">
            @yield('content')
        </main>
</body>
</html>

