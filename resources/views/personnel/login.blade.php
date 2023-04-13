@extends('layouts.loginpageapp')
@section('content')

<style>
            .img {
              max-width:100%;
              max-height:100%;
              object-fit: contain;
            }
            .logo {
              height:300px;
              width:450px;
            }
      
            .login {
              min-height: 100vh;
            }
            
            .bg-image {
              background-size: contain;
              background-position: center;
            }
            
            .login-heading {
              font-weight: 300;
            }
            
            .btn-login {
              font-size: 0.9rem;
              letter-spacing: 0.05rem;
              padding: 0.75rem 1rem;
            }
            .bucarelogo{
              width:100%;
              height:100%;
              object-fit: contain;
            }
            .bucarebgcolor{
                background-color:#0b1c2e;
            }
            @media screen and (max-width: 800px) {
              .d-none-at-zoom {
                display: none !important;
              }
            }

</style>

<div class="container-fluid ps-md-0 bucarebgcolor">
    <div class="row g-0">
        <div class="d-none d-md-flex col-md-6 col-lg-6">
            <img src="{{ asset('media/BUTorch.jpg') }}" alt="BUTorch.jpg" class="img-fluid" draggable="false"> 
        </div>
        <div class="col-md-6 col-lg-6">
            <div class="login d-flex align-items-center ">
                <div class="container">
                    <div class="row">
                            <div class="col-md-10 col-lg-10 col-sm-12 mx-auto my-auto">
                                    <p class="h1 pb-3 text-light">Personnel Log in</p>
                                <!-- old student login form -->
                                <form method="POST" action="{{ route('BUCare.login') }}" class="rounded bg-light p-4 oldDisplay" id="oldStudentLoginForm" style="display:block;">
                                    @csrf
                                    
                                    @if (Session::has('fail'))
                                      <div class="alert alert-danger"> {{ Session::get('fail') }} </div>
                                    @endif
                                    @if (Session::has('success'))
                                      <div class="alert alert-danger"> {{ Session::get('success') }} </div>
                                    @endif

                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="personnelID" name="personnelID" value="{{ old('personnelID') }}" placeholder="Student ID Number" required autocomplete="personnelID" autofocus>
                                            <label for="floatingInput">Personnel ID Number</label>
                                            <span class="text-danger"> 
                                              @error('personnelID') 
                                                {{  $message }} 
                                              @enderror
                                            </span>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required autocomplete="current-password">
                                            <label for="floatingInput">Password</label>
                                            <span class="text-danger"> 
                                              @error('password') 
                                                {{ $message }} 
                                              @enderror
                                            </span>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" value="1" name="remember" id="remember">
                                            <label class="form-check-label" for="rememberPasswordCheck">
                                                <p class="text-dark">Remember password</p>
                                            </label>
                                        </div>
                                        <div class="d-grid">
                                            <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="submit">Log in</button>
                                        </div>
                                            @if($errors->any())
                                              <h4>{{$errors->first()}}</h4>
                                            @endif
                                </form>
                        </div>
                    </div>  
              </div>
          </div>
      </div>
  </div>
</div>
@endsection