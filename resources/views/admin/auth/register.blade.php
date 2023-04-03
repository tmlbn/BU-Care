@extends('admin.layouts.loginpageapp')
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
</style>

<div class="container-fluid ps-md-0 bucarebgcolor">
    <div class="row g-0">
        <div class="d-none d-md-flex col-md-4 col-lg-6">
            <img src="{{ asset('media/BUTorch.jpg') }}" alt="BUTorch.jpg" class="img-fluid"> 
        </div>
        <div class="col-md-8 col-lg-6">
            <div class="login d-flex align-items-center">
                <div class="container">
                    <div class="row">
                            <div class="col-md-4 col-lg-8 mx-auto">
                                <!-- REGISTER STAFF -->
                                <form method="POST" action="{{ route('manualRegister.store') }}" class="rounded bg-light p-4 fluid" id="staffRegister" style="display:block;">
                                  @csrf

                                  @if (Session::has('fail'))
                                    <div class="alert alert-danger"> {{ Session::get('fail') }} </div>
                                  @endif
                                  @if (Session::has('success'))
                                    <div class="alert alert-danger"> {{ Session::get('success') }} </div>
                                  @endif

                                  <!-- STAFF ID NUMBER INPUT -->
                                  <p class="text-start fs-4 fw-light pb-1">Clinic Staff Registration</p>
                                      <div class="form-floating mb-3">
                                          <input type="text" class="form-control" id="staffID" name="staffID" value="{{ old('staffID') }}" placeholder="Staff ID Number" autocomplete="staffID" oninput="this.value = this.value.toUpperCase()" autofocus required>
                                          <label for="floatingInput">Staff ID Number</label>
                                          <span class="text-danger" id="staffIDErrormsg"> 
                                            @error('staffID') 
                                              {{ $message }} 
                                            @enderror
                                          </span>
                                      </div>
                                       <!-- EMAIL INPUT -->
                                       <div class="form-floating mb-3">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Email Address" autocomplete="email" autofocus required>
                                        <label for="floatingInput">Email Address</label>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                        <!-- PW INPUT -->
                                      <div class="form-floating mb-3">
                                          <input type="text" class="form-control" id="password" name="password" value="{{ old('password') }}" placeholder="Password" autocomplete="password" required>
                                          <label for="floatingInput">Password</label>
                                          <span class="text-danger" id="passwordErrormsg"> 
                                            @error('password') 
                                              {{ $message }} 
                                            @enderror
                                          </span>
                                      </div>
                                        <!-- LAST NAME INPUT -->
                                      <div class="form-floating mb-3">
                                          <input type="text" class="form-control" name="lastName" id="lastName" placeholder="Last Name" oninput="this.value = this.value.toUpperCase()" autocomplete="lastName" required>
                                          <label for="floatingInput">Last Name</label>
                                          <span class="text-danger" id="lastNameErrormsg"> 
                                            @error('lastName') 
                                              {{ $message }} 
                                            @enderror
                                          </span>
                                      </div>
                                       <!-- FIRST NAME INPUT -->
                                      <div class="form-floating mb-3">
                                          <input type="text" class="form-control @error('firstName') is-invalid @enderror" id="firstName" name="firstName" value="{{ old('firstName') }}" oninput="this.value = this.value.toUpperCase()" placeholder="Last Name" autocomplete="firstName" autofocus required>
                                          <label for="floatingInput">First Name</label>
                                          @error('firstName')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                          @enderror   
                                      </div>
                                       <!-- MIDDLE NAME INPUT -->
                                      <div class="form-floating mb-3">
                                          <input type="text" class="form-control @error('middleName') is-invalid @enderror" id="middleName" name="middleName" value="{{ old('middleName') }}" oninput="this.value = this.value.toUpperCase()" placeholder="First Name" autocomplete="middleName" autofocus required>
                                          <label for="floatingInput">Middle Name</label>
                                          @error('middleName')
                                          <span class="invalid feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                          @enderror   
                                      </div>
                                      <div class="d-grid">
                                        <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="submit">Register</button>
                                    </div>
                                      <!-- BUTTON TO SWITCH FORMS -->
                                      <div class="md:mb-0">
                                        <center>
                                          <a class="btn btn-link" id="switchForms2">
                                            Register student
                                          </a>
                                        </center>
                                    </div>
                                    <script>
                                      $('#switchForms2').click(function() {
                                      // remove required attributes in staff registration form
                                          $('#staffID').removeAttr('required');
                                          $('#password').removeAttr('required');
                                          $('#lastName').removeAttr('required');
                                          $('#firstName').removeAttr('required');
                                      // hide staff registration form
                                      $('#staffRegister').slideUp(300);
                              
                                      // show student registration form
                                      $('#studentRegister').slideDown(600);
                                      // add required attribute in student registration form
                                          $('#applicantID').attr('required',true);
                                          $('#lastName').attr('required',true);
                                          $('#firstName').attr('required',true);
                                          $('#applicantBirthMonth').attr('required',true);
                                          $('#applicantBirthDate').attr('required',true);
                                          $('#applicantBirthYear').attr('required',true);
                                  });
                                  </script>
                              </form>
                              <!-- new student login form -->
                              <form method="POST" action="{{ route('manualRegister.store') }}" class="rounded bg-light p-4 fluid" id="studentRegister" style="display:none;">
                                @csrf

                                @if (Session::has('fail'))
                                  <div class="alert alert-danger"> {{ Session::get('fail') }} </div>
                                @endif
                                @if (Session::has('success'))
                                  <div class="alert alert-danger"> {{ Session::get('success') }} </div>
                                @endif

                                <!-- APPLICATION ID NUMBER INPUT -->
                                <p class="text-start fs-4 fw-light pb-1">Student Registration</p>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="applicantID" name="applicantID" value="{{ old('applicantID') }}" placeholder="Applicant ID Number" autocomplete="applicantID" oninput="this.value = this.value.toUpperCase()" autofocus required>
                                        <label for="floatingInput">Applicant ID Number</label>
                                        <span class="text-danger" id="applicantIDErrormsg"> 
                                          @error('applicantID') 
                                            {{ $message }} 
                                          @enderror
                                        </span>
                                    </div>
                                <!-- STUDENT ID INPUT -->
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="studentID" name="studentID" value="{{ old('studentID') }}" placeholder="Student ID Number" oninput="this.value = this.value.toUpperCase()" autocomplete="studentID" autofocus>
                                        <label for="floatingInput" class="fst-italic">Student ID Number</label>
                                        <span class="text-danger" id="studentIDErrormsg"> 
                                          @error('studentID') 
                                            {{ $message }} 
                                          @enderror
                                        </span>
                                    </div>
                                     <!-- EMAIL INPUT -->
                                    <div class="form-floating mb-3">
                                      <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Last Name" autocomplete="email" autofocus>
                                      <label for="floatingInput" class="fst-italic">Email Address</label>
                                      @error('email')
                                      <span class="invalid feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror   
                                  </div>
                                <!-- PW INPUT -->
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="password" id="password" placeholder="Password" autocomplete="current-password">
                                        <label for="floatingInput" class="fst-italic">Password</label>
                                        <span class="text-danger" id="studentPWErrormsg"> 
                                          @error('studentPassword') 
                                            {{ $message }} 
                                          @enderror
                                        </span>
                                    </div>
                                     <!-- LAST NAME INPUT -->
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('lastName') is-invalid @enderror" id="lastName" name="lastName" value="{{ old('lastName') }}" oninput="this.value = this.value.toUpperCase()" placeholder="Last Name" autocomplete="lastName" autofocus required>
                                        <label for="floatingInput">Last Name</label>
                                        @error('lastName')
                                        <span class="invalid feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror   
                                    </div>
                                     <!-- FIRST NAME INPUT -->
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('firstName') is-invalid @enderror" id="firstName" name="firstName" value="{{ old('firstName') }}" oninput="this.value = this.value.toUpperCase()" placeholder="First Name" autocomplete="firstName" autofocus required>
                                        <label for="floatingInput">First Name</label>
                                        @error('firstName')
                                        <span class="invalid feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror   
                                    </div>
                                     <!-- MIDDLE NAME INPUT -->
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('middleName') is-invalid @enderror" id="middleName" name="middleName" value="{{ old('middleName') }}" placeholder="Middle Name" oninput="this.value = this.value.toUpperCase()" autocomplete="middleName" autofocus>
                                        <label for="floatingInput" class="fst-italic">Middle Name</label>
                                        @error('middleName')
                                        <span class="invalid feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror   
                                    </div>
                                <!-- BIRTH MONTH INPUT -->
                                <div class="form mb-3">
                                  <div class ="row justify-content-center">
                                    <div class ="col col-3 d-inline pt-3">
                                      <p class="h6"> Birth Month: </p>
                                    </div>
                                    <div class ="col col-9">
                                      <select class="form-select align-baseline @error('month') is-invalid @enderror" name ="applicantBirthMonth" id="applicantBirthMonth" placeholder="Birth Month" autofocus style="height:58px;" required>
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
                                    </div>
                                  </div>
                                    @error('month')
                                    <span class="invalid feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror   
                                </div>
                                    <!-- BIRTH DATE INPUT -->
                                    <div class="form mb-3">
                                      <div class ="row justify-content-center">
                                        <div class ="col col-3 d-inline pt-3">
                                          <p class="h6"> Birth Date: </p>
                                        </div>
                                        <div class ="col col-9">
                                          <select class="form-select align-baseline @error('date') is-invalid @enderror" name ="applicantBirthDate" id="applicantBirthDate" placeholder="Birth Date" autofocus style="height:58px;" required>
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
                                        </div>
                                      </div>
                                        @error('date')
                                        <span class="invalid feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror   
                                    </div>
                                    <!-- BIRTH YEAR INPUT -->
                                    <div class="form mb-3">
                                      <div class ="row justify-content-center">
                                        <div class ="col col-3 d-inline pt-3">
                                          <p class="h6"> Birth Year: </p>
                                        </div>
                                        <div class ="col col-9">
                                          <input type="text" class="form-control @error('year') is-invalid @enderror" name ="applicantBirthYear" id="applicantBirthYear" name="applicantBirthYear" value="{{ old('applicantBirthYear') }}" placeholder="e.g.,2002" maxlength="4" autocomplete="applicantBirthYear" autofocus style="height:58px;" required>
                                        </div>
                                      </div>
                                        @error('year')
                                        <span class="invalid feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror   
                                    </div>
                                    <div class="d-grid">
                                        <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="submit">Register</button>
                                    </div>
                                    <!-- BUTTON TO SWITCH FORMS -->
                                    <div class="md:mb-0">
                                      <center>
                                        <a class="btn btn-link" id="switchForms1">
                                          Register staff
                                        </a>
                                      </center>
                                  </div>
                                  <script>
                                    $('#switchForms1').click(function() {
                                      // remove required attributes in staff registration form
                                        $('#applicantID').removeAttr('required');
                                        $('#lastName').removeAttr('required');
                                        $('#firstName').removeAttr('required');
                                        $('#middleName').removeAttr('required');
                                        $('#applicantBirthMonth').removeAttr('required');
                                        $('#applicantBirthDate').removeAttr('required');
                                        $('#applicantBirthYear').removeAttr('required');

                                    // hide staff registration form
                                    $('#studentRegister').slideUp(300);

                                    // show student registration form
                                    $('#staffRegister').slideDown(600);
                                    // add required attribute in student registration form
                                        $('#staffID').attr('required',true);
                                        $('#password').attr('required',true);
                                        $('#lastName').attr('required',true);
                                        $('#firstName').attr('required',true);
                                        $('#middleName').attr('required',true);
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