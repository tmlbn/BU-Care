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
    <div class="col-md-12 p-3 text-decoration-none">    
        <div class="col-md-12 p-3 text-decoration-none d-print-none">    
            <div class="btn-group col-md-12" role="group" aria-label="Reports radio button group">
                <input type="radio" class="btn-check col-3" name="btnradio" id="btnradio1" autocomplete="off" onclick="redirectToStudentMedFormList()" {{ Route::currentRouteName() === 'admin.patientMedFormList.show' || Str::contains(url()->current(), '/admin/studentMedFormList/') ? 'checked' : '' }}>
                <label class="btn btn-outline-primary" for="btnradio1">STUDENT HEALTH RECORDS</label>
        
                <input type="radio" class="btn-check col-3" name="btnradio" id="btnradio2" autocomplete="off" onclick="redirectToPersonnelMedFormList()" {{ Route::currentRouteName() === 'admin.personnelMedFormList.show' || Str::contains(url()->current(), '/admin/personnelMedFormList/') ? 'checked' : '' }}>
                <label class="btn btn-outline-primary" for="btnradio2">PERSONNEL HEALTH RECORDS</label>
            
                <input type="radio" class="btn-check col-3" name="btnradio" id="btnradio3" autocomplete="off" onclick="redirectToMedPatientRecords()" {{ Route::currentRouteName() === 'admin.medPatientRecords.show' || Str::contains(url()->current(), '/admin/medical-patient-records-list') ? 'checked' : '' }}>
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
    <div class="col-xl-2 col-lg-12 my-2 d-print-none">
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
                    $('#personnelList').hide();
                }
                else{
                    $('#studentsList').hide();
                    $('#personnelList').show();
                }
            })
        })
    </script>
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
                <div class="row row-cols-lg-2 row-cols-md-2 row-cols-sm-1 align-items-center my-2 d-print-none" style="margin-right: -3%;">
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
                            <select id="campusFilter" name="campusFilter" class="form-select">
                                <option value="TODAY">Today</option>
                                <option value="MOTNH" class="alternate">Month</option>
                                <option value="YEAR">Year</option>
                            </select>
                        </div>
                    </div>
                </form>
                <form method="GET" action="{{ route('admin.medicalPatientRecord.filterDate') }}" id="filterByDate">
                    <div class="row align-items-center">
                        <div class="col-sm">
                            <input type="text" class="form-control" id="date" name="date" onkeydown="return false;">
                        </div>
                        <div class="col-sm">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </div>
            </form>
                    <script>
                       $(document).ready(function() {
                            let today = new Date();
                            let year = today.getFullYear().toString();
                            let month = today.toLocaleString('default', { month: 'short' });
                            let day = today.getDate().toString().padStart(2, '0');
                            let formatted_today = year + ' ' + month + ' ' + day;
                            $("#date").val(formatted_today);

                            console.log(formatted_today);

                            $("#date").datepicker({
                                changeMonth: true,
                                changeYear: true,
                                dateFormat: 'yy MM dd',
                                showButtonPanel: true,
                                yearRange: "2023:c",
                                showAnim: 'slideDown',
                                defaultDate: formatted_today // Set the initial date value here
                            });
                        });
                    </script>
                    
        

    <script>
        $searchQuery = '';
        if (isset($_GET['search'])) {
            $searchQuery = $_GET['search'];
        }
    </script>
      
        <table id="studentsList" name="studentsList" class="table table-striped table-bordered border-dark table-hover mt-3">       
            <caption>Medical Patient Records</caption>       
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Temperature</th>
                    <th>Blood Pressure</th>
                    <th>Diagnosis</th>
                    <th>Treatment/Medications</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $counter = 0;
                @endphp
                @foreach($medicalPatientRecordsStudents as $record)
                @php
                    $counter++;
                @endphp
                    <tr class="hover" onclick="window.location.href='{{ route('admin.medicalPatientRecord.show', ['patientID' => $record->MPRstudent->student_id_number ? $record->MPRstudent->student_id_number : $record->MPRstudent->applicant_id_number]) }}';">
                        <td contenteditable="false" style="max-width: 120px;">{{ $counter }}. &nbsp;{{ date('d-F-Y', strtotime($record->date_of_exam)) }}</td>
                        <td contenteditable="false" style="max-width: 140px;">{{ $record->MPRstudent->first_name }} {{ $record->MPRstudent->middle_name }} {{ $record->MPRstudent->last_name }}</td>
                        <td contenteditable="false" style="max-width: 120px;">{{ $record->MPRstudent->medicalRecord->course }}</td>
                        <td contenteditable="false" style="max-width: 40px;">{{ $record->temperature }}</td>
                        <td contenteditable="false" style="max-width: 40px;">{{ $record->bloodPressure }}</td>
                        <td contenteditable="false" style="max-width: 200px;">{{ htmlspecialchars_decode($record->historyAndPhysicalExamination) }}</td>
                        <td contenteditable="false" style="max-width: 200px;">{{ htmlspecialchars_decode($record->physicianDirections) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table id="personnelList" name="personnelList" class="table table-striped table-bordered border-dark table-hover" style="display: none;">       
            <caption>Medical Patient Records</caption>       
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Temperature</th>
                    <th>Blood Pressure</th>
                    <th>Diagnosis</th>
                    <th>Treatment/Medications</th>
                </tr>
            </thead>
            <tbody>
                @foreach($medicalPatientRecordsPersonnel as $record)
                    <tr class="hover" onclick="window.location.href='{{ route('admin.medicalPatientRecord.show', ['patientID' => $record->MPRpersonnel->student_id_number ? $record->MPRpersonnel->student_id_number : $record->MPRpersonnel->applicant_id_number]) }}';">
                        <td contenteditable="false" style="max-width: 120px;">{{ date('d-F-Y', strtotime($record->date_of_exam)) }}</td>
                        <td contenteditable="false" style="max-width: 140px;">{{ $record->MPRpersonnel->first_name }} {{ $record->MPRpersonnel->middle_name }} {{ $record->MPRpersonnel->last_name }}</td>
                        <td contenteditable="false" style="max-width: 120px;">{{ $record->MPRpersonnel->medicalRecord->course }}</td>
                        <td contenteditable="false" style="max-width: 40px;">{{ $record->temperature }}</td>
                        <td contenteditable="false" style="max-width: 40px;">{{ $record->bloodPressure }}</td>
                        <td contenteditable="false" style="max-width: 200px;">{{ htmlspecialchars_decode($record->historyAndPhysicalExamination) }}</td>
                        <td contenteditable="false" style="max-width: 200px;">{{ htmlspecialchars_decode($record->physicianDirections) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

</div> 
@endsection
