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
    option.alternate{
        background-color: #ececec;
    }
    .custom-file-upload {
        padding: 6px 12px;
        cursor: pointer;
    }
    input[type=checkbox] {
        outline: 1px solid #464646dc;
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
    .ui-state-default:hover{
        background-color: #009edf !important;
    }
    .form-floating>.form-control,
    .form-floating>.form-control-plaintext {
      padding: 0rem 0.75rem;
    }
    .form-floating>.form-control,
    .form-floating>.form-control-plaintext,
    .form-floating>.form-select {
      height: calc(2.5rem + 2px);
      line-height: 1rem;
    }
    .form-floating>label {
      padding: 0.5rem 2.5rem;
    }
    @media (min-width: 1200px) {
    .container{
        max-width: 1500px;
    }
}
</style>
<!-- Header -->
<div class="container-lg w-20 position-relative my-2 bg-light text-dark pt-5 px-3 headMargin checkboxes">
    @if($patient->hasValidatedRecord)
    <!-- HAS VALIDATED MEDICAL RECORD -->
    <i class="bi bi-person-check icon position-absolute top-0 end-0 fs-2 d-print-none" style="color:#f1731f;" data-toggle="tooltip" data-container="body" data-bs-placement="top" title="Validated Medical Record"></i>
  @else
    <!-- HAS MEDICAL RECORD BUT NOT VALIDATED -->
    <i class="bi bi-file-earmark-medical icon position-absolute top-0 end-0 fs-2 d-print-none" style="color:#f1731f;" data-toggle="tooltip" data-container="body" data-bs-placement="top" title="Medical Record not Validated"></i>
  @endif
  <!-- PRINTABLE -->
  <div class="row d-flex d-print-inline-block d-none d-print-block" style="margin-bottom: 100px;">
    <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
        <header class="text-center">
            <!-- LINE BREAK -->
        </header>
    </section>
</div>
<!-- END OF PRINTABLE -->
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
              <h2 class="display-7 fs-3 pt-auto font-monospace">Personnel Health Record</h2>
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

@php
    $date = $patient->date_of_birth;
    $formatted_dateOfBirth = date("Y F d", strtotime($date));
@endphp

<form method="POST" action="{{ route('medicalFormAdminPersonnel.store') }}" id="MRP_form" enctype="multipart/form-data" class="d-print-flex row g-3 pt-5 px-4 needs-validation" novalidate>
    @csrf
    @php
        if(isset($fromAppointment)){
            echo '<input type="hidden" name="fromAppointment" value="'.$fromAppointment.'">';
            echo '<input type="hidden" name="ticketID" value="'. $ticketID .'">';
        }
    @endphp
    
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

        <div class="row row-cols-lg-4 row-cols-md-2 mt-2">
            <div class="col-xl-4 col-lg-12">
                <label for="designation" class="form-label h6">Designation</label>
                <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-0 pb-0 fs-5 fw-bold" id="designation" name="designation" value="{{ $patient->medicalRecordPersonnel->designation }}" readonly>               
            </div>
            <div class="col-xl-4 col-lg-12">
                <p class="h6">Unit/Department</p>
                <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-0 pb-0 fs-5 fw-bold" id="unitDepartment" name="unitDepartment" value="{{ $patient->medicalRecordPersonnel->unitDepartment }}" readonly>
            </div> 
            <div class="col-xl-4 col-lg-12">
                <p class="h6">Campus</p>
                <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-0 pb-0 fs-5 fw-bold" id="P_campusSelect" name="P_campusSelect" value="{{ $patient->medicalRecordPersonnel->campus }}" readonly>
            </div>   
        </div>   
    <div class="d-flex flex-row">
        <h4 class="pb-3"></h4>
    </div>   
    
        <div class="col-md-1 d-flex align-items-center justify-content-center d-print-inline-block" style="width: 70px;">
            <span class="h5 text-center text-bottom" style="margin-left: -30%; padding-right: -50%;">Name</span>
        </div>
        <div class="col-md-6 text-bottom d-print-inline-block">
            <p class="form-label h6 p-0" style="position:static; margin-top: 0.3%; user-select:none;">&nbsp;</p>
            <div class="row justify-content-around text-center border-bottom border-dark mb-0 pb-0">
                <div class="col-3 pb-0 mb-0 text-bottom">
                    <input type="text" class="form-control-plaintext text-center mb-0 pb-0 fs-5 fw-bold" id="last_name" name="last_name" value="{{ $patient->medicalRecordPersonnel->last_name }}" readonly>
                </div>
                <div class="col-6">
                    <input type="text" class="form-control-plaintext text-center mb-0 pb-0 fs-5 fw-bold" id="first_name" name="first_name" value="{{ $patient->medicalRecordPersonnel->first_name }}" readonly>
                </div>
                <div class="col-3">
                    <input type="text" class="form-control-plaintext text-center mb-0 pb-0 fs-5 fw-bold" id="middle_name" name="middle_name" value="{{ $patient->medicalRecordPersonnel->middle_name }}" readonly>
                </div>
            </div>
            <div class="row justify-content-around text-center">
                <div class="col-3">
                    <p class="fst-italic fs-6 text-secondary" style="user-select: none;">(LAST)</p>
                </div>
                <div class="col-6">
                    <p class="fst-italic fs-6 text-secondary" style="user-select: none;">(FIRST)</p>
                </div>
                <div class="col-3">
                    <p class="fst-italic fs-6 text-secondary" style="user-select: none;">(MIDDLE)</p>
                </div>
            </div>
        </div>
        <div class="col-md-1">
            <label for="MRP_age" class="form-label h6">Age</label>
            <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-0 pb-0 fs-5 fw-bold" id="MRP_age" name="MRP_age" value="" readonly>
        </div>
        <script>
            $(document).ready(function() {
                var birthdate = new Date("<?php echo $date; ?>");
                var age = Math.floor((new Date() - birthdate) / (365.25 * 24 * 60 * 60 * 1000));
                $('#MRP_age').val(age);
            });
        </script>
        <div class="col-md-1">
            <label for="MRP_sex" class="form-label h6">Sex</label>
            <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-0 pb-0 fs-5 fw-bold" id="MRP_sex" name="MRP_sex" value="{{ $patient->medicalRecordPersonnel->sex }}" readonly>
        </div>
        <div class="col-md-2">
            <label for="MRP_gender" class="form-label h6">Gender</label>
            <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-0 pb-0 fs-5 fw-bold overflow-visible" id="MRP_gender" name="MRP_gender" value="{{ $patient->medicalRecordPersonnel->gender }}" readonly>
        </div>
        <div class="col-md-1">
            <div class="form-group d-flex align-items-center pt-4" style="margin-top: 6px;">
                <input class="form-check-input" type="checkbox" name="MRP_pwd" id="MRP_pwd" {{ $patient->medicalRecordPersonnel->pwd == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                <label for="MRP_pwd" class="form-check-label mt-1 ms-1 fs-5 fw-bold">PWD</label>
              </div>
        </div>
        <div class="col-md-3">
            <label for="MRP_placeOfBirth" class="form-label h6">Date of Birth</label>
            <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-0 pb-0 fs-5 fw-bold" id="MRP_placeOfBirth" name="MRP_placeOfBirth" value="{{ $formatted_dateOfBirth }}" readonly>
        </div>


        <div class="col-md-3">
            <label for="MRP_civilStatus" class="form-label h6">Civil Status</label>
            <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-0 pb-0 fs-5 fw-bold" id="MRP_civilStatus" name="MRP_civilStatus" value="{{ $patient->medicalRecordPersonnel->civilStatus }}" readonly>
        </div>
        <div class="col-md-3">
            <label for="MRP_nationality" class="form-label h6">Nationality</label>
            <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-0 pb-0 fs-5 fw-bold" id="MRP_nationality" name="MRP_nationality" value="{{ $patient->medicalRecordPersonnel->nationality }}" readonly>
        </div>
        <div class="col-md-3">
            <label for="MRP_religion" class="form-label h6">Religion</label>
            <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-0 pb-0 fs-5 fw-bold" id="MRP_religion" name="MRP_religion" value="{{ $patient->medicalRecordPersonnel->religion }}" readonly>
        </div>
        <div class="col-md-10">
            <label for="MRP_address" class="form-label h6">Home Address</label>
            <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-0 pb-0 fs-5 fw-bold" id="MRP_address" name="MRP_address" value="{{ $patient->medicalRecordPersonnel->region }}, {{ $patient->medicalRecordPersonnel->province }}, {{ $patient->medicalRecordPersonnel->cityMunicipality }}, {{ $patient->medicalRecordPersonnel->barangaySubdVillage }}, {{ $patient->medicalRecordPersonnel->houseNumberStName }}" readonly>
        </div>
        <div class="col-md-2">
            <label for="MRP_personnelContactNumber" class="form-label h6">Contact No.</label>
            <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-0 pb-0 fs-5 fw-bold" placeholder="09123456789" id="MRP_personnelContactNumber" name="MR_personnelContactNumber" value="0{{ $patient->medicalRecordPersonnel->contactNumber }}" readonly>
        </div>
        <h5 class="pt-2">Contact Person in case of Emergency:</h5>
        <div class="col-md-6">
            <label for="MRP_contactName" class="form-label h6">Name</label>
            <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-0 pb-0 fs-5 fw-bold" id="MRP_contactName" name="MRP_contactName" value="{{ $patient->medicalRecordPersonnel->emergencyContactName }}" readonly>
        </div>
        <div class="col-md-6">
            <label for="MRP_ContactNumber" class="form-label h6">Contact No.</label>
            <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-0 pb-0 fs-5 fw-bold" id="MRP_ContactNumber" name="MR_ContactNumber" value="0{{ $patient->medicalRecordPersonnel->emergencyContactNumber }}" readonly>
        </div>
        <div class="col-md-6">
            <label for="MRP_Occupation" class="form-label h6">Occupation</label>
            <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-0 pb-0 fs-5 fw-bold" id="MRP_Occupation" name="MRP_Occupation" value="{{ $patient->medicalRecordPersonnel->emergencyContactOccupation }}" readonly>
        </div>
        <div class="col-md-6">
            <label for="MRP_relationship" class="form-label h6">Relationship</label>
            <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-0 pb-0 fs-5 fw-bold" id="MRP_relationship" name="MRP_relationship" value="{{ $patient->medicalRecordPersonnel->emergencyContactRelationship }}" readonly>
        </div>
        <div class="col-md-12">
            <label for="MRP_OfficeAdd" class="form-label h6">Work/Home Address</label>
            <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-0 pb-0 fs-5 fw-bold" id="MRP_OfficeAdd" name="MRP_OfficeAdd" value="{{ $patient->medicalRecordPersonnel->emergencyContactAddressRegion }} {{ $patient->medicalRecordPersonnel->emergencyContactAddressProvince }} {{ $patient->medicalRecordPersonnel->emergencyContactAddressCityMunicipality }} {{ $patient->medicalRecordPersonnel->emergencyContactAddressBrgySubdVillage }} {{ $patient->medicalRecordPersonnel->emergencyContactAddressHouseNoStreet }}" readonly>
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
                            <input class="form-check-input" type="checkbox" name="FHP_cancer" {{ $patient->medicalRecordPersonnel->familyHistory->cancer == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_cancer">
                                    Cancer
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_heartDisease" {{ $patient->medicalRecordPersonnel->familyHistory->heartDisease == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_heartDisease">
                                    Heart Disease
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_hypertension" {{ $patient->medicalRecordPersonnel->familyHistory->hypertension == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_hypertension">
                                    Hypertension
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_thyroidDisease" {{ $patient->medicalRecordPersonnel->familyHistory->thyroidDisease == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_thyroidDisease">
                                    Thyroid Disease
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_tuberculosis" {{ $patient->medicalRecordPersonnel->familyHistory->tuberculosis == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_tuberculosis">
                                    Tuberculosis
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_hivAids" {{ $patient->medicalRecordPersonnel->familyHistory->hivAids == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_tuberculosis">
                                    HIV/AIDS
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div><!-- END OF COL DIV -->
                    <div class="col-md-4 p-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_diabetesMelittus" {{ $patient->medicalRecordPersonnel->familyHistory->diabetesMelittus == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_diabetesMelittus">
                                    Diabetes Melittus
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_mentalDisorder" {{ $patient->medicalRecordPersonnel->familyHistory->mentalDisorder == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_mentalDisorder">
                                    Mental Disorder
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_asthma" {{ $patient->medicalRecordPersonnel->familyHistory->asthma == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_asthma">
                                    Asthma
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_convulsions" {{ $patient->medicalRecordPersonnel->familyHistory->convulsions == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_convulsions">
                                    Convulsions
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_bleedingDyscrasia" {{ $patient->medicalRecordPersonnel->familyHistory->bleedingDyscrasia == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_bleedingDyscrasia">
                                    Bleeding Dyscrasia
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_arthritis" {{ $patient->medicalRecordPersonnel->familyHistory->arthritis == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_arthritis">
                                    Arthritis
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div><!-- END OF COL DIV -->
                    <div class="col-md-4 p-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_eyeDisorder" {{ $patient->medicalRecordPersonnel->familyHistory->eyeDisorder == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_eyeDisorder">
                                    Eye Disorder
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_skinProblems" {{ $patient->medicalRecordPersonnel->familyHistory->skinProblems == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_skinProblems">
                                    Skin Problems
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_kidneyProblems" {{ $patient->medicalRecordPersonnel->familyHistory->kidneyProblems == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_kidneyProblems">
                                    Kidney Problems
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_gastroDisease" {{ $patient->medicalRecordPersonnel->familyHistory->gastroDisease == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_gastroDisease">
                                    Gastrointestinal Disease
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="FHP_gastroDisease" {{ $patient->medicalRecordPersonnel->familyHistory->gastroDisease == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="FHP_gastroDisease">
                                    Hepatitis
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div><!-- END OF COL DIV --> 
                </div><!-- END OF ROW of CHECKBOXES DIV -->
            <div class="form-row align-items-center">
                <div class="col p-2">
                    <input class="form-check-input" type="checkbox" id="FHP_others" name="FHP_others" {{ $patient->medicalRecordPersonnel->familyHistory->others == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                        <label class="form-check-label" for="FHP_others" style="display: contents!important;">
                            Others
                        </label>
                            <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-0 pb-0 fs-6 fw-bold" id="FHP_othersDetails" name="FHP_othersDetails" value="{{ $patient->medicalRecordPersonnel->familyHistory->othersDetails }}" readonly disabled>

                            <!-- SCRIPT FOR INPUT TOGGLE ON CHECKBOX TICK -->
                    </div><!-- END OF COL OTHERS DIV -->
                </div><!-- END OF ROW OTHERS DIV -->
            </div><!-- END OF COL FH -->

            <!-- START OF PSH -->
            <div class="col-lg-5 col-md-12 p-2 border border-dark">
                <h6>Personal Social History</h6>
                    <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="PPSH_smoking" name="PPSH_smoking" {{ $patient->medicalRecordPersonnel->personalSocialHistory->smoking == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                        <label class="form-check-label" for="PPSH_smoking" style="display: contents!important;">
                            Smoking
                            <br>
                            <div class="d-flex align-items-center">
                                ( <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 text-center mb-2 pb-0 fs-6 fw-bold" style="width: 10%;" id="PPSH_smoking_amount" name="PPSH_smoking_amount" value="{{ $patient->medicalRecordPersonnel->personalSocialHistory->sticksPerDay }}" readonly> 
                                sticks/day for 
                                <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 text-center mb-2 pb-0 fs-6 fw-bold" style="width: 10%;"  id="PPSH_smoking_freq" name="PPSH_smoking_freq" value="{{$patient->medicalRecordPersonnel->personalSocialHistory->years }}" readonly> 
                                year/s ) 
                            </div>
                        </label>
                </div><!-- END OF SMOKING FORM DIV -->
                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" id="PPSH_eCig" name="PPSH_eCig" {{ $patient->medicalRecordPersonnel->personalSocialHistory->eCig == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;">
                    <label class="form-check-label" for="PPSH_eCig" style="display: contents!important;">
                        E-Cigarette
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="PPSH_vape" name="PPSH_vape" {{ $patient->medicalRecordPersonnel->personalSocialHistory->vape == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;">
                    <label class="form-check-label" for="PPSH_vape" style="display: contents!important;">
                        Vape
                    </label>  
                </div>

                <div class="form-check" style="margin-top:5%;">
                    <input class="form-check-input" type="checkbox" id="PPSH_drinking" name="PPSH_drinking" {{ $patient->medicalRecordPersonnel->personalSocialHistory->drinking == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                        <label class="form-check-label" for="PPSH_drinking" style="display: contents!important;">
                            Liquor Consumption:
                            How often?
                            <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-0 pb-0 fs-6 fw-bold" id="PPSH_drinkingDetails" name="PPSH_drinkingDetails" value="{{ $patient->medicalRecordPersonnel->personalSocialHistory->drinkingDetails }}" readonly/>                
                        </label>
                </div><!-- END OF DRINKING FORM DIV -->

                    <!-- SCRIPT FOR INPUT TOGGLE ON CHECKBOX TICK -->

            </div><!-- END OF PSH COL DIV -->
        </div><!-- END OF ROW ENTIRE DIV -->

        <!--Personal History-->
        <!-- PRINTABLE -->
        <div class="row d-flex d-print-inline-block d-none d-print-block" style="margin-bottom: 700px;">
            <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
                <header class="text-center">
                    <!-- LINE BREAK -->
                </header>
            </section>
        </div>
        <!-- END OF PRINTABLE -->
        <!-- PRINTABLE -->
        <div class="row d-flex d-print-inline-block d-none d-print-block" style="margin-bottom: 90px;">
            <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
                <header class="text-center">
                    <!-- LINE BREAK -->
                </header>
            </section>
        </div>
        <!-- END OF PRINTABLE -->
        
        <h5 class="ms-1">Personal Medical Condition</h5>
        <div class="mx-auto row row-cols-lg-1 mt-2">
            <div class="col-md-12 p-2 border border-dark">  
                <div class="d-flex row row-cols-xl-3 row-cols-lg-1 justify-content-between">
                    <div class="col-xl-2 p-2">
                        <div class="mx-auto row row-cols-xl-1 row-cols-lg-2 row-cols-sm-2 row-cols-xs-1 mt-2 ">
                            <div class="col mb-2">
                                <input class="form-check-input" type="checkbox" name="PPMC_hypertension" {{ $patient->medicalRecordPersonnel->personalMedicalCondition->hypertension == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                <label class="form-check-label" for="PPMC_hypertension">
                                    Hypertension
                                </label>
                            </div><!-- END OF CHECKBOX DIV -->
                            <div class="col mb-2">
                                <input class="form-check-input" type="checkbox" name="PPMC_asthma" {{ $patient->medicalRecordPersonnel->personalMedicalCondition->asthma == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                    <label class="form-check-label" for="PPMC_asthma">
                                        Asthma
                                    </label>
                            </div><!-- END OF CHECKBOX DIV -->
                            <div class="col mb-2">
                                <input class="form-check-input" type="checkbox" value="1" name="PPMC_diabetes" {{ $patient->medicalRecordPersonnel->personalMedicalCondition->diabetes == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                    <label class="form-check-label" for="PPMC_diabetes">
                                        Diabetes
                                    </label>
                            </div><!-- END OF CHECKBOX DIV -->
                            <div class="col mb-2">
                                <input class="form-check-input" type="checkbox" name="PPMC_arthritis" {{ $patient->medicalRecordPersonnel->personalMedicalCondition->arthritis == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                    <label class="form-check-label" for="PPMC_arthritis">
                                        Arthritis
                                    </label>
                            </div><!-- END OF CHECKBOX DIV -->
                            <div class="col mb-2">                    
                                <input class="form-check-input" type="checkbox" name="PPMC_chickenPox" {{ $patient->medicalRecordPersonnel->personalMedicalCondition->chickenPox == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                    <label class="form-check-label" for="PPMC_chickenPox">
                                        Chicken Pox
                                    </label>
                            </div><!-- END OF CHECKBOX DIV -->
                            <div class="col mb-2">
                                <input class="form-check-input" type="checkbox" name="PPMC_dengue" {{ $patient->medicalRecordPersonnel->personalMedicalCondition->dengue == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                    <label class="form-check-label" for="PPMC_dengue">
                                        Dengue
                                    </label>
                            </div><!-- END OF CHECKBOX DIV -->
                            <div class="col mb-2">
                                <input class="form-check-input" type="checkbox" name="PPMC_tuberculosis" {{ $patient->medicalRecordPersonnel->personalMedicalCondition->tuberculosis == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                    <label class="form-check-label" for="PPMC_tuberculosis">
                                        Tuberculosis
                                    </label>
                            </div><!-- END OF CHECKBOX DIV -->
                            <div class="col mb-2">
                                <input class="form-check-input" type="checkbox" name="PPMC_pneumonia" {{ $patient->medicalRecordPersonnel->personalMedicalCondition->pneumonia == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                    <label class="form-check-label" for="PPMC_pneumonia">
                                        Pneumonia
                                    </label>
                            </div><!-- END OF CHECKBOX DIV -->
                            <div class="col mb-2">
                                <input class="form-check-input" type="checkbox" name="PPMC_covid19" {{ $patient->medicalRecordPersonnel->personalMedicalCondition->covid19 == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                    <label class="form-check-label" for="PPMC_covid19">
                                        Covid-19
                                    </label>
                            </div><!-- END OF CHECKBOX DIV -->
                            <div class="col mb-2">
                                <input class="form-check-input" type="checkbox" name="PPMC_hivAids" {{ $patient->medicalRecordPersonnel->personalMedicalCondition->hivAids == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                    <label class="form-check-label" for="PPMC_hivAids">
                                        HIV/AIDS
                                    </label>
                            </div><!-- END OF CHECKBOX DIV -->
                        </div>
                    </div>
                <!-- START OF CHECKBOXES WITH INPUT -->
                    <div class="col-xl-5 p-2">
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                                <div class="input-group-text bg-light border-0">
                                    <input class="form-check-input mt-0" type="checkbox" name="PPMC_hepatitis" style="margin-right: -10px;" {{ $patient->medicalRecordPersonnel->personalMedicalCondition->hepatitis == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                </div>
                                <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Hepatitis: </span>
                                <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-6 fw-bold" style="width: 72%;" id="PPMC_hepatitisDetails" name="PPMC_hepatitisDetails" value="{{ $patient->medicalRecordPersonnel->personalMedicalCondition->hepatitisDetails }}" readonly>
                            </div>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                                <div class="input-group-text bg-light border-0">
                                    <input class="form-check-input mt-0" type="checkbox" name="PPMC_thyroidDisorder" style="margin-right: -10px;" {{ $patient->medicalRecordPersonnel->personalMedicalCondition->thyroidDisorder == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                </div>
                                <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Thyroid Disorder: </span>
                                <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-6 fw-bold" style="width: 59%;" id="PPMC_thyroidDisorderDetails" name="PPMC_thyroidDisorderDetails" value="{{ $patient->medicalRecordPersonnel->personalMedicalCondition->thyroidDisorderDetails }}" readonly>
                            </div>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                                <div class="input-group-text bg-light border-0">
                                    <input class="form-check-input mt-0" type="checkbox" value="1" name="PPMC_eyeDisorder" style="margin-right: -10px;" {{ $patient->medicalRecordPersonnel->personalMedicalCondition->eyeDisorder == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                </div>
                                <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Eye Disorder: </span>
                                <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-6 fw-bold" style="width: 66%;" id="PMC_eyeDisorderDetails" name="PPMC_eyeDisorderDetails" value="{{ $patient->medicalRecordPersonnel->personalMedicalCondition->eyeDisorderDetails }}" readonly>                                
                            </div>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                                <div class="input-group-text bg-light border-0">
                                    <input class="form-check-input mt-0" type="checkbox" name="PPMC_mentalDisorder" style="margin-right: -10px;" {{ $patient->medicalRecordPersonnel->personalMedicalCondition->mentalDisorder == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                </div>
                                <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Mental Disorder: </span>
                                <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-6 fw-bold" style="width: 60%;" id="PPMC_mentalDisorderDetails" name="PPMC_mentalDisorderDetails" value="{{ $patient->medicalRecordPersonnel->personalMedicalCondition->mentalDisorderDetails }}" readonly>
                            </div>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                                <div class="input-group-text bg-light border-0">
                                    <input class="form-check-input mt-0" type="checkbox" name="PPMC_gastroDisease" style="margin-right: -10px;" {{ $patient->medicalRecordPersonnel->personalMedicalCondition->gastroDisease == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                </div>
                                <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Gastrointestinal Disease: </span>
                                <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-6 fw-bold" style="width: 45.1%;" id="PPMC_gastroDiseaseDetails" name="PPMC_gastroDiseaseDetails" value="{{ $patient->medicalRecordPersonnel->personalMedicalCondition->gastroDiseaseDetails }}" readonly>
                            </div>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                                <div class="input-group-text bg-light border-0">
                                    <input class="form-check-input mt-0" type="checkbox" name="PPMC_kidneyDisease" style="margin-right: -10px;" {{ $patient->medicalRecordPersonnel->personalMedicalCondition->kidneyDisease == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                </div>
                                 <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Kidney Disease: </span>
                                 <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-6 fw-bold" style="width: 61%;" id="PPMC_kidneyDiseaseDetails" name="PPMC_kidneyDiseaseDetails" value="{{ $patient->medicalRecordPersonnel->personalMedicalCondition->kidneyDiseaseDetails }}" readonly>
                             </div>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-xl-5 p-2">
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                                <div class="input-group-text bg-light border-0">
                                    <input class="form-check-input mt-0" type="checkbox" name="PPMC_heartDisease" style="margin-right: -10px;" {{ $patient->medicalRecordPersonnel->personalMedicalCondition->heartDisease == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                </div>
                                <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Heart Disease: </span>
                                <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-6 fw-bold" style="width: 63%;" id="PPMC_heartDiseaseDetails" name="PPMC_heartDiseaseDetails" value="{{ $patient->medicalRecordPersonnel->personalMedicalCondition->heartDiseaseDetails }}" readonly>
                            </div>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                                <div class="input-group-text bg-light border-0">
                                    <input class="form-check-input mt-0" type="checkbox" name="PPMC_skinDisease" style="margin-right: -10px;" {{ $patient->medicalRecordPersonnel->personalMedicalCondition->skinDisease == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                </div>
                                <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Skin Disease: </span>
                                <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-6 fw-bold" style="width: 65.6%;" id="PPMC_skinDiseaseDetails" name="PPMC_skinDiseaseDetails" value="{{ $patient->medicalRecordPersonnel->personalMedicalCondition->skinDiseaseDetails }}" readonly>
                            </div>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                                <div class="input-group-text bg-light border-0">
                                    <input class="form-check-input mt-0" type="checkbox" name="PPMC_earDisease" style="margin-right: -10px;" {{ $patient->medicalRecordPersonnel->personalMedicalCondition->earDisease == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                </div>
                                <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Ear Disease: </span>
                                <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-6 fw-bold" style="width: 67.1%;" id="PPMC_earDiseaseDetails" name="PPMC_earDiseaseDetails" value="{{ $patient->medicalRecordPersonnel->personalMedicalCondition->earDiseaseDetails }}" readonly>
                            </div>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                                <div class="input-group-text bg-light border-0">
                                    <input class="form-check-input mt-0" type="checkbox" name="PPMC_cancer" style="margin-right: -10px;" {{ $patient->medicalRecordPersonnel->personalMedicalCondition->cancer == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                </div>
                                <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Cancer: </span>
                                <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-6 fw-bold" style="width: 74.2%;" id="PMC_cancerDetails" name="PPMC_cancerDetails" value="{{ $patient->medicalRecordPersonnel->personalMedicalCondition->cancerDetails }}" readonly>
                            </div>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                            <div class="input-group-text bg-light border-0">
                                    <input class="form-check-input mt-0" type="checkbox" name="PPMC_others" style="margin-right: -10px;" {{ $patient->medicalRecordPersonnel->personalMedicalCondition->others == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                </div>
                            <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Others: </span>
                                <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-6 fw-bold" style="width: 75.6%;" id="PPMC_othersDetails" name="PPMC_othersDetails" value="{{ $patient->medicalRecordPersonnel->personalMedicalCondition->othersDetails }}" readonly>
                            </div>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                </div>
            </div>
        </div>
        <!--Medical Status
                    HOSPITALIZATION-->
                    
                    <div class="mx-auto row row-cols-lg-1 mt-2">
                        <div class="col-md-12 p-2 border border-dark">  
                            <div class="d-flex flex-row">
                                <div class="col-sm">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input border-dark" type="checkbox" role="switch" name="hospitalization" id="hospitalization" {{ $patient->medicalRecordPersonnel->hospitalization == '1' ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                        <label class="form-check-label fw-bold" for="hospitalization">
                                            Do you have history of hospitalization for serious illness, operation, fracture or injury?
                                        </label>
                                    </div><!-- END OF YES DIV -->
                                    <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-6 fw-bold" id="hospitalizationDetails" name="hospitalizationDetails" placeholder="If yes, please give details:" value="{{ $patient->medicalRecordPersonnel->hospDetails }}" readonly/>
                                </div><!-- END OF COL DIV -->
                            </div><!-- END OF ROW DIV -->
            
                            <!-- REGULAR MEDICINES -->
                            <div class="d-flex flex-row pt-2">
                                <div class="col-sm">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input border-dark" type="checkbox" role="switch" name="regMeds" id="regMeds" {{ $patient->medicalRecordPersonnel->takingMedsRegularly == '1' ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                        <label class="form-check-label fw-bold" for="regMeds">
                                                Are you taking any medicine regularly?
                                        </label>
                                    </div><!-- END OF YES DIV -->
                                    <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-6 fw-bold" id="regMedsDetails" name="regMedsDetails" placeholder="If yes, name of drug/s:" value="{{ $patient->medicalRecordPersonnel->medsDetails }}" readonly/>
                                       <!-- END OF SCRIPT --> 
                               </div><!-- END OF COL DIV -->
                           </div><!-- END OF ROW DIV -->
            
                               <!-- ALLERGIES -->
                        <div class="d-flex flex-row pt-2">
                            <div class="col-sm" required>
                                <div class="form-check form-switch">
                                    <input class="form-check-input border-dark" type="checkbox" role="switch" name="allergy" id="allergy" {{ $patient->medicalRecordPersonnel->allergic == '1' ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                                    <label class="form-check-label fw-bold" for="allergy">
                                        Are you allergic to any food or medicine?
                                    </label>
                                </div><!-- END OF YES DIV -->                    
                                <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-6 fw-bold" id="allergyDetails" name="allergyDetails" placeholder="If yes, specify:" value="{{ $patient->medicalRecordPersonnel->allergyDetails }}" readonly/>
                                   <!-- END OF SCRIPT --> 
                            </div><!-- END OF COL DIV -->
                        </div><!-- END OF ROW DIV -->    
                    </div>
                </div>
        
        <!--Immunization History-->
        <div class="mx-auto row row-cols-lg-1 mt-2">
            <div class="col-md-12 p-2 border border-dark">
                <h6>Immunization History</h6>
                <div class="my-auto row row-cols-xl-2 row-cols-sm-1 align-items-center" style="margin-left: 5%;">
                    <div class="col-6">
                        <div class="row row-cols-2 row-cols-sm-1 align-items-center">
                            <div class="col-sm-4 p-2">
                                <input class="form-check-input" type="checkbox" name="PIH_bcg" {{ $patient->medicalRecordPersonnel->immunizationHistory->bcg == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;">
                                    <label class="form-check-label" for="PIH_bcg" data-toggle="tooltip" data-placement="top" title="Bacille Calmette-Guerin">
                                        BCG
                                    </label>
                            </div>
                            <div class="col-sm-8 p-2">
                                <input class="form-check-input" type="checkbox" name="PIH_polio" {{ $patient->medicalRecordPersonnel->immunizationHistory->polio == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;">
                                    <label class="form-check-label" for="PIH_polio">
                                        Polio I, II, II, Booster Dose
                                    </label>
                            </div>
                            <div class="col-sm-4 p-2">
                                <input class="form-check-input" type="checkbox" name="PIH_chickenPox" {{ $patient->medicalRecordPersonnel->immunizationHistory->chickenPox == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;">
                                    <label class="form-check-label" for="PIH_chickenPox">
                                        Chicken Pox
                                    </label>
                            </div>
                            <div class="col-sm-8 p-2">
                                <input class="form-check-input" type="checkbox" name="PIH_dpt" {{ $patient->medicalRecordPersonnel->immunizationHistory->dpt == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;">
                                    <label class="form-check-label" for="PIH_dpt">
                                        DPT I, II, III, Booster Dose
                                    </label>
                            </div>
                        </div>
                        <div class="row row-cols-1 row-cols-sm-1 align-items-center">
                            <div class="col-sm-12 p-2">
                                <div class="d-flex align-items-center">
                                <input class="form-check-input" style="margin-top:6px;" type="checkbox" id="IH_covidVacc" name="IH_covidVacc" {{ $patient->medicalRecordPersonnel->immunizationHistory->covidVacc == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;">
                                    <label class="form-check-label mt-2 ms-1" for="PIH_covidVacc">
                                        Covid-19 Vaccine I, II
                                    </label>
                                    <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 text-center mb-2 pb-0 fs-6 fw-bold" style="width:20%;" id="PIH_covidVaccName" name="PIH_covidVaccName" value="{{ $patient->medicalRecordPersonnel->immunizationHistory->covidVaccName }}" readonly>
                                    <label class="form-check-label" for="IH_dpt">
                                        Booster I, II
                                    </label>
                                    <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 text-center mb-2 pb-0 fs-6 fw-bold" style="width:20%;" id="PIH_covidBooster" name="PIH_covidBooster" value="{{ $patient->medicalRecordPersonnel->immunizationHistory->covidBoosterName }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row row-cols-xl-3 row-cols-lg-2 row-cols-sm-3 align-items-center">
                                <div class="col-4 p-2">
                                    <input class="form-check-input" type="checkbox" name="PIH_typhoid" {{ $patient->medicalRecordPersonnel->immunizationHistory->typhoid == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;">
                                        <label class="form-check-label" for="PIH_typhoid">
                                            Typhoid
                                        </label>
                                </div>
                                <div class="col-4 ps-lg-3 p-2">
                                    <input class="form-check-input" type="checkbox" name="PIH_mumps" {{ $patient->medicalRecordPersonnel->immunizationHistory->mumps == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;">
                                        <label class="form-check-label" for="PIH_mumps">
                                            Mumps
                                        </label>
                                </div>
                                <div class="col-4 ps-lg-3 p-2">
                                    <input class="form-check-input" type="checkbox" value="1" name="PIH_hepatitisA" {{ $patient->medicalRecordPersonnel->immunizationHistory->hepatitisA == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;">
                                        <label class="form-check-label" for="PIH_hepatitisA">
                                            Hepatitis A
                                        </label>
                                </div>
                                <div class="col-4 p-2">
                                    <input class="form-check-input" type="checkbox" value="1" name="PIH_measles" {{ $patient->medicalRecordPersonnel->immunizationHistory->measles == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;">
                                        <label class="form-check-label" for="PIH_measles">
                                            Measles
                                        </label>
                                </div>
                                <div class="col-4 ps-lg-3 p-2">
                                    <input class="form-check-input" type="checkbox" name="PIH_germanMeasles" {{ $patient->medicalRecordPersonnel->immunizationHistory->germanMeasles == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;">
                                        <label class="form-check-label" for="PIH_germanMeasles">
                                            German Measles
                                        </label>
                                </div>
                                <div class="col-4 ps-lg-3 p-2">
                                    <input class="form-check-input" type="checkbox" name="PIH_hepatitisB" {{ $patient->medicalRecordPersonnel->immunizationHistory->hepatitisB == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;">
                                        <label class="form-check-label" for="PIH_hepatitisB">
                                            Hepatitis B
                                        </label>
                                </div>
                                <div class="col-4 p-2">
                                    <input class="form-check-input" type="checkbox" name="PIH_measles" {{ $patient->medicalRecordPersonnel->immunizationHistory->measles == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;">
                                        <label class="form-check-label" for="PIH_measles">
                                            Pneumoccal
                                        </label>
                                </div>
                                <div class="col-4 ps-lg-3 p-2">
                                    <input class="form-check-input" type="checkbox" name="PIH_influenza" {{ $patient->medicalRecordPersonnel->immunizationHistory->influenza == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;">
                                        <label class="form-check-label" for="PIH_influenza">
                                            Influenza
                                        </label>
                                </div>
                                <div class="col-4 ps-lg-3 p-2">
                                    <input class="form-check-input" type="checkbox" name="PIH_hpv" {{ $patient->medicalRecordPersonnel->immunizationHistory->hpv == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;">
                                        <label class="form-check-label" for="PIH_hpv">
                                            HPV
                                        </label>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="my-auto pt-2 row row-cols-1 align-items-center" style="margin-left: 5%;">
                            <div class="form-group align-items-center col-sm-12 d-flex p-2">
                                <input type="hidden" name="IH_others" value="0">
                                <input class="form-check-input mb-1" type="checkbox" value="1" id="IH_others" name="IH_others" {{ $patient->medicalRecordPersonnel->immunizationHistory->others == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label mx-1" for="IH_others">
                                        Others
                                    </label>
                                <input type="text" class="form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-6 fw-bold" value="{{ $patient->medicalRecordPersonnel->immunizationHistory->othersDetails  }}" style="width: 90%;" id="IH_othersDetails" name="IH_othersDetails" {{ old('IH_others') == 1 ? '' : 'disabled' }}>
                            </div>
                     </div>
                </div>
            </div>
<!-- PRINTABLE -->
<div class="row d-flex d-print-inline-block d-none d-print-block" style="margin-bottom: 600px;">
    <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
        <header class="text-center">
            <!-- LINE BREAK -->
        </header>
    </section>
</div>
<!-- END OF PRINTABLE -->
<!-- PRINTABLE -->
<div class="row d-flex d-print-inline-block d-none d-print-block" style="margin-bottom: 140px;">
    <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
        <header class="text-center">
            <!-- LINE BREAK -->
        </header>
    </section>
</div>
<!-- END OF PRINTABLE -->
    <!-- ATTACHMENTS -->
    <div class="mx-auto row row-cols-lg-1 mt-2">
        <div class="col-md-12 p-1 border border-dark">
            <p class="fs-5 text-center">Please upload a photo of the official reading and result of the following:</p>
            <div class="flex justify-content-center">
                <div class="row row-cols-xl-2 row-cols-lg-1 row-cols-md-1 row-cols-sm-1 my-auto px-5 py-4">
                    <div class="col-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="MR_studentSignature" class="form-label fw-bold">Chest X-Ray Findings</label>
                        <a href="{{ asset('storage/'.$patient->medicalRecordPersonnel->chestXray) }}" data-lightbox="Chest X-Ray Findings" data-title="Chest X-Ray Findings">
                            <div class="mb-3 col-6 signature-container d-flex justify-content-center align-items-center divForResults border border-dark rounded-1">
                                <img class="img-fluid" src="{{ asset('storage/'.$patient->medicalRecordPersonnel->chestXray) }}" alt="Chest X-Ray Findings" style="">
                            </div>
                        </a>
                    </div>
                    <div class="row d-flex d-print-inline-block d-none d-print-block" style="margin-bottom: 50px;">
                        <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
                            <header class="text-center">
                                <!-- LINE BREAK -->
                            </header>
                        </section>
                    </div>
                    <div class="col-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="MR_parentGuardianSignature" class="form-label fw-bold">CBC Results</label>
                        <a href="{{ asset('storage/'.$patient->medicalRecordPersonnel->CBCResults) }}" data-lightbox="CBC Results" data-title="CBC Results">
                            <div class="mb-3 col-6 signature-container d-flex justify-content-center align-items-center divForResults border border-dark rounded-1">  
                                <img class="img-fluid" src="{{ asset('storage/'.$patient->medicalRecordPersonnel->CBCResults) }}" alt="CBC Results">
                            </div>
                        </a>
                    </div>
                    <div class="row d-flex d-print-inline-block d-none d-print-block" style="margin-bottom: 450px;">
                        <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
                            <header class="text-center">
                                <!-- LINE BREAK -->
                            </header>
                        </section>
                    </div>
                    <div class="row d-flex d-print-inline-block d-none d-print-block" style="margin-bottom: 120px;">
                        <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
                            <header class="text-center">
                                <!-- LINE BREAK -->
                            </header>
                        </section>
                    </div>
                    <div class="col-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="MR_parentGuardianSignature" class="form-label fw-bold">Hepatitis B Screening</label>
                        <a href="{{ asset('storage/'.$patient->medicalRecordPersonnel->hepaBscreening) }}" data-lightbox="Hepatitis B Screening" data-title="Hepatitis B Screening">
                            <div class="mb-3 col-6 signature-container d-flex justify-content-center align-items-center divForResults border border-dark rounded-1">
                                <img class="img-fluid" src="{{ asset('storage/'.$patient->medicalRecordPersonnel->hepaBscreening) }}" alt="Hepatitis B Screening">
                            </div>
                        </a>
                    </div> 
                    <div class="row d-flex d-print-inline-block d-none d-print-block" style="margin-bottom: 50px;">
                        <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
                            <header class="text-center">
                                <!-- LINE BREAK -->
                            </header>
                        </section>
                    </div>
                    <div class="col-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="MR_parentGuardianSignature" class="form-label fw-bold">Blood Type</label>
                        <a href="{{ asset('storage/'.$patient->medicalRecordPersonnel->bloodType) }}" data-lightbox="Blood Type" data-title="Blood Type">
                            <div class="mb-3 col-6 signature-container d-flex justify-content-center align-items-center divForResults border border-dark rounded-1">
                                <img class="img-fluid" src="{{ asset('storage/'.$patient->medicalRecordPersonnel->bloodType) }}" alt="Blood Type">
                            </div>
                        </a>
                    </div>
                    @php
                        for($i=1; $patient->medicalRecordPersonnel->{'resultName' . $i} != NULL; $i++){
                            echo    '<div class="mb-3 col-3 d-flex flex-column justify-content-center align-items-center">';
                            echo        '<label for="MR_parentGuardianSignature" class="form-label fw-bold">'. $patient->medicalRecordPersonnel->{'resultName' . $i} .'</label>';
                            echo        '<a href="' . asset("storage/" .$patient->medicalRecordPersonnel->{'resultImage' . $i}) . '" data-lightbox="'. $patient->medicalRecordPersonnel->{'resultName' . $i} .'" data-title="'. $patient->medicalRecordPersonnel->{'resultName' . $i} .'">';
                            echo            '<div class="mb-3 col-6 signature-container d-flex justify-content-center align-items-center divForResults border border-dark rounded-1">';
                            echo                '<img class="img-fluid" src="' . asset("storage/" .$patient->medicalRecordPersonnel->{'resultImage' . $i}) . '" alt="'. $patient->medicalRecordPersonnel->{'resultName' . $i} .'">';
                            echo            '</div>';
                            echo        '</a>';
                            echo    '</div>';
                        }
                    @endphp
                </div>
            </div>
        </div>
    </div>
    <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
        <header class="text-center">
            <!-- LINE BREAK -->
        </header>
    </section>
    <div class="row d-flex d-print-inline-block d-none d-print-block" style="margin-bottom: 500px;">
        <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
            <header class="text-center">
                <!-- LINE BREAK -->
            </header>
        </section>
    </div>
    <div class="row d-flex d-print-inline-block d-none d-print-block" style="margin-bottom: 150px;">
        <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
            <header class="text-center">
                <!-- LINE BREAK -->
            </header>
        </section>
    </div>
    
    <p class="text-center fw-bold pt-1" style="user-select:none;">
        ---------- TO BE ACCOMPLISHED BY THE MEDICAL PERSONNEL ----------
    </p>
        
    <!-- START OF PHYSICIAN INPUT -->
    <!-- VITAL SIGNS -->
    <div class="mx-auto row row-cols-lg-1 mt-2">
        <div class="col-md-12 p-1 border border-dark">
            <div class="container">
                <p class="fs-5 fw-bold">VITAL SIGNS:ANTHROPOMETRICS</p>
                <div class="row row-cols-xl-3 row-cols-sm-1 justify-content-center">
                    <!-- Col 1 (BASELINE) -->
                    <div class="col-xl-3">
                        <div class="form-group d-flex">
                            <label for="VS_bloodPressure" class="form-label h6 my-auto me-1" style="white-space: nowrap;">BP<span class="text-danger" style="user-select: none;">*</span>:&nbsp;</label>
                            <div class="d-flex align-items-center ms-4"style="margin-top:-1%;">
                                <input type="number" step="1" min="0" class="{{ $patient->medicalRecord_admin && $patient->medicalRecord_admin->bp_systolic ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('VS_bp_systolic') is-invalid @enderror me-1" id="VS_bp_systolic" name="VS_bp_systolic" value="{{ $patient->medicalRecord_admin && $patient->medicalRecord_admin->bp_systolic ? $patient->medicalRecord_admin->bp_systolic : old('VS_bp_systolic') }}" onKeyPress="if(this.value.length==3) return false;" style="width:31.7%;" {{ $patient->medicalRecord_admin ? 'readonly' : 'required' }}>
                                <span class="fs-6">/</span>
                                <input type="number" class="{{ $patient->medicalRecord_admin && $patient->medicalRecord_admin->bp_diastolic ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('VS_bp_diastolic') is-invalid @enderror ms-2" id="VS_bp_diastolic" name="VS_bp_diastolic" value="{{ $patient->medicalRecord_admin && $patient->medicalRecord_admin->bp_diastolic ? $patient->medicalRecord_admin->bp_diastolic : old('VS_bp_diastolic') }}" onKeyPress="if(this.value.length==3) return false;" style="width:31.7%;" {{ $patient->medicalRecord_admin ? 'readonly' : 'required' }}> 
                                <p class="pt-3" style="margin-left: 4px;">mmHg</p>
                            </div>
                        </div>                   
                        <div class="form-group d-flex">
                            <label for="VS_pulseRate" class="form-label h6 my-auto me-1">PR<span class="text-danger" style="user-select: none;">*</span>:&nbsp;</label>
                            <div class="d-flex align-items-center" style="margin-top:-1%;">
                                <input type="number" class="{{ $patient->medicalRecord_admin && $patient->medicalRecord_admin->pulseRate ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('VS_pulseRate') is-invalid @enderror me-1 ms-4" id="VS_pulseRate" name="VS_pulseRate" value="{{ $patient->medicalRecord_admin && $patient->medicalRecord_admin->pulseRate ? $patient->medicalRecord_admin->pulseRate : old('VS_pulseRate') }}" onKeyPress="if(this.value.length==4) return false;" {{ $patient->medicalRecord_admin ? 'readonly' : 'required' }}>
                                <p class="pt-3" style="margin-left: 4px;">/minute</p>
                                
                            </div>
                        </div>                 
                        <div class="form-group d-flex">
                            <label for="VS_respirationRate" class="form-label h6 my-auto me-1">RR<span class="text-danger" style="user-select: none;">*</span>:&nbsp;</label>
                            <div class="d-flex align-items-center" style="margin-top:-1%;">
                                <input type="number" class="{{ $patient->medicalRecord_admin && $patient->medicalRecord_admin->respirationRate ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('VS_respirationRate') is-invalid @enderror me-1 ms-4" id="VS_respirationRate" name="VS_respirationRate" value="{{ $patient->medicalRecord_admin && $patient->medicalRecord_admin->respirationRate ? $patient->medicalRecord_admin->respirationRate : old('VS_respirationRate') }}" onKeyPress="if(this.value.length==4) return false;" {{ $patient->medicalRecord_admin ? 'readonly' : 'required' }}>
                                <p class="pt-3" style="margin-left: 4px;">/minute</p>

                            </div>
                        </div>
                        <div class="form-group d-flex">
                            <label for="VS_temp" class="form-label h6 my-auto me-1">Temp<span class="text-danger" style="user-select: none;">*</span>:</label>
                            <div class="d-flex align-items-center">
                                <input type="number" class="{{ $patient->medicalRecord_admin && $patient->medicalRecord_admin->temp ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('VS_temp') is-invalid @enderror me-1" id="VS_temp" name="VS_temp" onKeyPress="if(this.value.length==4) return false;" step="0.01" min="0" lang="en" value="{{ $patient->medicalRecord_admin && $patient->medicalRecord_admin->temp ? $patient->medicalRecord_admin->temp : old('VS_temp') }}" style="margin-left: 1px; width:90%;" {{ $patient->medicalRecord_admin ? 'readonly' : 'required' }}>
                                <p class="pt-3" style="margin-left: 4px;">°C</p>
                                
                            </div>
                        </div>
                        <div class="form-group d-flex">
                            <label for="VS_o2saturation" class="form-label h6 my-auto me-1" style="white-space: nowrap;">O2 Saturation<span class="text-danger" style="user-select: none;">*</span>:</label>
                            <div class="d-flex align-items-center" style="margin-top:-1%;">
                                <input type="text" class="{{ $patient->medicalRecord_admin && $patient->medicalRecord_admin->o2saturation ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('VS_o2saturation') is-invalid @enderror me-1" id="VS_o2saturation" name="VS_o2saturation" value="{{ $patient->medicalRecord_admin && $patient->medicalRecord_admin->o2saturation ? $patient->medicalRecord_admin->o2saturation : old('VS_o2saturation') }}" style="width:90%;" {{ $patient->medicalRecord_admin ? 'readonly' : 'required' }}>
                                <p class="pt-3" style="margin-left: 4px;">%</p>
                            </div>
                        </div>      
                    </div> 
                    <!-- Col 2 (HEIGHT, WEIGHT, BMI) -->
                    <div class="col-xl-3 mx-4">
                        <div class="form-group d-flex">
                            <label for="VS_height" class="form-label h6 my-auto me-1">Height<span class="text-danger" style="user-select: none;">*</span>:</label>
                            <div class="d-flex align-items-center" style="margin-top:-1%;">
                                <input type="number" class="{{ $patient->medicalRecord_admin && $patient->medicalRecord_admin->height ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('VS_height') is-invalid @enderror me-1 ms-1" step="0.01" min="0" lang="en" id="VS_height" name="VS_height" value="{{ $patient->medicalRecord_admin && $patient->medicalRecord_admin->height ? $patient->medicalRecord_admin->height : old('VS_height') }}" onKeyPress="if(this.value.length==4) return false;" {{ $patient->medicalRecord_admin ? 'readonly' : 'required' }}>
                                <p class="pt-3" style="margin-left: 4px;">meters</p>
                            </div>
                        </div>  
                        <div class="form-group d-flex">
                            <label for="VS_weight" class="form-label h6 my-auto me-1">Weight<span class="text-danger" style="user-select: none;">*</span>:</label>
                            <div class="d-flex align-items-center" style="margin-top:-1%;">
                                <input type="number" class="{{ $patient->medicalRecord_admin && $patient->medicalRecord_admin->weight ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('VS_weight') is-invalid @enderror me-1" id="VS_weight" name="VS_weight" value="{{ $patient->medicalRecord_admin && $patient->medicalRecord_admin->weight ? $patient->medicalRecord_admin->weight : old('VS_weight') }}" onKeyPress="if(this.value.length==4) return false;" {{ $patient->medicalRecord_admin ? 'readonly' : 'required' }}>
                                <p class="pt-3" style="margin-left: 4px;">kg</p>
                            </div>
                        </div>  
                        <div class="form-group d-flex">
                            <label for="VS_bmi" class="form-label h6 my-auto me-1">BMI<span class="text-danger" style="user-select: none;">*</span>:&nbsp;</label>
                            <div class="d-flex align-items-center" style="margin-top:-1%;">
                                <input type="number" class="{{ $patient->medicalRecord_admin && $patient->medicalRecord_admin->bmi ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('VS_bmi') is-invalid @enderror me-1 ms-4" id="VS_bmi" name="VS_bmi" value="{{ $patient->medicalRecord_admin && $patient->medicalRecord_admin->bmi ? $patient->medicalRecord_admin->bmi : old('VS_bmi') }}" step="0.01" min="0" lang="en" onKeyPress="if(this.value.length==4) return false;" {{ $patient->medicalRecord_admin ? 'readonly' : 'required' }}>
                                <p class="pt-3" style="margin-left: 4px;">&nbsp;</p>
                                
                            </div>
                        </div>
                    </div>
                    <!-- Col 3 (FINDINGS) -->
                    <div class="col-xl-5">
                        <div class="form-group d-flex">
                            <label for="VS_xrayFindings" class="form-label h6 my-auto me-1" style="white-space: nowrap;">CHEST X-RAY FINDINGS<span class="text-danger" style="user-select: none;">*</span>:</label>
                            <div class="d-flex align-items-center" style="margin-top:-1%;">
                                <input type="text" class="{{ $patient->medicalRecord_admin && $patient->medicalRecord_admin->chestXrayFinding ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('VS_xrayFindings') is-invalid @enderror me-1" id="VS_xrayFindings" name="VS_xrayFindings" value="{{ $patient->medicalRecord_admin && $patient->medicalRecord_admin->chestXrayFinding ? $patient->medicalRecord_admin->chestXrayFinding : old('VS_xrayFindings') }}" style="width:310px;" {{ $patient->medicalRecord_admin ? 'readonly' : 'required' }}>
                                <p class="pt-3" style="margin-left: 4px;">&nbsp;</p>
                               
                            </div>
                        </div>                   
                        <div class="form-group d-flex">
                            <label for="VS_cbcResults" class="form-label h6 my-auto me-1" style="white-space: nowrap;">CBC Results<span class="text-danger" style="user-select: none;">*</span>:</label>
                            <div class="d-flex align-items-center" style="margin-top:-1%;">
                                <input type="text" class="{{ $patient->medicalRecord_admin && $patient->medicalRecord_admin->CBCResults ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('VS_cbcResults') is-invalid @enderror me-1" id="VS_cbcResults" name="VS_cbcResults" value="{{ $patient->medicalRecord_admin && $patient->medicalRecord_admin->CBCResults ? $patient->medicalRecord_admin->CBCResults : old('VS_cbcResults') }}" style="width:310px; margin-left: 86px;" {{ $patient->medicalRecord_admin ? 'readonly' : 'required' }}>
                                <p class="pt-3" style="margin-left: 4px;">&nbsp;</p>
                                
                            </div>
                        </div>               
                        <div class="form-group d-flex">
                            <label for="VS_hepaBscreening" class="form-label h6 my-auto me-1" style="white-space: nowrap;">Hepatitis B Screening<span class="text-danger" style="user-select: none;">*</span>:</label>
                            <div class="d-flex align-items-center" style="margin-top:-1%;">
                                <input type="text" class="{{ $patient->medicalRecord_admin && $patient->medicalRecord_admin->hepatitisBscreeningResults ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('VS_hepaBscreening') is-invalid @enderror me-1" id="VS_hepaBscreening" name="VS_hepaBscreening" value="{{ $patient->medicalRecord_admin && $patient->medicalRecord_admin->hepatitisBscreeningResults ? $patient->medicalRecord_admin->hepatitisBscreeningResults : old('VS_hepaBscreening') }}" style="margin-left: 12px; width:310px;" {{ $patient->medicalRecord_admin ? 'readonly' : 'required' }}>
                                <p class="pt-3" style="margin-left: 4px;">&nbsp;</p>
                                
                            </div>
                        </div>
                        <div class="form-group d-flex">
                            <label for="VS_bloodType" class="form-label h6 my-auto me-1" style="white-space: nowrap;">Blood Type<span class="text-danger" style="user-select: none;">*</span>:</label>
                            <div class="d-flex align-items-center" style="margin-top:-1%;">
                                <input type="text" class="{{ $patient->medicalRecord_admin && $patient->medicalRecord_admin->bloodtype ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('VS_bloodType') is-invalid @enderror me-1" id="VS_bloodType" name="VS_bloodType" value="{{ $patient->medicalRecord_admin && $patient->medicalRecord_admin->bloodtype ? $patient->medicalRecord_admin->bloodtype : old('VS_bloodType') }}" style="margin-left: 94px; width:310px;" {{ $patient->medicalRecord_admin ? 'readonly' : 'required' }}>
                                <p class="pt-3" style="margin-left: 4px;">&nbsp;</p>
                                
                            </div>
                        </div>
                    </div>
                </div>
                    <span class="text-danger"> 
                        @error('VS_bp_systolic') 
                            {{ $message }}
                            <br/>
                        @enderror
                    </span>
                    <span class="text-danger"> 
                        @error('VS_bp_diastolic') 
                            {{ $message }}
                            <br/>
                        @enderror
                    </span>
                    <span class="text-danger"> 
                        @error('VS_pulseRate') 
                            {{ $message }}
                            <br/>
                        @enderror
                    </span>
                    <span class="text-danger"> 
                        @error('VS_respirationRate') 
                            {{ $message }} 
                        @enderror
                    </span>
                    <span class="text-danger"> 
                        @error('VS_temp') 
                            {{ $message }}
                            <br/>
                        @enderror
                    </span>
                    <span class="text-danger"> 
                        @error('VS_o2saturation') 
                            {{ $message }} 
                        @enderror
                    </span>
                    <span class="text-danger"> 
                        @error('VS_height') 
                            {{ $message }}
                            <br/>
                        @enderror
                    </span>
                    <span class="text-danger"> 
                        @error('VS_weight') 
                            {{ $message }} 
                         @enderror
                    </span>
                    <span class="text-danger">
                        @error('VS_bmi')
                            {{ $message }}
                        @enderror
                    </span>
                    <span class="text-danger"> 
                        @error('VS_xrayFindings') 
                            {{ $message }}
                            <br/>
                        @enderror
                    </span>
                    <span class="text-danger"> 
                        @error('VS_cbcResults') 
                            {{ $message }}
                            <br/>
                        @enderror
                    </span>
                    <span class="text-danger"> 
                        @error('VS_hepaBscreening') 
                            {{ $message }}
                            <br/>
                        @enderror
                    </span>
                    <span class="text-danger"> 
                        @error('VS_bloodType') 
                            {{ $message }}
                            <br/>
                        @enderror
                    </span>
            </div>
        </div>
        <!-- Recommendation -->
        <div class="pt-3 border border-top-0 border-bottom-1 border-dark pb-3">
            <h5 class="fw-bold">Recommendations<span class="text-danger" style="user-select: none;">*</span></h5>
            <textarea class="form-control {{ $patient->medicalRecord_admin && $patient->medicalRecord_admin->recommendations ? 'mb-0 pb-0 fs-5 fw-bold' : '' }} @error('MRA_recommendations') is-invalid @enderror" id="MRA_recommendations" name="MRA_recommendations" style="resize: none; overflow: hidden;" required {{ $patient->medicalRecord_admin && $patient->medicalRecord_admin->recommendations ? 'readonly' : '' }}>{{ $patient->medicalRecord_admin && $patient->medicalRecord_admin->recommendations ? $patient->medicalRecord_admin->recommendations : old('MRA_recommendations') }}</textarea>
            <span class="text-danger"> 
                @error('MRA_recommendations') 
                    {{ $message }}
                    <br/>
                @enderror
            </span>
                <script>
                    var textarea = document.getElementById('MRA_recommendations');

                    textarea.addEventListener('input', function() {
                        this.style.height = 'auto';
                        this.style.height = this.scrollHeight + 'px';
                    });
                </script>
            <input type="hidden" name="mrp_id" value="{{ $patient->medicalRecordPersonnel->MRP_id }}">
            <input type="hidden" name="personnel_id" value="{{ $patient->id }}">
        </div>
    </div>
    <div class="row no-gutters justify-content-end pt-3 position-relative">
        <div class="col d-flex justify-content-end" style="margin-right:-1  %;">
            <button type="submit" class="btn btn-lg btn-primary btn-login fw-bold mb-2" style="{{ $patient->medicalRecordPersonnel ? 'display:none;' : '' }}">
                Submit
            </button>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Select height and weight input fields and BMI output field
            var heightInput = $('#VS_height');
            var weightInput = $('#VS_weight');
            var bmiOutput = $('#VS_bmi');

            // Attach event listener to height and weight input
            heightInput.on('input', calculateBMI);
            weightInput.on('input', calculateBMI);

            // Define function to calculate the BMI
            function calculateBMI() {
                // Get values from the height and weight input
                var height = parseFloat(heightInput.val());
                var weight = parseInt(weightInput.val());

                // Calculate BMI
                var bmi = weight / (height * height);

                // Round BMI to 2 decimal places
                bmi = bmi.toFixed(2);

                // Update BMI output field with the calculated value
                bmiOutput.val(bmi);
            }
        });

        (() => {
            'use strict'

            // Fetch all forms to apply validation styles to
            const forms = document.querySelectorAll('.needs-validation')

            // Loop and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()

                    // Get all the invalid input fields
                    const invalidInputs = form.querySelectorAll(':invalid')

                    // Focus on the first invalid input field
                    invalidInputs[0].focus()
                }

                form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</form>
@endsection