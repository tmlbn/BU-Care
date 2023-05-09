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
                            <select id="campusSelect" name="campusSelect" class="form-select fw-bold border-dark">
                                <option selected="selected" disabled="disabled" value="">STATUS</option>
                                <option value="RELEASED">RELEASED</option>
                                <option value="COMPLETED">COMPLETED</option>
                                <option value="SCHEDULED">SCHEDULED</option>
                                <option value="CANCELED-NOSHOW">CANCELED/NO-SHOW</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="btn-group mb-3 d-print-none" role="group" aria-label="Basic radio toggle button group">
                    <input type="radio" class="btn-check" name="timely" id="past" autocomplete="off">
                    <label class="btn btn-outline-primary" for="past">Past</label>

                    <input type="radio" class="btn-check" name="timely" id="today" autocomplete="off" checked>
                    <label class="btn btn-outline-primary" for="today">Today</label>

                    <input type="radio" class="btn-check" name="timely" id="thisWeek" autocomplete="off">
                    <label class="btn btn-outline-primary" for="thisWeek">This Week</label>
                    
                    <input type="radio" class="btn-check" name="timely" id="thisMonth" autocomplete="off">
                    <label class="btn btn-outline-primary" for="thisMonth">This Month</label>
                </div>
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
                                        @if($entry->usersStudent->medicalRecordAdmin && $entry->usersStudent->medicalRecordAdmin->released)
                                            <i class="bi bi-clipboard-check-fill icon fs-4" style="color:#f1731f;" data-toggle="tooltip" data-container="body" data-bs-placement="top" title="Medical Certificate Released"></i>
                                        @endif
                                    </p>
                                </td>
                            @elseif ($entry->usersPersonnel)
                            <td class="col-md-3 col-sm-3 border border-dark border-end-0">
                                <p class="fs-5 fw-normal mt-2">{{ $entry->usersPersonnel->first_name }} {{ $entry->usersPersonnel->middle_name }} {{ $entry->usersPersonnel->last_name }}
                                    @if($entry->usersPersonnel->medicalRecord_admin && $entry->usersPersonnel->medicalRecord_admin->released)
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