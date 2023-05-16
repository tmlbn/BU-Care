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
    .month-toggle{
        color: #0275d8 !important;
    }
    .month-toggle.show{
        color: white !important;
    }
    .month-toggle:hover{
        color: white !important;
    }
</style>

@csrf
<!-- Header -->
<div class="container-fluid bg-custom text-dark p-5">
    <div class="col-md-12 p-3 text-decoration-none">    
        <div class="col-md-12 p-3 text-decoration-none d-print-none d-print-none">    
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
    @php
    if(isset($byMonth)){
        if($byMonth == '1'){
            $byMonth = 'JANUARY';
        } elseif($byMonth == '2'){
            $byMonth = 'FEBRUARY';
        } elseif($byMonth == '3'){
            $byMonth = 'MARCH';
        } elseif($byMonth == '4'){
            $byMonth = 'APRIL';
        } elseif($byMonth == '5'){
            $byMonth = 'MAY';
        } elseif($byMonth == '6'){
            $byMonth = 'JUNE';
        } elseif($byMonth == '7'){
            $byMonth = 'JULY';
        } elseif($byMonth == '8'){
            $byMonth = 'AUGUST';
        } elseif($byMonth == '9'){
            $byMonth = 'SEPTEMBER';
        } elseif($byMonth == '10'){
            $byMonth = 'OCTOBER';
        } elseif($byMonth == '11'){
            $byMonth = 'NOVEMBER';
        } elseif($byMonth == '12'){
            $byMonth = 'DECEMBER';
        }
    }
    $monthNow = strtoupper(date('F'));
                                
    @endphp

    <!-- Search function -->
            <form method="GET" action="{{ route('admin.medPatientRecordList.show') }}" id="searchForm">
                <div class="row row-cols-lg-2 row-cols-md-2 row-cols-sm-1 align-items-center my-2 d-print-none" style="margin-right: -3%;">
                    <div class="row align-items-center">
                        <div class="col-sm">
                            <input type="text" class="form-control" id="search" name="search" value="{{ request()->input('search') }}" placeholder="Search by Name or ID">
                        </div>
                        <div class="col-sm">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-between">
                    <div class="col-sm-3 btn-group mb-3 d-print-none" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="timely" id="today" autocomplete="off" value="today">
                        <label class="btn btn-outline-primary" for="today">Today</label>
            
                        <input type="radio" class="btn-check" name="timely" id="thisWeek" autocomplete="off" value="thisWeek">
                        <label class="btn btn-outline-primary" for="thisWeek">This Week</label>

                        <input type="radio" class="btn-check" name="timely" id="thisMonth" autocomplete="off" value="thisMonth">
                        <label class="btn btn-outline-primary" for="thisMonth">This Month</label>
                    </div>
                    <div class="col-sm-3 d-flex justify-content-end dropdown align-self-start d-print-none">
                        <button class="btn btn-outline-primary dropdown-toggle month-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ isset($byMonth) ? $byMonth : $monthNow }}
                        </button>
                        <ul class="dropdown-menu">
                            <li><button class="dropdown-item {{ isset($byMonth) && $byMonth == 'JANUARY' || !isset($byMonth) && $monthNow == 'JANUARY' ? 'active' : '' }}" type="button" value="1" onclick="filterByMonth(this);">JANUARY</button></li>
                            <li><button class="dropdown-item {{ isset($byMonth) && $byMonth == 'FEBRUARY' || !isset($byMonth) && $monthNow == 'FEBRUARY' ? 'active' : '' }}" type="button" value="2" onclick="filterByMonth(this);">FEBRUARY</button></li>
                            <li><button class="dropdown-item {{ isset($byMonth) && $byMonth == 'MARCH' || !isset($byMonth) && $monthNow == 'MARCH' ? 'active' : '' }}" type="button" value="3" onclick="filterByMonth(this);">MARCH</button></li>
                            <li><button class="dropdown-item {{ isset($byMonth) && $byMonth == 'APRIL' || !isset($byMonth) && $monthNow == 'APRIL' ? 'active' : '' }}" type="button" value="4" onclick="filterByMonth(this);">APRIL</button></li>
                            <li><button class="dropdown-item {{ isset($byMonth) && $byMonth == 'MAY' || !isset($byMonth) && $monthNow == 'MAY' ? 'active' : '' }}" type="button" value="5" onclick="filterByMonth(this);">MAY</button></li>
                            <li><button class="dropdown-item {{ isset($byMonth) && $byMonth == 'JUNE' || !isset($byMonth) && $monthNow == 'JUNE' ? 'active' : '' }}" type="button" value="6" onclick="filterByMonth(this);">JUNE</button></li>
                            <li><button class="dropdown-item {{ isset($byMonth) && $byMonth == 'JULY' || !isset($byMonth) && $monthNow == 'JULY' ? 'active' : '' }}" type="button" value="7" onclick="filterByMonth(this);">JULY</button></li>
                            <li><button class="dropdown-item {{ isset($byMonth) && $byMonth == 'AUGUST' || !isset($byMonth) && $monthNow == 'AUGUST' ? 'active' : '' }}" type="button" value="8" onclick="filterByMonth(this);">AUGUST</button></li>
                            <li><button class="dropdown-item {{ isset($byMonth) && $byMonth == 'SEPTEMBER' || !isset($byMonth) && $monthNow == 'SEPTEMBER' ? 'active' : '' }}" type="button" value="9" onclick="filterByMonth(this);">SEPTEMBER</button></li>
                            <li><button class="dropdown-item {{ isset($byMonth) && $byMonth == 'OCTOBER' || !isset($byMonth) && $monthNow == 'OCTOBER' ? 'active' : '' }}" type="button" value="10" onclick="filterByMonth(this);">OCTOBER</button></li>
                            <li><button class="dropdown-item {{ isset($byMonth) && $byMonth == 'NOVEMBER' || !isset($byMonth) && $monthNow == 'NOVEMBER' ? 'active' : '' }}" type="button" value="11" onclick="filterByMonth(this);">NOVEMBER</button></li>
                            <li><button class="dropdown-item {{ isset($byMonth) && $byMonth == 'DECEMBER' || !isset($byMonth) && $monthNow == 'DECEMBER' ? 'active' : '' }}" type="button" value="12" onclick="filterByMonth(this);">DECEMBER</button></li>
                        </ul>
                    </div>
                    <input type="hidden" name="month" id="month">
                </form>
            </div>
                    <script>
                        $(document).ready(function(){
                            var filterBy = '<?php echo $filterBy ?>';
                            var month = '<?php echo $byMonth ?>';
                            console.log(filterBy);

                            if(!month){
                                $('input[name="timely"][value="' + filterBy + '"]').prop('checked', true);
                            }
                            $('input[name="timely"]').on('change', function(){
                                $('#searchForm').submit();
                            });

                            $('select[name="status"]').on('change', function(){
                                $('#searchForm').submit();
                            });
                        });
                        function filterByMonth($this) {
                                $('#month').val($this.value);
                                $('#searchForm').submit();
                            }
                    </script>
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

                        $('#Date').on('click', function(event){
                            event.preventDefault();
                            $("#date").datepicker('show');
                        });
                    </script>

    <script>
        $searchQuery = '';
        if (isset($_GET['search'])) {
            $searchQuery = $_GET['search'];
        }
    </script>
      
        <table id="studentsList" name="studentsList" class="table table-striped table-bordered border-dark table-hover mt-3 mx-auto">       
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
