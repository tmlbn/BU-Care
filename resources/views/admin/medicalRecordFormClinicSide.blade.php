@extends('admin.layouts.app')

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
    @if($patient->hasValidatedRecord)
          <!-- HAS VALIDATED MEDICAL RECORD -->
          <i class="bi bi-person-check icon position-absolute top-0 end-0 fs-2" style="color:#f1731f;" data-toggle="tooltip" data-container="body" data-bs-placement="top" title="Validated Medical Record"></i>
        @else
          <!-- HAS MEDICAL RECORD BUT NOT VALIDATED -->
          <i class="bi bi-file-earmark-medical icon position-absolute top-0 end-0 fs-2" style="color:#f1731f;" data-toggle="tooltip" data-container="body" data-bs-placement="top" title="Medical Record not Validated"></i>
    @endif
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
    @if(session('fail'))
        <div class="alert alert-danger">
            {{ session('fail') }}
        </div>
    @endif
    @if(session('alreadySubmitted'))
        <div class="alert alert-danger">
            {{ session('alreadySubmitted') }}
        </div>
    @endif

<form method="POST" action="{{ route('medicalForm.store') }}" enctype="multipart/form-data" class="row g-3 pt-5 px-4">
    @csrf     
    <div class="container">
        <div class="mx-auto row row-cols-lg-4 row-cols-md-2 mt-2">
            <div class="col-xl-5 col-lg-6">
                <p class="h6">Campus</p>
                <input type="text" class="form-control" id="campusSelect" name="campusSelect" value="{{ $patient->medicalRecord->campus }}" readonly>
            </div>
            <div class="col-xl-5 col-lg-6 col-md-6">
                <p class="h6">Course</p>
                <input type="text" class="form-control" id="courseSelect" name="courseSelect" value="{{ $patient->medicalRecord->course }}" readonly>
            </div>
            <div class="col-xl-2 col-lg-12 col-md-12">
                <label for="schoolYearStart" class="form-label h6" style="white-space: nowrap;">School Year</label>
                <div class="d-flex align-items-center" style="margin-top:-1%;">
                    <input type="text" class="form-control me-1" id="schoolYearStart" name="schoolYearStart" value="{{ $patient->medicalRecord->SYstart }}" readonly>
                    <span class="fs-6">-</span>
                    <input type="text" class="form-control ms-1" id="schoolYearEnd" name="schoolYearEnd" value="{{ $patient->medicalRecord->SYend }}" readonly>
                </div>
            </div>
            
            
            
        </div>
    </div>   
    <div class="d-flex flex-row">
        <h4 class="pb-3"></h4>
    </div>   
        <div class="col-md-3">
            <label for="MR_lastName" class="form-label h6">Last Name</label>
            <input type="text" class="form-control" id="MR_lastName" name="MR_lastName" value="{{ $patient->medicalRecord->lastName }}" readonly>
        </div>
        <div class="col-md-3">
            <label for="MR_firstName" class="form-label h6">First Name</label>
            <input type="text" class="form-control" id="MR_firstName" name="MR_firstName" value="{{ $patient->medicalRecord->firstName }}" readonly>
        </div>
        <div class="col-md-3">
            <label for="MR_middleName" class="form-label h6">Middle Name</label>
            <input type="text" class="form-control" id="MR_middleName" name="MR_middleName" value="{{ $patient->medicalRecord->middleName }}" readonly>
        </div>
        <div class="col-md-1">
            <label for="MR_age" class="form-label h6">Age</label>
            <input type="text" class="form-control" id="MR_age" name="MR_age" value="{{ $patient->medicalRecord->age }}" readonly>
        </div>
        <div class="col-md-2">
            <label for="MR_sex" class="form-label h6">Sex</label>
            <input type="text" class="form-control" id="MR_sex" name="MR_sex" value="{{ $patient->medicalRecord->sex }}" readonly>
        </div>
        <div class="col-md-4">
            <label for="MR_placeOfBirth" class="form-label h6">Place of Birth</label>
            <input type="text" class="form-control" id="MR_placeOfBirth" name="MR_placeOfBirth" value="{{ $patient->medicalRecord->placeOfBirth }}" readonly>
        </div>
        <div class="col-md-2">
            <label for="MR_civilStatus" class="form-label h6">Civil Status</label>
            <input type="text" class="form-control" id="MR_civilStatus" name="MR_civilStatus" value="{{ $patient->medicalRecord->civilStatus }}" readonly>
        </div>
        <div class="col-md-4">
            <label for="MR_nationality" class="form-label h6">Nationality</label>
            <input type="text" class="form-control" id="MR_nationality" name="MR_nationality" value="{{ $patient->medicalRecord->nationality }}" readonly>
            </div>
        <div class="col-md-2">
            <label for="MR_religion" class="form-label h6">Religion</label>
            <input type="text" class="form-control" id="MR_religion" name="MR_religion" value="{{ $patient->medicalRecord->religion }}" readonly>
            </div>
        <div class="col-md-12">
            <label for="MR_address" class="form-label h6">Home Address</label>
            <input type="text" class="form-control" id="MR_address" name="MR_address" value="{{ $patient->medicalRecord->homeAddress }}" readonly>
            </div>
        <div class="col-md-6">
            <label for="MR_fatherName" class="form-label h6">Father's Name</label>
            <input type="text" class="form-control" id="MR_fatherName" name="MR_fatherName" value="{{ $patient->medicalRecord->fatherName }}" readonly>
            </div>
        <div class="col-md-6">
            <label for="MR_motherName" class="form-label h6">Mother's Name</label>
            <input type="text" class="form-control" id="MR_motherName" name="MR_motherName" value="{{ $patient->medicalRecord->motherName }}" readonly>
            </div>
        <div class="col-md-6">
            <label for="MR_fatherOccupation" class="form-label h6">Father's Occupation</label>
            <input type="text" class="form-control" id="MR_fatherOccupation" name="MR_fatherOccupation" value="{{ $patient->medicalRecord->fatherOccupation }}" readonly>
            </div>
        <div class="col-md-6">
            <label for="MR_motherOccupation" class="form-label h6">Mother's Occupation</label>
            <input type="text" class="form-control" id="MR_motherOccupation" name="MR_motherOccupation" value="{{ $patient->medicalRecord->motherOccupation }}" readonly>
            </div>
        <div class="col-md-6">
            <label for="MR_fatherOffice" class="form-label h6">Office Address of Father</label>
            <input type="text" class="form-control" id="MR_fatherOffice" name="MR_fatherOffice" value="{{ $patient->medicalRecord->fatherOfficeAddress }}" readonly>
            </div>
        <div class="col-md-6">
            <label for="MR_motherOffice" class="form-label h6">Office Address of Mother</label>
            <input type="text" class="form-control" id="MR_motherOffice" name="MR_motherOffice" value="{{ $patient->medicalRecord->motherOfficeAddress }}" readonly>
            </div>
        <div class="col-md-6">
            <label for="MR_guardian" class="form-label h6">Guardian's Name</label>
            <input type="text" class="form-control" id="MR_guardian" name="MR_guardianName" value="{{ $patient->medicalRecord->guardianName }}" readonly>
        </div>
        <div class="col-md-6">
            <label for="MR_parentGuardianContactNumber" class="form-label h6">Parent's/Guardian's Contact No.</label>
            <input type="text" class="form-control" id="MR_parentGuardianContactNumber" name="MR_parentGuardianContactNumber" value="0{{ $patient->medicalRecord->parentGuardianContactNumber }}" readonly>
            </div>
        <div class="col-md-6">
            <label for="MR_guardianAddress" class="form-label h6">Guardian's Address</label>
            <input type="text" class="form-control" id="MR_guardianAddress" name="MR_guardianAddress" value="{{ $patient->medicalRecord->guardianAddress }}" readonly>
        </div>
        <div class="col-md-6">
            <label for="MR_studentContactNumber" class="form-label h6">Student's Contact No.</label>
            <input type="text" class="form-control" id="MR_studentContactNumber" name="MR_studentContactNumber" value="0{{ $patient->medicalRecord->studentContactNumber }}" readonly>
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
                            <input class="form-check-input" type="checkbox" name="FH_cancer" {{ $patient->medicalRecord->familyHistory->cancer == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FH_cancer">
                                    Cancer
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FH_heartDisease" {{ $patient->medicalRecord->familyHistory->heartDisease == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FH_heartDisease">
                                    Heart Disease
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FH_hypertension" {{ $patient->medicalRecord->familyHistory->hypertension == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FH_hypertension">
                                    Hypertension
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FH_thyroidDisease" {{ $patient->medicalRecord->familyHistory->thyroidDisease == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FH_thyroidDisease">
                                    Thyroid Disease
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input type="hidden" name="FH_tuberculosis" value="0">
                            <input class="form-check-input" type="checkbox" name="FH_tuberculosis" {{ $patient->medicalRecord->familyHistory->tuberculosis == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FH_tuberculosis">
                                    Tuberculosis
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div><!-- END OF COL DIV -->
                    <div class="col-md-4 p-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FH_diabetesMelittus" {{ $patient->medicalRecord->familyHistory->diabetesMelittus == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FH_diabetesMelittus">
                                    Diabetes Melittus
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FH_mentalDisorder" {{ $patient->medicalRecord->familyHistory->mentalDisorder == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FH_mentalDisorder">
                                    Mental Disorder
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FH_asthma" {{ $patient->medicalRecord->familyHistory->asthma == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FH_asthma">
                                    Asthma
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FH_convulsions" {{ $patient->medicalRecord->familyHistory->convulsions == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FH_convulsions">
                                    Convulsions
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FH_bleedingDyscrasia" {{ $patient->medicalRecord->familyHistory->bleedingDyscrasia == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FH_bleedingDyscrasia">
                                    Bleeding Dyscrasia
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div><!-- END OF COL DIV -->
                    <div class="col-md-4 p-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FH_eyeDisorder" {{ $patient->medicalRecord->familyHistory->eyeDisorder == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FH_eyeDisorder">
                                    Eye Disorder
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FH_skinProblems" {{ $patient->medicalRecord->familyHistory->skinProblems == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FH_skinProblems">
                                    Skin Problems
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FH_kidneyProblems" {{ $patient->medicalRecord->familyHistory->kidneyProblems == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FH_kidneyProblems">
                                    Kidney Problems
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FH_gastroDisease" {{ $patient->medicalRecord->familyHistory->gastrointestinalDisease == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FH_gastroDisease">
                                    Gastrointestinal Disease
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div><!-- END OF COL DIV --> 
                </div><!-- END OF ROW of CHECKBOXES DIV -->
            <div class="form-row align-items-center">
                <div class="col p-2">
                    <input class="form-check-input" type="checkbox" id="FH_others" name="FH_others" {{ $patient->medicalRecord->familyHistory->others == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                        <label class="form-check-label" for="FH_others" style="display: contents!important;">
                            Others
                        </label>
                            <input type="text" class="form-control input-sm" id="FH_othersDetails" name="FH_othersDetails" value="{{ $patient->medicalRecord->familyHistory->othersDetails }}" {{ $patient->medicalRecord->familyHistory->othersDetails == 'N/A' ? 'disabled' : 'readonly' }}>  
                            <!-- SCRIPT FOR INPUT TOGGLE ON CHECKBOX TICK -->
                </div><!-- END OF COL OTHERS DIV -->
            </div><!-- END OF ROW OTHERS DIV -->
        </div><!-- END OF COL FH -->

        <!-- START OF PSH -->
        <div class="col-lg-5 col-md-12 p-2 border border-dark">
            <h6>Personal Social History</h6>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="PSH_smoking" name="PSH_smoking" {{ $patient->medicalRecord->personalSocialHistory->smoking == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                        <label class="form-check-label" for="PSH_smoking" style="display: contents!important;">
                            Smoking
                            <br>
                            ( <input type="text" class="col-md-2" id="PSH_smoking_amount" name="PSH_smoking_amount" value="{{ $patient->medicalRecord->personalSocialHistory->sticksPerDay }}" {{ $patient->medicalRecord->personalSocialHistory->sticksPerDay == 0 ? 'disabled' : 'readonly' }}> 
                            sticks/day for 
                            <input type="text" class="col-md-2"  id="PSH_smoking_freq" name="PSH_smoking_freq" value="{{ $patient->medicalRecord->personalSocialHistory->years }}" {{ $patient->medicalRecord->personalSocialHistory->years == 0 ? 'disabled' : 'readonly' }}> 
                            year/s ) 
                        </label>
                </div><!-- END OF SMOKING FORM DIV -->

                <div class="form-check" style="margin-top:5%;">
                    <input class="form-check-input" type="checkbox" id="PSH_drinking" name="PSH_drinking" {{ $patient->medicalRecord->personalSocialHistory->drinking == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                        <label class="form-check-label" for="PSH_drinking" style="display: contents!important;">
                            Drinking 
                            <br>
                            ( <input type="text" class="col-md-4" id="PSH_drinking_amountOfBeer" name="PSH_drinking_amountOfBeer" value="{{ $patient->medicalRecord->personalSocialHistory->numberOfBeers }}" {{ $patient->medicalRecord->personalSocialHistory->numberOfBeers == 'N/A' ? 'disabled' : 'readonly' }}> 
                             Beer per 
                             <input type="text" class="col-md-4" id="PSH_drinking_freqOfBeer" name="PSH_drinking_freqOfBeer" value="{{ $patient->medicalRecord->personalSocialHistory->beerFrequency }}" {{ $patient->medicalRecord->personalSocialHistory->beerFrequency == 'N/A' ? 'disabled' : 'readonly' }}> ) 
                            <br>
                                or
                            <br>
                            ( <input type="text" class="col-md-4" id="PSH_drinking_amountofShots" name="PSH_drinking_amountofShots" value="{{ $patient->medicalRecord->personalSocialHistory->numberOfShots }}" {{ $patient->medicalRecord->personalSocialHistory->numberOfShots == 'N/A' ? 'disabled' : 'readonly' }}> 
                            <span class="text-danger"> 
                                @error('PSH_drinking_amountofShots') 
                                  {{ $message }} 
                                @enderror
                              </span>  
                             Shots per 
                             <input type="text" class="col-md-4" id="PSH_drinking_freqOfShots" name="PSH_drinking_freqOfShots" value="{{ $patient->medicalRecord->personalSocialHistory->shotsFrequency }}" {{ $patient->medicalRecord->personalSocialHistory->shotsFrequency == 'N/A' ? 'disabled' : 'readonly' }}> )
                             <span class="text-danger"> 
                                @error('PSH_drinking_freqOfShots') 
                                  {{ $message }} 
                                @enderror
                              </span>  
                        </label>
                </div><!-- END OF DRINKING FORM DIV -->
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
                                    <input class="form-check-input" type="checkbox" name="pi_primaryComplex" {{ $patient->medicalRecord->pastIllness->primaryComplex == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                        <label class="form-check-label" for="pi_primaryComplex">
                                            Primary Complex
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pi_chickenPox" {{ $patient->medicalRecord->pastIllness->chickenPox == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                        <label class="form-check-label" for="pi_chickenPox">
                                            Chicken Pox
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pi_kidneyDisease" {{ $patient->medicalRecord->pastIllness->kidneyDisease == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                        <label class="form-check-label" for="pi_kidneyDisease">
                                            Kidney Disease
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pi_typhoidFever" {{ $patient->medicalRecord->pastIllness->typhoidFever == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                        <label class="form-check-label" for="pi_typhoidFever">
                                            Typhoid Fever
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pi_earProblems" {{ $patient->medicalRecord->pastIllness->earProblems == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                        <label class="form-check-label" for="pi_earProblems">
                                            Ear Problems
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pi_heartDisease" {{ $patient->medicalRecord->pastIllness->heartDisease == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                       <label class="form-check-label" for="pi_heartDisease">
                                           Heart Disease
                                       </label>
                               </div><!-- END OF CHECKBOX DIV -->
                               <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pi_leukemia" {{ $patient->medicalRecord->pastIllness->leukemia == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                        <label class="form-check-label" for="pi_leukemia">
                                            Leukemia
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                            </div><!-- END OF CHECKBOX 1ST COL DIV -->
                            <div class="col-md-4 p-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pi_asthma" {{ $patient->medicalRecord->pastIllness->asthma == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                        <label class="form-check-label" for="pi_asthma">
                                            Asthma
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pi_diabetes" {{ $patient->medicalRecord->pastIllness->diabetes == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                        <label class="form-check-label" for="pi_diabetes">
                                            Diabetes
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pi_eyeDisorder" {{ $patient->medicalRecord->pastIllness->eyeDisorder == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                       <label class="form-check-label" for="pi_eyeDisorder">
                                           Eye Disorder
                                       </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pi_pneumonia" {{ $patient->medicalRecord->pastIllness->pneumonia == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                        <label class="form-check-label" for="pi_pneumonia">
                                            Pneumonia
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pi_dengue" {{ $patient->medicalRecord->pastIllness->dengue == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                        <label class="form-check-label" for="pi_dengue">
                                            Dengue
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pi_measles" {{ $patient->medicalRecord->pastIllness->measles == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                        <label class="form-check-label" for="pi_measles">
                                            Measles
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pi_hepatitis" {{ $patient->medicalRecord->pastIllness->hepatitis == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                        <label class="form-check-label" for="pi_hepatitis">
                                            Hepatitis
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                            </div><!-- END OF CHECKBOX 2ND COL DIV -->
                            <div class="col-md-4 p-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pi_rheumaticFever" {{ $patient->medicalRecord->pastIllness->rheumaticFever == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                        <label class="form-check-label" for="pi_rheumaticFever">
                                            Rheumatic Fever
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pi_mentalDisorder" {{ $patient->medicalRecord->pastIllness->mentalDisorder == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                        <label class="form-check-label" for="pi_mentalDisorder">
                                            Mental Disorder
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pi_skinProblems" {{ $patient->medicalRecord->pastIllness->skinProblems == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                        <label class="form-check-label" for="pi_skinProblems">
                                            Skin Problems
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pi_poliomyetis" {{ $patient->medicalRecord->pastIllness->poliomyetis == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                        <label class="form-check-label" for="pi_poliomyetis">
                                            Poliomyetis
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pi_thyroidDisorder" {{ $patient->medicalRecord->pastIllness->thyroidDisorder == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                        <label class="form-check-label" for="pi_thyroidDisorder">
                                            Thyroid Disorder
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pi_anemia" {{ $patient->medicalRecord->pastIllness->anemia == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                        <label class="form-check-label" for="pi_anemia">
                                            Anemia
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="pi_mumps" {{ $patient->medicalRecord->pastIllness->mumps == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
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
                                    <input class="form-check-input" type="checkbox" name="PI_chestPain" {{ $patient->medicalRecord->presentIllness->chestPain == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                        <label class="form-check-label" for="PI_chestPain">
                                            Chest Pain
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="PI_insomnia" {{ $patient->medicalRecord->presentIllness->insomnia == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                        <label class="form-check-label" for="PI_insomnia">
                                            Insomnia
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="PI_jointPains" {{ $patient->medicalRecord->presentIllness->jointPains == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                        <label class="form-check-label" for="PI_jointPains">
                                            Joint Pains
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="PI_dizziness" {{ $patient->medicalRecord->presentIllness->dizziness == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                        <label class="form-check-label" for="PI_dizziness">
                                            Dizzines
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                            </div><!-- END OF CHECKBOX 1ST COL DIV -->
                            <div class="col-md-4 p-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="PI_headaches" {{ $patient->medicalRecord->presentIllness->headaches == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                        <label class="form-check-label" for="PI_headaches">
                                            Headaches
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="PI_indigestion" {{ $patient->medicalRecord->presentIllness->indigestion == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                        <label class="form-check-label" for="PI_indigestion">
                                            Indigestion
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="PI_swollenFeet" {{ $patient->medicalRecord->presentIllness->swollenFeet == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                       <label class="form-check-label" for="PI_swollenFeet">
                                           Swollen Feet
                                       </label>
                               </div><!-- END OF CHECKBOX DIV -->
                               <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="PI_weightLoss" {{ $patient->medicalRecord->presentIllness->weightLoss == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                        <label class="form-check-label" for="PI_weightLoss">
                                            Weight Loss
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                            </div><!-- END OF CHECKBOX 2ND COL DIV -->
                            <div class="col-md-4 p-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="PI_nauseaOrVomiting" {{ $patient->medicalRecord->presentIllness->nauseaOrVomiting == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                        <label class="form-check-label" for="PI_nauseaOrVomiting">
                                            Nausea/Vomiting
                                        </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="PI_soreThroat" {{ $patient->medicalRecord->presentIllness->soreThroat == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                        <label class="form-check-label" for="PI_soreThroat">
                                            Sore Throat
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="PI_frequentUrination" {{ $patient->medicalRecord->presentIllness->frequentUrination == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                        <label class="form-check-label" for="PI_frequentUrination">
                                            Frequent Urination
                                        </label>
                                </div><!-- END OF CHECKBOX DIV -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="PI_difficultyOfBreathing" {{ $patient->medicalRecord->presentIllness->difficultyOfBreathing == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                        <label class="form-check-label" for="PI_difficultyOfBreathing">
                                            Diffculty of Breathing
                                        </label>
                                </div> <!-- END OF CHECKBOX DIV -->    
                            </div><!-- END OF CHECKBOX 3RD COL DIV -->
                        </div><!-- END OF CHECKBOX ROW DIV -->
                        <div class="form-row align-items-center">
                            <div class="col p-2">
                                <input class="form-check-input" type="checkbox" id="PI_others" name="PI_others" {{ $patient->medicalRecord->presentIllness->others == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                    <label class="form-check-label" for="PI_others" style="display: contents!important;">
                                        <span class="h6">Others</span>
                                    </label>
                                        <input type="text" class="form-control input-sm" id="PI_othersDetails" name="PI_othersDetails" value="{{ $patient->medicalRecord->presentIllness->othersDetails }}" {{ $patient->medicalRecord->presentIllness->othersDetails == 'N/A' ? 'disabled' : 'readonly' }}>  
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
                            <input class="form-check-input" type="radio" name="hospitalization" id="hospitalization_YES" onclick="return false;"/>
                            <label class="form-check-label" for="hospitalization_YES" style="margin-right: -15px; margin-left:-5px">
                            yes
                            </label>
                        </div><!-- END OF YES DIV -->
                        &nbsp;
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="hospitalization" id="hospitalization_NO" onclick="return false;"/>
                            <label class="form-check-label" for="hospitalization_NO" style="margin-right: -15px; margin-left:-5px">
                            no
                            </label>
                            <!-- SCRIPT TO SHOW IF YES OR NO -->
                            <script>
                                if ({{ $patient->medicalRecord->hospitalization }} == 1) {
                                    document.getElementById("hospitalization_YES").checked = true;
                                } else {
                                    document.getElementById("hospitalization_NO").checked = true;
                                }
                            </script>
                        </div>)<!-- END OF NO DIV -->
                        If yes, please give details:
                        <input type="text" class="col-sm-10" id="hospitalizationDetails" name="hospitalizationDetails" value="{{ $patient->medicalRecord->hospDetails }}" {{ $patient->medicalRecord->hospDetails == 'N/A' ? 'disabled' : 'readonly' }}>
                    </div><!-- END OF COL DIV -->
                </div><!-- END OF ROW DIV -->

                <!-- REGULAR MEDICINES -->
                <div class="d-flex flex-row pt-2">
                    <div class="col-sm">
                        Are you taking any medicine regularly?
                           (<div class="form-check form-check-inline">
                               <input class="form-check-input" type="radio" name="regMeds" id="regMeds_YES" onclick="return false;"/>
                               <label class="form-check-label" for="regMeds_YES" style="margin-right: -15px; margin-left:-5px">
                               yes
                               </label>
                           </div><!-- END OF YES DIV -->
                           &nbsp;
                           <div class="form-check form-check-inline">
                               <input class="form-check-input" type="radio" name="regMeds" id="regMeds_NO" onclick="return false;"/>
                               <label class="form-check-label" for="regMeds_NO" style="margin-right: -15px; margin-left:-5px">
                               no
                               </label>
                           </div>)<!-- END OF NO DIV -->
                           If yes, name of drug/s:
                           <input type="text" class="col-sm-10" id="regMedsDetails" name="regMedsDetails"  value="{{ $patient->medicalRecord->medsDetails }}" {{ $patient->medicalRecord->medsDetails == 'N/A' ? 'disabled' : 'readonly' }}>
                               <!-- SCRIPT TO SHOW IF YES OR NO -->
                               <script>
                                if ({{ $patient->medicalRecord->takingMedsRegularly }} == 1) {
                                    document.getElementById("regMeds_YES").checked = true;
                                } else {
                                    document.getElementById("regMeds_NO").checked = true;
                                }
                            </script>
                               <!-- END OF SCRIPT --> 
                       </div><!-- END OF COL DIV -->
                   </div><!-- END OF ROW DIV -->

                   <!-- ALLERGIES -->
                   <div class="col-sm">
                    Are you allergic to any food or medicine?
                       (<div class="form-check form-check-inline">
                           <input class="form-check-input" type="radio" name="allergy" id="allergy_YES" onclick="return false;"/>
                           <label class="form-check-label" for="allergy_YES" style="margin-right: -15px; margin-left:-5px">
                           yes
                           </label>
                       </div><!-- END OF YES DIV -->
                       &nbsp;
                       <div class="form-check form-check-inline">
                           <input class="form-check-input" type="radio" name="allergy" id="allergy_NO" onclick="return false;"/>
                           <label class="form-check-label" for="allergy_NO" style="margin-right: -15px; margin-left:-5px">
                           no
                           </label>
                       </div>)<!-- END OF NO DIV -->
                       If yes, specify:
                       <input type="text" class="col-sm-10" id="allergyDetails" name="allergyDetails" value="{{ $patient->medicalRecord->allergyDetails }}" {{ $patient->medicalRecord->allergyDetails == 'N/A' ? 'disabled' : 'readonly' }}>
                        <!-- SCRIPT TO SHOW IF YES OR NO -->
                        <script>
                            if ({{ $patient->medicalRecord->allergic }} == 1) {
                                document.getElementById("allergy_YES").checked = true;
                            } else {
                                document.getElementById("allergy_NO").checked = true;
                            }
                            </script>
                           <!-- END OF SCRIPT --> 
                   </div><!-- END OF COL DIV -->
               </div><!-- END OF ROW DIV -->    

        </div>   
        
        <!--Immunization History-->
        <div class="mx-auto row row-cols-lg-1 mt-2">
            <div class="col-md-12 p-2 border border-dark">
                <h6>Immunization History</h6>
                <div class="my-auto row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 align-items-center" style="margin-left: 5%;">
                    <div class="col-1 p-2">
                        <input class="form-check-input" type="checkbox" {{ $patient->medicalRecord->immunizationHistory->BCG == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;" name="IH_bcg">
                            <label class="form-check-label" for="IH_bcg" data-toggle="tooltip" data-placement="top" title="Bacille Calmette-Guerin">
                                BCG
                            </label>
                    </div>
                    <div class="col-sm-3 p-2">
                        <input class="form-check-input" type="checkbox" {{ $patient->medicalRecord->immunizationHistory->polio == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;" name="IH_polio">
                            <label class="form-check-label" for="IH_polio">
                                Polio I, II, II, Booster Dose
                            </label>
                    </div>
                    <div class="col-sm-2 p-2">
                        <input class="form-check-input" type="checkbox" {{ $patient->medicalRecord->immunizationHistory->mumps == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;" name="IH_mumps">
                            <label class="form-check-label" for="IH_mumps">
                                Mumps
                            </label>
                    </div>
                    <div class="col-sm-2 p-2">
                        <input class="form-check-input" type="checkbox" {{ $patient->medicalRecord->immunizationHistory->typhoid == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;" name="IH_typhoid">
                            <label class="form-check-label" for="IH_typhoid">
                                Typhoid
                            </label>
                    </div>
                    <div class="col-sm-3 p-2">
                        <input class="form-check-input" type="checkbox" {{ $patient->medicalRecord->immunizationHistory->hepatitisA == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;" name="IH_hepatitisA">
                            <label class="form-check-label" for="IH_hepatitisA">
                                Hepatitis A
                            </label>
                    </div>
                    <div class="w-100"></div>
                    <!-- NEW LINE -->
                    <div class="col-sm-2 p-2">
                        <input class="form-check-input" type="checkbox" {{ $patient->medicalRecord->immunizationHistory->chickenPox == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;" name="IH_chickenPox">
                            <label class="form-check-label" for="IH_chickenPox">
                                Chicken Pox
                            </label>
                    </div>
                    <div class="col-sm-3 p-2">
                        <input class="form-check-input" type="checkbox" {{ $patient->medicalRecord->immunizationHistory->DPT == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;" name="IH_dpt">
                            <label class="form-check-label" for="IH_dpt">
                                DPT I, II, III, Booster Dose
                            </label>
                    </div>
                    <div class="col-sm-2 p-2">
                        <input class="form-check-input" type="checkbox" {{ $patient->medicalRecord->immunizationHistory->measles == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;" name="IH_measles">
                            <label class="form-check-label" for="IH_measles">
                                Measles
                            </label>
                    </div>
                    <div class="col-sm-2 p-2">
                        <input class="form-check-input" type="checkbox" {{ $patient->medicalRecord->immunizationHistory->germanMeasles == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;" name="IH_germanMeasles">
                            <label class="form-check-label" for="IH_germanMeasles">
                                German Measles
                            </label>
                    </div>
                    <div class="col-sm-3 p-2">
                        <input class="form-check-input" type="checkbox" {{ $patient->medicalRecord->immunizationHistory->hepatitisB == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;" name="IH_hepatitisB">
                            <label class="form-check-label" for="IH_hepatitisB">
                                Hepatitis B
                            </label>
                    </div>
                    <div class="w-100"></div>
                    <!-- NEW LINE -->
                    <div class="col-sm-1 p-2">
                        <input class="form-check-input" type="checkbox" {{ $patient->medicalRecord->immunizationHistory->others == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;" id="IH_others" name="IH_others">
                            <label class="form-check-label" for="IH_others">
                                Others
                            </label>
                    </div>
                    <div class="col-sm-9 p-2">
                            <input type="text" class="col-sm-12" id="IH_othersDetails" name="IH_othersDetails" value="{{ $patient->medicalRecord->immunizationHistory->othersDetails }}" {{ $patient->medicalRecord->immunizationHistory->othersDetails == 'N/A' ? 'disabled' : 'readonly' }}>
                    </div>
            </div>
        </div>
    </div>
    <!-- ATTACHMENTS -->
    <div class="d-flex flex-row">
        <div class="col-md-12 p-1 border border-dark">
            <p class="fs-5 text-center">Please upload a photo of the official reading and result of the following:</p>
            <div class="flex justify-content-center">
                <div class="row row-cols-xl-2 row-cols-lg-1 row-cols-md-1 row-cols-sm-1 my-auto px-5 py-4">
                    <div class="mb-3 col-3 d-flex flex-column justify-content-center align-items-center" >
                        <label for="MR_studentSignature" class="form-label fw-bold">Chest X-Ray Findings</label>
                        <div class="mb-3 col-6 signature-container d-flex justify-content-center align-items-center">  
                            <img src="{{ asset('storage/app/'.$patient->medicalRecord->chestXray) }}" alt="Chest X-Ray Findings">
                        </div>
                    </div>
                    <div class="mb-3 col-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="MR_parentGuardianSignature" class="form-label fw-bold">CBC Results</label>
                        <div class="mb-3 col-6 signature-container d-flex justify-content-center align-items-center">  
                            <img src="{{ asset('storage/app/'.$patient->medicalRecord->CBCResults) }}" alt="CBC Results">
                        </div>
                      </div>                      
                    <div class="mb-3 col-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="MR_parentGuardianSignature" class="form-label fw-bold">Hepatitis B Screening</label>
                        <div class="mb-3 col-6 signature-container d-flex justify-content-center align-items-center">  
                            <img src="{{ asset('storage/app/'.$patient->medicalRecord->hepaBscreening) }}" alt="Hepatitis B Screening">
                        </div>
                    </div> 
                    <div class="mb-3 col-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="MR_parentGuardianSignature" class="form-label fw-bold">Blood Type</label>
                        <div class="mb-3 col-6 signature-container d-flex justify-content-center align-items-center">  
                            <img src="{{ asset('storage/app/'.$patient->medicalRecord->bloodType) }}" alt="Blood Type">
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
        <!--Signatures-->
        <div class="mx-auto row row-cols-lg-1 mt-2">
            <div class="col-md-12 p-1 border border-dark">
                <p class="fs-5 fst-italic text-center">I hereby certify that the foregoing answers are true and complete, and to the best of my knowledge.</p>
                <div class="flex justify-content-center">
                    <div class="row row-cols-xl-2 row-cols-lg-1 row-cols-md-1 row-cols-sm-1 my-auto p-5">
                        <div class="mb-3 col-6 d-flex flex-column justify-content-center align-items-center" style="margin-top: -2%;">
                            <label for="MR_studentSignature" class="form-label">Signature of student over printed name</label>
                            <div class="mb-3 col-6 signature-container d-flex justify-content-center align-items-center">  
                                <img src="{{ asset('storage/app/'.$patient->medicalRecord->studentSignature) }}" alt="Signature of student">
                            </div>
                        </div>
                        <div class="mb-3 col-6 d-flex flex-column justify-content-center align-items-center">
                            <label for="MR_parentGuardianSignature" class="form-label">Signature of parent/guardian over printed name</label>
                            <div class="mb-3 col-6 signature-container d-flex justify-content-center align-items-center">
                                <img src="{{ asset('storage/app/'.$patient->medicalRecord->parentGuardianSignature) }}" alt="Signature of parent/guardian">
                            </div>
                        </div>                              
                    </div>
                </div>
            </div>
        </div>

        <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
            <header class="text-center">
                <!-- LINE BREAK -->
            </header>
        </section>
        
        <p class="text-center fw-bold pt-1" style="user-select:none;">---------- TO BE ACCOMPLISHED BY THE MEDICAL PERSONNEL ----------</p>
    <!-- START OF PHYSICIAN INPUT -->
        <!-- VITAL SIGNS -->
        <div class="mx-auto row row-cols-lg-1 mt-2">
            <div class="col-md-12 p-1 border border-dark">
                <div class="container">
                    <p class="fs-4">VITAL SIGNS:ANTHROPOMETRICS</p>
                    <div class="mx-auto p-3 row row-cols-lg-4 row-cols-md-2 mt-2 justify-content-center">
                        <div class="col-xl-3 p-3 ">
                            <div class="form-group row">
                            <label for="bloodPressure" class="form-label h6" style="white-space: nowrap;">BP:</label>
                                <div class="d-flex align-items-center" style="margin-top:-1%;">
                                    <input type="text" class="form-control me-1" id="VS_bp_systolic" name="VS_bp_systolic"  maxlength="4" required>
                                        <span class="text-danger"> 
                                            @error('VS_bp_systolic') 
                                            {{ $message }} 
                                            @enderror
                                        </span>
                                    <span class="fs-6">/</span>
                                    <input type="text" class="form-control ms-2" id="VS_bp_diastolic" name="VS_bp_diastolic" maxlength="4" required> 
                                    <p class="pt-3" style="margin-left: 4px;">mmHg</p>
                                        <span class="text-danger"> 
                                            @error('VS_bp_diastolic') 
                                            {{ $message }} 
                                            @enderror
                                        </span> 
                                </div>
                            </div>                   
                            <div class="form-group row">
                            <label for="pulseRate" class="form-label h6">PR:</label>
                            <div class="d-flex align-items-center" style="margin-top:-1%;">
                                <input type="text" class="form-control me-1" id="VS_pulseRate" name="VS_pulseRate"  maxlength="4" required>
                                <p class="pt-3" style="margin-left: 4px;">/minute</p>
                                    <span class="text-danger"> 
                                        @error('VS_pulseRate') 
                                        {{ $message }} 
                                        @enderror
                                    </span>
                                </div>
                            </div>                 
                            <div class="form-group row">
                            <label for="respirationRate" class="form-label h6">RR:</label>
                            <div class="d-flex align-items-center" style="margin-top:-1%;">
                                <input type="text" class="form-control me-1" id="VS_respirationRate" name="VS_respirationRate"  maxlength="4" required>
                                <p class="pt-3" style="margin-left: 4px;">/minute</p>
                                    <span class="text-danger"> 
                                        @error('VS_respirationRate') 
                                        {{ $message }} 
                                        @enderror
                                    </span>
                                </div>
                            </div>                       
                            <div class="form-group row">
                            <label for="temp" class="form-label h6">Temp:</label>
                            <div class="d-flex align-items-center" style="margin-top:-1%;">
                                <input type="text" class="form-control me-1" id="VS_temp" name="VS_temp"  maxlength="4" required>
                                <p class="pt-3" style="margin-left: 4px;">°C</p>
                                    <span class="text-danger"> 
                                        @error('VS_temp') 
                                        {{ $message }} 
                                        @enderror
                                    </span>
                                </div>
                            </div>
                        </div> 
                        <div class="col-xl-3 p-3 ">
                            <div class="form-group row">
                                <label for="height" class="form-label h6">Height</label>
                                <div class="d-flex align-items-center" style="margin-top:-1%;">
                                    <input type="text" class="form-control me-1" id="VS_height" name="VS_height"  maxlength="4" required>
                                    <p class="pt-3" style="margin-left: 4px;">meters</p>
                                        <span class="text-danger"> 
                                            @error('VS_height') 
                                            {{ $message }} 
                                            @enderror
                                        </span>
                                    </div>
                                </div>  
                                <div class="form-group row">
                                    <label for="weight" class="form-label h6">Weight</label>
                                    <div class="d-flex align-items-center" style="margin-top:-1%;">
                                        <input type="text" class="form-control me-1" id="VS_weight" name="VS_weight"  maxlength="4" required>
                                        <p class="pt-3" style="margin-left: 4px;">kgs</p>
                                            <span class="text-danger"> 
                                                @error('VS_weight') 
                                                {{ $message }} 
                                                @enderror
                                            </span>
                                        </div>
                                    </div>  
                                    <div class="form-group row">
                                        <label for="BMI" class="form-label h6">BMI</label>
                                        <div class="d-flex align-items-center" style="margin-top:-1%;">
                                            <input type="text" class="form-control me-1" id="VS_BMI" name="VS_BMI"  maxlength="4" required>
                                                <span class="text-danger"> 
                                                    @error('VS_BMI') 
                                                    {{ $message }} 
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>                                 
                        </div>   
                    </div>   
                </div>
            </div>
        </div>
        <!-- FITNESS CERTIFICATION -->
        <div class="mx-auto row row-cols-lg-1 mt-2">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4 p-3 border border-dark">
                        <h5 class="text-center">CATEGORY</h5>
                    </div>
                    <div class="col-md-8 p-3 border border-dark">
                        <h5 class="text-center">PHYSICAL EXAMINATION FINDINGS</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 p-1 border border-dark">
                        <p class="pt-3">1. General Appearance</p>
                    </div>
                    <div class="col-md-8 p-1 border border-dark">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="PE_GenAppearance" id="PE_GenAppearance_Okay">
                            <label class="form-check-label" for="PE_GenAppearance_Okay">
                                Normal
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="PE_GenAppearance" id="PE_GenAppearance_others">
                            <label class="form-check-label" for="PE_GenAppearance_others">
                                Other findings
                                <input type="text" class="form-control" id="PE_GenAppearance_othersComment">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 p-1 border border-dark">
                        <p class="pt-3">2. HEENT</p>
                    </div>
                    <div class="col-md-8 p-1 border border-dark">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="PE_HEENT" id="PE_HEENT_Okay">
                            <label class="form-check-label" for="PE_HEENT_Okay">
                                Normal
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="PE_HEENT" id="PE_HEENT_others">
                            <label class="form-check-label" for="PE_HEENT_others">
                                Other findings
                                <input type="text" class="form-control" id="PE_HEENT_othersComment">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 p-1 border border-dark">
                        <p class="pt-3">3. Chest & Lungs</p>
                    </div>
                    <div class="col-md-8 p-1 border border-dark">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="PE_Chest&Lungs" id="PE_Chest&LungsOkay">
                            <label class="form-check-label" for="PE_Chest&LungsOkay">
                                Normal
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="PE_Chest&Lungs" id="PE_Chest&Lungsothers">
                            <label class="form-check-label" for="PE_Chest&Lungsothers">
                                Other findings
                                <input type="text" class="form-control" id="PE_Chest&LungsothersComment">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 p-1 border border-dark">
                        <p class="pt-3">4. Cardiovascular</p>
                    </div>
                    <div class="col-md-8 p-1 border border-dark">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="PE_Cardio" id="PE_CardioOkay">
                            <label class="form-check-label" for="PE_CardioOkay">
                                Normal
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="PE_Cardio" id="PE_Cardioothers">
                            <label class="form-check-label" for="PhysicalExam_cardioothers">
                                Other findings
                                <input type="text" class="form-control" id="PhysicalExam_CardioComment">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 p-1 border border-dark">
                        <p class="pt-3">5. Abdomen</p>
                    </div>
                    <div class="col-md-8 p-1 border border-dark">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="PE_Abdomen" id="PE_AbdomenOkay">
                            <label class="form-check-label" for="PhysicalExam_AbdomenOkay">
                                Normal
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="PE_Abdomen" id="PE_Abdomenothers">
                            <label class="form-check-label" for="PE_AbdomenComment">
                                Other findings
                                <input type="text" class="form-control" id="PhysicalExam_abdomen2">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 p-1 border border-dark">
                        <p class="pt-3">6. Genito urinary</p>
                    </div>
                    <div class="col-md-8 p-1 border border-dark">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="PE_Genito" id="PE_GenitoOkay">
                            <label class="form-check-label" for="PE_GenitoOkay">
                                Normal
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="PE_Genito" id="PE_Genitoothers">
                            <label class="form-check-label" for="PE_Genitoothers">
                                Other findings
                                <input type="text" class="form-control" id="PE_GenitoComment">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 p-1 border border-dark">
                        <p class="pt-3">7. Musculoskeletal</p>
                    </div>
                    <div class="col-md-8 p-1 border border-dark">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="PE_Musculoskeletal" id="PE_MusculoskeletalOkay">
                            <label class="form-check-label" for="PE_MusculoskeletalOkay">
                                Normal
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="PE_Musculoskeletal" id="PE_Musculoskeletalothers">
                            <label class="form-check-label" for="PE_Musculoskeletalothers">
                                Other findings
                                <input type="text" class="form-control" id="PE_MusculoskeletalComment">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 p-1 border border-dark">
                        <p class="pt-3">8. Nervous System</p>
                    </div>
                    <div class="col-md-8 p-1 border border-dark">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="PE_NervousSystem" id="PE_NervousSystemOkay">
                            <label class="form-check-label" for="PE_NervousSystem">
                                Normal
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="PE_NervousSystem" id="PE_NervousSystemothers">
                            <label class="form-check-label" for="PE_NervousSystemothers">
                                Other findings
                                <input type="text" class="form-control" id="PE_NervousSystemComment">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 p-1 border border-dark">
                        <p class="pt-3">9. Other Significant Findings:</p>
                    </div>
                    <div class="col-md-8 p-1 border border-dark">
                        <div class="form-group">
                            <textarea class="form-control" id="PE_Others" rows="2"></textarea>
                        </div>
                    </div>
                </div>
            </div>
                <div class="col-md-12 p-3 border border-dark">
                    <h5 class="pl-6">FITNESS CERTIFICATION</h5>
                        <div class="d-flex flex-row">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="fitness" type="radio" id="fitness_Fit" value="fitness_Fit">
                                <label class="form-check-label" for="fitness_Fit">
                                    Fit for Enrollment
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="fitness" type="radio" id="fitness_notFit" value="fitness_notFit">
                                <label class="form-check-label" for="fitness_notFit">
                                    Not Fit for Enrollment
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" name="fitness" type="radio" id="fitness_Pending" value="fitness_Pending">
                                <label class="form-check-label" for="fitness_Pending">
                                    Pending
                                </label>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group row pb-2" style="margin-top: -8px;">
                                    <label for="fit_Reason" class="col-sm-2 col-form-label">Reason</label>
                                    <div class="col-sm-10">
                                      <input type="text" id="fit_Reason" class="form-control">
                                    </div>
                                </div>
                            </div>
                    </div>                 
            </div>
            <!-- IMPRESSION -->
                <div class="form-control pt-3 border border-dark">
                    <h5>IMPRESSION</h5>
                    <textarea class="form-control" id="Impression" rows="3"></textarea>
                </div>
            <!-- SIGNATURES -->
                <div class="col-md-12 p-3 border border-dark">
                    <div class="flex-row justify-content-center">
                        <div class="row row-cols-xl-2 row-cols-lg-1 row-cols-md-1 row-cols-sm-1 my-auto p-5">
                            <div class="mb-3 col-md-2">
                                <label for="MR_physicianSignature" class="form-label">Signature over Printed Name of Attending Physician</label>
                                <input type="file" class="form-control" id="MR_studentSignature" name="MR_studentSignature" accept="image/jpeg, image/png" required>
                            </div>
                            <div class="col-md-3 pt-2">
                                <label for="MR_licenseNumber">License Number</label>
                                <input type="text" class="form-control" id="signatures">
                            </div>
                            <div class="col-md-3">
                                <label for="MR_PTRNumber">PTR Number</label>
                                <input type="text" class="form-control" id="signatures">
                            </div>
                            <div class="col-md-3">
                                <label for="MR_DateofExam">Date of Examination</label>
                                <input type="text" class="form-control" id="signatures">
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
            <header class="text-center">
                <!-- LINE BREAK -->
            </header>
        </section>
        
        <p class="text-center fw-bold pt-1" style="user-select:none;"> FOR BICOL UNIVERSITY HEALTH SERVICE PHYSICIAN'S VALIDATION ONLY </p>

        <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
            <header class="text-center">
                <!-- LINE BREAK -->
            </header>
        </section>

        <div class="col-md-12 p-3 border border-dark">
            <div class="flex-row justify-content-center">
                <p class="fs-5 fst-italic text-center">The above findings are certified correct and are based on the physical examination, diagnostic results available, and the disclosure of the student's/parent's pertinent medical history at the time and date of examination </p>
                <div class="row row-cols-xl-2 row-cols-lg-1 row-cols-md-1 row-cols-sm-1 my-auto p-5">
                    <div class="mb-3 col-md-2">
                        <label for="MR_physicianSignature" class="form-label">Signature over Printed Name of Attending Physician</label>
                        <input type="file" class="form-control" id="MR_studentSignature" name="MR_studentSignature" accept="image/jpeg, image/png" required>
                    </div>
                    <div class="col-md-3 pt-2">
                        <label for="MR_licenseNumber">License Number</label>
                        <input type="text" class="form-control" id="signatures">
                    </div>
                    <div class="col-md-3">
                        <label for="MR_PTRNumber">PTR Number</label>
                        <input type="text" class="form-control" id="signatures">
                    </div>
                    <div class="col-md-3">
                        <label for="MR_DateofExam">Date of Examination</label>
                        <input type="text" class="form-control" id="signatures">
                    </div>
                </div>
            </div>
        </div>

     
    <div class="row no-gutters justify-content-end pt-3 position-relative">
        <div class="col d-flex justify-content-end" style="margin-right:-1  %;">
            <button class="btn btn-lg btn-primary btn-login fw-bold mb-2" type="submit">Submit</button>
        </div>
    </div>
</div> 
</form>
@endsection
