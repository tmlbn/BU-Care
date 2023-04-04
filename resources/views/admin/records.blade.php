@extends('admin.layouts.app')
<style>
     body{
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        background-image: url({{ asset('media/RegistrationBG.jpg') }});
    }
</style>

@section('content')
    <div class="container my-2 bg-light w-20 text-dark p-5 headMargin checkboxes">
        <div class="row">
            <div class="d-flex justify-content-center">  
                <div class="col border border-dark">
                    <header class="text-center">
                        <h1 class="pt-1">MEDICAL PATIENT RECORD</h1>
                    </header>    
                </div>
            </div>
<form method="POST" action="{{ route('medicalForm.store') }}" enctype="multipart/form-data" class="row g-3 pt-2">
    @csrf

        <div class="row row-cols-lg-4 row-cols-md-2 mt-2">
            <div class="col-sm col-lg-4">
                <p class="h6">Course/Grade/Year</p>
                <input type="text" class="form-control" id="campusSelect" name="campusSelect" value="{{ $patient->medicalRecord->campus }}" readonly>
            </div>
            <div class="col-sm col-lg-4">
                <p class="h6">Unit</p>
                <input type="text" class="form-control" id="courseSelect" name="courseSelect" value="{{ $patient->medicalRecord->campus }}" readonly>
            </div> 
        </div>   
            <div class="d-flex flex-row">
            </div>
            <div class="col-md-3">
                <label for="MR_lastName" class="form-label h6">Last Name</label>
                <input type="text" class="form-control" id="MR_lastName" name="MR_lastName" value="{{ $patient->medicalRecord->lastName }}" readonly>
            </div>
            <div class="col-md-3">
                <label for="MR_firstName" class="form-label h6">First Name</label>
                <input type="text" class="form-control" id="MR_firstName" name="MR_firstName" value="{{ $patient->medicalRecord->firstName }}" readonly>
            </div>
            <div class="col-md-3">
                <label for="MR_middleName" class="form-label h6">Middle Name</label>
                <input type="text" class="form-control" id="MR_middleName" name="MR_middleName" value="{{ $patient->medicalRecord->middleName }}" readonly>
            </div>
            <div class="col-md-3">
                <label for="MR_middleName" class="form-label h6">Birthday</label>
                <input type="text" class="form-control" id="MR_middleName" name="MR_middleName" value="{{ $patient->birth_month }}/{{ $patient->birth_date }}/{{ $patient->birth_year }}" readonly>
            </div>
            <div class="col-md-9">
                <label for="MR_middleName" class="form-label h6">Address</label>
                <input type="text" class="form-control" id="MR_middleName" name="MR_middleName" value="{{ $patient->medicalRecord->homeAddress }}" readonly>
            </div>
            <div class="col-md-3">
                <label for="MR_middleName" class="form-label h6">Religion</label>
                <input type="text" class="form-control" id="MR_middleName" name="MR_middleName" value="{{ $patient->medicalRecord->religion }}" readonly>
            </div>
            <div class="col-md-3">
                <label for="validationDefault07" class="form-label">Contact Number(s)</label>
                <input type="text" class="form-control" id="MR_middleName" name="MR_middleName" value="0{{ $patient->medicalRecord->studentContactNumber }}" readonly>
            </div>
            <div class="col-md-3">
                <label for="validationDefault07" class="form-label">Civil Status</label>
                <input type="text" class="form-control" id="MR_middleName" name="MR_middleName" value="{{ $patient->medicalRecord->civilStatus }}" readonly>
            </div>
            <div class="col-md-3">
                <label for="validationDefault07" class="form-label">Sex</label>
                <input type="text" class="form-control" id="MR_middleName" name="MR_middleName" value="{{ $patient->medicalRecord->sex }}" readonly>
            </div>
            <div class="col-md-3">
                <label for="validationDefault07" class="form-label">Age</label>
                <input type="text" class="form-control" id="MR_middleName" name="MR_middleName" value="{{ $patient->medicalRecord->age }}" readonly>
             </div>
        <h5>Parents</h5>
            <div class="col-md-4">
                <label for="validationDefault07" class="form-label">Father's Name</label>
                <input type="text" class="form-control" id="MR_middleName" name="MR_middleName" value="{{ $patient->medicalRecord->fatherName }}" readonly>
            </div>
            <div class="col-md-4">
                <label for="validationDefault07" class="form-label">Office Address</label>
                <input type="text" class="form-control" id="MR_middleName" name="MR_middleName" value="{{ $patient->medicalRecord->fatherOfficeAddress }}" readonly>
            </div>
            <div class="col-md-4">
                <label for="validationDefault07" class="form-label">Contact Number</label>
                <input type="text" class="form-control" id="MR_middleName" name="MR_middleName" value="0{{ $patient->medicalRecord->parentGuardianContactNumber }}" readonly>
            </div>
            <div class="col-md-4">
                <label for="validationDefault07" class="form-label">Mother's Name</label>
                <input type="text" class="form-control" id="MR_middleName" name="MR_middleName" value="{{ $patient->medicalRecord->motherName }}" readonly>
            </div>
            <div class="col-md-4">
                <label for="validationDefault07" class="form-label">Office Address</label>
                <input type="text" class="form-control" id="MR_middleName" name="MR_middleName" value="{{ $patient->medicalRecord->motherOfficeAddress }}" readonly>
            </div>
            <div class="col-md-4">
                <label for="validationDefault07" class="form-label">Contact Number</label>
                <input type="text" class="form-control" id="MR_middleName" name="MR_middleName" value="0{{ $patient->medicalRecord->parentGuardianContactNumber }}" readonly>
            </div>
                <h5>Incase of Emergency please notify</h5>
                <div class="col-md-6">
                    <label for="validationDefault15" class="form-label">Name</label>
                    <input type="text" class="form-control" id="validationDefault15" required>
                </div>
                <div class="col-md-6">
                    <label for="validationDefault16" class="form-label">Contact Number</label>
                    <input type="text" class="form-control" id="validationDefault16" required>
                </div>

            <h5>Illness</h5>    

                <!--Illness-->
            <div class="mx-auto row row-cols-lg-2 row-cols-md-1 align-items-center"><!-- START DIV FOR FAMILY HISTORY AND PSH -->
                <div class="col-lg-12 p-2 border border-dark"> 
                <!--Column 1-->    
                    <div class="d-flex flex-row">
                        <div class="col-md-4 p-2 align-items-center justify-content-center ms-lg-5 ms-sm-1">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Hypertension
                                    </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Diabetes
                                    </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Kidney Disease
                                    </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Measles
                                    </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Diphteria
                                    </label>
                            </div>
                            <div class="col-md-9">
                                <label for="validationDefault17" class="form-label">Others(specify)</label>
                                <input type="text" class="form-control form-control-sm" id="validationDefault17" required>
                            </div>
                        </div>    
                    
                        <!--Column 2-->
                    
                    <div class="col-md-4 p-2 align-items-center justify-content-center ms-lg-5 ms-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Asthma
                                </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Rheumatic Fever
                                </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Seizure Disorder
                                </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Hepatitis
                                </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Allergy <input type="text" class="form-control form-control-sm">
                                </label>
                        </div>
                    </div> 
                    <!--Column 3--> 
                    <div class="col-md-4 p-2 align-items-center justify-content-center ms-lg-5 ms-sm-1">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Mumps
                                </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Cardiac Disease
                                </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Chicken Pox
                                </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Tuberculosis
                                </label>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>

    <div class="col-md-12 border border-dark">
        <header class="text-center">
            <h3 class="pt-2">EXAMINATIONS</h3>
        </header>    
    </div>    
    <div class="table">
        <table id="data_table" class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Temperature/Blood Pressure</th>
                    <th>Weight</th>
                    <th>Height</th>
                    <th>History and Physical Examination</th>
                    <th>Physician Directions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td contenteditable="true"></td>
                    <td contenteditable="true"></td>
                    <td contenteditable="true"></td>
                    <td contenteditable="true"></td>
                    <td contenteditable="true"></td>
                    <td contenteditable="true"></td>
                </tr>
            </tbody>
            </table>
            <!-- NEED INPUT FOR ACTUAL CONSULTATION -->
    </div>

@endsection
