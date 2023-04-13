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
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.print.min.css' rel='stylesheet' media='print' />
    <link href='https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap/main.css' rel='stylesheet' />


    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.6.4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    <script src="https://use.fontawesome.com/03f8a0ebd4.js"></script>

    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
            $('[data-bs-toggle="popover"]').popover()
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
            .nav-link{
                size: 16px;
            }
        }

        .text-responsive{
            color:black;
        }
        @media (max-width: 650px) {
            .text-responsive{
                color: white;
            }
        }
        .login-responsive{
            color:white;
        }
        @media (max-width: 650px) {
            .login-responsive{
                color: black;
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

        .btn-orange:hover,
        .btn-orange.active {
            color: black;
            background: #f1731f;
            border: 2px solid #f1731f;
        }

        .pillars-bg{
            background-repeat: no-repeat; 
            background-size:100%;
            background-image:url({{ asset('media/pillars.jpg') }}); 
        }
        a.loginButton {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 0.25rem;
            text-decoration: none;
            font-size: 1rem;
            line-height: 1.5;
            width: 115px;
            text-align: center; /* center the text horizontally */
        }
        a.loginButton:hover,
        a.loginButton.active{
            background-color: #f1731f;
            color: black;
            text-decoration: none;
            transition: 0.3s;
        }
    </style>

</head>
    <body class="antialiased">
        <header class="fw-normal">
            <div class="container-fluid">
                <div class="row bg-whitetoblue py-3">
                    <div class="col-md-4">
                        <a class="mb-4 md:mb-0 mt-4 ms-5" href="{{ route('home') }}">
                            <img src="{{ asset('media/BU-Carelogo1.png') }}" alt="" class="img-fluid" style="height: 60px;">
                        </a>
                    </div>
                    <div class="col-md-4 text-center my-auto">
                        <nav class="my-auto">
                            <div class="row row-cols-xl-4 row-cols-lg-1 my-auto">
                                <div class="col-xl-3 col-lg-6 col-md-6 mx-auto">
                                    <a class="nav-link fs-5 {{ Route::currentRouteName() === 'home' ? 'active' : '' }} text-decoration-none" href="{{ route('home') }}">Home</a>
                                </div>
                                <div class="col-xl-5 col-lg-12 col-md-12 mx-auto order-xl-1 order-lg-2">
                                    <a class="nav-link fs-5 {{ Route::currentRouteName() === 'appointments' ? 'active' : '' }} text-decoration-none" href="#">Set Appointment</a>
                                </div>
                                <div class="col-xl-3 col-lg-6 col-md-6 mx-auto order-xl-2 order-lg-1">
                                    <a class="nav-link fs-5 {{ Route::currentRouteName() === 'about' ? 'active' : '' }} text-decoration-none" href="#">About</a>
                                </div>
                            </div>
                        </nav>
                    </div>
                    <div class="col-md-4 d-flex justify-content-end my-auto">
                        <nav class="mb-1 md:ml-4 md:py-1 md:pl-4 me-5"> 
                            <button type="button" id="loginButton" class="btn btn-orange rounded d-inline-flex" data-toggle="popover" data-bs-html="true" title="Login as:">
                                <span class="login-reponsive">
                                    Login
                                </span>
                            </button>
                            <script>
                                $(document).ready(function(){
                                    $('[data-toggle="popover"]').popover({
                                        placement : 'top',
                                        html : true,
                                        content : '<a class="loginButton my-1" href="{{ route('login') }}">Student</a><br><a class="loginButton my-1" href="{{ route('personnel.login') }}">Personnel</a>'
                                    });
                                    $(document).on("click", ".popover .close" , function(){
                                        $(this).parents(".popover").popover('hide');
                                    });
                                    $('#loginButton').on('click', function() {
                                        if($(this).hasClass('active')){
                                            $(this).removeClass('active');
                                        }else{
                                            $(this).addClass('active');
                                        }
                                    });
                                });
                                </script>


                        </nav>
                    </div>
                </div>
            </div>
        </header>
        
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

        <main class="py">
            @yield('content')
        </main>
    </body>
</html>