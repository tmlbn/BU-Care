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
            .btn-orange{
            color: black;
            height: 50px;
            border-bottom: black 1px solid !important;
            border-radius: 0%;
            }
            .btn-orange:hover,
            .btn-orange.active {
                color: #f1731f;
                border-bottom: #f1731f 1px solid !important;
                transition: 0.2s;
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
                cursor: pointer;
                transition: 0.3s;
            }
            .bucarelogo{
              width:100%;
              height:100%;
              object-fit: contain;
            }
            .bucarebgcolor{
              background-color:#0b1c2e;
            }
            .ui-datepicker {
              z-index: 9999 !important;
            }
            .form-header {
              cursor: pointer;
            }
</style>

<div class="container-fluid ps-md-0 bucarebgcolor">
    <div class="row g-0">
      <div class="d-none d-lg-flex col-md-6 col-lg-6">
        <img src="{{ asset('media/BUTorch.jpg') }}" alt="BUTorch.jpg" class="img-fluid" draggable="false"> 
      </div>
        <div class="col-md-12 col-lg-6">

            <script>
              // CLINIC IS ACTIVE
              $(document).ready(function(){
                $('[data-toggle="popover1"]').popover({
                  placement : 'left',
                  html : true,
                  title: '<p class="fw-bold fs-5 text-center mb-0">Register:</p>',
                  content : '<a class="loginButton formButton my-1" id="switchForms2">Student</a><br><a class="loginButton formButton my-1" id="switchForms3">Personnel</a><br><a class="loginButton active formButton my-1" id="switchForms1" disabled>Clinic Staff</a>'
                });
              $(document).on("click", ".popover .close" , function(){
                $(this).parents(".popover").popover('hide');
              });
              $('.popover-dismiss').popover({
                trigger: 'focus'
              });
            });
            // STUDENT IS ACTIVE
            $(document).ready(function(){
                $('[data-toggle="popover2"]').popover({
                  placement : 'left',
                  html : true,
                  title: '<p class="fw-bold fs-5 text-center mb-0">Register:</p>',
                  content : '<a class="loginButton active formButton my-1" id="switchForms2" disabled>Student</a><br><a class="loginButton formButton my-1" id="switchForms3">Personnel</a><br><a class="loginButton formButton my-1" id="switchForms1">Clinic Staff</a>'
                });
              $(document).on("click", ".popover .close" , function(){
                $(this).parents(".popover").popover('hide');
              });
              $('.popover-dismiss').popover({
                trigger: 'focus'
              });
            });
            // PERSONNEL IS ACTIVE
            $(document).ready(function(){
                $('[data-toggle="popover3"]').popover({
                  placement : 'left',
                  html : true,
                  title: '<p class="fw-bold fs-5 text-center mb-0">Register:</p>',
                  content : '<a class="loginButton formButton my-1" id="switchForms2">Student</a><br><a class="loginButton active formButton my-1" id="switchForms3" disabled>Personnel</a><br><a class="loginButton formButton my-1" id="switchForms1">Clinic Staff</a>'
                });
              $(document).on("click", ".popover .close" , function(){
                $(this).parents(".popover").popover('hide');
              });
              $('.popover-dismiss').popover({
                trigger: 'focus'
              });
            });
            </script>

            <div class="login d-flex align-items-center">
                <div class="container">
                    <div class="row">
                      <div class="col-md-10 col-lg-10 mx-auto my-auto">
                                <!-- REGISTER STAFF -->
                                <form method="POST" action="{{ route('manualRegister.store') }}" class="rounded bg-light p-4 fluid" id="staffRegister" style="display:block;">
                                  @csrf
                                  @if (Session::has('fail'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                      {{ Session::get('fail') }} 
                                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                  @endif
                                  @if (Session::has('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                      {{ Session::get('success') }}
                                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                  @endif

                                  <!-- STAFF ID NUMBER INPUT -->
                                <a tabindex="0" role="button" id="loginButton" class="btn btn-orange form-header d-inline-flex border-0 mb-3 align-items-center" data-toggle="popover1" data-bs-trigger="focus" data-bs-html="true" title="Register:">
                                  <p class="fs-4 fw-bold me-2" id="pButton"><i class="bi bi-chevron-double-right"></i></p>
                                  <p class="fs-4 fw-bold mt-2" id="pButton">Clinic Staff Registration</p>
                                </a>
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
                                        <input type="email" class="form-control @error('staff_email') is-invalid @enderror" id="staff_email" name="staff_email" value="{{ old('staff_email') }}" placeholder="Email Address" autocomplete="staff_email" required>
                                        <label for="floatingInput">Email Address</label>
                                        @error('staff_email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                        <!-- PW INPUT -->
                                      <div class="form-floating mb-3">
                                          <input type="text" class="form-control" id="staff_password" name="staff_password" value="{{ old('staff_password') }}" placeholder="Password" autocomplete="staff_password" required>
                                          <label for="floatingInput">Password</label>
                                          <span class="text-danger" id="passwordErrormsg"> 
                                            @error('staff_password') 
                                              {{ $message }} 
                                            @enderror
                                          </span>
                                      </div>
                                        <!-- LAST NAME INPUT -->
                                      <div class="form-floating mb-3">
                                          <input type="text" class="form-control" name="staff_lastName" id="staff_lastName" placeholder="Last Name" oninput="this.value = this.value.toUpperCase()" autocomplete="staff_lastName" required>
                                          <label for="floatingInput">Last Name</label>
                                          <span class="text-danger" id="staff_lastNameErrormsg"> 
                                            @error('staff_lastName') 
                                              {{ $message }} 
                                            @enderror
                                          </span>
                                      </div>
                                       <!-- FIRST NAME INPUT -->
                                      <div class="form-floating mb-3">
                                          <input type="text" class="form-control @error('staff_firstName') is-invalid @enderror" id="staff_firstName" name="staff_firstName" value="{{ old('staff_firstName') }}" oninput="this.value = this.value.toUpperCase()" placeholder="First Name" autocomplete="staff_firstName" required>
                                          <label for="floatingInput">First Name</label>
                                          @error('staff_firstName')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                          @enderror   
                                      </div>
                                       <!-- MIDDLE NAME INPUT -->
                                      <div class="form-floating mb-3">
                                          <input type="text" class="form-control @error('staff_middleName') is-invalid @enderror" id="staff_middleName" name="staff_middleName" value="{{ old('staff_middleName') }}" oninput="this.value = this.value.toUpperCase()" placeholder="First Name" autocomplete="staff_middleName" required>
                                          <label for="floatingInput">Middle Name</label>
                                          @error('staff_middleName')
                                          <span class="invalid feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                          @enderror   
                                      </div>
                                       <!-- DATE OF BIRTH INPUT -->
                                      <div class="form mb-3">
                                        <div class ="row justify-content-center">
                                          <div class ="col col-3 d-inline pt-3">
                                            <p class="h6"> Date of Birth: </p>
                                          </div>
                                          <div class ="col col-9">
                                            <input type="text" class="form-control @error('staff_dateOfBirth') is-invalid @enderror" id="staff_dateOfBirth" name="staff_dateOfBirth" style="height:58px;" value="{{ old('staff_dateOfBirth') }}" placeholder="YEAR-MONTH-DATE" autocomplete="staff_dateOfBirth" required>
                                            <span class="text-danger"> 
                                                @error('staff_dateOfBirth') 
                                                    {{ $message }} 
                                                @enderror
                                            </span>
                                            <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
                                            <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
                                            
                                            <script>
                                            $(document).ready(function() {
                                                $("#staff_dateOfBirth").datepicker({
                                                    changeMonth: true,
                                                    changeYear: true,
                                                    dateFormat: 'yy-mm-dd',
                                                    showButtonPanel: true,
                                                    yearRange: "1900:c",
                                                    showAnim: 'slideDown',
                                                });
                                            });
                                            </script>

                                          </div>
                                        </div>
                                          @error('month')
                                          <span class="invalid feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span>
                                          @enderror   
                                      </div>
                          
                                    <div class="d-grid">
                                      <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="submit">Register</button>
                                    </div>  
                              </form>

                              <!-- new student login form -->
                              <form method="POST" action="{{ route('manualRegister.store') }}" class="rounded bg-light p-4 fluid" id="studentRegister" style="display:none;">
                                @csrf

                                @if (Session::has('fail'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                      {{ Session::get('fail') }} 
                                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                  @endif
                                  @if (Session::has('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                      {{ Session::get('success') }}
                                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                  @endif

                                <!-- APPLICATION ID NUMBER INPUT -->
                                <a tabindex="0" role="button" id="loginButton" class="btn btn-orange form-header d-inline-flex border-0 mb-3 align-items-center" data-toggle="popover2" data-bs-trigger="focus" data-bs-html="true" title="Register:">
                                  <p class="fs-4 fw-bold me-2" id="pButton"><i class="bi bi-chevron-double-right"></i></p>
                                  <p class="fs-4 fw-bold mt-2" id="pButton">Student Registration</p>
                                </a>
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
                                        <input type="text" class="form-control" id="studentID" name="studentID" value="{{ old('studentID') }}" placeholder="Student ID Number" oninput="this.value = this.value.toUpperCase()" autocomplete="studentID">
                                        <label for="floatingInput" class="fst-italic">Student ID Number</label>
                                        <span class="text-danger" id="studentIDErrormsg"> 
                                          @error('studentID') 
                                            {{ $message }} 
                                          @enderror
                                        </span>
                                    </div>
                                     <!-- EMAIL INPUT -->
                                    <div class="form-floating mb-3">
                                      <input type="text" class="form-control @error('student_email') is-invalid @enderror" id="student_email" name="student_email" value="{{ old('student_email') }}" placeholder="Email" autocomplete="student_email">
                                      <label for="floatingInput" class="fst-italic">Email Address</label>
                                      @error('student_email')
                                      <span class="invalid feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror   
                                  </div>
                                <!-- PW INPUT -->
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="student_password" id="student_password" placeholder="Student Password">
                                        <label for="floatingInput" class="fst-italic">Password</label>
                                        <span class="text-danger" id="studentPWErrormsg"> 
                                          @error('student_password') 
                                            {{ $message }} 
                                          @enderror
                                        </span>
                                    </div>
                                     <!-- LAST NAME INPUT -->
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('student_lastName') is-invalid @enderror" id="student_lastName" name="student_lastName" value="{{ old('student_lastName') }}" oninput="this.value = this.value.toUpperCase()" placeholder="Last Name" autocomplete="student_lastName" required>
                                        <label for="floatingInput">Last Name</label>
                                        @error('student_lastName')
                                        <span class="invalid feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror   
                                    </div>
                                     <!-- FIRST NAME INPUT -->
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('student_firstName') is-invalid @enderror" id="student_firstName" name="student_firstName" value="{{ old('student_firstName') }}" oninput="this.value = this.value.toUpperCase()" placeholder="First Name" autocomplete="student_firstName" required>
                                        <label for="floatingInput">First Name</label>
                                        @error('student_firstName')
                                        <span class="invalid feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror   
                                    </div>
                                     <!-- MIDDLE NAME INPUT -->
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('student_middleName') is-invalid @enderror" id="student_middleName" name="student_middleName" value="{{ old('student_middleName') }}" placeholder="Middle Name" oninput="this.value = this.value.toUpperCase()" autocomplete="student_middleName">
                                        <label for="floatingInput" class="fst-italic">Middle Name</label>
                                        @error('student_middleName')
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
                                      <select class="form-select align-baseline @error('month') is-invalid @enderror" name ="applicantBirthMonth" id="applicantBirthMonth" placeholder="Birth Month" style="height:58px;" required>
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
                                          <select class="form-select align-baseline @error('date') is-invalid @enderror" name ="applicantBirthDate" id="applicantBirthDate" placeholder="Birth Date" style="height:58px;" required>
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
                                          <input type="text" class="form-control @error('year') is-invalid @enderror" name ="applicantBirthYear" id="applicantBirthYear" name="applicantBirthYear" value="{{ old('applicantBirthYear') }}" placeholder="e.g.,2002" maxlength="4" autocomplete="applicantBirthYear" style="height:58px;" required>
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
                            </form>

                            <!-- PERSONNEL FORM -->
                            <form method="POST" action="{{ route('manualRegister.store') }}" class="rounded bg-light p-4 fluid" id="personnelRegister" style="display:none;">
                              @csrf
                              @if (Session::has('fail'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                      {{ Session::get('fail') }} 
                                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                  @endif
                                  @if (Session::has('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                      {{ Session::get('success') }}
                                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                  @endif  
                                <!-- PERSONNEL ID NUMBER INPUT -->
                                <a tabindex="0" role="button" id="loginButton" class="btn btn-orange form-header d-inline-flex border-0 mb-3 align-items-center" data-toggle="popover3" data-bs-trigger="focus" data-bs-html="true" title="Register:">
                                  <p class="fs-4 fw-bold me-2" id="pButton"><i class="bi bi-chevron-double-right"></i></p>
                                  <p class="fs-4 fw-bold mt-2" id="pButton">Personnel Registration</p>
                                </a>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="personnelID" name="personnelID" value="{{ old('personnelID') }}" placeholder="Staff ID Number" autocomplete="personnelID" oninput="this.value = this.value.toUpperCase()" autofocus required>
                                    <label for="floatingInput">Personnel ID Number</label>
                                    <span class="text-danger" id="personnelIDErrormsg"> 
                                      @error('personnelID') 
                                        {{ $message }} 
                                      @enderror
                                    </span>
                                </div>
                                <!-- EMAIL INPUT -->
                                <div class="form-floating mb-3">
                                  <input type="email" class="form-control @error('personnel_email') is-invalid @enderror" id="personnel_email" name="personnel_email" value="{{ old('personnel_email') }}" placeholder="Email Address" autocomplete="personnel_email" required>
                                  <label for="floatingInput">Email Address</label>
                                  @error('personnel_email')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                  @enderror
                              </div>
                                  <!-- PW INPUT -->
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="personnel_password" name="personnel_password" value="{{ old('personnel_password') }}" placeholder="Password" autocomplete="personnel_password" required>
                                    <label for="floatingInput">Password</label>
                                    <span class="text-danger" id="personnel_passwordErrormsg"> 
                                      @error('personnel_password') 
                                        {{ $message }} 
                                      @enderror
                                    </span>
                                </div>
                                  <!-- LAST NAME INPUT -->
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="personnel_lastName" id="personnel_lastName" placeholder="Last Name" oninput="this.value = this.value.toUpperCase()" autocomplete="personnel_lastName" required>
                                    <label for="floatingInput">Last Name</label>
                                    <span class="text-danger" id="personnel_lastNameErrormsg"> 
                                      @error('personnel_lastName') 
                                        {{ $message }} 
                                      @enderror
                                    </span>
                                </div>
                                <!-- FIRST NAME INPUT -->
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('personnel_firstName') is-invalid @enderror" id="personnel_firstName" name="personnel_firstName" value="{{ old('personnel_firstName') }}" oninput="this.value = this.value.toUpperCase()" placeholder="First Name" autocomplete="personnel_firstName" required>
                                    <label for="floatingInput">First Name</label>
                                    @error('personnel_firstName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror   
                                </div>
                                <!-- MIDDLE NAME INPUT -->
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('personnel_middleName') is-invalid @enderror" id="personnel_middleName" name="personnel_middleName" value="{{ old('personnel_middleName') }}" oninput="this.value = this.value.toUpperCase()" placeholder="First Name" autocomplete="personnel_middleName" required>
                                    <label for="floatingInput">Middle Name</label>
                                    @error('personnel_middleName')
                                    <span class="invalid feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror   
                                </div>
                                <!-- DATE OF BIRTH INPUT -->
                                <div class="form mb-3">
                                  <div class ="row justify-content-center">
                                    <div class ="col col-3 d-inline pt-3">
                                      <p class="h6"> Date of Birth: </p>
                                    </div>
                                    <div class ="col col-9">
                                      <input type="text" class="form-control @error('personnel_dateOfBirth') is-invalid @enderror" id="personnel_dateOfBirth" name="personnel_dateOfBirth" style="height:58px;" value="{{ old('personnel_dateOfBirth') }}" placeholder="YEAR-MONTH-DATE" autocomplete="personnel_dateOfBirth" required>
                                      <span class="text-danger"> 
                                          @error('personnel_dateOfBirth') 
                                              {{ $message }} 
                                          @enderror
                                      </span>
                                    </div>
                                  </div>
                                    @error('month')
                                    <span class="invalid feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror   
                                </div>
                      
                              <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
                              <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
                              
                              <script>
                              $(document).ready(function() {
                                  $("#personnel_dateOfBirth").datepicker({
                                      changeMonth: true,
                                      changeYear: true,
                                      dateFormat: 'yy-mm-dd',
                                      showButtonPanel: true,
                                      yearRange: "1900:c",
                                      showAnim: 'slideDown',
                                  });
                              });
                              </script>

                                <div class="d-grid">
                                  <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="submit">Register</button>
                              </div>
                        </form>
                        <script>
                          /* SWITCH TO STAFF FORM */
                                    $(document).on('click', '#switchForms1', function() {
                                      // remove required attributes from other forms
                                        $('#applicantID').removeAttr('required');
                                        $('#student_lastName').removeAttr('required');
                                        $('#student_firstName').removeAttr('required');
                                        $('#applicantBirthMonth').removeAttr('required');
                                        $('#applicantBirthDate').removeAttr('required');
                                        $('#applicantBirthYear').removeAttr('required');
                                        $('#personnelID').removeAttr('required');
                                        $('#personnel_email').removeAttr('required');
                                        $('#personnel_password').removeAttr('required');
                                        $('#personnel_lastName').removeAttr('required');
                                        $('#personnel_firstName').removeAttr('required');
                                        $('#personnel_dateofBirth').removeAttr('required');
                                          // hide other registration forms
                                          $('#studentRegister').slideUp(300);
                                          $('#personnelRegister').slideUp(300);
                          
                                          // show staff registration form
                                          $('#staffRegister').slideDown(600);
                                        // add required attribute in staff registration form
                                        $('#staffID').attr('required',true);
                                        $('#staff_email').attr('required',true);
                                        $('#staff_password').attr('required',true);
                                        $('#staff_lastName').attr('required',true);
                                        $('#staff_firstName').attr('required',true);
                                        $('#staff_dateofBirth').attr('required',true);
                                        $('#switchForms1').addClass('active');
                                        $('#switchForms2').removeClass('active');
                                        $('#switchForms3').removeClass('active');
                                      });
                          
                          /* SWITCH TO STUDENT FORM */
                                      $(document).on('click', '#switchForms2', function() {
                                        // remove required attributes from other forms
                                        $('#staffID').removeAttr('required');
                                        $('#staff_password').removeAttr('required');
                                        $('#staff_email').removeAttr('required');
                                        $('#staff_lastName').removeAttr('required');
                                        $('#staff_firstName').removeAttr('required');
                                        $('#staff_dateofBirth').removeAttr('required');
                                        $('#personnelID').removeAttr('required');
                                        $('#personnel_email').removeAttr('required');
                                        $('#personnel_password').removeAttr('required');
                                        $('#personnel_lastName').removeAttr('required');
                                        $('#personnel_firstName').removeAttr('required');
                                        $('#personnel_dateofBirth').removeAttr('required');
                                          // hide other registration forms
                                          $('#staffRegister').slideUp(300);
                                          $('#personnelRegister').slideUp(300);
                                                        
                                          // show student registration forms
                                          $('#studentRegister').slideDown(600);
                                        // add required attribute in student registration form
                                        $('#applicantID').attr('required',true);
                                        $('#student_lastName').attr('required',true);
                                        $('#student_firstName').attr('required',true);
                                        $('#applicantBirthMonth').attr('required',true);
                                        $('#applicantBirthDate').attr('required',true);
                                        $('#applicantBirthYear').attr('required',true);
                                        $('#switchForms2').addClass('active');
                                        $('#switchForms1').removeClass('active');
                                        $('#switchForms3').removeClass('active');
                                      });
                          
                          /* SWITCH TO PERSONNEL FORM */
                                    $(document).on('click', '#switchForms3', function() {
                                      // remove required attributes from other forms
                                        $('#applicantID').removeAttr('required');
                                        $('#student_lastName').removeAttr('required');
                                        $('#student_firstName').removeAttr('required');
                                        $('#student_middleName').removeAttr('required');
                                        $('#applicantBirthMonth').removeAttr('required');
                                        $('#applicantBirthDate').removeAttr('required');
                                        $('#applicantBirthYear').removeAttr('required');
                                        $('#staffID').removeAttr('required');
                                        $('#staff_password').removeAttr('required');
                                        $('#staff_email').removeAttr('required');
                                        $('#staff_lastName').removeAttr('required');
                                        $('#staff_firstName').removeAttr('required');
                                        $('#staff_dateofBirth').removeAttr('required');
                                          // hide other registration forms
                                          $('#studentRegister').slideUp(300);
                                          $('#staffRegister').slideUp(300);
                          
                                          // show personnel registration form
                                          $('#personnelRegister').slideDown(600);
                                        // add required attribute in personnel registration form
                                        $('#personnelID').attr('required',true);
                                        $('#personnel_email').attr('required',true);
                                        $('#personnel_password').attr('required',true);
                                        $('#personnel_lastName').attr('required',true);
                                        $('#personnel_firstName').attr('required',true);
                                        $('#personnel_dateofBirth').attr('required',true);
                                        $('#switchForms3').addClass('active');
                                        $('#switchForms2').removeClass('active');
                                        $('#switchForms1').removeClass('active');
                                      });
                          </script>
                        </div>
                    </div>  
              </div>
          </div>
      </div>
  </div>
</div>
@endsection