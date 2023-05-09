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
    /*@media print {
        body {
             font-size: 12pt;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12 {
                float: left;
        }
        .col-md-12 {
                width: 100%;
        }
        .col-md-11 {
                width: 91.66666667%;
        }
        .col-md-10 {
                width: 83.33333333%;
        }
        .col-md-9 {
                width: 75%;
        }
        .col-md-8 {
                width: 66.66666667%;
        }
        .col-md-7 {
                width: 58.33333333%;
        }
        .col-md-6 {
                width: 50%;
        }
        .col-md-5 {
                width: 41.66666667%;
        }
        .col-md-4 {
                width: 33.33333333%;
        }
        .col-md-3 {
                width: 25%;
        }
        .col-md-2 {
                width: 16.66666667%;
        }
        .col-md-1 {
                width: 8.33333333%;
        }
    }*/
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
    input.form-control-plaintext{
        border: 0;
        box-shadow: none;
        outline: 0 !important;
    }

</style>
<!-- Header -->
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@php
    $ticket_id = request()->query('ticket_id');

    $released = 1;
    if($patient->hasValidatedRecord && $patient->medicalRecordAdmin->released === 0){
        $released = 0;
    }
@endphp
<script>
    const releasedValue = '<?php echo $released;?>';
    const released = parseInt(releasedValue);

    if(released === 0){
        console.log(released);
        $(document).ready(function(){
              $('#successModal').modal("show");
          });
    }

</script>

<div class="modal fade" id="successModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title fw-bold">BU-Care</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center">
            <div class="alert alert-info fade show d-flex align-items-center justify-content-center" style="height:70px;" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
              <div class="text-center mt-3">
                <p class="alert-heading fs-5 p-2">This health record form is already complete but medical certificate is not yet released.</p>
              </div>
            </div>
            <p class="fs-4 p-2 fw-bold text-black"> Release medical certificate?</p>
            <div class="modal-footer">
                @if($patient->hasValidatedRecord && $ticket_id)
                    <button type="button" class="btn btn-primary" onclick="submitmedcertAppointmentReleaseForm()">Yes</button>
                @elseif($patient->hasValidatedRecord)
                    <button type="button" class="btn btn-primary" onclick="submitMedcertReleaseForm()">Yes</button>
                @endif
              </div>
          </div>
      </div>
    </div>
</div>
<script>
    function submitmedcertAppointmentReleaseForm(){
        $('#medcertAppointmentRelease').submit();
    }
    function submitMedcertReleaseForm(){
        $('#medcertRelease').submit();
    }
</script>
@if($patient->hasValidatedRecord && $ticket_id)
    <form method="POST" action="{{ route('appointments.medcert.release') }}" enctype="multipart/form-data" id="medcertAppointmentRelease" class="d-print-none">
        @csrf
        <input type="hidden" name="patientID" value="{{ $patient->id }}">
        <input type="hidden" name="MRA_id" value="{{ $patient->medicalRecordAdmin->MRA_id }}">
        <input type="hidden" name="ticketID" value="{{ $ticket_id }}">
    </form>
@elseif($patient->hasValidatedRecord)
    <form method="POST" action="{{ route('medcert.release') }}" enctype="multipart/form-data" id="medcertRelease" class="d-print-none">
        @csrf
        <input type="hidden" name="patientID" value="{{ $patient->id }}">
        <input type="hidden" name="MRA_id" value="{{ $patient->medicalRecordAdmin->MRA_id }}">
    </form>
@endif

<div class="container position-relative my-2 bg-light w-20 text-dark pt-5 px-3 headMargin checkboxes d-print-inline-block">
    @if($patient->hasValidatedRecord)
          <!-- HAS VALIDATED MEDICAL RECORD -->
          <i class="bi bi-person-check icon position-absolute top-0 end-0 fs-2 d-print-none" style="color:#f1731f;" data-toggle="tooltip" data-container="body" data-bs-placement="top" title="Validated Medical Record"></i>
        @else
          <!-- HAS MEDICAL RECORD BUT NOT VALIDATED -->
          <i class="bi bi-file-earmark-medical icon position-absolute top-0 end-0 fs-2 d-print-none" style="color:#f1731f;" data-toggle="tooltip" data-container="body" data-bs-placement="top" title="Medical Record not Validated"></i>
    @endif
