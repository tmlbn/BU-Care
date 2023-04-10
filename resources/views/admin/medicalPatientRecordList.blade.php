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
    tr.hover {
        transition: background-color 0.2s ease; /* Add transition to the background-color property */
    }
    tr.hover:hover {
        background-color: #f5c999; /* Change to the desired color on hover */
        color: #2460a0; /* Change the text color to make it visible */
        cursor: pointer;
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
                    <p class="fs-4 fw-normal">Daily Consultation and Treatment Form</p>
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

    <script>
        $searchQuery = '';
        if (isset($_GET['search'])) {
            $searchQuery = $_GET['search'];
        }
    </script>
      
        <table id="data_table" name="data_table" class="table table-striped table-bordered border-dark table-hover">       
            <caption>Medical Patient Records</caption>       
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Complaint/s</th>
                    <th>Temperature</th>
                    <th>Blood Pressure</th>
                    <th>Diagnosis</th>
                    <th>Treatment/Medications</th>
                </tr>
            </thead>
            <tbody>
                @foreach($medicalPatientRecords as $record)
                    <tr class="hover" onclick="window.location.href='{{ route('admin.medicalPatientRecord.show', ['patientID' => $record->MPRstudent->student_id_number ? $record->MPRstudent->student_id_number : $record->MPRstudent->applicant_id_number]) }}';">
                        <td contenteditable="false" style="max-width: 120px;">{{ date('d-F-Y', strtotime($record->date)) }}</td>
                        <td contenteditable="false" style="max-width: 140px;">{{ $record->MPRstudent->first_name }} {{ $record->MPRstudent->middle_name }} {{ $record->MPRstudent->last_name }}</td>
                        <td contenteditable="false" style="max-width: 120px;">{{ $record->MPRstudent->medicalRecord->course }}</td>
                        <td contenteditable="false" style="max-width: 120px;">Complaints</td>
                        <td contenteditable="false" style="max-width: 40px;">{{ $record->temperature }}</td>
                        <td contenteditable="false" style="max-width: 40px;">{{ $record->blood_pressure }}</td>
                        <td contenteditable="false" style="max-width: 200px;">{{ $record->historyPhysical_examinations }}</td>
                        <td contenteditable="false" style="max-width: 200px;">{{ $record->physician_directions }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

</div> 
@endsection