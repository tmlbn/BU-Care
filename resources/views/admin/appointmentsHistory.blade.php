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
<div class="container-fluid bg-custom text-dark p-5" style="min-height:900px;">
    <div class="col-md-12 p-3 text-decoration-none d-print-none">    
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


    <div class="d-flex flex-row">
        <div class="col-sm border p-3 border-dark">
            <header class="text-center">
                <h5 class="display-7 pt-3">
                    <p class="fs-2 fw-bold">Bicol University Health Services</p>
                    <p class="fs-4 fw-normal" id="bannerStudent">Appointments History</p>
            </header>
        </div>
    </div>

    <!-- Search function -->
        <form method="GET" action="{{ route('admin.appointmentsHistory.show') }}" id="searchForm">
                <div class="row row-cols-lg-2 row-cols-md-2 row-cols-sm-1 align-items-center my-2 d-print-none" style="margin-right: -3%;">
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
                            <select id="status" name="status" class="form-select fw-bold border-dark">
                                <option selected="selected" disabled="disabled" value="">STATUS</option>
                                <option value="ALL" {{ $status && $status == 'ALL' || (!$status) ? 'selected' : '' }}>ALL</option>
                                <option value="RELEASED" {{ $status && $status == 'RELEASED' ? 'selected' : '' }}>RELEASED</option>
                                <option value="COMPLETED" {{ $status && $status == 'COMPLETED' ? 'selected' : '' }}>COMPLETED BUT NOT RELEASED</option>
                                <option value="SCHEDULED" id="scheduledStatus" {{ $status && $status == 'SCHEDULED' ? 'selected' : '' }}>SCHEDULED</option>
                                <option value="CANCELLED or NO-SHOW" {{ $status && $status == 'CANCELLED or NO-SHOW' ? 'selected' : '' }}>CANCELLED or NO-SHOW</option>
                            </select>
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
                    <div class="col-sm-3 d-flex justify-content-end dropdown align-self-start">
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
                </div>
                <script>
                    $(document).ready(function(){
                        var filterBy = '<?php echo $filterBy ?>';
                        var status = '<?php echo $status ?>';
                        var month = '<?php echo $byMonth ?>';

                        if(!month){
                            $('input[name="timely"][value="' + filterBy + '"]').prop('checked', true);
                        }
                        $('input[name="timely"]').on('change', function(){
                            $('#searchForm').submit();
                        });

                        $('select[name="status"]').on('change', function(){
                            $('#searchForm').submit();
                        });

                        if($('#past').is(':checked')){
                            $('#scheduledStatus').attr('disabled', true);
                        }
                        else{
                            $('#scheduledStatus').attr('disabled', false);
                        }
                    });
                    function filterByMonth($this) {
                            $('#month').val($this.value);
                            $('#searchForm').submit();
                        }
                </script>
        </form>
        <div class="table-responsive" id="studentsList">
            <table class="table table-bordered table-sm mt-3">
                <caption style="user-select: none;">Appointments History</caption>
                <thead>
                    <tr class="text-center">
                        <th class="col-md-3 col-sm-3 custom-col-id border border-dark border-end-0">
                            <span class="fs-4 font-monospace fw-bold">TICKET ID</span>
                        </th>
                        <th class="col-md-3 col-sm-3 border border-dark border-end-0">
                            <span class="fs-4 font-monospace fw-bold">NAME</span>
                        </th>
                        <th class="col-md-2 col-sm-3 border border-dark border-end-0">
                            <span class="fs-4 font-monospace fw-bold">Date & Time</span>
                        </th>
                        <th class="col-md-2 col-sm-3 border border-dark">
                            <span class="fs-4 font-monospace fw-bold">Services Availed</span>
                        </th>
                        <th class="col-md-3 col-sm-3 border border-dark">
                            <span class="fs-4 font-monospace fw-bold">Description</span>
                        </th>
                        <th class="col-md-3 col-sm-3 border border-dark">
                            <span class="fs-4 font-monospace fw-bold">Status</span>
                        </th>
                    </tr>
                </thead>
                    @php
                        $counter = 0;
                    @endphp
                <tbody class="table-group-divider">
                    @foreach ($entries as $entry)
                    @php
                        $counter++;
                    @endphp
                    @if($entry->usersStudent && $entry->MPRstudent)
                        <tr class="text-center divHover" onClick="window.open('{{ route('admin.medicalPatientRecord.show', ['patientID' => $entry->usersStudent->student_id_number ?: $entry->usersStudent->applicant_id_number, 'ticket_id' => $entry->ticket_id ?? null]) }}', '_blank'); return false;">
                    @elseif($entry->usersStudent)
                        <tr class="text-center divHover" onClick="window.open('{{ route('admin.studentMedForm.show', ['patientID' => $entry->usersStudent->student_id_number ?: $entry->usersStudent->applicant_id_number, 'ticket_id' => $entry->ticket_id ?? null]) }}', '_blank'); return false;">
                    @elseif($entry->usersPersonnel && $entry->MPRpersonnel)
                        <tr class="text-center divHover" onClick="window.open('{{ route('admin.medicalPatientRecord.show', ['patientID' => $entry->usersPersonnel->personnel_id_number, 'ticket_id' => $entry->ticket_id ?? null]) }}', '_blank'); return false;">
                    @elseif($entry->usersPersonnel)
                        <tr class="text-center divHover" onClick="window.open('{{ route('admin.personnelMedForm.show', ['patientID' => $entry->usersPersonnel->personnel_id_number, 'ticket_id' => $entry->ticket_id ?? null]) }}', '_blank'); return false;">
                    @endif
                            <td class="col-md-3 col-sm-3 border border-dark border-end-0 custom-col-id">
                                <div class="d-flex flex-row justify-content-center">
                                    <div class="col-sm">
                                        <p class="fs-5 fw-normal lessBottomMargin"><span class="font-monospace">{{ $counter }}. &nbsp;{{ $entry->ticket_id }}</span></p>
                                    </div>
                                </div>
                            </td>
                            @if ($entry->usersStudent)
                                <td class="col-md-3 col-sm-3 border border-dark border-end-0">
                                    <p class="fs-5 fw-normal mt-2">{{ $entry->usersStudent->first_name }} {{ $entry->usersStudent->middle_name }} {{ $entry->usersStudent->last_name }}
                                        @if($entry->released)
                                            <i class="bi bi-clipboard-check-fill icon fs-4" style="color:#f1731f;" data-toggle="tooltip" data-container="body" data-bs-placement="top" title="Medical Certificate Released"></i>
                                        @endif
                                    </p>
                                </td>
                            @elseif ($entry->usersPersonnel)
                            <td class="col-md-3 col-sm-3 border border-dark border-end-0">
                                <p class="fs-5 fw-normal mt-2">{{ $entry->usersPersonnel->first_name }} {{ $entry->usersPersonnel->middle_name }} {{ $entry->usersPersonnel->last_name }}
                                    @if($entry->released)
                                        <i class="bi bi-clipboard-check-fill icon fs-4" style="color:#f1731f;" data-toggle="tooltip" data-container="body" data-bs-placement="top" title="Medical Certificate Released"></i>
                                    @endif
                                </p>
                            </td>
                            @endif
                            @php
                                $date = new DateTime($entry->appointmentDate);
                                $time = DateTime::createFromFormat('H:i:s', $entry->appointmentTime);
                                // Format date as "Y F d" (e.g. "2023 April 24")
                                $formattedDate = $date->format('Y F d');
                                // Format time as "g:i A" (e.g. "8:00 AM")
                                $formattedTime = $time->format('g:i A');
                            @endphp
                            <td class="col-md-2 col-sm-3 border border-dark border-end-0">
                                <p class="fs-5 fw-normal mt-2">{{ $formattedDate }} @ {{ $formattedTime }}</p>
                            </td>
                                <td class="col-md-2 col-sm-3 border border-dark border-end-0">
                                    <p class="fs-5 fw-normal mt-2">{{ $entry->services ?: $entry->others }}</p>
                                </td>
                                <td class="col-md-3 col-sm-3 border border-dark">
                                    <p class="fs-5 fw-normal mt-2">{{ $entry->appointmentDescription }}</p>
                                </td>
                                <td class="col-md-3 col-sm-3 border border-dark" style="background-color: {{ ($entry->status == 'SCHEDULED' ? '' : ($entry->released ? 'rgba(92, 184, 92, 0.7)' : ($entry->status == 'COMPLETED' ? 'rgba(91, 192, 222, 0.7)' : 'rgba(220, 53, 69, 0.7)'))) }};">
                                    <p class="fs-5 fw-normal mt-2" >@if($entry->released) Medical Certificate Released @else {{ $entry->status }} @endif</p>
                                </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $entries->links() }}
@endsection