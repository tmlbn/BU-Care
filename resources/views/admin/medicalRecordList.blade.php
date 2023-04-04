@extends('admin.layouts.app')

@section('content')

<style>
    body{
        background-image: url({{ asset('media/RegistrationBG.jpg') }});
        background-attachment: fixed;
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
    .lessBottomMargin{
        margin-bottom: -1%;
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
    .custom-col-id {
        padding: 0%;
    }

    @media (min-width: 768px) {
        .custom-col-id {
            flex-basis: 12.5%;
            max-width: 12.5%;
        }
    }
    .custom-col-CC {
        padding: 0%;
        flex-basis: 27.09%;
        max-width: 27.09%;
    }
    .divHover {
        transition: background-color 0.3s ease; /* Add transition to the background-color property */
    }
    .divHover:hover {
        background-color: #f5c999; /* Change to the desired color on hover */
        color: #2460a0; /* Change the text color to make it visible */
    }
    .bg-custom{
        background-color:#f0faff;
    }

</style>
@csrf
<!-- Header -->
<div class="container-fluid bg-custom text-dark p-5">
    <div class="d-flex flex-row">
        <div class="col-sm border p-3 border-dark">
            <header class="text-center">
                <h5 class="display-7 pt-3">
                    <p class="fs-2 fw-bold">Bicol University Health Services</p>
                    <p class="fs-4 fw-normal">Medical Records List</p>
            </header>
        </div>
    </div>

    <!--Personal Basic Information-->
    @if(session('fail'))
        <div class="alert alert-danger">
            {{ session('fail') }}
        </div>
    @endif

    <div class="d-flex flex-row">
        <div class="col-md-2 custom-col-id border border-dark border-top-0 border-end-0">
            <p class="fs-4 font-monospace fw-bold text-center">ID</p>
        </div>
        <div class="col-md-4 border border-dark border-top-0 border-end-0">
            <p class="fs-4 font-monospace fw-bold text-center">NAME</p>
        </div>
        <div class="col-md-3 border border-dark border-top-0 border-end-0 custom-col-CC">
            <p class="fs-4 font-monospace fw-bold text-center">CAMPUS</p>
        </div>
        <div class="col-md-3 border border-dark border-top-0 custom-col-CC">
            <p class="fs-4 font-monospace fw-bold text-center">COURSE</p>
        </div>
    </div>
    <!-- Start list of Medical Forms -->
    @foreach ($patients as $patient)
    <a class="text-decoration-none text-dark" href="{{ route('admin.patientMedForm.show', ['patientID' => $patient->student_id_number ? $patient->student_id_number : $patient->applicant_id_number]) }}" target="_blank">
    <div class="d-flex flex-row divHover">
        <div class="col-md-2 border border-dark border-top-0 border-end-0 custom-col-id">
            <!-- Applicant ID Number -->
            <div class="d-flex flex-row">
                <div class="col-sm">
                    <p class="fs-5 fw-normal text-center lessBottomMargin">{{ $patient->applicant_id_number }}</p>
                </div>
            </div>
            <!-- Student ID Number -->
            <div class="d-flex flex-row border-dark border-top">
                <div class="col-sm">
                    <p class="fs-5 fw-normal text-center lessBottomMargin">{{ $patient->student_id_number }}</p>
                </div>
            </div>
        </div>
        <!-- NAME -->
        <div class="col-md-4 border border-dark border-top-0 border-end-0">
            <p class="fs-5 fw-normal text-center mt-2">{{ $patient->first_name }} {{ $patient->middle_name }} {{ $patient->last_name }}</p>
        </div>
        <!-- CAMPUS -->
        <div class="col-md-3 border border-dark border-top-0 border-end-0 custom-col-CC">
            <p class="fs-5 fw-normal text-center mt-2">{{ $patient->medicalRecord->campus }}</p>
        </div>
        <!-- COURSE -->
        <div class="col-md-3 border border-dark border-top-0 custom-col-CC">
            <p class="fs-5 fw-normal text-center mt-2">{{ $patient->medicalRecord->course }}</p>
        </div>
    </div>
    </a>
    @endforeach

    <p class="text-center fw-light fst-italic pt-1" style="user-select:none;">---------- NOTHING FOLLOWS ----------</p>

</div> 
@endsection
