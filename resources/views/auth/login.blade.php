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
                                    <p class="h1 pb-3 text-light">Log in</p>
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
                                            <input type="text" class="form-control" id="studentID" name="studentID" value="{{ old('studentID') }}" placeholder="Student ID Number" required autocomplete="studentID" autofocus>
                                            <label for="floatingInput">Student ID Number</label>
                                            <span class="text-danger"> 
                                              @error('studentID') 
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
                                            <input class="form-check-input" type="checkbox" value="" id="rememberPasswordCheck">
                                            <label class="form-check-label" for="rememberPasswordCheck">
                                                <p class="text-dark">Remember password</p>
                                            </label>
                                        </div>
                                        <div class="d-grid">
                                            <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="submit">Log in</button>
                                        </div>
                                            <div class="md:mb-0">
                                                <center>
                                                        <a class="btn btn-link trigger" id="switchForms" @disabled($errors->isNotEmpty())>
                                                        I am a new student.
                                                        </a>
                                                </center>
                                            </div>
                                            @if($errors->any())
                                              <h4>{{$errors->first()}}</h4>
                                            @endif
                                      <!-- BUTTON TO SWITCH FORMS -->
                                            <script>
                                              $('#switchForms').click(function() {
                                              // remove required attribute to old student login form
                                                  $('#studentID').removeAttr('required');
                                                  $('#password').removeAttr('required');
                                              // Hides the old student login form
                                              $('#oldStudentLoginForm').slideUp(300);

                                              //shows the new student login form
                                              $('#newStudentLoginForm').slideDown(600);
                                              // add required attribute to new student login form
                                                  $('#applicantID').attr('required',true);
                                                  $('#applicantBirthMonth').attr('required',true);
                                                  $('#applicantBirthDate').attr('required',true);
                                                  $('#applicantBirthYear').attr('required',true);
                                          });
                                          </script>          
                                </form>

                                <!-- new student login form -->
                                <form method="POST" action="{{ route('BUCare.login') }}" class="rounded bg-light p-4 fluid" id="newStudentLoginForm" style="display:none;">
                                    @csrf
                                    <!-- APPLICATION ID NUMBER INPUT -->
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control @error('applicantID') is-invalid @enderror" id="applicantID" name="applicantID" value="{{ old('applicantID') }}" placeholder="Applicant ID Number" autocomplete="applicantID" autofocus>
                                            <label for="floatingInput">Applicant ID Number</label>
                                            <span class="text-danger"> 
                                              @error('applicantID') 
                                                {{ $message }} 
                                              @enderror
                                            </span> 
                                        </div>
                                    <!-- BIRTH MONTH INPUT -->
                                    <div class="form mb-3">
                                      <div class ="row justify-content-center">
                                        <div class ="col col-3 d-inline pt-3">
                                          <p class="h6"> Birth Month: </p>
                                        </div>
                                        <div class ="col col-9">
                                          <select class="form-select align-baseline" name ="applicantBirthMonth" id="applicantBirthMonth" placeholder="Birth Month" autofocus style="height:58px;">
                                              <option selected="selected" disabled="disabled" value="">SELECT</option>
                                              <option value="JANUARY" id="januaryMonth" class="align-baseline">JANUARY</option>
                                              <option value="FEBRUARY" id="februaryMonth">FEBRUARY</option>
                                              <option value="MARCH" id="marchMonth">MARCH</option>
                                              <option value="APRIL" id="aprilMonth">APRIL</option>
                                              <option value="MAY" id="mayMonth">MAY</option>
                                              <option value="JUNE" id="juneMonth">JUNE</option>
                                              <option value="JULY" id="julyMonth">JULY</option>
                                              <option value="AUGUST" id="augustMonth">AUGUST</option>
                                              <option value="SEPTEMBER" id="septemberMonth">SEPTEMBER</option>
                                              <option value="OCTOBER" id="octoberMonth">OCTOBER</option>
                                              <option value="NOVEMBER" id="novemberMonth">NOVEMBER</option>
                                              <option value="DECEMBER" id="decemberMonth">DECEMBER</option>
                                          </select>
                                          <span class="text-danger"> 
                                            @error('applicantBirthMonth') 
                                              {{ $message }} 
                                            @enderror
                                          </span> 
                                        </div>
                                      </div>
                                    </div>
                                        <!-- BIRTH DATE INPUT -->
                                        <div class="form mb-3">
                                          <div class ="row justify-content-center">
                                            <div class ="col col-3 d-inline pt-3">
                                              <p class="h6"> Birth Date: </p>
                                            </div>
                                            <div class ="col col-9">
                                              <select class="form-select align-baseline" name ="applicantBirthDate" id="applicantBirthDate" placeholder="Birth Date" autofocus style="height:58px;">
                                                  <option selected="selected" disabled="disabled" value="">SELECT</option>
                                                  <option value="1" id="1st">1</option>
                                                  <option value="2" id="2nd">2</option>
                                                  <option value="3" id="3rd">3</option>
                                                  <option value="4" id="4th">4</option>
                                                  <option value="5" id="5th">5</option>
                                                  <option value="6" id="6th">6</option>
                                                  <option value="7" id="7th">7</option>
                                                  <option value="8" id="8th">8</option>
                                                  <option value="9" id="9th">9</option>
                                                  <option value="10" id="10th">10</option>
                                                  <option value="11" id="11th">11</option>
                                                  <option value="12" id="12th">12</option>
                                                  <option value="13" id="13th">13</option>
                                                  <option value="14" id="14th">14</option>
                                                  <option value="15" id="15th">15</option>
                                                  <option value="16" id="16th">16</option>
                                                  <option value="17" id="17th">17</option>
                                                  <option value="18" id="18th">18</option>
                                                  <option value="19" id="19th">19</option>
                                                  <option value="20" id="20th">20</option>
                                                  <option value="21" id="21st">21</option>
                                                  <option value="22" id="22nd">22</option>
                                                  <option value="23" id="23rd">23</option>
                                                  <option value="24" id="24th">24</option>
                                                  <option value="25" id="25th">25</option>
                                                  <option value="26" id="26th">26</option>
                                                  <option value="27" id="27th">27</option>
                                                  <option value="28" id="28th">28</option>
                                                  <option value="29" id="29th">29</option>
                                                  <option value="30" id="30th">30</option>
                                                  <option value="31" id="31th">31</option>
                                              </select>
                                              <span class="text-danger"> 
                                                @error('applicantBirthDate') 
                                                  {{ $message }} 
                                                @enderror
                                              </span> 
                                            </div>
                                          </div>
                                        </div>
                                        <!-- BIRTH YEAR INPUT -->
                                        <div class="form mb-3">
                                          <div class ="row justify-content-center">
                                            <div class ="col col-3 d-inline pt-3">
                                              <p class="h6"> Birth Year: </p>
                                            </div>
                                            <div class ="col col-9">
                                              <input type="text" class="form-control" name ="applicantBirthYear" id="applicantBirthYear" name="applicantBirthYear" value="{{ old('applicantBirthYear') }}" placeholder="e.g.,2002" maxlength="4" autocomplete="applicantBirthYear" autofocus style="height:58px;">
                                              <span class="text-danger"> 
                                                @error('applicantBirthYear') 
                                                  {{ $message }} 
                                                @enderror
                                              </span>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="d-grid">
                                            <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="submit">Log in</button>
                                        </div>
                                        <!-- BUTTON TO SWITCH FORMS -->
                                            <div class="md:mb-0">
                                                <center>
                                                  <a class="btn btn-link" id="switchForms2">
                                                    I am an old student.
                                                  </a>
                                                </center>
                                            </div>
                                            <script>
                                              $('#switchForms2').click(function() {
                                              // remove required attributes in new student login form
                                                  $('#applicantID').removeAttr('required');
                                                  $('#applicantBirthMonth').removeAttr('required');
                                                  $('#applicantBirthDate').removeAttr('required');
                                                  $('#applicantBirthYear').removeAttr('required');
                                              // hide new student login form
                                              $('#newStudentLoginForm').slideUp(300);
                                      
                                              // show old student login form
                                              $('#oldStudentLoginForm').slideDown(600);
                                              // add required attribute in old student login form
                                                  $('#studentID').attr('required',true);
                                                  $('#password').attr('required',true);
                                          });
                                          </script>
                                </form>
                        </div>
                    </div>  
              </div>
          </div>
      </div>
  </div>
</div>
@endsection