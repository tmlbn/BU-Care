@extends('layouts.app')

@section('content')

<style>
    ::-webkit-input-placeholder {
   font-style: italic;
    }
    :-moz-placeholder {
    font-style: italic;  
    }
    ::-moz-placeholder {
    font-style: italic;  
    }
    :-ms-input-placeholder {  
    font-style: italic; 
    }

    body{
        background-image: url({{ asset('media/RegistrationBG.jpg') }});
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
    }

    div.settings {
    display:grid;
    grid-template-columns: max-content max-content;
    grid-gap:5px;
    padding-left: -5px;
    }
    div.settings label{
        text-align:right;
    }
    span.h5{
        margin-bottom:10px;
    }
    .checkboxes input, select{
        outline: 1px solid #d4d4d4dc;
    }
    option.alternate{
        background-color: #ececec;
    }
    .custom-file-upload {
        padding: 6px 12px;
        cursor: pointer;
    }

    input.signa{
        display: inline-block;
        width: 6em;
        position: relative;
        top: -3em;
        margin-bottom: 10px;
    }

    label.signa{
        display: inline-block;
        width: 6em;
        margin-top: 50px;
        margin-right: .5em;
    }
    .no-gutters {
        margin-right: 0;
        margin-left: 0;

        > .col,
        > [class*="col-"] {
            padding-right: 0;
            padding-left: 0;
        }
    }

</style>
<!-- Header -->
<div class="container position-relative my-2 bg-light w-20 text-dark pt-5 px-3 headMargin checkboxes">
    <div class="d-flex flex-row">
        <div class="col-6 border border-dark border-end-0 d-flex align-items-center justify-content-center">
            <div class="row">
                <div class="col-2 d-flex align-items-center justify-content-center">
                    <img src="{{ asset('media/BU-logo.png') }}" class="rounded" alt="BUHS-LOGO" style="width:100%; margin-left: 30%;">
                  </div>                  
                <div class="col-sm">
                    <header class="text-center px-auto py-auto">
                        <h5 class="display-7 pt-3 fs-3 font-monospace">
                            Republic of the Philippines<br>
                        </h5>
                        <h6 class="fw-bold fs-5 font-monospace">Bicol University</h6>
                        <h6 class="fs-5 font-monospace">Bicol University Health Services</h6>
                    </header>
                </div>
                <div class="col-2 d-flex align-items-center justify-content-center">
                    <img src="{{ asset('media/BUHS-logo.png') }}" class="rounded float-end" alt="BUHS-LOGO" style="width:100%; margin-right: 30%;">
                </div>
            </div>
        </div>
        <div class="col-6 border border-dark d-flex align-items-center justify-content-center">
            <header class="text-center px-auto py-auto">
              <h2 class="display-7 fs-3 pt-auto font-monospace">Student Health Record</h2>
            </header>
          </div>          
    </div>

    <!--Personal Basic Information-->
