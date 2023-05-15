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
    <div class="col-md-12 p-3 text-decoration-none">    
        <div class="btn-group col-md-12" role="group" aria-label="Reports radio button group">
            <input type="radio" class="btn-check col-3" name="btnradio" id="btnradio1" autocomplete="off" onclick="redirectToStudentMedFormList()" {{ Route::currentRouteName() === 'admin.patientMedFormList.show' || Str::contains(url()->current(), '/admin/studentMedFormList/') ? 'checked' : '' }}>
            <label class="btn btn-outline-primary" for="btnradio1">STUDENT HEALTH RECORDS</label>
    
            <input type="radio" class="btn-check col-3" name="btnradio" id="btnradio2" autocomplete="off" onclick="redirectToPersonnelMedFormList()" {{ Route::currentRouteName() === 'admin.personnelMedFormList.show' || Str::contains(url()->current(), '/admin/personnelMedFormList/') ? 'checked' : '' }}>
            <label class="btn btn-outline-primary" for="btnradio2">PERSONNEL HEALTH RECORDS</label>
        
            <input type="radio" class="btn-check col-3" name="btnradio" id="btnradio3" autocomplete="off" onclick="redirectToMedPatientRecords()" {{ Route::currentRouteName() === 'admin.medPatientRecords.show' || Str::contains(url()->current(), '/admin/medical-patient-records-list/') ? 'checked' : '' }}>
            <label class="btn btn-outline-primary" for="btnradio3">MEDICAL PATIENT RECORDS</label>
          
            <input type="radio" class="btn-check col-3" name="btnradio" id="btnradio4" autocomplete="off" onclick="redirectToAppointmentsRecords()" {{ Route::currentRouteName() === 'admin.appointmentsHistory.show' || Str::contains(url()->current(), '/admin/appointments-history') ? 'checked' : '' }}>
            <label class="btn btn-outline-primary" for="btnradio4">APPOINTMENTS</label>
            
            <input type="radio" class="btn-check col-3" name="btnradio" id="btnradio5" autocomplete="off" onclick="redirectToDailyConsultations()" {{ Route::currentRouteName() === 'admin.medPatientRecordList.show' || Str::contains(url()->current(), '/admin/medical-patient-records/') ? 'checked' : '' }}>
            <label class="btn btn-outline-primary" for="btnradio5">DAILY CONSULTATIONS</label>
          
            <input type="radio" class="btn-check col-3" name="btnradio" id="btnradio6" autocomplete="off" onclick="redirectToReports()" {{ Route::currentRouteName() === 'admin.reports' || Str::contains(url()->current(), '/admin/reports/') ? 'checked' : '' }}>
            <label class="btn btn-outline-primary" for="btnradio6">REPORTS</label>
          </div>
      </div>
    
    <script>
      function redirectToStudentMedFormList() {
          window.location.href = "{{ route('admin.patientMedFormList.show') }}";
      }
    
      function redirectToPersonnelMedFormList() {
          window.location.href = "{{ route('admin.personnelMedFormList.show') }}";
      }
    
      function redirectToMedPatientRecords() {
          window.location.href = "{{ route('admin.medPatientRecords.show') }}";
      }

      function redirectToAppointmentsRecords() {
          window.location.href = "{{ route('admin.appointmentsHistory.show') }}";
      }
      
      function redirectToDailyConsultations() {
          window.location.href = "{{ route('admin.medPatientRecordList.show') }}";
      }
    
      function redirectToReports() {
          window.location.href = "{{ route('admin.reports') }}";
      }
    </script>
    <div class="col-12">      
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
    <form method="GET" action="{{ route('admin.patientMedFormList.index') }}" id="searchForm">
            <div class="row row-cols-lg-2 row-cols-md-2 row-cols-sm-1 align-items-center my-2" style="margin-right: -3%;">
                    <div class="row align-items-center">
                        <div class="col-sm">
                            <input type="text" class="form-control border-dark fw-bold" placeholder="Search by ID number or name" name="search">    
                        </div>
                
                        <div class="col-sm">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                <!--/form>
                <form method="GET" action="{{ route('medicalRecordList') }}" id="filterForm"-->
                    <div class="row justify-content-end mt-2">
                        <div class="col-sm-2">
                            <p class="fs-5 fw-light float-end pt-1">
                                Filter by:
                            </p>
                        </div>
                        <div class="col-lg-5">
                            <select id="campusSelect" name="campusSelect" class="form-select border-dark fw-bold">
                                <option selected="selected" disabled="disabled" value="">CAMPUS</option>
                                <option value="ALL" {{ isset($filterByCampus) && $filterByCampus == 'ALL' ? 'selected' : '' }}>ALL</option>
                                <option value="College of Agriculture and Forestry" {{ isset($filterByCampus) && $filterByCampus == 'College of Agriculture and Forestry' ? 'selected' : '' }}>College of Agriculture and Forestry</option>
                                <option value="College of Arts and Letters" class="alternate" {{ isset($filterByCampus) && $filterByCampus == 'College of Arts and Letters' ? 'selected' : '' }}>College of Arts and Letters</option>
                                <option value="College of Business, Entrepreneurship, and Management" {{ isset($filterByCampus) && $filterByCampus == 'College of Business, Entrepreneurship, and Management' ? 'selected' : '' }}>College of Business, Entrepreneurship, and Management</option>
                                <option value="College of Education" class="alternate" {{ isset($filterByCampus) && $filterByCampus == 'College of Education' ? 'selected' : '' }}>College of Education</option>
                                <option value="College of Engineering" {{ isset($filterByCampus) && $filterByCampus == 'College of Engineering' ? 'selected' : '' }}>College of Engineering</option>
                                <option value="College of Industrial Technology" class="alternate" {{ isset($filterByCampus) && $filterByCampus == 'College of Industrial Technology' ? 'selected' : '' }}>College of Industrial Technology</option>
                                <option value="College of Medicine" {{ isset($filterByCampus) && $filterByCampus == 'College of Medicine' ? 'selected' : '' }}>College of Medicine</option>
                                <option value="College of Nursing" class="alternate" {{ isset($filterByCampus) && $filterByCampus == 'College of Nursing' ? 'selected' : '' }}>College of Nursing</option>
                                <option value="College of Science" {{ isset($filterByCampus) && $filterByCampus == 'College of Science' || (!isset($filterByCampus)) ? 'selected' : '' }}>College of Science</option>
                                <option value="College of Social Science and Philosophy" class="alternate" {{ isset($filterByCampus) && $filterByCampus == 'College of Social Science and Philosophy' ? 'selected' : '' }}>College of Social Science and Philosophy</option>
                                <option value="Institute of Design and Architecture" {{ isset($filterByCampus) && $filterByCampus == 'Institute of Design and Architecture' ? 'selected' : '' }}>Institute of Design and Architecture</option>
                                <option value="Institute of Physical Education, Sports, and Recreation" class="alternate" {{ isset($filterByCampus) && $filterByCampus == 'Institute of Physical Education, Sports, and Recreation' ? 'selected' : '' }}>Institute of Physical Education, Sports, and Recreation</option>
                                <option value="Gubat Campus" {{ isset($filterByCampus) && $filterByCampus == 'Gubat Campus' ? 'selected' : '' }}>Gubat Campus</option>
                                <option value="Polangui Campus" class="alternate" {{ isset($filterByCampus) && $filterByCampus == 'Polangui Campus' ? 'selected' : '' }}>Polangui Campus</option>
                                <option value="Tabaco Campus" {{ isset($filterByCampus) && $filterByCampus == 'Tabaco Campus' ? 'selected' : '' }}>Tabaco Campus</option>
                            </select>
                        </div>

                        <script>
                             $(document).ready(function () {
                                $('#campusSelect').on('change', function () {
                                    $('#searchForm').submit();
                                });
                            });
                        </script>

                    </div>
                </div>
            </form>
        <div class="table-responsive" id="studentsList">
            <table class="table table-bordered table-sm" id="studentsTable">
                <caption style="user-select: none;">Student Health Records List</caption>
                <thead>
                    <tr class="text-center">
                        <th class="col-md-3 col-sm-3 custom-col-id border border-dark border-end-0">
                            <span class="fs-4 font-monospace fw-bold">ID</span>
                        </th>
                        <th class="col-md-3 col-sm-3 border border-dark border-end-0">
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
                <tbody id="studentsTableBody" class="table-group-divider">
                    @foreach ($students as $student)
                    <tr class="text-center divHover" onClick="window.open('{{ route('admin.studentMedForm.show', ['patientID' => $student->student_id_number ? $student->student_id_number : $student->applicant_id_number]) }}', '_blank'); return false;">
                      <td class="col-md-3 col-sm-3 border border-dark border-end-0 custom-col-id">
                        <div class="d-flex flex-row justify-content-center">
                          <div class="col-sm">
                            <p class="fs-5 fw-normal lessBottomMargin"><span class="font-monospace">AID: </span>{{ $student->applicant_id_number }}</p>
                          </div>
                        </div>
                        @if($student->student_id_number)
                            <div class="d-flex flex-row border-dark">
                                <div class="col-sm">
                                    <p class="fs-5 fw-normal lessBottomMargin"><span class="font-monospace">SID: </span>{{ $student->student_id_number }}</p>
                                </div>
                            </div>
                        @endif
                      </td>
                      <td class="col-md-3 col-sm-3 border border-dark border-end-0">
                        <p class="fs-5 fw-normal mt-2">{{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }}
                            @if ($student->hasValidatedRecord)
                                <i class="bi bi-person-check icon fs-4" style="color:#007bff;" data-toggle="tooltip" data-container="body" data-bs-placement="top" title="Validated Medical Record"></i>
                            @endif
                            @if($student->medicalRecordAdmin && $student->medicalRecordAdmin->released)
                                <i class="bi bi-clipboard-check-fill icon fs-4" style="color:#f1731f;" data-toggle="tooltip" data-container="body" data-bs-placement="top" title="Medical Certificate Released"></i>
                            @endif
                        </p>
                      </td>
                      @if(isset($student->medicalRecord->campus))
                        <td class="col-md-3 col-sm-3 border border-dark border-end-0">
                            <p class="fs-5 fw-normal mt-2">{{ $student->medicalRecord->campus }}</p>
                        </td>
                        <td class="col-md-3 col-sm-3 border border-dark">
                            <p class="fs-5 fw-normal mt-2">{{ $student->medicalRecord->course }}</p>
                        </td>
                      @else
                        <td class="col-md-3 col-sm-3 border border-dark border-end-0">
                            <p class="fs-5 fw-normal mt-2">{{ $student->campus }}</p>
                        </td>
                        <td class="col-md-3 col-sm-3 border border-dark">
                            <p class="fs-5 fw-normal mt-2">{{ $student->course }}</p>
                        </td>
                      @endif
                    </tr>
                    @endforeach
                  </tbody>
            </table>
        {{ $students->links() }}
    </div>
@endsection