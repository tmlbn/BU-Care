@extends('admin.layouts.app')

@section('content')

<style>
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
    <form action="{{ route('import.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <button type="button" class="btn btn-primary mb-1" onclick="document.getElementById('csv_file').click()">Choose File</button>
        <input type="file" name="csv_file" id="csv_file" accept=".csv" style="display: none" onchange="document.getElementById('file-name').textContent = this.files[0].name; document.getElementById('import-btn').style.display = this.files.length ? 'inline-block' : 'none'">
        <span id="file-name"></span>
        <button id="import-btn" class="btn btn-success mb-1" style="display: none">Import</button>
    </form>
    
    
    <div class="d-flex flex-row">
        <div class="col-sm border p-3 border-dark">
            <header class="text-center">
                <h5 class="display-7 pt-3">
                    <p class="fs-2 fw-bold">Bicol University Health Services</p>
                    <p class="fs-4 fw-normal">Student Health Records List</p>
            </header>
        </div>
    </div>

    <!-- Search function -->
        <form method="GET" action="{{ route('admin.patientMedFormList.show') }}" id="searchForm">
                <div class="row row-cols-lg-2 row-cols-md-2 row-cols-sm-1 align-items-center my-2" style="margin-right: -3%;">
                    <div class="row align-items-center">
                        <div class="col-sm">
                            <input type="text" class="form-control" id="search" name="search" value="{{ request()->input('search') }}" placeholder="Search...">
                        </div>
                        <div class="col-sm">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                    <div class="row justify-content-end mt-2">
                        <div class="col-sm-2 ">
                            <p class="fs-5 fw-light float-end pt-1">
                                Filter by:
                            </p>
                        </div>
                        <div class="col-sm-5">
                            <select id="campusFilter" name="campusFilter" class="form-select" required>
                                <option selected="selected" disabled="disabled" value="">CAMPUS</option>
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
                        </div>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="course" name="course" value="{{ request()->input('course') }}" placeholder="Filter by course...">
                        </div>
                    </div>
                </div>
        </form>

    <div class="d-flex flex-row text-align-center justify-content-center">
        <div class="col-md-2 col-sm-3 custom-col-id border border-dark border-end-0">
            <p class="fs-4 font-monospace fw-bold text-center">PATIENT ID</p>
        </div>
        <div class="col-md-4 col-sm-3 border border-dark border-end-0">
            <p class="fs-4 font-monospace fw-bold text-center">NAME</p>
        </div>
        <div class="col-md-3 col-sm-3 border border-dark border-end-0 custom-col-CC">
            <p class="fs-4 font-monospace fw-bold text-center">CAMPUS</p>
        </div>
        <div class="col-md-3 col-sm-3 border border-dark custom-col-CC">
            <p class="fs-4 font-monospace fw-bold text-center">COURSE</p>
        </div>
    </div>
   
    <!-- Start list of Medical Forms -->
    <!-- Modify loop to filter based on search query -->
    <script>
        $searchQuery = '';
        if (isset($_GET['search'])) {
            $searchQuery = $_GET['search'];
        }
    </script>
      

    @foreach ($patients->filter(function($patient) use ($searchQuery) {
        return stripos($patient->first_name, $searchQuery) !== false 
            || stripos($patient->middle_name, $searchQuery) !== false 
            || stripos($patient->last_name, $searchQuery) !== false
            || stripos($patient->applicant_id_number, $searchQuery) !== false
            || stripos($patient->student_id_number, $searchQuery) !== false;
    }) as $patient)
    <a class="text-decoration-none text-dark" href="{{ route('admin.patientMedForm.show', ['patientID' => $patient->student_id_number ? $patient->student_id_number : $patient->applicant_id_number]) }}" target="_blank">
    <div class="d-flex flex-row divHover">
        <div class="col-md-2 col-sm-3 border border-dark border-top-0 border-end-0 custom-col-id">
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
        <div class="col-md-4 col-sm-3 border border-dark border-top-0 border-end-0">
            <p class="fs-5 fw-normal text-center mt-2">{{ $patient->first_name }} {{ $patient->middle_name }} {{ $patient->last_name }}</p>
        </div>
        <!-- CAMPUS -->
        <div class="col-md-3 col-sm-3 border border-dark border-top-0 border-end-0 custom-col-CC">
            <p class="fs-5 fw-normal text-center mt-2">{{ $patient->medicalRecord->campus }}</p>
        </div>
        <!-- COURSE -->
        <div class="col-md-3 col-sm-3 border border-dark border-top-0 custom-col-CC">
            <p class="fs-5 fw-normal text-center mt-2">{{ $patient->medicalRecord->course }}</p>
        </div>
    </div>
    </a>
    @endforeach

    <p class="text-center fw-light fst-italic pt-1" style="user-select:none;">---------- NOTHING FOLLOWS ----------</p>

</div> 
@endsection
