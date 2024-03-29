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
        
            <input type="radio" class="btn-check col-3" name="btnradio" id="btnradio3" autocomplete="off" onclick="redirectToMedPatientRecords()" {{ Route::currentRouteName() === 'admin.medPatientRecords.show' ? 'checked' : '' }}>
            <label class="btn btn-outline-primary" for="btnradio3">MEDICAL PATIENT RECORDS</label>
          
            <input type="radio" class="btn-check col-3" name="btnradio" id="btnradio4" autocomplete="off" onclick="redirectToDailyConsultations()" {{ Route::currentRouteName() === 'admin.medPatientRecordList.show' ? 'checked' : '' }}>
            <label class="btn btn-outline-primary" for="btnradio4">DAILY CONSULTATIONS</label>
          
            <input type="radio" class="btn-check col-3" name="btnradio" id="btnradio5" autocomplete="off" onclick="redirectToReports()" {{ Route::currentRouteName() === 'admin.reports' ? 'checked' : '' }}>
            <label class="btn btn-outline-primary" for="btnradio5">REPORTS</label>
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
        
        function redirectToDailyConsultations() {
            window.location.href = "{{ route('admin.medPatientRecordList.show') }}";
        }
        
        function redirectToReports() {
            window.location.href = "{{ route('admin.reports') }}";
        }
    </script>


    <div class="d-flex flex-row">
        <div class="col-sm border p-3 border-dark">
            <header class="text-center">
                <h5 class="display-7 pt-3">
                    <p class="fs-2 fw-bold">Bicol University Health Services</p>
                    <p class="fs-4 fw-normal" id="bannerStudent">Appointments</p>
                </h5>
            </header>
        </div>
    </div>

    <!-- Search function -->
        <form method="GET" action="{{ route('admin.appointments.index') }}" id="searchForm">
                <div class="row row-cols-lg-2 row-cols-md-2 row-cols-sm-1 align-items-center my-2" style="margin-right: -3%;">
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
                        <label class="btn btn-outline-primary" for="btnradio1">Radio 1</label>
                      
                        <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio2">Radio 2</label>
                      
                        <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btnradio3">Radio 3</label>
                      </div>
                    <div class="row align-items-center">
                        <div class="col-sm">
                            <input type="text" class="form-control fw-bold border-dark" id="search" name="search" value="{{ request()->input('search') }}" placeholder="Search...">
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
                        <div class="col-lg-5">
                            <select id="service" name="service" class="form-select fw-bold border-dark">
                                <option selected="selected" disabled="disabled" value="">SERVICE AVAILED</option>
                                <option value="ALL">ALL</option>
                                <option value="medcert">Medical Certificate</option>
                                <option value="OPD">OPD Consultant</option>
                                <option value="OTHERS">Others</option>
                                <option value="REINSTATEMENT">Reinstatement</option>
                                <option value="SICKLEAVE">Sick Leave</option>
                                <option value="NEWLYHIRED">Newly Hired</option>
                            </select>
                        </div>
                    </div>
                </div>
        </form>
        <div class="table-responsive" id="studentsList">
            <table class="table table-bordered table-sm">
                <caption style="user-select: none;">Appointments History</caption>
                <thead>
                    <tr class="text-center">
                        <th class="col-md-3 col-sm-3 custom-col-id border border-dark border-end-0">
                            <span class="fs-4 font-monospace fw-bold">TICKET ID</span>
                        </th>
                        <th class="col-md-3 col-sm-3 border border-dark border-end-0">
                            <span class="fs-4 font-monospace fw-bold">NAME</span>
                        </th>
                        <th class="col-md-3 col-sm-3 border border-dark border-end-0">
                            <span class="fs-4 font-monospace fw-bold">Date & Time</span>
                        </th>
                        <th class="col-md-3 col-sm-3 border border-dark">
                            <span class="fs-4 font-monospace fw-bold">Services Availed</span>
                        </th>
                        <th class="col-md-3 col-sm-3 border border-dark">
                            <span class="fs-4 font-monospace fw-bold">Description</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($students as $student)
                        <tr class="text-center divHover" onClick="window.open('{{ route('admin.medicalPatientRecord.show', ['patientID' => $student->student_id_number ? $student->student_id_number : $student->applicant_id_number]) }}', '_blank'); return false;">
                            <td class="col-md-3 col-sm-3 border border-dark border-end-0 custom-col-id">
                                <div class="d-flex flex-row justify-content-center">
                                    <div class="col-sm">
                                        <p class="fs-5 fw-normal lessBottomMargin"><span class="font-monospace">#</span>{{ $student->applicant_id_number }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="col-md-3 col-sm-3 border border-dark border-end-0">
                                <p class="fs-5 fw-normal mt-2">{{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }}</p>
                            </td>
                            @if (isset($prof->medicalRecord))
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
        </div>
        

    <div class="table-responsive" id="personnelList" style="display: none;">
        <table class="table table-bordered table-sm">
            <caption style="user-select: none;">Personnel Health Records List</caption>
            <thead>
                <tr class="text-center">
                    <th class="col-md-2 col-sm-3 custom-col-id border border-dark border-end-0">
                        <span class="fs-4 font-monospace fw-bold">ID</span>
                    </th>
                    <th class="col-md-4 col-sm-3 border border-dark border-end-0">
                        <span class="fs-4 font-monospace fw-bold">NAME</span>
                    </th>
                    <th class="col-md-2 col-sm-3 border border-dark border-end-0">
                        <span class="fs-4 font-monospace fw-bold">DESIGNATION</span>
                    </th>
                    <th class="col-md-2 col-sm-3 border border-dark border-end-0">
                        <span class="fs-4 font-monospace fw-bold">UNIT/DEPARTMENT</span>
                    </th>
                    <th class="col-md-2 col-sm-3 border border-dark">
                        <span class="fs-4 font-monospace fw-bold">CAMPUS</span>
                    </th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($personnel as $prof)
                    <tr class="text-center divHover" onClick="window.open('{{ route('admin.personnelMedForm.show', ['patientID' => $prof->personnel_id_number ]) }}', '_blank'); return false;">
                        <td class="col-md-2 col-sm-3 border border-dark border-end-0 custom-col-id">
                            <p class="fs-5 fw-normal lessBottomMargin">{{ $prof->personnel_id_number }}</p>
                        </td>
                        <td class="col-md-4 col-sm-3 border border-dark border-end-0">
                            <p class="fs-5 fw-normal mt-2">{{ $prof->first_name }} {{ $prof->middle_name }} {{ $prof->last_name }}</p>
                        </td>
                        @if (isset($prof->medicalRecordPersonnel))
                            <td class="col-md-2 col-sm-3 border border-dark">
                                <p class="fs-5 fw-normal mt-2">{{ $prof->medicalRecordPersonnel->designation }}</p>
                            </td>
                            <td class="col-md-2 col-sm-3 border border-dark">
                                <p class="fs-5 fw-normal mt-2">{{ $prof->medicalRecordPersonnel->unitDepartment }}</p>
                            </td>
                            <td class="col-md-2 col-sm-3 border border-dark">
                                <p class="fs-5 fw-normal mt-2">{{ $prof->medicalRecordPersonnel->campus }}</p>
                            </td>
                        @else
                            <td class="col-md-2 col-sm-3 border border-dark">
                                <p class="fs-5 fw-normal mt-2">{{ $prof->designation }}</p>
                            </td>
                            <td class="col-md-2 col-sm-3 border border-dark">
                                <p class="fs-5 fw-normal mt-2">{{ $prof->unitDepartment }}</p>
                            </td>
                            <td class="col-md-2 col-sm-3 border border-dark">
                                <p class="fs-5 fw-normal mt-2">{{ $prof->campus }}</p>
                            </td>
                        @endif
                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        const filterSelect = document.querySelector('#campusSelect');
        filterSelect.addEventListener('change', filterTable);

        function filterTable() {
            $('#searchForm').submit();
        }
    </script>
@endsection