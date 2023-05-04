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
        cursor: pointer;
    }
    .bg-custom{
        background-color:#f0faff;
    }

</style>

@csrf
<!-- Header -->
<div class="container-fluid bg-custom text-dark p-5">
    <form action="{{ route('import.store.new') }}" method="post" enctype="multipart/form-data">
        @csrf
        <button type="button" class="btn btn-primary mb-1" onclick="document.getElementById('csv_new').click()">Choose File</button>
          <input type="file" name="csv_new" id="csv_new" accept=".csv" style="display: none" onchange="document.getElementById('file-name-new').textContent = this.files[0].name; document.getElementById('import-btn-new').style.display = this.files.length ? 'inline-block' : 'none'">
          <span id="file-name-new"></span>
        <button id="import-btn-new" class="btn btn-success mb-1" style="display: none">Import</button>
      </form>
    </div>
    <div>
      <form action="{{ route('import.store.old') }}" method="post" enctype="multipart/form-data">
        @csrf
        <button type="button" class="btn btn-primary mb-1" onclick="document.getElementById('csv_old').click()">Choose File</button>
          <input type="file" name="csv_old" id="csv_old" accept=".csv" style="display: none" onchange="document.getElementById('file-name-old').textContent = this.files[0].name; document.getElementById('import-btn-old').style.display = this.files.length ? 'inline-block' : 'none'">
          <span id="file-name-old"></span>
        <button id="import-btn-old" class="btn btn-success mb-1" style="display: none">Import</button>
      </form>
    </div>
    <div class="col-xl-2 col-lg-12 my-2">
        <label for="listType" class="form-label h6">Select Table</label>
        <select id="listType" name="listType" class="form-select" required>
            <option value="STUDENTS" selected="selected">Students</option>
            <option value="PERSONNEL" class="alternate">Personnel</option>
        </select>
    </div>

    <script>
        $(document).ready(function(){
            $('#listType').on('change', function(){
                if($('#listType').val() == 'STUDENTS'){
                    $('#studentsList').show();
                    $('#bannerStudent').show()
                    $('#personnelList').hide();
                    $('#bannerPersonnel').hide()
                }
                else{
                    $('#studentsList').hide();
                    $('#bannerStudent').hide()
                    $('#personnelList').show();
                    $('#bannerPersonnel').show()
                }
            })
        })
    </script>
    
    <div class="d-flex flex-row">
        <div class="col-sm border p-3 border-dark">
            <header class="text-center">
                <h5 class="display-7 pt-3">
                    <p class="fs-2 fw-bold">Bicol University Health Services</p>
                    <p class="fs-4 fw-normal" id="bannerStudent">Student Health Records List</p>
                    <p class="fs-4 fw-normal" id="bannerPersonnel" style="display: none;">Personnel Health Records List</p>
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
                                <option value="all">All</option>
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
        <div class="table-responsive">
            <table class="table table-bordered table-sm" id="studentsList">
                <caption style="user-select: none;">End of Student Health Records List</caption>
                <thead>
                    <tr class="text-center">
                        <th class="col-md-2 col-sm-3 custom-col-id border border-dark border-end-0">
                            <span class="fs-4 font-monospace fw-bold">ID</span>
                        </th>
                        <th class="col-md-4 col-sm-3 border border-dark border-end-0">
                            <span class="fs-4 font-monospace fw-bold">NAME</span>
                        </th>
                        <th class="col-md-3 col-sm-3 border border-dark border-end-0">
                            <span class="fs-4 font-monospace fw-bold">CAMPUS</span>
                        </th>
                        <th class="col-md-3 col-sm-3 border border-dark">
                            <span class="fs-4 font-monospace fw-bold">COURSE</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($students as $student)
                        <tr class="text-center divHover" onClick="window.open('{{ route('admin.studentMedForm.show', ['patientID' => $student->student_id_number ? $student->student_id_number : $student->applicant_id_number]) }}', '_blank'); return false;">
                            <td class="col-md-2 col-sm-3 border border-dark border-end-0 custom-col-id">
                                <div class="d-flex flex-row justify-content-center">
                                    <div class="col-sm">
                                        <p class="fs-5 fw-normal lessBottomMargin">{{ $student->applicant_id_number }}</p>
                                    </div>
                                </div>
                                <div class="d-flex flex-row border-dark">
                                    <div class="col-sm">
                                        <p class="fs-5 fw-normal lessBottomMargin">{{ $student->student_id_number }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="col-md-4 col-sm-3 border border-dark border-end-0">
                                <p class="fs-5 fw-normal mt-2">{{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }}</p>
                            </td>
                            <td class="col-md-3 col-sm-3 border border-dark border-end-0">
                                <p class="fs-5 fw-normal mt-2">{{ $student->medicalRecord->campus }}</p>
                            </td>
                            <td class="col-md-3 col-sm-3 border border-dark">
                                <p class="fs-5 fw-normal mt-2">{{ $student->medicalRecord->course }}</p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
            <tbody class="table-group-divider">
                @foreach ($personnel as $personnel)
                    <tr class="text-center divHover" onClick="window.open('{{ route('admin.personnelMedForm.show', ['patientID' => $personnel->personnel_id_number ]) }}', '_blank'); return false;">
                        <td class="col-md-2 col-sm-3 border border-dark border-end-0 custom-col-id">
                            <p class="fs-5 fw-normal lessBottomMargin">{{ $personnel->personnel_id_number }}</p>
                        </td>
                        <td class="col-md-4 col-sm-3 border border-dark border-end-0">
                            <p class="fs-5 fw-normal mt-2">{{ $personnel->first_name }} {{ $personnel->middle_name }} {{ $personnel->last_name }}</p>
                        </td>
                        <td class="col-md-2 col-sm-3 border border-dark">
                            <p class="fs-5 fw-normal mt-2">{{ $personnel->medicalRecordPersonnel->designation }}</p>
                        </td>
                        <td class="col-md-2 col-sm-3 border border-dark">
                            <p class="fs-5 fw-normal mt-2">{{ $personnel->medicalRecordPersonnel->unitDepartment }}</p>
                        </td>
                        <td class="col-md-2 col-sm-3 border border-dark">
                            <p class="fs-5 fw-normal mt-2">{{ $personnel->medicalRecordPersonnel->campus }}</p>
                        </td>
                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