<form method="POST" action="{{ route('medicalForm.store') }}" enctype="multipart/form-data" class="row g-3 pt-5 px-4">
    @csrf
    <div class="container">
        <div class="mx-auto row row-cols-lg-4 row-cols-md-2 mt-2">
            <div class="col-xl-5 col-lg-6">
                <p class="h6">Campus</p>
                <select id="campusSelect" name="campusSelect" class="form-select" required>
                    <option selected="selected" disabled="disabled" value="">SELECT</option>
                    <option value="College of Agriculture and Forestry">College of Agriculture and Forestry</option>
                    <option value="College of Arts and Letters" class="alternate">College of Arts and Letters</option>
                    <option value="Entrepreneurship, and Management">College of Business, Entrepreneurship, and Management</option>
                    <option value="College of Education" class="alternate">College of Education</option>
                    <option value="College of Engineering">College of Engineering</option>
                    <option value="College of Industrial Technology" class="alternate">College of Industrial Technology</option>
                    <option value="College of Medicine">College of Medicine</option>
                    <option value="College of Nursing" class="alternate">College of Nursing</option>
                    <option value="College of Science">College of Science</option>
                    <option value="College of Social Science and Philosoph" class="alternate">College of Social Science and Philosophy</option>
                    <option value="Institute of Design and Architecture">Institute of Design and Architecture</option>
                    <option value="Institute of Physical Education, Sports, and Recreation" class="alternate">Institute of Physical Education, Sports, and Recreation</option>
                    <option value="Gubat Campus">Gubat Campus</option>
                    <option value="Polangui Campus" class="alternate">Polangui Campus</option>
                    <option value="Tabaco Campus">Tabaco Campus</option>
                </select>
                <span class="text-danger"> 
                    @error('campusSelect') 
                      {{ $message }} 
                    @enderror
                  </span>
            </div>
            <div class="col-xl-5 col-lg-6 col-md-6">
                <p class="h6">Course</p>
                <select id="courseSelect" name="courseSelect" class="form-select" required>
                    <option selected="selected" disabled="disabled" value="">SELECT</option>
                    <option>Information Technology</option>
                    <option></option>
                    <option></option>
                </select>
                <span class="text-danger"> 
                    @error('courseSelect') 
                      {{ $message }} 
                    @enderror
                  </span>
            </div> 
            <div class="col-xl-2 col-lg-12 col-md-12">
                <label for="schoolYearStart" class="form-label h6" style="white-space: nowrap;">School Year</label>
                    <div class="d-flex align-items-center" style="margin-top:-1%;">
                        <input type="text" class="form-control me-1" id="schoolYearStart" name="schoolYearStart" placeholder="YYYY" maxlength="4" required>
                        <span class="fs-6">-</span>
                        <input type="text" class="form-control ms-2" id="schoolYearEnd" name="schoolYearEnd" placeholder="YYYY" maxlength="4" required>
                    </div>
                    <span class="text-danger"> 
                        @error('schoolYearStart') 
                        {{ $message }} 
                        @enderror
                    </span>
                    <span class="text-danger"> 
                        @error('schoolYearEnd') 
                        {{ $message }} 
                        @enderror
                    </span>
            </div>   
        </div>   
    </div>
    <div class="d-flex flex-row">
        <h4 class="pb-3"></h4>
    </div>   
        <div class="col-md-3">
            <label for="MR_lastName" class="form-label h6">Last Name</label>
            <input type="text" class="form-control" id="MR_lastName" name="MR_lastName" oninput="this.value = this.value.toUpperCase()" required>
            <span class="text-danger"> 
                @error('MR_lastName') 
                  {{ $message }} 
                @enderror
              </span>
        </div>
        <div class="col-md-3">
            <label for="MR_firstName" class="form-label h6">First Name</label>
            <input type="text" class="form-control" id="MR_firstName" name="MR_firstName" oninput="this.value = this.value.toUpperCase()" required>
            <span class="text-danger"> 
                @error('MR_firstName') 
                  {{ $message }} 
                @enderror
              </span>
        </div>
        <div class="col-md-3">
            <label for="MR_middleName" class="form-label h6">Middle Name</label>
            <input type="text" class="form-control" id="MR_middleName" name="MR_middleName" oninput="this.value = this.value.toUpperCase()" required>
            <span class="text-danger"> 
                @error('MR_middleName') 
                  {{ $message }} 
                @enderror
              </span>
        </div>
        <div class="col-md-1">
            <label for="MR_age" class="form-label h6">Age</label>
            <input type="text" class="form-control" id="MR_age" name="MR_age" required>
            <span class="text-danger"> 
                @error('MR_age') 
                  {{ $message }} 
                @enderror
              </span>
        </div>
        <div class="col-md-2">
            <label for="MR_sex" class="form-label h6">Sex</label>
            <select id="MR_sex" class="form-select" name="MR_sex" required>
                <option selected="selected" disabled="disabled" value="">SELECT</option>
                <option value="MALE">MALE</option>
                <option value="FEMALE">FEMALE</option>
            </select>
            <span class="text-danger"> 
                @error('MR_sex') 
                  {{ $message }} 
                @enderror
              </span>
        </div>
        <div class="col-md-4">
            <label for="MR_placeOfBirth" class="form-label h6">Place of Birth</label>
            <input type="text" class="form-control" id="MR_placeOfBirth" name="MR_placeOfBirth" oninput="this.value = this.value.toUpperCase()" required>
            <span class="text-danger"> 
                @error('MR_placeOfBirth') 
                  {{ $message }} 
                @enderror
              </span>
        </div>
        <div class="col-md-2">
            <label for="MR_civilStatus" class="form-label h6">Civil Status</label>
            <select id="MR_civilStatus" name="MR_civilStatus" class="form-select" required>
                <option selected="selected" disabled="disabled" value="">SELECT</option>
                <option value="SINGLE">SINGLE</option>
                <option value="MARRIED" class="alternate">MARRIED</option>
                <option value="DIVORCED">DIVORCED</option>
                <option value="SEPARATED" class="alternate">SEPARATED</option>
                <option value="WIDOWED">WIDOWED</option>
            </select>
            <span class="text-danger"> 
                @error('MR_civilStatus') 
                  {{ $message }} 
                @enderror
              </span>
        </div>
        <div class="col-md-4">
            <label for="MR_nationality" class="form-label h6">Nationality</label>
            <input type="text" class="form-control" id="MR_nationality" name="MR_nationality" oninput="this.value = this.value.toUpperCase()" required>
            <span class="text-danger"> 
                @error('MR_nationality') 
                  {{ $message }} 
                @enderror
              </span>
        </div>
        <div class="col-md-2">
            <label for="MR_religion" class="form-label h6">Religion</label>
            <input type="text" class="form-control" id="MR_religion" name="MR_religion" oninput="this.value = this.value.toUpperCase()" required>
            <span class="text-danger"> 
                @error('MR_religion') 
                  {{ $message }} 
                @enderror
              </span>
        </div>
        <div class="col-md-12">
            <label for="MR_address" class="form-label h6">Home Address</label>
            <input type="text" class="form-control" id="MR_address" name="MR_address" oninput="this.value = this.value.toUpperCase()" required>
            <span class="text-danger"> 
                @error('MR_address') 
                  {{ $message }} 
                @enderror
              </span>
        </div>
        <div class="col-md-6">
            <label for="MR_fatherName" class="form-label h6">Father's Name</label>
            <input type="text" class="form-control" id="MR_fatherName" name="MR_fatherName" oninput="this.value = this.value.toUpperCase()" required>
            <span class="text-danger"> 
                @error('MR_fatherName') 
                  {{ $message }} 
                @enderror
              </span>
        </div>
        <div class="col-md-6">
            <label for="MR_motherName" class="form-label h6">Mother's Name</label>
            <input type="text" class="form-control" id="MR_motherName" name="MR_motherName" oninput="this.value = this.value.toUpperCase()" required>
            <span class="text-danger"> 
                @error('MR_motherName') 
                  {{ $message }} 
                @enderror
              </span>
        </div>
        <div class="col-md-6">
            <label for="MR_fatherOccupation" class="form-label h6">Father's Occupation</label>
            <input type="text" class="form-control" id="MR_fatherOccupation" name="MR_fatherOccupation" oninput="this.value = this.value.toUpperCase()">
            <span class="text-danger"> 
                @error('MR_fatherOccupation') 
                  {{ $message }} 
                @enderror
              </span>
        </div>
        <div class="col-md-6">
            <label for="MR_motherOccupation" class="form-label h6">Mother's Occupation</label>
            <input type="text" class="form-control" id="MR_motherOccupation" name="MR_motherOccupation" oninput="this.value = this.value.toUpperCase()">
            <span class="text-danger"> 
                @error('MR_motherOccupation') 
                  {{ $message }} 
                @enderror
              </span>
        </div>
        <div class="col-md-6">
            <label for="MR_fatherOffice" class="form-label h6">Office Address of Father</label>
            <input type="text" class="form-control" id="MR_fatherOffice" name="MR_fatherOffice" oninput="this.value = this.value.toUpperCase()">
            <span class="text-danger"> 
                @error('MR_fatherOffice') 
                  {{ $message }} 
                @enderror
              </span>
        </div>
        <div class="col-md-6">
            <label for="MR_motherOffice" class="form-label h6">Office Address of Mother</label>
            <input type="text" class="form-control" id="MR_motherOffice" name="MR_motherOffice" oninput="this.value = this.value.toUpperCase()">
            <span class="text-danger"> 
                @error('MR_motherOffice') 
                  {{ $message }} 
                @enderror
              </span>
        </div>
        <div class="col-md-6">
            <label for="MR_guardian" class="form-label h6">Guardian's Name</label>
            <input type="text" class="form-control" id="MR_guardian" name="MR_guardianName" placeholder="skip if not applicable" oninput="this.value = this.value.toUpperCase()">
        </div>
        <div class="col-md-6">
            <label for="MR_parentGuardianContactNumber" class="form-label h6">Parent's/Guardian's Contact No.</label>
            <input type="text" class="form-control" placeholder="09123456789" id="MR_parentGuardianContactNumber" name="MR_parentGuardianContactNumber" required>
            <span class="text-danger"> 
                @error('MR_parentGuardianContactNumber') 
                  {{ $message }} 
                @enderror
              </span>
        </div>
        <div class="col-md-6">
            <label for="MR_guardianAddress" class="form-label h6">Guardian's Address</label>
            <input type="text" class="form-control" id="MR_guardianAddress" name="MR_guardianAddress" placeholder="skip if not applicable" oninput="this.value = this.value.toUpperCase()">
        </div>
        <div class="col-md-6">
            <label for="MR_studentContactNumber" class="form-label h6">Student's Contact No.</label>
            <input type="text" class="form-control" placeholder="09123456789" id="MR_studentContactNumber" name="MR_studentContactNumber" required>
            <span class="text-danger"> 
                @error('MR_studentContactNumber') 
                  {{ $message }} 
                @enderror
              </span>
        </div>
        
        <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
            <header class="text-center">
                <!-- LINE BREAK -->
            </header>
        </section>

        <h5>Please click the box if one of the following is applicable to you</h5>

        <!--Family and Social History-->
        <div class="mx-auto row row-cols-lg-2 row-cols-md-1"><!-- START DIV FOR FAMILY HISTORY AND PSH -->
            <div class="col-lg-7 col-md-12 p-2 border border-dark border-lg-end-0">
                <h5>Family History</h5>
                <div class="d-flex flex-row checkboxes">
                    <div class="col-md-4 p-2">
                        <div class="form-check">
                            <input type="hidden" value="0" name="FH_cancer">
                            <input class="form-check-input" type="checkbox" value="1" name="FH_cancer">
                                <label class="form-check-label" for="FH_cancer">
                                    Cancer
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input type="hidden" value="0" name="FH_heartDisease">
                            <input class="form-check-input" type="checkbox" value="1" name="FH_heartDisease">
                                <label class="form-check-label" for="FH_heartDisease">
                                    Heart Disease
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input type="hidden" value="0" name="FH_hypertension">
                            <input class="form-check-input" type="checkbox" value="1" name="FH_hypertension">
                                <label class="form-check-label" for="FH_hypertension">
                                    Hypertension
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input type="hidden" value="0" name="FH_thyroidDisease">
                            <input class="form-check-input" type="checkbox" value="1" name="FH_thyroidDisease">
                                <label class="form-check-label" for="FH_thyroidDisease">
                                    Thyroid Disease
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input type="hidden" name="FH_tuberculosis" value="0">
                            <input class="form-check-input" type="checkbox" value="1" name="FH_tuberculosis">
                                <label class="form-check-label" for="FH_tuberculosis">
                                    Tuberculosis
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div><!-- END OF COL DIV -->
                    <div class="col-md-4 p-2">
                        <div class="form-check">
                            <input type="hidden" value="0" name="FH_diabetesMelittus">
                            <input class="form-check-input" type="checkbox" value="1" name="FH_diabetesMelittus">
                                <label class="form-check-label" for="FH_diabetesMelittus">
                                    Diabetes Melittus
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input type="hidden" name="FH_mentalDisorder" value="0">
                            <input class="form-check-input" type="checkbox" value="1" name="FH_mentalDisorder">
                                <label class="form-check-label" for="FH_mentalDisorder">
                                    Mental Disorder
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input type="hidden" name="FH_asthma" value="0">
                            <input class="form-check-input" type="checkbox" value="1" name="FH_asthma">
                                <label class="form-check-label" for="FH_asthma">
                                    Asthma
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input type="hidden" name="FH_convulsions" value="0">
                            <input class="form-check-input" type="checkbox" value="1" name="FH_convulsions">
                                <label class="form-check-label" for="FH_convulsions">
                                    Convulsions
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input type="hidden" name="FH_bleedingDyscrasia" value="0">
                            <input class="form-check-input" type="checkbox" value="1" name="FH_bleedingDyscrasia">
                                <label class="form-check-label" for="FH_bleedingDyscrasia">
                                    Bleeding Dyscrasia
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div><!-- END OF COL DIV -->
                    <div class="col-md-4 p-2">
                        <div class="form-check">
                            <input type="hidden" name="FH_eyeDisorder" value="0">
                            <input class="form-check-input" type="checkbox" value="1" name="FH_eyeDisorder">
                                <label class="form-check-label" for="FH_eyeDisorder">
                                    Eye Disorder
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input type="hidden" name="FH_skinProblems" value="0">
                            <input class="form-check-input" type="checkbox" value="1" name="FH_skinProblems">
                                <label class="form-check-label" for="FH_skinProblems">
                                    Skin Problems
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input type="hidden" name="FH_kidneyProblems" value="0">
                            <input class="form-check-input" type="checkbox" value="1" name="FH_kidneyProblems">
                                <label class="form-check-label" for="FH_kidneyProblems">
                                    Kidney Problems
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input type="hidden" name="FH_gastroDisease" value="0">
                            <input class="form-check-input" type="checkbox" value="1" name="FH_gastroDisease">
                                <label class="form-check-label" for="FH_gastroDisease">
                                    Gastrointestinal Disease
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div><!-- END OF COL DIV --> 
                </div><!-- END OF ROW of CHECKBOXES DIV -->
            <div class="form-row align-items-center">
                <div class="col p-2">
                    <input type="hidden" name="FH_others" value="0">
                    <input class="form-check-input" type="checkbox" value="1" id="FH_others" name="FH_others">
                        <label class="form-check-label" for="FH_others" style="display: contents!important;">
                            Others
                        </label>
                            <input type="hidden" name="FH_othersDetails" value="N/A">
                            <input type="text" class="form-control input-sm" id="FH_othersDetails" name="FH_othersDetails" placeholder="separate with comma(,) if multiple" disabled>
                            <span class="text-danger"> 
                                @error('FH_othersDetails') 
                                  {{ $message }} 
                                @enderror
                              </span>    
                            <!-- SCRIPT FOR INPUT TOGGLE ON CHECKBOX TICK -->
                                <script>
                                    const fhOthers = document.getElementById('FH_others');
                                    const fhOthersDetails = document.getElementById('FH_othersDetails');
                                    
                                    fhOthers.onchange = function() {
                                        if (this.checked) {
                                            fhOthersDetails.disabled = false;
                                            fhOthersDetails.required = true;
                                        } else {
                                            fhOthersDetails.disabled = true;
                                            fhOthersDetails.required = false;
                                        }
                                    };

                                    // Initialize the form state on page load
                                    if (fhOthers.checked) {
                                        fhOthersDetails.disabled = false;
                                        fhOthersDetails.required = true;
                                    } else {
                                        fhOthersDetails.disabled = true;
                                        fhOthersDetails.required = false;
                                    }
                                </script>
                    </div><!-- END OF COL OTHERS DIV -->
                </div><!-- END OF ROW OTHERS DIV -->
            </div><!-- END OF COL FH -->

            <!-- START OF PSH -->
            <div class="col-lg-5 col-md-12 p-2 border border-dark">
                <h6>Personal Social History</h6>
                    <div class="form-check">
                    <input type="hidden" name="PSH_smoking" value="0">
                    <input class="form-check-input" type="checkbox" value="1" id="PSH_smoking" name="PSH_smoking">
                        <label class="form-check-label" for="PSH_smoking" style="display: contents!important;">
                            Smoking
                            <br>
                            ( <input type="text" class="col-md-2" id="PSH_smoking_amount" name="PSH_smoking_amount" disabled> 
                            <span class="text-danger"> 
                                @error('PSH_smoking_amount') 
                                  {{ $message }} 
                                @enderror
                              </span>  
                            sticks/day for 
                            <input type="text" class="col-md-2"  id="PSH_smoking_freq" name="PSH_smoking_freq" disabled> year/s )
                            <span class="text-danger"> 
                                @error('PSH_smoking_freq') 
                                  {{ $message }} 
                                @enderror
                              </span>  
                        </label>
                </div><!-- END OF SMOKING FORM DIV -->

                <div class="form-check" style="margin-top:5%;">
                    <input type="hidden" name="PSH_drinking" value="0">
                    <input class="form-check-input" type="checkbox" value="1" id="PSH_drinking" name="PSH_drinking">
                        <label class="form-check-label" for="PSH_drinking" style="display: contents!important;">
                            Drinking 
                            <br>
                            ( <input type="text" class="col-md-4" id="PSH_drinking_amountOfBeer" name="PSH_drinking_amountOfBeer" disabled>
                            <span class="text-danger"> 
                                @error('PSH_drinking_amountOfBeer') 
                                  {{ $message }} 
                                @enderror
                              </span>  
                             Beer per 
                             <input type="text" class="col-md-4" id="PSH_drinking_freqOfBeer" name="PSH_drinking_freqOfBeer" disabled> ) 
                             <span class="text-danger"> 
                                @error('PSH_drinking_freqOfBeer') 
                                  {{ $message }} 
                                @enderror
                              </span>  
                            <br>
                                or
                            <br>
                            ( <input type="text" class="col-md-4" id="PSH_drinking_amountofShots" name="PSH_drinking_amountofShots" disabled>
                            <span class="text-danger"> 
                                @error('PSH_drinking_amountofShots') 
                                  {{ $message }} 
                                @enderror
                              </span>  
                             Shots per 
                             <input type="text" class="col-md-4" id="PSH_drinking_freqOfShots" name="PSH_drinking_freqOfShots" disabled>)
                             <span class="text-danger"> 
                                @error('PSH_drinking_freqOfShots') 
                                  {{ $message }} 
                                @enderror
                              </span>  
                        </label>
                </div><!-- END OF DRINKING FORM DIV -->

                    <!-- SCRIPT FOR INPUT TOGGLE ON CHECKBOX TICK -->
                <script>
                   $(document).ready(function() {
                        /* SMOKING */
                        $('#PSH_smoking').change(function() {
                            $('#PSH_smoking_amount').prop('disabled', !this.checked);
                            $('#PSH_smoking_freq').prop('disabled', !this.checked);
                        });
                        
                        /* DRINKING */
                        $('#PSH_drinking').change(function() {
                            $('#PSH_drinking_amountOfBeer').prop('disabled', !this.checked);
                            $('#PSH_drinking_freqOfBeer').prop('disabled', !this.checked);
                            $('#PSH_drinking_amountofShots').prop('disabled', !this.checked);
                            $('#PSH_drinking_freqOfShots').prop('disabled', !this.checked);
                        });
                    });

                </script>

            </div><!-- END OF PSH COL DIV -->
        </div><!-- END OF ROW ENTIRE DIV -->

        <!--Personal History-->
        <h5 class="ms-1">Personal History</h5>
        <div class="mx-auto row row-cols-lg-2 row-cols-md-1"><!-- START DIV FOR PAST AND PRESENT ILLNESS -->
            <div class="col-lg-6 col-md-12 p-2 border border-dark border-lg-end-0">
                <h6>Past Ilness</h6>
                     <div class="d-flex flex-row">
                            <div class="col-md-4 p-2">
                                <div class="form-check">
                                    <input type="hidden" name="pi_primaryComplex" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="pi_primaryComplex">
                                        <label class="form-check-label" for="pi_primaryComplex">
                                            Primary Complex
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input type="hidden" name="pi_chickenPox" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="pi_chickenPox">
                                        <label class="form-check-label" for="pi_chickenPox">
                                            Chicken Pox
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input type="hidden" name="pi_kidneyDisease" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="pi_kidneyDisease">
                                        <label class="form-check-label" for="pi_kidneyDisease">
                                            Kidney Disease
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input type="hidden" name="pi_typhoidFever" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="pi_typhoidFever">
                                        <label class="form-check-label" for="pi_typhoidFever">
                                            Typhoid Fever
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input type="hidden" name="pi_earProblems" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="pi_earProblems">
                                        <label class="form-check-label" for="pi_earProblems">
                                            Ear Problems
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input type="hidden" name="pi_heartDisease" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="pi_heartDisease">
                                       <label class="form-check-label" for="pi_heartDisease">
                                           Heart Disease
                                       </label>
                               </div><!-- END OF CHECKBOX DIV -->
                               <div class="form-check">
                                    <input type="hidden" name="pi_leukemia" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="pi_leukemia">
                                        <label class="form-check-label" for="pi_leukemia">
                                            Leukemia
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                            </div><!-- END OF CHECKBOX 1ST COL DIV -->
                            <div class="col-md-4 p-2">
                                <div class="form-check">
                                    <input type="hidden" name="pi_asthma" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="pi_asthma">
                                        <label class="form-check-label" for="pi_asthma">
                                            Asthma
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input type="hidden" name="pi_diabetes" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="pi_diabetes">
                                        <label class="form-check-label" for="pi_diabetes">
                                            Diabetes
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input type="hidden" name="pi_eyeDisorder" value="0">
                                   <input class="form-check-input" type="checkbox" value="1" name="pi_eyeDisorder">
                                       <label class="form-check-label" for="pi_eyeDisorder">
                                           Eye Disorder
                                       </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input type="hidden" name="pi_pneumonia" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="pi_pneumonia">
                                        <label class="form-check-label" for="pi_pneumonia">
                                            Pneumonia
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input type="hidden" name="pi_dengue" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="pi_dengue">
                                        <label class="form-check-label" for="pi_dengue">
                                            Dengue
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input type="hidden" name="pi_measles" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="pi_measles">
                                        <label class="form-check-label" for="pi_measles">
                                            Measles
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input type="hidden" name="pi_hepatitis" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="pi_hepatitis">
                                        <label class="form-check-label" for="pi_hepatitis">
                                            Hepatitis
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                            </div><!-- END OF CHECKBOX 2ND COL DIV -->
                            <div class="col-md-4 p-2">
                                <div class="form-check">
                                    <input type="hidden" name="pi_rheumaticFever" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="pi_rheumaticFever">
                                        <label class="form-check-label" for="pi_rheumaticFever">
                                            Rheumatic Fever
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input type="hidden" name="pi_mentalDisorder" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="pi_mentalDisorder">
                                        <label class="form-check-label" for="pi_mentalDisorder">
                                            Mental Disorder
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input type="hidden" name="pi_skinProblems" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="pi_skinProblems">
                                        <label class="form-check-label" for="pi_skinProblems">
                                            Skin Problems
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input type="hidden" name="pi_poliomyetis" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="pi_poliomyetis">
                                        <label class="form-check-label" for="pi_poliomyetis">
                                            Poliomyetis
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input type="hidden" name="pi_thyroidDisorder" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="pi_thyroidDisorder">
                                        <label class="form-check-label" for="pi_thyroidDisorder">
                                            Thyroid Disorder
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input type="hidden" name="pi_anemia" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="pi_anemia">
                                        <label class="form-check-label" for="pi_anemia">
                                            Anemia
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input type="hidden" name="pi_mumps" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="pi_mumps">
                                        <label class="form-check-label" for="pi_mumps">
                                            Mumps
                                        </label>
                                    </div><!-- END OF CHECKBOX DIV -->
                                </div><!-- END OF CHECKBOX 3ND COL DIV -->
                            </div><!-- END OF PAST ILLNESS CHECKBOX ROW DIV -->
                        </div><!-- END OF PAST ILLNESS ROW DIV -->
                  <div class="col-lg-6 col-md-12 p-2 border border-dark">
                        <h6>Present Ilness</h6>       
                            <div class="d-flex flex-row">
                                <div class="col-md-4 p-2">
                                    <div class="form-check">
                                    <input type="hidden" name="PI_chestPain" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="PI_chestPain">
                                        <label class="form-check-label" for="PI_chestPain">
                                            Chest Pain
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input type="hidden" name="PI_insomnia" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="PI_insomnia">
                                        <label class="form-check-label" for="PI_insomnia">
                                            Insomnia
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input type="hidden" name="PI_jointPains" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="PI_jointPains">
                                        <label class="form-check-label" for="PI_jointPains">
                                            Joint Pains
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input type="hidden" name="PI_dizziness" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="PI_dizziness">
                                        <label class="form-check-label" for="PI_dizziness">
                                            Dizzines
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                            </div><!-- END OF CHECKBOX 1ST COL DIV -->
                            <div class="col-md-4 p-2">
                                <div class="form-check">
                                    <input type="hidden" name="PI_headaches" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="PI_headaches">
                                        <label class="form-check-label" for="PI_headaches">
                                            Headaches
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input type="hidden" name="PI_indigestion" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="PI_indigestion">
                                        <label class="form-check-label" for="PI_indigestion">
                                            Indigestion
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input type="hidden" name="PI_swollenFeet" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="PI_swollenFeet">
                                       <label class="form-check-label" for="PI_swollenFeet">
                                           Swollen Feet
                                       </label>
                               </div><!-- END OF CHECKBOX DIV -->
                               <div class="form-check">
                                    <input type="hidden" name="PI_weightLoss" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="PI_weightLoss">
                                        <label class="form-check-label" for="PI_weightLoss">
                                            Weight Loss
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                            </div><!-- END OF CHECKBOX 2ND COL DIV -->
                            <div class="col-md-4 p-2">
                                <div class="form-check">
                                    <input type="hidden" name="PI_nauseaOrVomiting" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="PI_nauseaOrVomiting">
                                        <label class="form-check-label" for="PI_nauseaOrVomiting">
                                            Nausea/Vomiting
                                        </label>
                                </div>
                                <div class="form-check">
                                    <input type="hidden" name="PI_soreThroat" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="PI_soreThroat">
                                        <label class="form-check-label" for="PI_soreThroat">
                                            Sore Throat
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input type="hidden" name="PI_frequentUrination" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="PI_frequentUrination">
                                        <label class="form-check-label" for="PI_frequentUrination">
                                            Frequent Urination
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input type="hidden" name="PI_difficultyOfBreathing" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="PI_difficultyOfBreathing">
                                        <label class="form-check-label" for="PI_difficultyOfBreathing">
                                            Diffculty of Breathing
                                        </label>
                                </div> <!-- END OF CHECKBOX DIV -->    
                            </div><!-- END OF CHECKBOX 3RD COL DIV -->
                        </div><!-- END OF CHECKBOX ROW DIV -->
                        <div class="form-row align-items-center">
                            <div class="col p-2">
                                <input type="hidden" name="PI_others" value="0">
                                <input class="form-check-input" type="checkbox" value="1" id="PI_others" name="PI_others">
                                    <label class="form-check-label" for="PI_others" style="display: contents!important;">
                                        <span class="h6">Others</span>
                                    </label>
                                        <input type="text" class="form-control input-sm" id="PI_othersDetails" name="PI_othersDetails" placeholder="separate with comma(,) if multiple" disabled>
                                        <span class="text-danger"> 
                                            @error('PI_othersDetails') 
                                              {{ $message }} 
                                            @enderror
                                          </span>     
                                        <!-- SCRIPT FOR INPUT TOGGLE ON CHECKBOX TICK -->
                                        <script>
                                            document.getElementById('PI_others').onchange = function() {
                                            document.getElementById('PI_othersDetails').disabled = !this.checked;
                                            };
                                        </script>
                            </div><!-- END OF OTHERS COL DIV -->
                        </div><!-- END OF OTHERS ROW DIV -->
                </div><!-- END OF PRESENT ILLNESS DIV -->
        </div><!-- END OF PAST AND PRESENT ILLNESS DIV -->

        <!--Medical Status
                    HOSPITALIZATION-->
        <div class="mx-auto row row-cols-lg-1 mt-2">
            <div class="col-md-12 p-2 border border-dark">  
                <div class="d-flex flex-row">
                    <div class="col-sm">
                     Do you have history of hospitalization for serious illness, operation, fracture or injury?
                        (<div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="hospitalization" id="hospitalization_YES" value="1" required/>
                            <label class="form-check-label" for="hospitalization_YES" style="margin-right: -15px; margin-left:-5px">
                            yes
                            </label>
                        </div><!-- END OF YES DIV -->
                        &nbsp;
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="hospitalization" id="hospitalization_NO" value="0"/>
                            <label class="form-check-label" for="hospitalization_NO" style="margin-right: -15px; margin-left:-5px">
                            no
                            </label>
                        </div>)<!-- END OF NO DIV -->
                        If yes, please give details:
                        <input type="text" class="col-sm-10" id="hospitalizationDetails" name="hospitalizationDetails" disabled/>
                        <span class="text-danger"> 
                            @error('hospitalizationDetails') 
                              {{ $message }} 
                            @enderror
                          </span>  
                            <!-- SCRIPT FOR TOGGLE DETAILS IF YES/NO -->
                            <script>
                                $(document).ready(function() {
                                    $('#hospitalization_YES, #hospitalization_NO').change(function() {
                                        if ($('#hospitalization_YES').is(':checked')) {
                                            $('#hospitalizationDetails').prop('disabled', false);
                                        } else if ($('#hospitalization_NO').is(':checked')) {
                                            $('#hospitalizationDetails').prop('disabled', true);
                                        }
                                    });
                                });
                            </script>
                            <!-- END OF SCRIPT --> 
                    </div><!-- END OF COL DIV -->
                </div><!-- END OF ROW DIV -->

                <!-- REGULAR MEDICINES -->
                <div class="d-flex flex-row pt-2">
                    <div class="col-sm">
                        Are you taking any medicine regularly?
                           (<div class="form-check form-check-inline">
                               <input class="form-check-input" type="radio" name="regMeds" id="regMeds_YES" value="1" required/>
                               <label class="form-check-label" for="regMeds_YES" style="margin-right: -15px; margin-left:-5px">
                               yes
                               </label>
                           </div><!-- END OF YES DIV -->
                           &nbsp;
                           <div class="form-check form-check-inline">
                               <input class="form-check-input" type="radio" name="regMeds" id="regMeds_NO" value="0"/>
                               <label class="form-check-label" for="regMeds_NO" style="margin-right: -15px; margin-left:-5px">
                               no
                               </label>
                           </div>)<!-- END OF NO DIV -->
                           If yes, name of drug/s:
                           <input type="text" class="col-sm-10" id="regMedsDetails" name="regMedsDetails" disabled/>
                           <span class="text-danger"> 
                            @error('regMedsDetails') 
                              {{ $message }} 
                            @enderror
                          </span>  
                               <!-- SCRIPT FOR TOGGLE DETAILS IF YES/NO -->
                               <script>
                                   $(document).ready(function() {
                                       $('#regMeds_YES, #regMeds_NO').change(function() {
                                           if ($('#regMeds_YES').is(':checked')) {
                                               $('#regMedsDetails').prop('disabled', false);
                                           } else if ($('#regMeds_NO').is(':checked')) {
                                               $('#regMedsDetails').prop('disabled', true);
                                           }
                                       });
                                   });
                               </script>
                               <!-- END OF SCRIPT --> 
                       </div><!-- END OF COL DIV -->
                   </div><!-- END OF ROW DIV -->

                   <!-- ALLERGIES -->
                   <div class="col-sm" required>
                    Are you allergic to any food or medicine?
                       (<div class="form-check form-check-inline">
                           <input class="form-check-input" type="radio" name="allergy" id="allergy_YES" value="1" required/>
                           <label class="form-check-label" for="allergy_YES" style="margin-right: -15px; margin-left:-5px">
                           yes
                           </label>
                       </div><!-- END OF YES DIV -->
                       &nbsp;
                       <div class="form-check form-check-inline">
                           <input class="form-check-input" type="radio" name="allergy" id="allergy_NO" value="0"/>
                           <label class="form-check-label" for="allergy_NO" style="margin-right: -15px; margin-left:-5px">
                           no
                           </label>
                       </div>)<!-- END OF NO DIV -->
                       If yes, specify:
                       <input type="text" class="col-sm-10" id="allergyDetails" name="allergyDetails" disabled/>
                       <span class="text-danger"> 
                        @error('allergyDetails') 
                          {{ $message }} 
                        @enderror
                      </span> 
                           <!-- SCRIPT FOR TOGGLE DETAILS IF YES/NO -->
                           <script>
                               $(document).ready(function() {
                                   $('#allergy_YES, #allergy_NO').change(function() {
                                       if ($('#allergy_YES').is(':checked')) {
                                           $('#allergyDetails').prop('disabled', false);
                                       } else if ($('#allergy_NO').is(':checked')) {
                                           $('#allergyDetails').prop('disabled', true);
                                       }
                                   });
                               });
                           </script>
                           <!-- END OF SCRIPT --> 
                   </div><!-- END OF COL DIV -->
               </div><!-- END OF ROW DIV -->    

        </div>   
        
        <!--Immunization History-->
        <div class="mx-auto row row-cols-lg-1 mt-2">
            <div class="col-md-12 p-2 border border-dark">
                <h6>Immunization History</h6>
                <div class="my-auto row row-cols-xl-5 row-cols-lg-4 row-cols-md-2 align-items-center" style="margin-left: 5%;">
                    <div class="col-sm-1 p-2">
                        <input type="hidden" name="IH_bcg" value="0">
                        <input class="form-check-input" type="checkbox" value="1" name="IH_bcg">
                            <label class="form-check-label" for="IH_bcg" data-toggle="tooltip" data-placement="top" title="Bacille Calmette-Guerin">
                                BCG
                            </label>
                    </div>
                    <div class="col-sm-3 p-2">
                        <input type="hidden" name="IH_polio" value="0">
                        <input class="form-check-input" type="checkbox" value="1"name="IH_polio">
                            <label class="form-check-label" for="IH_polio">
                                Polio I, II, II, Booster Dose
                            </label>
                    </div>
                    <div class="col-sm-2 p-2">
                        <input type="hidden" name="IH_mumps" value="0">
                        <input class="form-check-input" type="checkbox" value="1" name="IH_mumps">
                            <label class="form-check-label" for="IH_mumps">
                                Mumps
                            </label>
                    </div>
                    <div class="col-sm-2 p-2">
                        <input type="hidden" name="IH_typhoid" value="0">
                        <input class="form-check-input" type="checkbox" value="1" name="IH_typhoid">
                            <label class="form-check-label" for="IH_typhoid">
                                Typhoid
                            </label>
                    </div>
                    <div class="col-sm-3 p-2">
                        <input type="hidden" name="IH_hepatitisA" value="0">
                        <input class="form-check-input" type="checkbox" value="1" name="IH_hepatitisA">
                            <label class="form-check-label" for="IH_hepatitisA">
                                Hepatitis A
                            </label>
                    </div>
                    <div class="w-100"></div>
                    <!-- NEW LINE -->
                    <div class="col-sm-2 p-2">
                        <input type="hidden" name="IH_chickenPox" value="0">
                        <input class="form-check-input" type="checkbox" value="1" name="IH_chickenPox">
                            <label class="form-check-label" for="IH_chickenPox">
                                Chicken Pox
                            </label>
                    </div>
                    <div class="col-sm-3 p-2">
                        <input type="hidden" name="IH_dpt" value="0">
                        <input class="form-check-input" type="checkbox" value="1" name="IH_dpt">
                            <label class="form-check-label" for="IH_dpt">
                                DPT I, II, III, Booster Dose
                            </label>
                    </div>
                    <div class="col-sm-2 p-2">
                        <input type="hidden" name="IH_measles" value="0">
                        <input class="form-check-input" type="checkbox" value="1" name="IH_measles">
                            <label class="form-check-label" for="IH_measles">
                                Measles
                            </label>
                    </div>
                    <div class="col-sm-2 p-2">
                        <input type="hidden" name="IH_germanMeasles" value="0">
                        <input class="form-check-input" type="checkbox" value="1" name="IH_germanMeasles">
                            <label class="form-check-label" for="IH_germanMeasles">
                                German Measles
                            </label>
                    </div>
                    <div class="col-sm-3 p-2">
                        <input type="hidden" name="IH_hepatitisB" value="0">
                        <input class="form-check-input" type="checkbox" value="1" name="IH_hepatitisB">
                            <label class="form-check-label" for="IH_hepatitisB">
                                Hepatitis B
                            </label>
                    </div>
                    <div class="w-100"></div>
                    <!-- NEW LINE -->
                    <div class="col-sm-1 p-2">
                        <input type="hidden" name="IH_others" value="0">
                        <input class="form-check-input" type="checkbox" value="1" id="IH_others" name="IH_others">
                            <label class="form-check-label" for="IH_others">
                                Others
                            </label>
                    </div>
                    <div class="col-sm-9 p-2">
                            <input type="text" class="col-sm-12" id="IH_othersDetails" name="IH_othersDetails" disabled>
                            <span class="text-danger"> 
                                @error('IH_othersDetails') 
                                  {{ $message }} 
                                @enderror
                              </span> 
                    </div>
                    <script>
                        document.getElementById('IH_others').onchange = function() {
                        document.getElementById('IH_othersDetails').disabled = !this.checked;
                        };
                    </script>
            </div>
        </div>
    </div>
    <!-- ATTACHMENTS -->
    <div class="d-flex flex-row">
        <div class="col-md-12 p-1 border border-dark">
            <p class="fs-5 text-center">Please upload a photo of the official reading and result of the following:</p>
            <div class="flex justify-content-center">
                <div class="row row-cols-xl-4 row-cols-lg-2 row-cols-md-1 row-cols-sm-1 my-auto px-5 py-4">
                    <div class="mb-3 col-3 d-flex flex-column justify-content-center align-items-center" >
                        <label for="MR_studentSignature" class="form-label fw-bold">Chest X-Ray Findings</label>
                        <input type="file" class="form-control" id="MR_studentSignature" name="MR_studentSignature" accept="image/jpeg, image/png" required>
                    </div>
                    <div class="mb-3 col-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="MR_cbcresults" class="form-label fw-bold">CBC Results</label>
                        <input type="file" class="form-control" id="MR_cbcresults" name="MR_cbcresults" accept="image/jpeg, image/png" required>
                      </div>                      
                    <div class="mb-3 col-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="MR_hepaBscreening" class="form-label fw-bold">Hepatitis B Screening</label>
                        <input type="file" class="form-control" id="MR_hepaBscreening" name="MR_hepaBscreening" accept="image/jpeg, image/png" required>
                    </div> 
                    <div class="mb-3 col-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="MR_bloodtype" class="form-label fw-bold">Blood Type</label>
                        <input type="file" class="form-control" id="MR_bloodtype" name="MR_bloodtype" accept="image/jpeg, image/png" required>
                    </div>
                </div>
                    <div id="resultsContainer" class="row row-cols-xl-4 row-cols-lg-2 row-cols-md-1 row-cols-sm-1 my-auto px-5 py-4">
                        <script>
                            let maxResults = 8;
                            let currentResults = 0;
                            let nextResultId = 1;
                            let lastRemovedResultId = null;
                        
                            const addResult = () => {
                                if (currentResults < maxResults) {
                                    if (lastRemovedResultId !== null) {
                                        nextResultId = lastRemovedResultId;
                                        lastRemovedResultId = null;
                                    } else {
                                        nextResultId = currentResults + 1;
                                    }
                        
                                    let container = document.getElementById('resultsContainer');
                                    let resultDiv = document.createElement('div');
                                    resultDiv.id = `result${nextResultId}`;
                                    resultDiv.classList.add('mb-3', 'col-3', 'd-flex', 'flex-column', 'justify-content-center', 'align-items-center');
                                    resultDiv.innerHTML = `
                                        <div class="align-items-center" style="display: flex; flex-direction: row;">
                                            <label for="MR_additionalResult${nextResultId}" class="form-label fw-bold me-5" style="margin-right: 20px;">
                                                Results for:
                                            </label>
                                            <button type="button" class="btn btn-sm btn-light ms-5" style="margin-bottom: 5px; "margin-left: 200px;" onclick="removeResult('${nextResultId}')">&times;</button>
                                        </div>
                                        <input type="text" class="form-control my-1" id="MR_additionalResult${nextResultId}" name="MR_additionalResult${nextResultId}" placeholder="e.g. Urinalisys, Diabetes, ECG">
                                        <input type="file" class="form-control my-1" id="MR_additionalUpload${nextResultId}" name="MR_additionalUpload${nextResultId}" accept="image/jpeg, image/png" required>
                                    `;
                                    container.appendChild(resultDiv);
                                    currentResults++;
                        
                                    if (currentResults == maxResults) {
                                        document.getElementById('addResultButton').disabled = true;
                                    }
                                }
                            }
                        
                            const removeResult = (resultId) => {
                                let resultDiv = document.getElementById(`result${resultId}`);
                                resultDiv.remove();
                                currentResults--;
                                console.log(currentResults);
                                console.log(maxResults);
                        
                                if (currentResults < maxResults) {
                                    document.getElementById('addResultButton').disabled = false;
                                }
                        
                                if (resultId < nextResultId) {
                                    lastRemovedResultId = resultId;
                                }
                            }
                        </script>
                    </div>
                </div>
            <button type="button" id="addResultButton" class="btn btn-primary" onclick="addResult()">Add Result</button>
        </div>
    </div>
        <!--Signatures-->
        <div class="d-flex flex-row">
            <div class="col-md-12 p-1 border border-dark">
                <p class="fs-5 fst-italic text-center">I hereby certify that the foregoing answers are true and complete, and to the best of my knowledge.</p>
                    <div class="flex-row justify-content-center">
                        <div class="row row-cols-xl-2 row-cols-lg-1 row-cols-md-1 row-cols-sm-1 my-auto p-5 align-items-center">
                            <div class="mb-3 col-md-6">
                                <label for="MR_studentSignature" class="form-label">Student's Signature over printed name</label>
                                <input type="file" class="form-control" id="MR_studentSignature" name="MR_studentSignature" accept="image/jpeg, image/png" required>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="MR_parentGuardianSignature" class="form-label">Signature of parent/guardian over printed name</label>
                                <input type="file" class="form-control" id="MR_parentGuardianSignature" name="MR_parentGuardianSignature" accept="image/jpeg, image/png" required>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    <div class="row no-gutters justify-content-end pt-3 position-relative">
        <div class="col d-flex justify-content-end" style="margin-right:-1  %;">
            <button type="button" class="btn btn-lg btn-primary btn-login fw-bold mb-2" data-bs-toggle="modal" data-bs-target="#submitModal">
                Submit
            </button>
        </div>
    </div>
    
    <!-- Modal -->
    <div class="modal modal-xl fade" id="submitModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="submitModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="submitModalLabel">
                        Medical Form Submission
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <div class="modal-body">
                        <p class="fs-5 fw-bold text-center">Please review your responses carefully before submitting this medical form. </p>
                        <hr>
                        <p class="fs-5 text-center">By submitting this medical form, you are confirming that all the answers provided are true and correct to the best of your knowledge.</p>
                    </div>
                <div class="modal-footer row justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="input-group">
                            <label for="passwordInput" class="form-label h6 mt-2 me-2">Password:</label>
                            <input type="password" class="form-control" id="passwordInput" name="passwordInput" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <span class="bi bi-eye-fill" aria-hidden="true"></span>
                            </button>
                        </div>
                        <button type="button" class="btn btn-primary">
                            Understood
                        </button>

                        <script>
                            const passwordInput = document.getElementById('passwordInput');
                            const togglePassword = document.getElementById('togglePassword');
                            togglePassword.addEventListener('click', function() {
                                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                                passwordInput.setAttribute('type', type);
                                togglePassword.querySelector('span').classList.toggle('bi-eye-fill');
                                togglePassword.querySelector('span').classList.toggle('bi-eye-slash-fill');
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </form>    
</div> 
@endsection
