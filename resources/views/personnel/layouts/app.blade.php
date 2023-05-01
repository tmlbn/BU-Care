<!doctype html>
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
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.print.min.css' rel='stylesheet' media='print' />
    <link href='https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap/main.css' rel='stylesheet' />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.6.4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://momentjs.com/downloads/moment-timezone-with-data.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    <script src="https://use.fontawesome.com/03f8a0ebd4.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>

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
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            /* display: none; <- Crashes Chrome on hover */
            -webkit-appearance: none;
            margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
        }

        input[type=number] {
            -moz-appearance:textfield; /* Firefox */
        }

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
        .icon {
            position: relative;
            top: -4px; /* adjust the value as needed */
        }
        .pillars-bg{
            background-repeat: no-repeat; 
            background-size:100%;
            background-image:url({{ asset('media/pillars.jpg') }}); 
        }
        .dropdown-toggle{
            color: #f1731f !important;
        }
        
    </style>
</head>

<body>
    <div class="main-navbar shadow-sm">
        <div class="top-navbar">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-2 d-none d-sm-none d-md-block d-lg-block ms-5 my-1" style="height:45px; width:170px;">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('media/BU-Carelogo1.png') }}" alt="" class="img-fluid" style="height:90%;">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <nav class="navbar navbar-expand-lg bg-body-tertiary navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand d-block d-sm-block d-md-none d-lg-none" href="{{ route('home') }}">
                    <img src="{{ asset('media/BU-Carelogo1.png') }}" alt="" style="height:40px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarOffcanvasLg" aria-controls="navbarOffcanvasLg" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-start" tabindex="-1" id="navbarOffcanvasLg" aria-labelledby="navbarOffcanvasLgLabel">
                    <div class="offcanvas-header">
                        <div class="col-5">
                            <img src="{{ asset('media/BU-Carelogo1.png') }}" class="img-fluid offcanvas-title d-block" id="offcanvasNavbarLabel" alt="">
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                      </div>
                    <ul class="navbar-nav ms-auto mb-1 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link fs-5 {{ Route::currentRouteName() === 'home' ? 'active' : 'inactive' }}" href="{{ route('home') }}">HOME</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-5 {{ Route::currentRouteName() === 'setAppointment.show' ? 'active' : 'inactive' }}" href="{{ route('setAppointment.show') }}">SET APPOINTMENT</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-5 {{ Route::currentRouteName() === 'personnel.medicalForm.show' ? 'active' : 'inactive' }}" href="{{ route('personnel.medicalForm.show') }}" style="{{ Auth::guard('employee')->user()->hasMedRecord == 1 ? 'display: none;' : '' }}">SUBMIT MEDICAL RECORD</a>
                        </li>
                        <li class="pt-2 mt-1">
                            <div class="vr pt-4"></div>
                            <div class="vr pt-4"></div>
                            <div class="vr pt-4"></div>
                        </li>
                        <li class="nav-item dropdown">
                            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex flex-row">
                                <li class="nav-item dropdown align-items-center">
                                    <a class="nav-link dropdown-toggle text-primary fs-5 align-items-center" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="white-space: nowrap;">
                                        {{ Auth::guard('employee')->user()->first_name }}
                                        @if(Auth::guard('employee')->user()->hasMedRecord)
                                            @if(Auth::guard('employee')->user()->hasValidatedRecord)
                                                <!-- HAS VALIDATED MEDICAL RECORD -->
                                                <i class="bi bi-person-check icon" style="color:#007bff;" data-toggle="tooltip" data-container="body" data-bs-placement="top" title="Validated Medical Record"></i>
                                            @else
                                                <!-- HAS MEDICAL RECORD BUT NOT VALIDATED -->
                                                <i class="bi bi-file-earmark-medical icon" style="color:#007bff;" data-toggle="tooltip" data-container="body" data-bs-placement="top" title="Submitted Medical Record"></i>
                                            @endif
                                        @else
                                            <!-- NO MEDICAL RECORD -->
                                            <i class="bi bi-person-x icon" style="color:#007bff;" data-toggle="tooltip" data-container="body" data-bs-placement="top" title="No Medical Record"></i>
                                        @endif
                                    </a>
                                    
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item" href="#">My Appointments History</a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
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

        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <!-- Check Symbol -->
            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
              <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </symbol>
            <!-- Exclamation Symbol -->
            <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
            </symbol>
          </svg>

        @if(session('fail'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center justify-content-center" style="height:70px;" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div class="text-center mt-3">
                    <p class="alert-heading fs-4 fw-bold p-2">Error!</p>
                </div>
                <div class="vr"></div>
                <div class="text-center mt-3 p-2">
                    <p class="fs-5">{{ session('fail') }}</p>
                </div>
                <button type="button" class="btn-close mt-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-center" style="height:70px;" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#check-circle-fill"/></svg>
                <div class="text-center mt-3">
                    <p class="alert-heading fs-4 fw-bold p-2">Success!</p>
                </div>
                <div class="vr"></div>
                <div class="text-center mt-3 p-2">
                    <p class="fs-5">{{ session('success') }}</p>
                </div>
                <button type="button" class="btn-close mt-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center justify-content-center" style="height:70px;" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#check-circle-fill"/></svg>
                <div class="text-center mt-3 p-2">
                    <p class="fs-5">{{ session('warning') }}</p>
                </div>
                <button type="button" class="btn-close mt-2" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <main class="py">
            @yield('content')
        </main>
</body>
</html>

