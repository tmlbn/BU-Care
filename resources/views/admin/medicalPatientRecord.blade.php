@extends('admin.layouts.app')

@section('content')
<style>
     body{
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        background-image: url({{ asset('media/RegistrationBG.jpg') }});
    }
</style>

@section('content')

<!-- Set timezone to Philippines -->
<?php
    date_default_timezone_set('Asia/Manila');
?>

    <div class="container my-2 bg-light w-20 text-dark p-5 headMargin checkboxes">
        <div class="row g-3 pt-2">
            <div class="d-flex justify-content-center">  
                <div class="col border border-dark">
                    <header class="text-center">
                        <h1 class="pt-1">MEDICAL PATIENT RECORD</h1>
                    </header>    
                </div>
            </div>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @php
        if(isset($fromAppointment)){
            echo  '<input type="hidden" name="fromAppointment" value="'.$fromAppointment.'">';
            echo  '<input type="hidden" name="ticketID" value="'. $ticketID .'">';
        }
    @endphp
            <div class="col-md-3">
                <p class="h6">Campus</p>
                <input type="text" class="form-control-plaintext border-bottom border-dark border-top-0 mb-0 pb-0 fs-5 fw-bold" id="campusSelect" name="MPR_campusSelect" value="{{ $patient->medicalRecord->campus }}" readonly>
            </div>
            <div class="col-md-3">
                <p class="h6">Course</p>
                <input type="text" class="form-control-plaintext border-bottom border-dark border-top-0 mb-0 pb-0 fs-5 fw-bold" id="courseSelect" name="MPR_courseSelect" value="{{ $patient->medicalRecord->course }}" readonly>
            </div> 
        
            <div class="d-flex flex-row">
            </div>
            <div class="col-md-3">
                <label for="MPR_lastName" class="form-label h6">Last Name</label>
                <input type="text" class="form-control-plaintext border-bottom border-dark border-top-0 mb-0 pb-0 fs-5 fw-bold" id="MPR_lastName" name="MPR_lastName" value="{{ $patient->medicalRecord->last_name }}" readonly>
            </div>
            <div class="col-md-3">
                <label for="MPR_firstName" class="form-label h6">First Name</label>
                <input type="text" class="form-control-plaintext border-bottom border-dark border-top-0 mb-0 pb-0 fs-5 fw-bold" id="MPR_firstName" name="MPR_firstName" value="{{ $patient->medicalRecord->first_name }}" readonly>
            </div>
            <div class="col-md-3">
                <label for="MPR_middleName" class="form-label h6">Middle Name</label>
                <input type="text" class="form-control-plaintext border-bottom border-dark border-top-0 mb-0 pb-0 fs-5 fw-bold" id="MPR_middleName" name="MPR_middleName" value="{{ $patient->medicalRecord->middle_name }}" readonly>
            </div>
            <div class="col-md-3">
                <label for="MPR_birthday" class="form-label h6">Birthday</label>
                <input type="text" class="form-control-plaintext border-bottom border-dark border-top-0 mb-0 pb-0 fs-5 fw-bold" id="MPR_birthday" name="MPR_birthday" value="{{ $patient->birth_month }}/{{ $patient->birth_date }}/{{ $patient->birth_year }}" readonly>
            </div>
            <div class="col-md-9">
                <label for="MPR_address" class="form-label h6">Address</label>
                <input type="text" class="form-control-plaintext border-bottom border-dark border-top-0 mb-0 pb-0 fs-5 fw-bold" id="MPR_address" name="MPR_address" value="{{ $patient->medicalRecord->houseNumberStName }}, {{ $patient->medicalRecord->barangaySubdVillage }}, {{ $patient->medicalRecord->cityMunicipality }}, {{ $patient->medicalRecord->province }}, {{ $patient->medicalRecord->region }}" readonly>
            </div>
            <div class="col-md-3">
                <label for="MPR_religion" class="form-label h6">Religion</label>
                <input type="text" class="form-control-plaintext border-bottom border-dark border-top-0 mb-0 pb-0 fs-5 fw-bold" id="MPR_religion" name="MPR_religion" value="{{ $patient->medicalRecord->religion }}" readonly>
            </div>
            <div class="col-md-3">
                <label for="MPR_contact" class="form-label">Contact Number(s)</label>
                <input type="text" class="form-control-plaintext border-bottom border-dark border-top-0 mb-0 pb-0 fs-5 fw-bold" id="contact" name="contact" value="0{{ $patient->medicalRecord->studentContactNumber }}" readonly>
            </div>
            <div class="col-md-3">
                <label for="MPR_civilStatus" class="form-label">Civil Status</label>
                <input type="text" class="form-control-plaintext border-bottom border-dark border-top-0 mb-0 pb-0 fs-5 fw-bold" id="MPR_civilStatus" name="MPR_civilStatus" value="{{ $patient->medicalRecord->civilStatus }}" readonly>
            </div>
            <div class="col-md-3">
                <label for="MPR_sex" class="form-label">Sex</label>
                <input type="text" class="form-control-plaintext border-bottom border-dark border-top-0 mb-0 pb-0 fs-5 fw-bold" id="MPR_sex" name="MPR_sex" value="{{ $patient->medicalRecord->sex }}" readonly>
            </div>
            <div class="col-md-3">
                <label for="MPR_age" class="form-label">Age</label>
                <input type="text" class="form-control-plaintext border-bottom border-dark border-top-0 mb-0 pb-0 fs-5 fw-bold" id="MPR_age" name="MPR_age" value="{{ $patient->medicalRecord->age }}" readonly>
            </div>
                <span class="h5 mt-4" style="margin-bottom: -1%;">Parents</span>
            <div class="col-md-4">
                <label for="MPR_fatherName" class="form-label">Father's Name</label>
                <input type="text" class="form-control-plaintext border-bottom border-dark border-top-0 mb-0 pb-0 fs-5 fw-bold" id="MPR_fatherName" name="MPR_fatherName" value="{{ $patient->medicalRecord->fatherName }}" readonly>
            </div>
            <div class="col-md-4">
                <label for="MPR_fatherOffice" class="form-label">Office Address</label>
                <input type="text" class="form-control-plaintext border-bottom border-dark border-top-0 mb-0 pb-0 fs-5 fw-bold" id="MPR_fatherOffice" name="MPR_fatherOffice" value="{{ htmlspecialchars_decode($patient->medicalRecord->fatherOfficeAddress) }}" readonly>
            </div>
            <div class="col-md-4">
                <label for="MPR_fatherContact" class="form-label">Contact Number</label>
                <input type="text" class="form-control-plaintext border-bottom border-dark border-top-0 mb-0 pb-0 fs-5 fw-bold" id="MPR_fatherContact" name="MPR_fatherContact" value="0{{ $patient->medicalRecord->parentGuardianContactNumber }}" readonly>
            </div>
            <div class="col-md-4">
                <label for="MPR_motherName" class="form-label">Mother's Name</label>
                <input type="text" class="form-control-plaintext border-bottom border-dark border-top-0 mb-0 pb-0 fs-5 fw-bold" id="MPR_motherName" name="MPR_motherName" value="{{ $patient->medicalRecord->motherName }}" readonly>
            </div>
            <div class="col-md-4">
                <label for="MPR_motherOffice" class="form-label">Office Address</label>
                <input type="text" class="form-control-plaintext border-bottom border-dark border-top-0 mb-0 pb-0 fs-5 fw-bold" id="MPR_motherOffice" name="MPR_motherOffice" value="{{ htmlspecialchars_decode($patient->medicalRecord->motherOfficeAddress) }}" readonly>
            </div>
            <div class="col-md-4">
                <label for="MPR_motherContact" class="form-label">Contact Number</label>
                <input type="text" class="form-control-plaintext border-bottom border-dark border-top-0 mb-0 pb-0 fs-5 fw-bold" id="MPR_motherContact" name="MPR_motherContact" value="0{{ $patient->medicalRecord->parentGuardianContactNumber }}" readonly>
            </div>
                <span class="h5 mt-4" style="margin-bottom: -1%;">Incase of Emergency please notify</span>
            <div class="col-md-6">
                <label for="MPR_emergencyName" class="form-label">Name</label>
                <input type="text" class="form-control-plaintext border-bottom border-dark border-top-0 mb-0 pb-0 fs-5 fw-bold" id="MPR_emergencyName" name="MPR_emergencyName" value="{{ $patient->medicalRecord->emergencyContactName }}" readonly>
            </div>
            <div class="col-md-6">
                <label for="MPR_emergencyContact" class="form-label">Contact Number</label>
                <input type="text" class="form-control-plaintext border-bottom border-dark border-top-0 mb-0 pb-0 fs-5 fw-bold" id="MPR_emergencyContact" name="MPR_emergencyContact" value="0{{ $patient->medicalRecord->emergencyContactNumber }}" readonly>
            </div>
        </div>
            <form method="POST" action="{{ route('admin.medicalPatientRecord.store') }}" enctype="multipart/form-data">
             @csrf
        <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
            <header class="text-center">
                <!-- LINE BREAK -->
            </header>
        </section>

        <div class="d-flex justify-content-center pt-3">  
            <div class="col border border-dark">
                <header class="text-center">
                    <h1 class="pt-1">EXAMINATIONS</h1>
                </header>    
            </div>
        </div>
        <div class="table-responsive">
            
            <table id="data_table" name="data_table" class="table table-striped table-bordered border-dark table-hover">       
                <caption>Medical Patient Record of {{ $patient->medicalRecord->first_name }} {{ $patient->medicalRecord->middle_name }} {{ $patient->medicalRecord->last_name }}</caption>       
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Temperature</th>
                        <th>Blood Pressure</th>
                        <th>Weight</th>
                        <th>Height</th>
                        <th>History and Physical Examination</th>
                        <th>Physician Directions</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <!-- Need loop to print every record of the patient -->
                    @php
                        $counter = 0;
                    @endphp
                    @foreach($medicalPatientRecords as $record)
                    @php
                        $counter++;
                    @endphp
                        <tr>
                            <td contenteditable="false" class="table-success border border-dark">{{ $counter }}.&nbsp;&nbsp;{{ date('d-F-Y', strtotime($record->date_of_exam)) }}</td>
                            <td contenteditable="false" class="table-success border border-dark">{{ $record->temperature }}</td>
                            <td contenteditable="false" class="table-success border border-dark">{{ $record->bloodPressure }}</td>
                            <td contenteditable="false" class="table-success border border-dark">{{ $record->weight }}</td>
                            <td contenteditable="false" class="table-success border border-dark">{{ $record->height }}</td>
                            <td contenteditable="false" class="table-success border border-dark" style="max-width: 100px;">{{ htmlspecialchars_decode($record->historyAndPhysicalExamination) }}</td>
                            <td contenteditable="false" class="table-success border border-dark" style="max-width: 100px;">{{ htmlspecialchars_decode($record->physicianDirections) }}</td>
                            
                        </tr>
                        @endforeach
                        @php
                            $counter++;
                        @endphp
                    <tr id="newData" class="table-info border border-dark">
                        <td contenteditable="true" id="table_date" name="table_date" data-toggle="tooltip" data-container="body" data-bs-placement="bottom" title="{{ date("D, d F y") }}"> {{ date('d-F-Y') }}</td>
                        <td contenteditable="true" id="table_temperature" name="table_temperature" onkeypress="return isNumeric(event)"></td>
                        <td contenteditable="true" id="table_bloodPressure" name="table_bloodPressure"></td>
                        <td contenteditable="true" id="table_weight" name="table_weight" onkeypress="return isNumeric(event)"></td>
                        <td contenteditable="true" id="table_height" name="table_height" onkeypress="return isNumeric(event)"></td>
                        <td contenteditable="true" id="table_historyAndPhysicalExamination" name="table_historyAndPhysicalExamination" style="max-width: 100px;"></td>
                        <td contenteditable="true" id="table_physicianDirections" name="table_physicianDirections" style="max-width: 100px;"></td>
                        <script>
                            function isNumeric(evt) {
                                var charCode = (evt.which) ? evt.which : event.keyCode;
                                if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
                                    return false;
                                }
                                return true;
                            }
                        </script>
                    </tr>
                </tbody>
            </table>

            <input type="hidden" id="patientID" name="patientID" value="{{ $patient->id }}">
            <input type="hidden" id="patientType" name="patientType" value="{{ $patient->user_type }}">
            <input type="hidden" id="date" name="date">
            <input type="hidden" id="temperature" name="temperature">
            <input type="hidden" id="bloodPressure" name="bloodPressure">
            <input type="hidden" id="weight" name="weight">
            <input type="hidden" id="height" name="height">
            <input type="hidden" id="historyAndPhysicalExamination" name="historyAndPhysicalExamination">
            <input type="hidden" id="physicianDirections" name="physicianDirections">

        </div>
        <span class="text-danger"> 
            @error('patientID') 
              {{ $message }}<br>
            @enderror
        </span>
        <span class="text-danger"> 
            @error('date') 
              {{ $message }}<br>
            @enderror
        </span>
        <span class="text-danger"> 
            @error('temperature') 
              {{ $message }}<br>
            @enderror
        </span>
        <span class="text-danger"> 
            @error('bloodPressure') 
              {{ $message }}<br>
            @enderror
        </span>
        <span class="text-danger"> 
            @error('weight') 
              {{ $message }}<br>
            @enderror
        </span>
        <span class="text-danger"> 
            @error('height') 
              {{ $message }}<br>
            @enderror
        </span>
        <span class="text-danger"> 
            @error('historyAndPhysicalExamination')
              {{ $message }}<br>
            @enderror
        </span>
        <span class="text-danger"> 
            @error('physicianDirections') 
              {{ $message }}<br>
            @enderror
        </span>


        <div class="row no-gutters justify-content-end pt-3 position-relative">
            <div class="col d-flex justify-content-end" style="margin-right:-1  %;">
                <button type="button" class="btn btn-lg btn-primary btn-login fw-bold mb-2 d-print-none" data-bs-toggle="modal" data-bs-target="#saveModal" onclick="confirmTable();">
                    Submit
                </button>
            </div>
        </div>

        <script>
            function confirmTable() {
                $('#data_table tbody tr').each(function(row, tr) {
                    // Get the specific row by its id
                    var row = $('#data_table tbody tr#newData');
                    // Get the cells in the current row
                    var cells = $(row).find('td');

                    // Get the values in the cells of the current row
                    var dateValue = cells.eq(0).text();
                    var temperatureValue = cells.eq(1).text();
                    var bloodPressureValue = cells.eq(2).text();
                    var weightValue = cells.eq(3).text();
                    var heightValue = cells.eq(4).text();
                    var historyAndPhysicalExaminationValue = cells.eq(5).text();
                    var physicianDirectionsValue = cells.eq(6).text();

                    // Update the cells in the current row in the table you provided
                    $('#confirm_date').text(dateValue);
                    $('#confirm_temperature').text(temperatureValue);
                    $('#confirm_bloodPressure').text(bloodPressureValue);
                    $('#confirm_weight').text(weightValue);
                    $('#confirm_height').text(heightValue);
                    $('#confirm_historyAndPhysicalExamination').text(historyAndPhysicalExaminationValue);
                    $('#confirm_physicianDirections').text(physicianDirectionsValue);

                    // Update the value of hidden inputs to post
                    $('#date').val(dateValue);
                    $('#temperature').val(temperatureValue);
                    $('#bloodPressure').val(bloodPressureValue);
                    $('#weight').val(weightValue);
                    $('#height').val(heightValue);
                    $('#historyAndPhysicalExamination').val(historyAndPhysicalExaminationValue);
                    $('#physicianDirections').val(physicianDirectionsValue);

                });
            }

            $(document).ready(function() {
                confirmTable();
            });
        </script>

        <!-- Modal -->
        <div class="modal fade modal-xl" id="saveModal" tabindex="-1" data-bs-keyboard="false" data-bs-backdrop="static" aria-labelledby="saveModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="saveModalLabel">Medical Patient Record</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                <div class="modal-body">
                    <p class="fs-6 fw-bold">Please confirm if the data is correct.</p>
                    
                    <div class="table">
                        <table id="confirm_data_table" class="table table-striped table-bordered border-dark table-responsive table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Temperature</th>
                                    <th>Blood Pressure</th>
                                    <th>Weight</th>
                                    <th>Height</th>
                                    <th>History and Physical Examination</th>
                                    <th>Physician Directions</th>
                                    
                                </tr>
                            </thead>
                            <tbody>                               
                                <tr class="table-info border border-dark">
                                    <td contenteditable="false" id="confirm_date" name="date" data-toggle="tooltip" data-container="body" data-bs-placement="bottom" title="{{ date("D, M j Y") }}">{{ date('d-m-Y') }}</td>
                                    <td contenteditable="false" id="confirm_temperature" name="temperature"></td>
                                    <td contenteditable="false" id="confirm_bloodPressure" name="bloodPressure"></td>
                                    <td contenteditable="false" id="confirm_weight" name="weight"></td>
                                    <td contenteditable="false" id="confirm_height" name="height"></td>
                                    <td contenteditable="false" id="confirm_historyAndPhysicalExamination" name="historyAndPhysicalExamination"></td>
                                    <td contenteditable="false" id="confirm_physicianDirections" name="physicianDirections"></td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                
                    <div class="modal-footer">
                    </div>
                    <div class="col d-flex justify-content-end" style="margin-right:-1  %;">
                        <button class="btn btn-primary btn-login fw-bold" type="submit">Looks good!</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