<form method="POST" action="{{ route('medicalFormAdmin.store') }}" enctype="multipart/form-data" id="MR_form" class="d-print-inline-flex row g-3 pt-5 mx-2 d-print-inline-block needs-validation" novalidate>
    @csrf
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

    @php
    if(isset($fromAppointment) && $fromAppointment === 1){
        echo '<input type="hidden" name="fromAppointment" value="'.$fromAppointment.'">';
        echo '<input type="hidden" name="ticketID" value="'. $ticketID .'">';
    }
    @endphp

    <div class="container d-print-inline-block">
        <input type="hidden" class="form-control" id="studentID" name="studentID" value="{{ $patient->id }}">
        <input type="hidden" class="form-control" id="medRecID" name="medRecID" value="{{ $patient->MR_id }}">
            <div class="row justify-content-end">
                <div class="col-xl-4 col-lg-6 col-md-12 d-flex" style="text-align: justify;">
                    <p class="h6">Course:&nbsp;</p>
                    <div class="col-xl-9 col-lg-6">
                        <p class="h6 text-decoration-underline text-break">{{ $patient->medicalRecord->course }}</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-end">
                <div class="col-xl-4 col-lg-6 col-md-12 d-flex">
                    <p class="h6">School Year:&nbsp;</p>
                    <div class="col-xl-8 col-lg-6 border-bottom border-dark" style="height:60%;">
                        <p class="h6">{{ $patient->medicalRecord->SYstart }}-{{ $patient->medicalRecord->SYend }}</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-end">
                <div class="col-xl-4 col-lg-6 col-md-12 d-flex">
                    <p class="h6">Campus:&nbsp;</p>
                    <div class="col-xl-8 col-lg-6 border-bottom border-dark" style="height:59%; width: 72.75%;">
                        <p class="h6">{{ $patient->medicalRecord->campus }}</p>
                    </div>
                </div>
            </div>


            @php
                $date = $patient->medicalRecord->dateOfBirth;
                $formatted_dateOfBirth = date("Y F d", strtotime($date));
            @endphp
        
    </div>   
    <div class="d-flex flex-row d-print-inline-block">
    </div>

    <!-- PRINTABLE -->
    <div class="row d-flex d-print-inline-block d-none d-print-block">
        <div class="col-md-1 mt-5 d-flex align-items-center justify-content-center d-print-inline-block">
            <p class="h5">Name</p>
        </div>
        <div class="col-md-9 text-bottom" style="">
            <p class="form-label h6 p-0" style="margin-top: 0.3%; user-select:none;">&nbsp;</p>
            <div class="row justify-content-around text-center border-bottom border-dark pb-0" style="margin-top: -50px;">
                <div class="col-4 pb-0 mb-0">
                    <input type="text" class="form-control-plaintext text-center mb-0 pb-0 fs-5 fw-bold" id="last_name" name="last_name" value="{{ $patient->medicalRecord->last_name }}" readonly>
                </div>
                <div class="col-5">
                    <input type="text" class="form-control-plaintext text-center mb-0 pb-0 fs-5 fw-bold" id="first_name" name="first_name" value="{{ $patient->medicalRecord->first_name }}" readonly>
                </div>
                <div class="col-3">
                    <input type="text" class="form-control-plaintext text-center mb-0 pb-0 fs-5 fw-bold" id="middle_name" name="middle_name" value="{{ $patient->medicalRecord->middle_name }}" readonly>
                </div>
            </div>
            <div class="row justify-content-around text-center">
                <div class="col-4">
                    <p class="fst-italic fs-6 text-secondary" style="user-select: none;">(LAST)</p>
                </div>
                <div class="col-5">
                    <p class="fst-italic fs-6 text-secondary" style="user-select: none;">(FIRST)</p>
                </div>
                <div class="col-3">
                    <p class="fst-italic fs-6 text-secondary" style="user-select: none;">(MIDDLE)</p>
                </div>
            </div>
        </div>
        <div class="col-1">
            <label for="pr_age" class="form-label h6">Age</label>
            <input type="text" class="form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold" id="pr_age" name="pr_age" value="" readonly>
        </div>
        <div class="col-1">
            <label for="MR_sex" class="form-label h6">Sex</label>
            <input type="text" class="form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold" id="MR_sex" name="MR_sex" value="{{ $patient->medicalRecord->sex }}" readonly>
        </div>
        <script>
            $(document).ready(function() {
                var birthDate = new Date("<?php echo $date; ?>");
                var age = Math.floor((new Date() - birthDate) / (365.25 * 24 * 60 * 60 * 1000));
                $('#pr_age').val(age);
            });
        </script>
    </div>
    <!-- END OF PRINTABLE -->

    <div class="row justify-content-end pb-0 mb-0 d-print-inline-block d-print-none">
        <div class="col-md-1 d-flex align-items-center justify-content-center d-print-inline-block">
            <p class="h5 text-center text-bottom m-0 p-0">Name</p>
        </div>
        <div class="col-md-9 text-bottom d-print-inline-block">
            <p class="form-label h6 p-0" style="position:static; margin-top: 0.3%; user-select:none;">&nbsp;</p>
            <div class="row justify-content-around text-center border-bottom border-dark mb-0 pb-0">
                <div class="col-4 pb-0 mb-0 text-bottom">
                    <input type="text" class="form-control-plaintext text-center mb-0 pb-0 fs-5 fw-bold" id="last_name" name="last_name" value="{{ $patient->medicalRecord->last_name }}" readonly>
                </div>
                <div class="col-5">
                    <input type="text" class="form-control-plaintext text-center mb-0 pb-0 fs-5 fw-bold" id="first_name" name="first_name" value="{{ $patient->medicalRecord->first_name }}" readonly>
                </div>
                <div class="col-3">
                    <input type="text" class="form-control-plaintext text-center mb-0 pb-0 fs-5 fw-bold" id="middle_name" name="middle_name" value="{{ $patient->medicalRecord->middle_name }}" readonly>
                </div>
            </div>
            <div class="row justify-content-around text-center">
                <div class="col-4">
                    <p class="fst-italic fs-6 text-secondary" style="user-select: none;">(LAST)</p>
                </div>
                <div class="col-5">
                    <p class="fst-italic fs-6 text-secondary" style="user-select: none;">(FIRST)</p>
                </div>
                <div class="col-3">
                    <p class="fst-italic fs-6 text-secondary" style="user-select: none;">(MIDDLE)</p>
                </div>
            </div>
        </div>
        <div class="col-md-1">
            <label for="age" class="form-label h6">Age</label>
            <input type="text" class="form-control-plaintext border-bottom border-dark fs-5 fw-bold" id="age" name="age" value="" readonly>
        </div>
        <script>
            $(document).ready(function() {
                var birthDate = new Date("<?php echo $date; ?>");
                var age = Math.floor((new Date() - birthDate) / (365.25 * 24 * 60 * 60 * 1000));
                $('#age').val(age);
            });
        </script>
        <div class="col-md-1">
            <label for="MR_sex" class="form-label h6">Sex</label>
            <input type="text" class="form-control-plaintext border-bottom border-dark fs-5 fw-bold" id="MR_sex" name="MR_sex" value="{{ $patient->medicalRecord->sex }}" readonly>
        </div>
    </div>
        <div class="col-md-4">
            <label for="MR_dateOfBirth" class="form-label h6">Date of Birth</label>
            <input type="text" class="form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold" id="MR_dateOfBirth" name="MR_dateOfBirth" value="{{ $formatted_dateOfBirth }}" readonly>
        </div>
        <div class="col-md-2">
            <label for="MR_civilStatus" class="form-label h6">Civil Status</label>
            <input type="text" class="form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold" id="MR_civilStatus" name="MR_civilStatus" value="{{ $patient->medicalRecord->civilStatus }}" readonly>
        </div>
        <div class="col-md-4">
            <label for="MR_nationality" class="form-label h6">Nationality</label>
            <input type="text" class="form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold" id="MR_nationality" name="MR_nationality" value="{{ $patient->medicalRecord->nationality }}" readonly>
            </div>
        <div class="col-md-2">
            <label for="MR_religion" class="form-label h6">Religion</label>
            <input type="text" class="form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold" id="MR_religion" name="MR_religion" value="{{ $patient->medicalRecord->religion }}" readonly>
            </div>
        <div class="col-md-12">
            <label for="MR_address" class="form-label h6">Home Address</label>
            <input type="text" class="form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold" id="MR_address" name="MR_address" value="{{ $patient->medicalRecord->region }}, {{ $patient->medicalRecord->province }}, {{ $patient->medicalRecord->cityMunicipality }}, {{ $patient->medicalRecord->barangaySubdVillage }}, {{ $patient->medicalRecord->houseNumberStName }}" readonly>
            </div>
        <div class="col-md-6">
            <label for="MR_fatherName" class="form-label h6">Father's Name</label>
            <input type="text" class="form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold" id="MR_fatherName" name="MR_fatherName" value="{{ $patient->medicalRecord->fatherName }}" readonly>
            </div>
        <div class="col-md-6">
            <label for="MR_motherName" class="form-label h6">Mother's Name</label>
            <input type="text" class="form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold" id="MR_motherName" name="MR_motherName" value="{{ $patient->medicalRecord->motherName }}" readonly>
            </div>
        <div class="col-md-6">
            <label for="MR_fatherOccupation" class="form-label h6">Father's Occupation</label>
            <input type="text" class="form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold" id="MR_fatherOccupation" name="MR_fatherOccupation" value="{{ $patient->medicalRecord->fatherOccupation }}" readonly>
            </div>
        <div class="col-md-6">
            <label for="MR_motherOccupation" class="form-label h6">Mother's Occupation</label>
            <input type="text" class="form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold" id="MR_motherOccupation" name="MR_motherOccupation" value="{{ $patient->medicalRecord->motherOccupation }}" readonly>
            </div>
        <div class="col-md-6">
            <label for="MR_fatherOffice" class="form-label h6">Office Address of Father</label>
            <input type="text" class="form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold" id="MR_fatherOffice" name="MR_fatherOffice" value="{{ htmlspecialchars_decode( $patient->medicalRecord->f_region)}}, {{ htmlspecialchars_decode($patient->medicalRecord->f_province )}}, {{ htmlspecialchars_decode($patient->medicalRecord->f_cityMunicipality)}}, {{ htmlspecialchars_decode($patient->medicalRecord->f_barangaySubdVillage)}}, {{ htmlspecialchars_decode($patient->medicalRecord->f_houseNumberStName) }}" readonly>
            </div>
        <div class="col-md-6">
            <label for="MR_motherOffice" class="form-label h6">Office Address of Mother</label>
            <input type="text" class="form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold" id="MR_motherOffice" name="MR_motherOffice" value="{{ htmlspecialchars_decode( $patient->medicalRecord->m_region)}}, {{ htmlspecialchars_decode($patient->medicalRecord->m_province )}}, {{ htmlspecialchars_decode($patient->medicalRecord->m_cityMunicipality)}}, {{ htmlspecialchars_decode($patient->medicalRecord->m_barangaySubdVillage)}}, {{ htmlspecialchars_decode($patient->medicalRecord->m_houseNumberStName) }}" readonly>
            </div>
        <div class="col-md-6">
            <label for="MR_guardian" class="form-label h6">Guardian's Name</label>
            <input type="text" class="form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold" id="MR_guardian" name="MR_guardianName" value="{{ $patient->medicalRecord->m_guardianName }}" readonly>
        </div>
        <div class="col-md-6">
            <label for="MR_parentGuardianContactNumber" class="form-label h6">Parent's/Guardian's Contact No.</label>
            <input type="text" class="form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold" id="MR_parentGuardianContactNumber" name="MR_parentGuardianContactNumber" value="0{{ $patient->medicalRecord->parentGuardianContactNumber }}" readonly>
            </div>
        <div class="col-md-6">
            <label for="MR_guardianAddress" class="form-label h6">Guardian's Address</label>
            <input type="text" class="form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold" id="MR_guardianAddress" name="MR_guardianAddress" value="@if($patient->medicalRecord->g_region) {{ htmlspecialchars_decode($patient->medicalRecord->g_region)}}, {{ htmlspecialchars_decode($patient->medicalRecord->g_province )}}, {{ htmlspecialchars_decode($patient->medicalRecord->g_cityMunicipality)}}, {{ htmlspecialchars_decode($patient->medicalRecord->g_barangaySubdVillage)}}, {{ htmlspecialchars_decode($patient->medicalRecord->g_houseNumberStName) }} @endif" readonly>
        </div>
        <div class="col-md-6">
            <label for="MR_studentContactNumber" class="form-label h6">Student's Contact No.</label>
            <input type="text" class="form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold" id="MR_studentContactNumber" name="MR_studentContactNumber" value="0{{ $patient->medicalRecord->studentContactNumber }}" readonly>
            </div>
            <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
            <header class="text-center">
                <!-- LINE BREAK -->
            </header>
        </section>
        <div class="col-md-6">
            <p class="h6 me-2">In case of emergency, contact:</p>
            <input type="text" class="form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold" id="MR_emergencyContactName" value="{{ $patient->medicalRecord->emergencyContactName }}" name="MR_emergencyContactName" readonly>
        </div>
        <div class="col-md-6">
            <label for="MR_emergencyContactOccupation" class="form-label h6">Occupation</label>
            <input type="text" class="form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold" id="MR_emergencyContactOccupation" value="{{ $patient->medicalRecord->emergencyContactOccupation }}" name="MR_emergencyContactOccupation" readonly>
        </div>
        <div class="col-md-6">
            <label for="MR_emergencyContactRelationship" class="form-label h6">Relationship</label>
            <input type="text" class="form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold" id="MR_emergencyContactRelationship" value="{{ $patient->medicalRecord->emergencyContactRelationship }}" name="MR_emergencyContactRelationship" readonly>
        </div>
        <div class="col-md-6">
            <label for="MR_emergencyContactNumber" class="form-label h6">Contact Number</label>
            <input type="text" class="form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold" id="MR_emergencyContactNumber" value="0{{ $patient->medicalRecord->emergencyContactNumber }}" name="MR_emergencyContactNumber" readonly>
        </div>
        <div class="col-md-12">
            <label for="MR_emergencyContactAddress" class="form-label h6">Address</label>
            <input type="text" class="form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold" id="MR_emergencyContactAddress" value="{{ htmlspecialchars_decode( $patient->medicalRecord->ec_region)}}, {{ htmlspecialchars_decode($patient->medicalRecord->ec_province )}}, {{ htmlspecialchars_decode($patient->medicalRecord->ec_cityMunicipality)}}, {{ htmlspecialchars_decode($patient->medicalRecord->ec_barangaySubdVillage)}}, {{ htmlspecialchars_decode($patient->medicalRecord->ec_houseNumberStName) }}" name="MR_emergencyContactAddress" readonly>
        </div>
        
        
        <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
            <header class="text-center">
                <!-- LINE BREAK -->
            </header>
        </section>

        
        <!-- PRINTABLE -->
        <div class="row d-flex d-print-inline-block d-none d-print-block" style="margin-bottom: 600px;">
            <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
                <header class="text-center">
                    <!-- LINE BREAK -->
                </header>
            </section>
        </div>
        <!-- END OF PRINTABLE -->

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
                            <input type="hidden" name="FH_tuberculosis" value="others">
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
                            <input type="text" class="form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold input-sm" id="FH_othersDetails" name="FH_othersDetails" value="{{ $patient->medicalRecord->familyHistory->othersDetails }}" {{ $patient->medicalRecord->familyHistory->othersDetails == 'N/A' ? 'disabled' : 'readonly' }}>  
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
                            <div class="d-flex align-items-center">
                                ( <input type="text" class="col-md-2 mb-2 text-center form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold" style="width: 10%;" id="PSH_smoking_amount" name="PSH_smoking_amount" value="{{ $patient->medicalRecord->personalSocialHistory->sticksPerDay }}" {{ $patient->medicalRecord->personalSocialHistory->sticksPerDay == 0 ? 'disabled' : 'readonly' }}> 
                                sticks/day for 
                                <input type="text" class="col-md-2 mb-2 text-center form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold" style="width: 10%;"   id="PSH_smoking_freq" name="PSH_smoking_freq" value="{{ $patient->medicalRecord->personalSocialHistory->years }}" {{ $patient->medicalRecord->personalSocialHistory->years == 0 ? 'disabled' : 'readonly' }}> 
                                year/s ) 
                            </div>
                        </label>
                </div><!-- END OF SMOKING FORM DIV -->

                <div class="form-check" style="margin-top:5%;">
                    <input class="form-check-input" type="checkbox" id="PSH_drinking" name="PSH_drinking" {{ $patient->medicalRecord->personalSocialHistory->drinking == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                        <label class="form-check-label" for="PSH_drinking" style="display: contents!important;">
                            Drinking 
                            <br>
                            <div class="d-flex align-items-center">
                                ( <input type="text" class="col-md-4 mb-2 text-center form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold" style="width: 20%;" id="PSH_drinking_amountOfBeer" name="PSH_drinking_amountOfBeer" value="{{ $patient->medicalRecord->personalSocialHistory->numberOfBeers }}" {{ $patient->medicalRecord->personalSocialHistory->numberOfBeers == 'N/A' ? 'disabled' : 'readonly' }}> 
                                Beer per 
                                <input type="text" class="col-md-4 mb-2 text-center form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold" style="width: 20%;" id="PSH_drinking_freqOfBeer" name="PSH_drinking_freqOfBeer" value="{{ $patient->medicalRecord->personalSocialHistory->beerFrequency }}" {{ $patient->medicalRecord->personalSocialHistory->beerFrequency == 'N/A' ? 'disabled' : 'readonly' }}> ) 
                                <br>
                            </div>
                                or
                            <br>
                            <div class="d-flex">
                                ( <input type="text" class="col-md-4 text-center form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold" style="width: 20%;" id="PSH_drinking_amountofShots" name="PSH_drinking_amountofShots" value="{{ $patient->medicalRecord->personalSocialHistory->numberOfShots }}" {{ $patient->medicalRecord->personalSocialHistory->numberOfShots == 'N/A' ? 'disabled' : 'readonly' }}>
                                Shots per 
                                <input type="text" class="col-md-4 text-center form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold" style="width: 20%;" id="PSH_drinking_freqOfShots" name="PSH_drinking_freqOfShots" value="{{ $patient->medicalRecord->personalSocialHistory->shotsFrequency }}" {{ $patient->medicalRecord->personalSocialHistory->shotsFrequency == 'N/A' ? 'disabled' : 'readonly' }}> 
                                )
                            </div>
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
                                        <input type="text" class="form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold input-sm" id="PI_othersDetails" name="PI_othersDetails" value="{{ $patient->medicalRecord->presentIllness->othersDetails }}" {{ $patient->medicalRecord->presentIllness->othersDetails == 'N/A' ? 'disabled' : 'readonly' }}>  
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
                        <div class="form-check form-switch">
                            <input class="form-check-input border-dark @error('hospitalization') is-invalid @enderror" type="checkbox" role="switch" name="hospitalization" id="hospitalization" value="1" {{ $patient->medicalRecord->hospitalization == '1' ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                            <label class="form-check-label fw-bold" for="hospitalization">
                                Do you have history of hospitalization for serious illness, operation, fracture or injury?
                            </label>
                        </div><!-- END OF YES DIV -->
                        <input type="text" class="form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold input-sm" id="hospitalizationDetails" name="hospitalizationDetails" value="{{ $patient->medicalRecord->hospDetails }}" {{ $patient->medicalRecord->hospDetails == 'N/A' ? 'disabled' : 'readonly' }}>
                    </div><!-- END OF COL DIV -->
                </div><!-- END OF ROW DIV -->

                <!-- REGULAR MEDICINES -->
                <div class="d-flex flex-row pt-2">
                    <div class="col-sm">
                        <div class="form-check form-switch">
                            <input class="form-check-input border-dark @error('regMeds') is-invalid @enderror" type="checkbox" role="switch" name="regMeds" id="regMeds" value="1" {{ old('takingMedsRegularly') == '1' ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                            <label class="form-check-label fw-bold" for="regMeds">
                                    Are you taking any medicine regularly?
                            </label>
                        </div><!-- END OF YES DIV -->
                        <input type="text" class="form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold input-sm" id="regMedsDetails" name="regMedsDetails" value="{{ $patient->medicalRecord->medsDetails }}" {{ $patient->medicalRecord->medsDetails == 'N/A' ? 'disabled' : 'readonly' }}>
                       </div><!-- END OF COL DIV -->
                   </div><!-- END OF ROW DIV -->

                   <!-- ALLERGIES -->
                   <div class="col-sm">
                    <div class="form-check form-switch">
                        <input class="form-check-input border-dark @error('allergy') is-invalid @enderror" type="checkbox" role="switch" name="allergy" id="allergy" value="1" {{ old('allergic') == '1' || $patient->medicalRecord->allergic ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                        <label class="form-check-label fw-bold" for="allergy">
                                Are you allergic to any food or medicine?
                        </label>
                    </div><!-- END OF YES DIV -->     
                    <input type="text" class="form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold input-sm" id="allergyDetails" name="allergyDetails" value="{{ $patient->medicalRecord->allergyDetails }}" {{ $patient->medicalRecord->allergyDetails == 'N/A' ? 'disabled' : 'readonly' }}>
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
                </div>
                    <!-- NEW LINE -->
                    <div class="form-row mx-5 align-items-center">
                        <div class="col p-2">
                            <input class="form-check-input" type="checkbox" id="IH_others" name="IH_others" {{ $patient->medicalRecord->immunizationHistory->others == 1 ? 'checked' : '' }} onclick="this.checked=!this.checked;"/>
                            <label class="form-check-label" for="IH_others">
                                Others
                            </label>
                            <input type="text" class="form-control-plaintext border-bottom border-dark mb-0 pb-0 fs-5 fw-bold input-sm" id="IH_othersDetails" name="IH_othersDetails" value="{{ $patient->medicalRecord->immunizationHistory->othersDetails }}" {{ $patient->medicalRecord->immunizationHistory->othersDetails == 'N/A' ? 'disabled' : 'readonly' }}>
                        </div><!-- END OF OTHERS COL DIV -->
                    </div><!-- END OF OTHERS ROW DIV -->
            </div>
        </div>
        <!-- PRINTABLE -->
        <div class="row d-flex d-print-inline-block d-none d-print-block" style="margin-bottom: 300px;">
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
                    <div class="mb-3 col-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="MR_studentSignature" class="form-label fw-bold">Chest X-Ray Findings</label>
                        <a href="{{ asset('storage/'.$patient->medicalRecord->chestXray) }}" data-lightbox="Chest X-Ray Findings" data-title="Chest X-Ray Findings">
                            <div class="mb-3 col-6 signature-container d-flex justify-content-center align-items-center divForResults border border-dark rounded-1">
                                <img class="img-fluid" src="{{ asset('storage/'.$patient->medicalRecord->chestXray) }}" alt="Chest X-Ray Findings" style="">
                            </div>
                        </a>
                    </div>
                    <!-- PRINTABLE -->
        <div class="row d-flex d-print-inline-block d-none d-print-block" style="margin-bottom: 50px;">
            <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
                <header class="text-center">
                    <!-- LINE BREAK -->
                </header>
            </section>
        </div>
        <!-- END OF PRINTABLE -->
                    <div class="mb-3 col-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="MR_parentGuardianSignature" class="form-label fw-bold">CBC Results</label>
                            <a href="{{ asset('storage/'.$patient->medicalRecord->CBCResults) }}" data-lightbox="CBC Results" data-title="CBC Results">
                                <div class="mb-3 col-6 signature-container d-flex justify-content-center align-items-center divForResults border border-dark rounded-1">  
                                    <img class="img-fluid" src="{{ asset('storage/'.$patient->medicalRecord->CBCResults) }}" alt="CBC Results">
                                </div>
                            </a>
                      </div>
                      <!-- PRINTABLE -->
        <div class="row d-flex d-print-inline-block d-none d-print-block" style="margin-bottom: 380px;">
            <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
                <header class="text-center">
                    <!-- LINE BREAK -->
                </header>
            </section>
        </div>
        <!-- END OF PRINTABLE -->
                    <div class="mb-3 col-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="MR_parentGuardianSignature" class="form-label fw-bold">Hepatitis B Screening</label>
                        <a href="{{ asset('storage/'.$patient->medicalRecord->hepaBscreening) }}" data-lightbox="Hepatitis B Screening" data-title="Hepatitis B Screening">
                            <div class="mb-3 col-6 signature-container d-flex justify-content-center align-items-center divForResults border border-dark rounded-1">
                                <img class="img-fluid" src="{{ asset('storage/'.$patient->medicalRecord->hepaBscreening) }}" alt="Hepatitis B Screening">
                            </div>
                        </a>
                    </div> 
                    <!-- PRINTABLE -->
        <div class="row d-flex d-print-inline-block d-none d-print-block" style="margin-bottom: 50px;">
            <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
                <header class="text-center">
                    <!-- LINE BREAK -->
                </header>
            </section>
        </div>
        <!-- END OF PRINTABLE -->
                    <div class="mb-3 col-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="MR_parentGuardianSignature" class="form-label fw-bold">Blood Type</label>
                        <a href="{{ asset('storage/'.$patient->medicalRecord->bloodType) }}" data-lightbox="Blood Type" data-title="Blood Type">
                            <div class="mb-3 col-6 signature-container d-flex justify-content-center align-items-center divForResults border border-dark rounded-1">
                                <img class="img-fluid" src="{{ asset('storage/'.$patient->medicalRecord->bloodType) }}" alt="Blood Type">
                            </div>
                        </a>
                    </div>
                    @php
                        for($i=1; $patient->medicalRecord->{'resultName' . $i} != NULL; $i++){
                            echo    '<div class="mb-3 col-3 d-flex flex-column justify-content-center align-items-center">';
                            echo        '<label for="MR_parentGuardianSignature" class="form-label fw-bold">'. $patient->medicalRecord->{'resultName' . $i} .'</label>';
                            echo        '<a href="' . asset("storage/" .$patient->medicalRecord->{'resultImage' . $i}) . '" data-lightbox="'. $patient->medicalRecord->{'resultName' . $i} .'" data-title="'. $patient->medicalRecord->{'resultName' . $i} .'">';
                            echo            '<div class="mb-3 col-6 signature-container d-flex justify-content-center align-items-center divForResults border border-dark rounded-1">';
                            echo                '<img class="img-fluid" src="' . asset("storage/" .$patient->medicalRecord->{'resultImage' . $i}) . '" alt="'. $patient->medicalRecord->{'resultName' . $i} .'">';
                            echo            '</div>';
                            echo        '</a>';
                            echo    '</div>';
                        }
                    @endphp
                </div>
            </div>
        </div>
    </div>
        <!--Signatures-->
        <div class="mx-auto row row-cols-lg-1 mt-2">
            <div class="form-check d-flex border border-dark align-items-center text-center justify-content-center">
                <input class="form-check-input my-5 me-1" type="radio" {{ $patient->medicalRecord->signed == 1 ? 'checked' : '' }} onclick="return false;" name="certify">
                <label class="form-check-label fs-5 fst-italic text-center" for="certify">
                    I hereby certify that the foregoing answers are true and complete, and to the best of my knowledge.
                </label>
            </div>
        </div>

        <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
            <header class="text-center">
                <!-- LINE BREAK -->
            </header>
        </section>
        <!-- PRINTABLE -->
        <div class="row d-flex d-print-inline-block d-none d-print-block" style="margin-bottom: 270px;">
            <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
                <header class="text-center">
                    <!-- LINE BREAK -->
                </header>
            </section>
        </div>
        <!-- END OF PRINTABLE -->
        
        
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
                                <input type="number" step="1" min="0" class="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->bp_systolic ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('VS_bp_systolic') is-invalid @enderror me-1" id="VS_bp_systolic" name="VS_bp_systolic" value="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->bp_systolic ? $patient->medicalRecordAdmin->bp_systolic : old('VS_bp_systolic') }}" onKeyPress="if(this.value.length==3) return false;" style="width:31.7%;" {{ $patient->medicalRecordAdmin ? 'readonly' : 'required' }}>
                                <span class="fs-6">/</span>
                                <input type="number" class="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->bp_diastolic ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('VS_bp_diastolic') is-invalid @enderror ms-2" id="VS_bp_diastolic" name="VS_bp_diastolic" value="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->bp_diastolic ? $patient->medicalRecordAdmin->bp_diastolic : old('VS_bp_diastolic') }}" onKeyPress="if(this.value.length==3) return false;" style="width:31.7%;" {{ $patient->medicalRecordAdmin ? 'readonly' : 'required' }}> 
                                <p class="pt-3" style="margin-left: 4px;">mmHg</p>
                            </div>
                        </div>                   
                        <div class="form-group d-flex">
                            <label for="VS_pulseRate" class="form-label h6 my-auto me-1">PR<span class="text-danger" style="user-select: none;">*</span>:&nbsp;</label>
                            <div class="d-flex align-items-center" style="margin-top:-1%;">
                                <input type="number" class="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->pulseRate ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('VS_pulseRate') is-invalid @enderror me-1 ms-4" id="VS_pulseRate" name="VS_pulseRate" value="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->pulseRate ? $patient->medicalRecordAdmin->pulseRate : old('VS_pulseRate') }}" onKeyPress="if(this.value.length==4) return false;" {{ $patient->medicalRecordAdmin ? 'readonly' : 'required' }}>
                                <p class="pt-3" style="margin-left: 4px;">/minute</p>
                            </div>
                        </div>                 
                        <div class="form-group d-flex">
                            <label for="VS_respirationRate" class="form-label h6 my-auto me-1">RR<span class="text-danger" style="user-select: none;">*</span>:&nbsp;</label>
                            <div class="d-flex align-items-center" style="margin-top:-1%;">
                                <input type="number" class="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->respirationRate ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('VS_respirationRate') is-invalid @enderror me-1 ms-4" id="VS_respirationRate" name="VS_respirationRate" value="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->respirationRate ? $patient->medicalRecordAdmin->respirationRate : old('VS_respirationRate') }}" onKeyPress="if(this.value.length==4) return false;" {{ $patient->medicalRecordAdmin ? 'readonly' : 'required' }}>
                                <p class="pt-3" style="margin-left: 4px;">/minute</p>

                            </div>
                        </div>
                        <div class="form-group d-flex">
                            <label for="VS_temp" class="form-label h6 my-auto me-1">Temp<span class="text-danger" style="user-select: none;">*</span>:</label>
                            <div class="d-flex align-items-center">
                                <input type="number" placeholder="e.g. 36.5" class="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->temp ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('VS_temp') is-invalid @enderror me-1" id="VS_temp" name="VS_temp" onKeyPress="if(this.value.length==4) return false;" step="0.01" min="0" lang="en" value="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->temp ? $patient->medicalRecordAdmin->temp : old('VS_temp') }}" style="margin-left: 1px; width:90%;" {{ $patient->medicalRecordAdmin ? 'readonly' : 'required' }}>
                                <p class="pt-3" style="margin-left: 4px;">°C</p>
                                
                            </div>
                        </div>    
                    </div> 
                    <!-- Col 2 (HEIGHT, WEIGHT, BMI) -->
                    <div class="col-xl-3 mx-4">
                        <div class="form-group d-flex">
                            <label for="VS_height" class="form-label h6 my-auto me-1">Height<span class="text-danger" style="user-select: none;">*</span>:</label>
                            <div class="d-flex align-items-center" style="margin-top:-1%;">
                                <input type="number" placeholder="e.g. 1.7" class="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->height ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('VS_height') is-invalid @enderror me-1 ms-1" step="0.1" min="0" lang="en" id="VS_height" name="VS_height" value="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->height ? $patient->medicalRecordAdmin->height : old('VS_height') }}" step="0.01" min="0" lang="en" onKeyPress="if(this.value.length==4) return false;" {{ $patient->medicalRecordAdmin ? 'readonly' : 'required' }}>
                                <p class="pt-3" style="margin-left: 4px;">meters</p>
                            </div>
                        </div>  
                        <div class="form-group d-flex">
                            <label for="VS_weight" class="form-label h6 my-auto me-1">Weight<span class="text-danger" style="user-select: none;">*</span>:</label>
                            <div class="d-flex align-items-center" style="margin-top:-1%;">
                                <input type="number" placeholder="e.g. 75" class="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->weight ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('VS_weight') is-invalid @enderror me-1" id="VS_weight" name="VS_weight" value="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->weight ? $patient->medicalRecordAdmin->weight : old('VS_weight') }}" onKeyPress="if(this.value.length==4) return false;" {{ $patient->medicalRecordAdmin ? 'readonly' : 'required' }}>
                                <p class="pt-3" style="margin-left: 4px;">kg</p>
                            </div>
                        </div>  
                        <div class="form-group d-flex">
                            <label for="VS_bmi" class="form-label h6 my-auto me-1">BMI<span class="text-danger" style="user-select: none;">*</span>:&nbsp;</label>
                            <div class="d-flex align-items-center" style="margin-top:-1%;">
                                <input type="number" placeholder="AUTO" class="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->bmi ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('VS_bmi') is-invalid @enderror me-1 ms-4" id="VS_bmi" name="VS_bmi" value="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->bmi ? $patient->medicalRecordAdmin->bmi : old('VS_bmi') }}" step="0.01" min="0" lang="en" onKeyPress="if(this.value.length==4) return false;" {{ $patient->medicalRecordAdmin ? 'readonly' : 'required' }}>
                                <p class="pt-3" style="margin-left: 4px;">&nbsp;</p>
                                
                            </div>
                        </div>
                    </div>
                    <!-- Col 3 (FINDINGS) -->
                    <div class="col-xl-5">
                        <div class="form-group d-flex">
                            <label for="VS_xrayFindings" class="form-label h6 my-auto me-1" style="white-space: nowrap;">CHEST X-RAY FINDINGS<span class="text-danger" style="user-select: none;">*</span>:</label>
                            <div class="d-flex align-items-center" style="margin-top:-1%;">
                                <input type="text" oninput="this.value = this.value.toUpperCase()" class="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->xrayFindings ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('VS_xrayFindings') is-invalid @enderror me-1" id="VS_xrayFindings" name="VS_xrayFindings" value="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->xrayFindings ? $patient->medicalRecordAdmin->xrayFindings : old('VS_xrayFindings') }}" style="width: 100%;" {{ $patient->medicalRecordAdmin ? 'readonly' : 'required' }}>
                                <p class="pt-3" style="margin-left: 4px;">&nbsp;</p>
                               
                            </div>
                        </div>                   
                        <div class="form-group d-flex">
                            <label for="VS_cbcResults" class="form-label h6 my-auto me-1" style="white-space: nowrap;">CBC Results<span class="text-danger" style="user-select: none;">*</span>:</label>
                            <div class="d-flex align-items-center" style="margin-top:-1%;">
                                <input type="text" oninput="this.value = this.value.toUpperCase()" class="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->cbcResults ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('VS_cbcResults') is-invalid @enderror me-1" id="VS_cbcResults" name="VS_cbcResults" value="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->cbcResults ? $patient->medicalRecordAdmin->cbcResults : old('VS_cbcResults') }}" style="width: 100%; margin-left: 86px;" {{ $patient->medicalRecordAdmin ? 'readonly' : 'required' }}>
                                <p class="pt-3" style="margin-left: 4px;">&nbsp;</p>
                                
                            </div>
                        </div>               
                        <div class="form-group d-flex">
                            <label for="VS_hepaBscreening" class="form-label h6 my-auto me-1" style="white-space: nowrap;">Hepatitis B Screening<span class="text-danger" style="user-select: none;">*</span>:</label>
                            <div class="d-flex align-items-center" style="margin-top:-1%;">
                                <input type="text" oninput="this.value = this.value.toUpperCase()" class="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->hepaBscreening ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('VS_hepaBscreening') is-invalid @enderror me-1" id="VS_hepaBscreening" name="VS_hepaBscreening" value="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->hepaBscreening ? $patient->medicalRecordAdmin->hepaBscreening : old('VS_hepaBscreening') }}" style="margin-left: 12px; width: 100%;" {{ $patient->medicalRecordAdmin ? 'readonly' : 'required' }}>
                                <p class="pt-3" style="margin-left: 4px;">&nbsp;</p>
                                
                            </div>
                        </div>
                        <div class="form-group d-flex">
                            <label for="VS_bloodType" class="form-label h6 my-auto me-1" style="white-space: nowrap;">Blood Type<span class="text-danger" style="user-select: none;">*</span>:</label>
                            <div class="d-flex align-items-center" style="margin-top:-1%;">
                                <input type="text" oninput="this.value = this.value.toUpperCase()" class="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->bloodtype ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('VS_bloodType') is-invalid @enderror me-1" id="VS_bloodType" name="VS_bloodType" value="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->bloodtype ? $patient->medicalRecordAdmin->bloodtype : old('VS_bloodType') }}" style="margin-left: 94px; width: 100%;" {{ $patient->medicalRecordAdmin ? 'readonly' : 'required' }}>
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
        </div>
        <!-- FITNESS CERTIFICATION -->
        <div class="mx-auto row row-cols-lg-1 mt-2">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4 p-3 border border-end-0 border-dark">
                        <h5 class="text-center">CATEGORY</h5>
                    </div>
                    <div class="col-md-8 p-3 border border-dark">
                        <h5 class="text-center">PHYSICAL EXAMINATION FINDINGS</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 p-1 border-bottom border-start border-dark">
                        <p class="pt-4 fs-5 mx-auto">1. General Appearance<span class="text-danger">*</span></p>
                    </div>
                    <div class="col-md-8 p-1 border border-top-0 border-dark">
                        <div class="form-check">
                            <label class="form-check-label fw-bold" for="PE_GenAppearance_Okay">
                              Normal
                            </label>
                            <input class="form-check-input" type="radio" name="PE_GenAppearance" id="PE_GenAppearance_Okay" value="1" {{ (old('PE_GenAppearance') == '1') || ($patient->medicalRecordAdmin && $patient->medicalRecordAdmin->generalAppearance == '1') ? 'checked' : '' }} {{ $patient->medicalRecordAdmin ? 'disabled' : 'required' }}>
                          </div>
                          <div class="form-check">
                            <label class="form-check-label fw-bold" for="PE_GenAppearance_others">
                              Other findings
                            </label>
                            <input class="form-check-input" type="radio" name="PE_GenAppearance" id="PE_GenAppearance_others" value="2" {{ (old('PE_GenAppearance') == '2') || ($patient->medicalRecordAdmin && $patient->medicalRecordAdmin->generalAppearance =='2') ? 'checked' : '' }} {{ $patient->medicalRecordAdmin ? 'disabled' : '' }}>
                            <input type="text" oninput="this.value = this.value.toUpperCase()" class="{{ $patient->medicalRecordAdmin ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('PE_GenAppearance') is-invalid @enderror" id="PE_GenAppearanceDetails" name="PE_GenAppearanceDetails" size="90" value="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->generalAppearanceDetails ? $patient->medicalRecordAdmin->generalAppearanceDetails : old('PE_GenAppearanceDetails') }}" {{ $patient->medicalRecordAdmin ? 'readonly' : 'disabled' }}>
                          </div>
                          <span class="text-danger"> 
                            @error('PE_GenAppearance') 
                              {{ $message }} 
                            @enderror
                          </span>                                               
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 p-1 border-bottom border-start border-dark">
                        <p class="pt-4 fs-5 mx-auto">2. HEENT<span class="text-danger">*</span></p>
                    </div>
                    <div class="col-md-8 p-1 border border-top-0 border-dark">
                        <div class="form-check">
                            <label class="form-check-label fw-bold" for="PE_HEENT_Okay">
                                Normal
                            </label>
                            <input class="form-check-input" type="radio" name="PE_HEENT" id="PE_HEENT_Okay" value="1" {{ (old('PE_HEENT') == '1') || ($patient->medicalRecordAdmin && $patient->medicalRecordAdmin->HEENT == 1)? 'checked' : '' }} {{ $patient->medicalRecordAdmin ? 'disabled ' : 'required' }}>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label fw-bold" for="PE_HEENT_others">
                                Other findings
                            </label>
                            <input class="form-check-input" type="radio" name="PE_HEENT" id="PE_HEENT_others" value="2" {{ (old('PE_HEENT') == '2') || ($patient->medicalRecordAdmin && $patient->medicalRecordAdmin->HEENT == 2) ? 'checked' : '' }} {{ $patient->medicalRecordAdmin ? 'disabled ' : '' }}>
                            <input type="text"  oninput="this.value = this.value.toUpperCase()" class="{{ $patient->medicalRecordAdmin ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('PE_HEENT') is-invalid @enderror" id="PE_HEENTDetails" name="PE_HEENTDetails" size="90" value="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->HEENTDetails ? $patient->medicalRecordAdmin->HEENTDetails : old('PE_HEENTDetails') }}" {{ $patient->medicalRecordAdmin ? 'readonly' : 'disabled' }}>
                        </div>
                        <span class="text-danger"> 
                            @error('PE_HEENT') 
                                {{ $message }} 
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 p-1 border-bottom border-start border-dark">
                        <p class="pt-4 fs-5 mx-auto">3. Chest & Lungs<span class="text-danger">*</span></p>
                    </div>
                    <div class="col-md-8 p-1 border border-top-0 border-dark">
                        <div class="form-check">
                            <label class="form-check-label fw-bold" for="PE_ChestLungsOkay">
                                Normal
                            </label>
                            <input class="form-check-input" type="radio" name="PE_ChestLungs" id="PE_ChestLungsOkay" value="1" {{ (old('PE_ChestLungs') == '1') || ($patient->medicalRecordAdmin && $patient->medicalRecordAdmin->chestLungs == 1) ? 'checked' : '' }} {{ $patient->medicalRecordAdmin ? 'disabled' : 'required' }}>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label fw-bold" for="PE_ChestLungsothers">
                                Other findings
                            </label>
                            <input class="form-check-input" type="radio" name="PE_ChestLungs" id="PE_ChestLungsothers" value="2" {{ (old('PE_ChestLungs') == '2') || ($patient->medicalRecordAdmin && $patient->medicalRecordAdmin->chestLungs == 2) ? 'checked' : '' }} {{ $patient->medicalRecordAdmin ? 'disabled' : '' }}>
                            <input type="text"  oninput="this.value = this.value.toUpperCase()" class="{{ $patient->medicalRecordAdmin ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('PE_ChestLungs') is-invalid @enderror" id="PE_ChestLungsDetails" name="PE_ChestLungsDetails" size="90" value="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->chestLungsDetails ? $patient->medicalRecordAdmin->chestLungsDetails : old('PE_ChestLungsDetails') }}" {{ $patient->medicalRecordAdmin ? 'readonly' : 'disabled' }}>
                        </div>
                        <span class="text-danger"> 
                            @error('PE_ChestLungs') 
                                {{ $message }} 
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 p-1 border-bottom border-start border-dark">
                        <p class="pt-4 fs-5 mx-auto">4. Cardiovascular<span class="text-danger">*</span></p>
                    </div>
                    <div class="col-md-8 p-1 border border-top-0 border-dark">
                        <div class="form-check">
                            <label class="form-check-label fw-bold" for="PE_CardioOkay">
                                Normal
                            </label>
                            <input class="form-check-input" type="radio" name="PE_Cardio" id="PE_CardioOkay" value="1" {{ (old('PE_Cardio') == '1') || ($patient->medicalRecordAdmin && $patient->medicalRecordAdmin->cardio == 1) ? 'checked' : '' }} {{ $patient->medicalRecordAdmin ? 'disabled ' : 'required' }} >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label fw-bold" for="PE_Cardioothers">
                                Other findings
                            </label>
                            <input class="form-check-input" type="radio" name="PE_Cardio" id="PE_Cardioothers" value="2" {{ (old('PE_Cardio') == '2') || ($patient->medicalRecordAdmin && $patient->medicalRecordAdmin->cardio == 2)  ? 'checked' : '' }} {{ $patient->medicalRecordAdmin ? 'disabled ' : '' }}>
                            <input type="text"  oninput="this.value = this.value.toUpperCase()" class="{{ $patient->medicalRecordAdmin ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('PE_Cardio') is-invalid @enderror" id="PE_CardioDetails" name="PE_CardioDetails" size="90" value="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->cardioDetails ? $patient->medicalRecordAdmin->cardioDetails : old('PE_CardioDetails') }}" {{ $patient->medicalRecordAdmin ? 'readonly' : 'disabled' }}>
                        </div>
                        <span class="text-danger"> 
                            @error('PE_Cardio') 
                                {{ $message }} 
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 p-1 border-bottom border-start border-dark">
                        <p class="pt-4 fs-5 mx-auto">5. Abdomen<span class="text-danger">*</span></p>
                    </div>
                    <div class="col-md-8 p-1 border border-top-0 border-dark">
                        <div class="form-check">
                            <label class="form-check-label fw-bold" for="PE_AbdomenOkay">
                                Normal
                            </label>
                            <input class="form-check-input" type="radio" name="PE_Abdomen" id="PE_AbdomenOkay" value="1" {{ (old('PE_Abdomen') == '1') || ($patient->medicalRecordAdmin && $patient->medicalRecordAdmin->abdomen == 1) ? 'checked' : '' }} {{ $patient->medicalRecordAdmin ? 'disabled ' : 'required' }}>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label fw-bold" for="PE_Abdomenothers">
                                Other findings
                            </label>
                            <input class="form-check-input" type="radio" name="PE_Abdomen" id="PE_Abdomenothers" value="2" {{ (old('PE_Abdomen') == '2') || ($patient->medicalRecordAdmin && $patient->medicalRecordAdmin->abdomen == 2) ? 'checked ' : '' }} {{ $patient->medicalRecordAdmin ? 'disabled ' : '' }}>
                            <input type="text"  oninput="this.value = this.value.toUpperCase()" class="{{ $patient->medicalRecordAdmin ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('PE_Abdomen') is-invalid @enderror" id="PE_AbdomenDetails" name="PE_AbdomenDetails" size="90" value="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->abdomenDetails ? $patient->medicalRecordAdmin->abdomenDetails : old('PE_AbdomenDetails') }}" {{ $patient->medicalRecordAdmin ? 'readonly' : 'disabled' }}>
                        </div>
                        <span class="text-danger"> 
                            @error('PE_Abdomen') 
                                {{ $message }} 
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 p-1 border-bottom border-start border-dark">
                        <p class="pt-4 fs-5 mx-auto">6. Genito Urinary<span class="text-danger">*</span></p>
                    </div>
                    <div class="col-md-8 p-1 border border-top-0 border-dark">
                        <div class="form-check">
                            <label class="form-check-label fw-bold" for="PE_GenitoOkay">
                                Normal
                            </label>
                            <input class="form-check-input" type="radio" name="PE_Genito" id="PE_GenitoOkay" value="1" {{ (old('PE_Genito') == '1') || ($patient->medicalRecordAdmin && $patient->medicalRecordAdmin->genito == '1') ? 'checked' : '' }} {{ $patient->medicalRecordAdmin ? 'disabled ' : 'required' }}>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label fw-bold" for="PE_Genitoothers">
                                Other findings
                            </label>
                            <input class="form-check-input" type="radio" name="PE_Genito" id="PE_Genitoothers" value="2" {{ (old('PE_Genito') == '2') || ($patient->medicalRecordAdmin && $patient->medicalRecordAdmin->genito == 2) ? 'checked' : '' }} {{ $patient->medicalRecordAdmin ? 'disabled ' : '' }}>
                            <input type="text"  oninput="this.value = this.value.toUpperCase()" class="{{ $patient->medicalRecordAdmin ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('PE_Genito') is-invalid @enderror" id="PE_GenitoDetails" name="PE_GenitoDetails" size="90" value="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->genitoDetails ? $patient->medicalRecordAdmin->genitoDetails : old('PE_GenitoDetails') }}" {{ $patient->medicalRecordAdmin ? 'readonly' : 'disabled' }}>
                        </div>
                        <span class="text-danger"> 
                            @error('PE_Genito') 
                                {{ $message }} 
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 p-1 border-bottom border-start border-dark">
                        <p class="pt-4 fs-5 mx-auto">7. Musculoskeletal<span class="text-danger">*</span></p>
                    </div>
                    <div class="col-md-8 p-1 border border-top-0 border-dark">
                        <div class="form-check">
                            <label class="form-check-label fw-bold" for="PE_MusculoskeletalOkay">
                                Normal
                            </label>
                            <input class="form-check-input" type="radio" name="PE_Musculoskeletal" id="PE_MusculoskeletalOkay" value="1" {{ (old('PE_Musculoskeletal') == '1') || ($patient->medicalRecordAdmin && $patient->medicalRecordAdmin->musculoskeletal == '1') ? 'checked' : '' }} {{ $patient->medicalRecordAdmin ? 'disabled ' : 'required' }} >
                        </div>
                        <div class="form-check">
                            <label class="form-check-label fw-bold" for="PE_Musculoskeletalothers">
                                Other findings
                            </label>
                            <input class="form-check-input" type="radio" name="PE_Musculoskeletal" id="PE_Musculoskeletalothers" value="2" {{ (old('PE_Musculoskeletal') == '2') || ($patient->medicalRecordAdmin && $patient->medicalRecordAdmin->musculoskeletal == '2') ? 'checked' : '' }} {{ $patient->medicalRecordAdmin ? 'disabled ' : '' }}>
                            <input type="text"  oninput="this.value = this.value.toUpperCase()" class="{{ $patient->medicalRecordAdmin ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('PE_Musculoskeletal') is-invalid @enderror" id="PE_MusculoskeletalDetails" name="PE_MusculoskeletalDetails" size="90" value="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->musculoskeletalDetails ? $patient->medicalRecordAdmin->musculoskeletalDetails : old('PE_MusculoskeletalDetails') }}" {{ $patient->medicalRecordAdmin ? 'readonly' : 'disabled' }}>
                        </div>
                        <span class="text-danger"> 
                            @error('PE_Musculoskeletal') 
                                {{ $message }} 
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 p-1 border-bottom border-start border-dark">
                        <p class="pt-4 fs-5 mx-auto">8. Nervous System<span class="text-danger">*</span></p>
                    </div>
                    <div class="col-md-8 p-1 border border-top-0 border-dark">
                        <div class="form-check">
                            <label class="form-check-label fw-bold" for="PE_NervousSystem">
                                Normal
                            </label>
                            <input class="form-check-input" type="radio" name="PE_NervousSystem" id="PE_NervousSystemOkay" value="1" {{ (old('PE_NervousSystem') == '1') || ($patient->medicalRecordAdmin && $patient->medicalRecordAdmin->nervousSystem == '1') ? 'checked' : '' }} {{ $patient->medicalRecordAdmin ? 'disabled ' : 'required' }}>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label fw-bold" for="PE_NervousSystemothers">
                                Other findings
                            </label>
                            <input class="form-check-input" type="radio" name="PE_NervousSystem" id="PE_NervousSystemothers" value="2" {{ (old('PE_NervousSystem') == '2') || ($patient->medicalRecordAdmin && $patient->medicalRecordAdmin->nervousSystem == '2') ? 'checked' : '' }} {{ $patient->medicalRecordAdmin ? 'disabled ' : '' }}>
                            <input type="text"  oninput="this.value = this.value.toUpperCase()" class="{{ $patient->medicalRecordAdmin ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('PE_NervousSystem') is-invalid @enderror" id="PE_NervousSystemDetails" name="PE_NervousSystemDetails" size="90" value="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->nervousSystemDetails ? $patient->medicalRecordAdmin->nervousSystemDetails : old('PE_NervousSystemDetails') }}" {{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->nervousSystemDetails ? 'readonly' : 'disabled' }}>
                        </div>
                        <span class="text-danger"> 
                            @error('PE_NervousSystem') 
                                {{ $message }} 
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 p-1 border-start border-dark">
                        <p class="pt-4 fs-5 mx-auto">9. Other Significant Findings:</p>
                    </div>
                    <div class="col-md-8 p-1 border-start border-end border-dark">
                        <div class="form-group">
                            <textarea oninput="this.value = this.value.toUpperCase()" class="{{ $patient->medicalRecordAdmin ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('PE_otherSignificantFindings') is-invalid @enderror mx-auto" id="PE_otherSignificantFindings" name="PE_otherSignificantFindings" style="resize: none; overflow: hidden; width:95%;" {{ $patient->medicalRecordAdmin ? 'readonly' : '' }}>{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->otherSignificantFindings ? $patient->medicalRecordAdmin->otherSignificantFindings : old('PE_otherSignificantFindings') }}</textarea>
                        <script>
                            var textarea = document.getElementById('PE_otherSignificantFindings');

                            textarea.addEventListener('input', function() {
                                this.style.height = 'auto';
                                this.style.height = this.scrollHeight + 'px';
                            });
                        </script>
                        <span class="text-danger"> 
                            @error('PE_otherSignificantFindings') 
                                {{ $message }} 
                            @enderror
                        </span>
                    </div>
                </div>
            </div>

                <script>
                    $(document).ready(function(){
                        $('#PE_GenAppearance_others').click(function(){
                            $('#PE_GenAppearanceDetails').prop('disabled', false);
                            $('#PE_GenAppearanceDetails').prop('required', true);
                        });
                        $('#PE_GenAppearance_Okay').click(function(){
                            $('#PE_GenAppearanceDetails').prop('disabled', true);
                            $('#PE_GenAppearanceDetails').prop('required', false);
                        });

                        $('#PE_HEENT_others').click(function(){
                            $('#PE_HEENTDetails').prop('disabled', false);
                            $('#PE_HEENTDetails').prop('required', true);
                        });
                        $('#PE_HEENT_Okay').click(function(){
                            $('#PE_HEENTDetails').prop('disabled', true);
                            $('#PE_HEENTDetails').prop('required', false);
                        });

                        $('#PE_ChestLungsothers').click(function(){
                            $('#PE_ChestLungsDetails').prop('disabled', false);
                            $('#PE_ChestLungsDetails').prop('required', true);
                        });
                        $('#PE_ChestLungsOkay').click(function(){
                            $('#PE_ChestLungsDetails').prop('disabled', true);
                            $('#PE_ChestLungsDetails').prop('required', false);
                        });

                        $('#PE_Cardioothers').click(function(){
                            $('#PE_CardioDetails').prop('disabled', false);
                            $('#PE_CardioDetails').prop('required', true);
                        });
                        $('#PE_CardioOkay').click(function(){
                            $('#PE_CardioDetails').prop('disabled', true);
                            $('#PE_CardioDetails').prop('required', false);
                        });

                        $('#PE_Abdomenothers').click(function(){
                            $('#PE_AbdomenDetails').prop('disabled', false);
                            $('#PE_AbdomenDetails').prop('required', true);
                        });
                        $('#PE_AbdomenOkay').click(function(){
                            $('#PE_AbdomenDetails').prop('disabled', true);
                            $('#PE_AbdomenDetails').prop('required', false);
                        });

                        $('#PE_Genitoothers').click(function(){
                            $('#PE_GenitoDetails').prop('disabled', false);
                            $('#PE_GenitoDetails').prop('required', true);
                        });
                        $('#PE_GenitoOkay').click(function(){
                            $('#PE_GenitoDetails').prop('disabled', true);
                            $('#PE_GenitoDetails').prop('required', false);
                        });

                        $('#PE_Musculoskeletalothers').click(function(){
                            $('#PE_MusculoskeletalDetails').prop('disabled', false);
                            $('#PE_MusculoskeletalDetails').prop('required', true);
                        });
                        $('#PE_MusculoskeletalOkay').click(function(){
                            $('#PE_MusculoskeletalDetails').prop('disabled', true);
                            $('#PE_MusculoskeletalDetails').prop('required', false);
                        });

                        $('#PE_NervousSystemothers').click(function(){
                            $('#PE_NervousSystemDetails').prop('disabled', false);
                            $('#PE_NervousSystemDetails').prop('required', true);
                        });
                        $('#PE_NervousSystemOkay').click(function(){
                            $('#PE_NervousSystemDetails').prop('disabled', true);
                            $('#PE_NervousSystemDetails').prop('required', false);
                        });
                    });
                </script>
            </div>
                <div class="p-3 border border-dark">
                    <h5 class="pl-6">FITNESS CERTIFICATION<span class="text-danger">*</span></h5>
                    <div class="d-flex justify-content-evenly mt-3">
                        <div class="col-xl-2 col-lg-6 col-sm-12 form-check">
                            <input class="form-check-input ms-2" name="fitness" type="radio" id="fitness_Fit" onclick="disableReasonInput();" value="fit" {{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->fitness == 'fit' ? 'checked' : '' }} {{ $patient->medicalRecordAdmin ? 'disabled' : 'required' }}>
                            <label class="form-check-label ms-1 fw-bold" for="fitness_Fit">
                                Fit for Enrollment
                            </label>
                        </div>
                        <div class="col-xl-2 col-lg-6 col-sm-12 form-check">
                            <input class="form-check-input" name="fitness" type="radio" id="fitness_notFit" onclick="enableReasonInput();" value="notFit" {{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->fitness == 'notFit' ? 'checked' : '' }} {{ $patient->medicalRecordAdmin ? 'disabled' : 'required' }}>
                            <label class="form-check-label fw-bold" for="fitness_notFit">
                                Not Fit for Enrollment
                            </label>
                        </div>
                        <div class="col-xl-2 col-lg-6 col-sm-12 form-check">
                            <input class="form-check-input" name="fitness" type="radio" id="fitness_Pending" onclick="enableReasonInput();" value="pending" {{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->fitness == 'pending' ? 'checked' : ' ' }} {{ $patient->medicalRecordAdmin ? 'disabled' : 'required' }}>
                            <label class="form-check-label fw-bold" for="fitness_Pending">
                                Pending
                            </label>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 d-flex">
                            <label for="fit_Reason" class="form-label me-1">Reason:</label>
                            <input type="text" id="fit_Reason" name="fit_reason" class="{{ $patient->medicalRecordAdmin ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('fit_reason') is-invalid @enderror" placeholder="For 'not fit' and 'pending'" style="margin-top: -6px;" {{ $patient->medicalRecordAdmin ? 'readonly' : 'disabled' }} value={{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->notfitPendingReason ? $patient->medicalRecordAdmin->notfitPendingReason : old("fit_reason") }}> 
                        </div>
                        <div class="invalid-feedback">
                            This field is required. Please fill up this field.
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

                        function disableReasonInput() {
                            document.getElementById("fit_Reason").disabled = true;
                            document.getElementById("fit_Reason").required = false;
                        }
                    
                        function enableReasonInput() {
                            document.getElementById("fit_Reason").disabled = false;
                            document.getElementById("fit_Reason").required = true;
                        }
                    </script>
                </div>
                <!-- Recommendations -->
                <div class="pt-3 border border-top-0 border-dark pb-2">
                    <h5>Impression/Recommendations</h5>
                    <textarea class="{{ $patient->medicalRecordAdmin ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }}" id="MRA_recommendations" name="MRA_recommendations" style="resize: none; overflow: hidden;" {{ $patient->medicalRecordAdmin ? 'readonly' : 'required' }}>{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->impression ? $patient->medicalRecordAdmin->impression : old('MRA_recommendations')  }}</textarea>
                        <script>
                            var textarea = document.getElementById('MRA_recommendations');

                            textarea.addEventListener('input', function() {
                                this.style.height = 'auto';
                                this.style.height = this.scrollHeight + 'px';
                            });
                        </script>
                </div>
            </div>

        <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
            <header class="text-center">
                <!-- LINE BREAK -->
            </header>
        </section>
        <!-- PRINTABLE -->
        <div class="row d-flex d-print-inline-block d-none d-print-block" style="margin-bottom: 200px;">
            <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
                <header class="text-center">
                    <!-- LINE BREAK -->
                </header>
            </section>
        </div>
        <!-- END OF PRINTABLE -->
        
        <p class="text-center fw-bold pt-1" style="user-select:none;"> FOR BICOL UNIVERSITY HEALTH SERVICE PHYSICIAN'S VALIDATION ONLY </p>

        <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
            <header class="text-center">
                <!-- LINE BREAK -->
            </header>
        </section>
        @php
            $date = date('Y F d');

            if($patient->medicalRecordAdmin){
                $savedDate = new DateTime($patient->medicalRecordAdmin->dateOfExam);
                $formattedDate = $savedDate->format('Y F d');
            }
        @endphp
        <div class="col-md-12 p-3 border border-dark">
            <div class="flex-row justify-content-center">
                <p class="fs-5 fst-italic text-center">The above findings are certified correct and are based on the physical examination, diagnostic results available, and the disclosure of the student's/parent's pertinent medical history at the time and date of examination </p>
                <div class="row row-cols-xl-3 row-cols-lg-1 row-cols-md-1 row-cols-sm-1 my-auto p-5">
                    <div class="col-md-4">
                        <label class="form-label h6" for="MRA_licenseNumber">License Number</label>
                        <input type="text" class="{{ $patient->medicalRecordAdmin ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('MRA_licenseNumber') is-invalid @enderror" id="MRA_licenseNumber" name="MRA_licenseNumber" value="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->licenseNumber ? $patient->medicalRecordAdmin->licenseNumber : old('MRA_licenseNumber')}}" {{ $patient->medicalRecordAdmin ? 'readonly disabled' : 'required' }}>
                        <div class="invalid-feedback">
                            Please enter a valid license number.
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label h6" for="MRA_PTRNumber">PTR Number</label>
                        <input type="text" class="{{ $patient->medicalRecordAdmin ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('MRA_PTRNumber') is-invalid @enderror" id="MRA_PTRNumber" name="MRA_PTRNumber" value="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->PTRnumber ? $patient->medicalRecordAdmin->PTRnumber : old('MRA_PTRNumber')}}" {{ $patient->medicalRecordAdmin ? 'readonly disabled' : 'required' }}>
                        <div class="invalid-feedback">
                            Please enter your a valid PTR Number.
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="MRA_dateOfExamination" class="form-label h6">Date of Examination<span class="text-danger">*</span></label>
                        <input type="text" class="{{ $patient->medicalRecordAdmin ? 'form-control-plaintext border-bottom border-black border-top-0 mb-2 pb-0 fs-5 fw-bold' : 'form-control' }} @error('MRA_dateOfExamination') is-invalid @enderror" id="MRA_dateOfExamination" name="MRA_dateOfExamination" onkeydown="return false;" value="{{ $patient->medicalRecordAdmin && $patient->medicalRecordAdmin->dateOfExam ? $formattedDate :  (old('MRA_dateOfExamination') ?: $date) }}" {{ $patient->medicalRecordAdmin ? 'readonly onclick="return false;" disabled' : 'required' }}>
                        <div class="invalid-feedback">
                            Please enter a valid date.
                        </div>
                    </div>
                    <script>
                    $(document).ready(function() {
                            $("#MRA_dateOfExamination").datepicker({
                                changeMonth: true,
                                changeYear: true,
                                dateFormat: 'yy MM dd',
                                showButtonPanel: true,
                                yearRange: "2023:c",
                                showAnim: 'slideDown',
                            });
                        });
                    </script>
                </div>
            </div>
        </div>

     
    <div class="row no-gutters justify-content-end pt-3 position-relative">
        <div class="col d-flex justify-content-end" style="margin-right:-1  %;">
            <button class="btn btn-lg btn-primary btn-login fw-bold mb-2" type="submit" style="{{ $patient->medicalRecordAdmin ? 'display:none;' : '' }}">Submit</button>

        </div
    </div>
    <script>
        function printForm() {
            var formContainer = document.getElementById("MR_form");
            var printWindow = window.open('', 'PrintWindow', 'height=400,width=600');
            printWindow.document.write('<html><head><title>Printable Form</title></head><body>');
            printWindow.document.write(formContainer.innerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }

        (() => {
            'use strict'

            // Fetch all the forms to apply validation styles to
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
</div> 
</form>
@endsection
