@extends('layouts.app')

@section('content')

<style>
    ::-webkit-input-placeholder {
   font-style: italic;
    }
    :-moz-placeholder {
    font-style: italic;  
    }
    ::-moz-placeholder {
    font-style: italic;  
    }
    :-ms-input-placeholder {  
    font-style: italic; 
    }
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

</style>
<!-- Header -->
<div class="container position-relative my-2 bg-light w-20 text-dark pt-5 px-3 headMargin checkboxes">
    <div class="row row-cols-1 row-cols-md-2">
        <div class="col-lg-6 col-md-12 border border-dark d-flex align-items-center justify-content-center">
                <div class="col-2 d-flex align-items-center justify-content-center">
                    <img src="{{ asset('media/BU-logo.png') }}" class="rounded" alt="BUHS-LOGO" style="width:80%; ">
                  </div>                  
                <div class="col-lg-8 col-xs-4">
                    <header class="text-center px-auto py-auto">
                        <h5 class="display-7 pt-3 fs-3 font-monospace">
                            Republic of the Philippines<br>
                        </h5>
                        <h6 class="fw-bold fs-5 font-monospace">Bicol University</h6>
                        <h6 class="fs-5 font-monospace">Bicol University Health Services</h6>
                    </header>
                </div>
                <div class="col-2 d-flex align-items-center justify-content-center">
                    <img src="{{ asset('media/BUHS-logo.png') }}" class="rounded float-end img-fluid" alt="BUHS-LOGO" style="width:80%; ">
                </div>
        </div>
        <div class="col-lg-6 col-md-12 border border-dark d-flex align-items-center justify-content-center">
            <header class="text-center px-auto py-auto">
              <h2 class="display-7 fs-3 m-md-4 m-sm-4 m-xs-4 font-monospace">Student Health Record</h2>
            </header>
          </div>          
    </div>

    <!--Personal Basic Information-->
    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
<form method="POST" action="{{ route('medicalForm.store') }}" id="MR_form" enctype="multipart/form-data" class="row g-3 pt-5 px-4 needs-validation" novalidate>
    @csrf
    <div class="container">
        <div class="mx-auto row row-cols-lg-4 row-cols-md-2 mt-2">
            <div class="col-xl-5 col-lg-6">
                <p class="h6">Campus<span class="text-danger">*</span></p>
                <select id="campusSelect" name="campusSelect" class="form-select" required>
                    <option selected="selected" disabled="disabled" value="">SELECT</option>
                    <option value="College of Agriculture and Forestry" {{ old('campusSelect') == 'College of Agriculture and Forestry' ? 'selected' : '' }}>College of Agriculture and Forestry</option>
                    <option value="College of Arts and Letters" class="alternate" {{ old('campusSelect') == 'College of Arts and Letters' ? 'selected' : '' }}>College of Arts and Letters</option>
                    <option value="College of Business, Entrepreneurship, and Management" {{ old('campusSelect') == 'College of Business, Entrepreneurship, and Management' ? 'selected' : '' }}>College of Business, Entrepreneurship, and Management</option>
                    <option value="College of Education" class="alternate" {{ old('campusSelect') == 'College of Education' ? 'selected' : '' }}>College of Education</option>
                    <option value="College of Engineering" {{ old('campusSelect') == 'College of Engineering' ? 'selected' : '' }}>College of Engineering</option>
                    <option value="College of Industrial Technology" class="alternate" {{ old('campusSelect') == 'College of Industrial Technology' ? 'selected' : '' }}>College of Industrial Technology</option>
                    <option value="College of Medicine" {{ old('campusSelect') == 'College of Medicine' ? 'selected' : '' }}>College of Medicine</option>
                    <option value="College of Nursing" class="alternate" {{ old('campusSelect') == 'College of Nursing' ? 'selected' : '' }}>College of Nursing</option>
                    <option value="College of Science" {{ old('campusSelect') == 'College of Science' ? 'selected' : '' }}>College of Science</option>
                    <option value="College of Social Science and Philosophy" class="alternate" {{ old('campusSelect') == 'College of Social Science and Philosophy' ? 'selected' : '' }}>College of Social Science and Philosophy</option>
                    <option value="Institute of Design and Architecture" {{ old('campusSelect') == 'Institute of Design and Architecture' ? 'selected' : '' }}>Institute of Design and Architecture</option>
                    <option value="Institute of Physical Education, Sports, and Recreation" class="alternate" {{ old('campusSelect') == 'Institute of Physical Education, Sports, and Recreation' ? 'selected' : '' }}>Institute of Physical Education, Sports, and Recreation</option>
                    <option value="Gubat Campus" {{ old('campusSelect') == 'Gubat Campus' ? 'selected' : '' }}>Gubat Campus</option>
                    <option value="Polangui Campus" class="alternate" {{ old('campusSelect') == 'Polangui Campus' ? 'selected' : '' }}>Polangui Campus</option>
                    <option value="Tabaco Campus" {{ old('campusSelect') == 'Tabaco Campus' ? 'selected' : '' }}>Tabaco Campus</option>
                </select>
                <div class="invalid-feedback">
                    Please select your campus.
                </div>
                <span class="text-danger"> 
                    @error('campusSelect') 
                      {{ $message }} 
                    @enderror
                </span>
            </div>
            <div class="col-xl-5 col-lg-6 col-md-6">
                <p class="h6">Course<span class="text-danger">*</span></p>
                <select id="courseSelect" name="courseSelect" class="form-select" required>
                    <option selected="selected" disabled="disabled" value="">SELECT</option>
                    <script>
                        var courses= {
                            "College of Social Science and Philosophy": ["AB Peace Studies","AB Philosophy","AB Political Science","AB Sociology","BS Psychology","BS Social Work"],
                            "College of Business, Entrepreneurship, and Management": ["BS Accountancy","BS Economics","BS Entrepreneurship","BSBA Major in Financial Management","BSBA Major in Human Resource Management","BS Management","BSBA Major in Marketing Management","BSBA Microfinance","BSBA Major in Operations Management"],
                            "College of Education": ["B Early Childhood Education","B Elementary Education","B Secondary Education","Bachelor of Culture and Arts Education"],
                            "College of Arts and Letters": ["BA Broadcasting","BA Communication","BA English Language","BA Journalism","BA Performing Arts (BPeA) Theater","BA Literature"],
                            "College of Nursing": ["BS Nursing"],
                            "College of Science": ["BS Biology","BS Chemistry","BS Computer Science","BS Information Technology","BS Meteorology"],
                            "Institute of Physical Education, Sports, and Recreation": ["BS in Exercise & Sports Sciences","Bachelor of Physical Education"],
                            "College of Engineering": ["BS Chemical Engineering","BS Civil Engineering","BS Electrical Engineering","BS Geodetic Engineering","BS Mechanical Engineering","BS Mining Engineering"],
                            "Institute of Design and Architecture": ["BS Architecture"],
                            "College of Industrial Technology": ["BS Automotive Technology","BS Civil Technology","BS Electrical Technology","BS Electronics Technology","BS Mechanical Technology","BS Food Technology","B Industrial Design","B Technical - Vocational Teacher Educ. Major in Drafting Technology","B Technical - Vocational Teacher Educ. Major in Electrical Technology","AB Technical - Vocational Teacher Educ. Major in Food Service Management","B Technical - Vocational Teacher Educ. Major in Garments Fashion and Design"],
                            "College of Agriculture and Forestry": ["B Agricultural Technology","BS Agribusiness","BS Agricultural & Biosystems Engineering","BS Agriculture","BS Forestry","B Technical - Vocational Teacher Educ. Major in Animal Production","B Technical - Vocational Teacher Educ. Major in Agricultural Crop Production","Doctor of Veterinary Medicine"],
                            "Tabaco Campus": ["B Secondary Education (Science & Math)","BS Entrepreneurship","BS Fisheries","BS Food Technology","BS Nursing","BS Social Work"],
                            "College of Medicine": ["Doctor of Medicine"],
                            "Gubat Campus": ["B Elementary Education","B Secondary Education (Filipino & Social Studies)","BS Agricultural Technology (Ladderized)","BS Entrepreneurship","BSBA Major in Microfinance"],
                            "Polangui Campus": ["B Elementary Education","B Secondary Education Major in English","B Secondary Education Major in Math","BS Automotive Technology","BS Computer Engineering","BS Computer Science","BS Electronics Engineering","BS Electronics Technology","BS Entrepreneurship","BS Food Technology","BS Information System","BS Information Technology","BS Information Technology (Animation)","BS Nursing","B Technology and Livelihood Education (BTLed-ICT)"]
                        };
  
                        $(document).ready(function() {
                            // get the selected campus
                            var selectedCampus = $('#campusSelect').val();
                            // get the corresponding courses from the JSON object
                            var selectedCampusCourses = courses[selectedCampus];
                            // counter for class alternate
                            var counter = 0;
                            console.log(selectedCampus);
                            // clear the current options in the courseSelect element
                            if(selectedCampus != null){
                                $('#courseSelect').empty();
                                // add the new options based on the selected campus
                                $.each(selectedCampusCourses, function(index, value) {
                                    counter++;
                                    var option = $('<option>').text(value).attr('value', value);
                                    if (value == "{{ old('courseSelect') }}") {
                                        option.attr('selected', 'selected');
                                    }
                                    if(counter % 2 == 1){
                                        $('#courseSelect').append(option.addClass('alternate'));
                                    }else{
                                        $('#courseSelect').append(option);
                                    }
                                });
                            }
                            
                            $('#campusSelect').on('change', function() {
                                // get the selected campus
                                var selectedCampus = $(this).val();
                                // get the corresponding courses from the JSON object
                                var selectedCampusCourses = courses[selectedCampus];
                                // counter for class alternate
                                var counter = 0;
                                // clear the current options in the courseSelect element
                                $('#courseSelect').empty();
                                // add the new options based on the selected campus
                                $.each(selectedCampusCourses, function(index, value) {
                                    counter++;
                                    var option = $('<option>').text(value).attr('value', value);
                                    if(counter % 2 == 1){
                                        $('#courseSelect').append(option.addClass('alternate'));
                                    }else{
                                        $('#courseSelect').append(option);
                                    }
                                });
                            });
                            // Auto School Year
                            const yearStart = new Date().getFullYear();
                            const yearEnd = yearStart + 1;

                            $('#schoolYearStart').val(yearStart);
                            $('#schoolYearEnd').val(yearEnd);
                        });
                    </script>
                </select>
                <div class="invalid-feedback">
                    Please select your course.
                </div>
                <span class="text-danger"> 
                    @error('courseSelect') 
                      {{ $message }} 
                    @enderror
                </span>
            </div> 
            <div class="col-xl-2 col-lg-12 col-md-12">
                <label for="schoolYearStart" class="form-label h6" style="white-space: nowrap;">School Year<span class="text-danger">*</span></label>
                    <div class="d-flex align-items-center" style="margin-top:-1%;">
                        <input type="number" class="form-control me-1 @error('schoolYearStart') is-invalid @enderror" id="schoolYearStart" name="schoolYearStart" value="{{ old('schoolYearStart') }}" placeholder="YYYY" onKeyPress="if(this.value.length==4) return false;"  onkeyup="if(this.value.length == 4) document.getElementById('schoolYearEnd').value = parseInt(this.value) + 1;"required> 
                        <span class="fs-6">-</span>
                        <input type="number" class="form-control ms-2 @error('schoolYearEnd') is-invalid @enderror" id="schoolYearEnd" name="schoolYearEnd" value="{{ old('schoolYearEnd') }}" placeholder="YYYY" onKeyPress="if(this.value.length==4) return false;" required>
                    </div>
                    <div class="invalid-feedback">
                        Please enter your school year.
                    </div>
                    <span class="text-danger"> 
                        @error('schoolYearStart') 
                            {{ $message }}
                        @enderror
                    </span>
                    <span class="text-danger"> 
                        @error('schoolYearEnd') 
                            {{ $message }}
                        @enderror
                    </span>
            </div>   
        </div>   
    </div>
    <div class="d-flex flex-row">
        <h4 class="pb-3"></h4>
    </div>   
        <div class="col-md-3">
            <label for="MR_lastName" class="form-label h6">Last Name<span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('MR_lastName') is-invalid @enderror" id="MR_lastName" name="MR_lastName" value="{{ old('MR_lastName') ?:  $user->last_name }}" oninput="this.value = this.value.toUpperCase()" required>
            <div class="invalid-feedback">
                Please enter your last name.
            </div>
            <span class="text-danger"> 
                @error('MR_lastName') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-3">
            <label for="MR_firstName" class="form-label h6">First Name<span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('MR_firstName') is-invalid @enderror" id="MR_firstName" name="MR_firstName" value="{{ old('MR_firstName') ?:  $user->first_name }}" oninput="this.value = this.value.toUpperCase()" required>
            <div class="invalid-feedback">
                Please enter your first name.
            </div>
            <span class="text-danger"> 
                @error('MR_firstName') 
                  {{ $message }} 
                @enderror
              </span>
        </div>
        <div class="col-md-3">
            <label for="MR_middleName" class="form-label h6">Middle Name</label>
            <input type="text" class="form-control @error('MR_middleName') is-invalid @enderror" id="MR_middleName" name="MR_middleName" value="{{ old('MR_middleName') ?:  $user->middle_name }}" oninput="this.value = this.value.toUpperCase()">
            <div class="invalid-feedback">
                Please enter your middle name.
            </div>
            <span class="text-danger"> 
                @error('MR_middleName') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-3">
            <label for="MR_dateOfBirth" class="form-label h6">Date of Birth<span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('MR_dateOfBirth') is-invalid @enderror" id="MR_dateOfBirth" name="MR_dateOfBirth" value="{{ old('MR_dateOfBirth') ?: $birthDate }}" onkeydown="return false;" required>
            <div class="invalid-feedback">
                Please enter your date of birth.
            </div>
            <span class="text-danger"> 
                @error('MR_dateOfBirth') 
                    {{ $message }} 
                @enderror
            </span>
        </div>
        <script>
        $(document).ready(function() {
            var initialBirthDate = new Date("<?php echo $birthDate; ?>");
            var age = Math.floor((new Date() - initialBirthDate) / (365.25 * 24 * 60 * 60 * 1000));
            $('#MR_age').val(age);

            $("#MR_dateOfBirth").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy MM dd',
                showButtonPanel: true,
                yearRange: "1900:c",
                showAnim: 'slideDown',
                defaultDate: initialBirthDate // Set the initial date value here
            });
            // Calculate age when birthdate changes
            $('#MR_dateOfBirth').change(function() {
                var birthdate = $(this).datepicker('getDate');
                if (birthdate) {
                    var age = Math.floor((new Date() - birthdate) / (365.25 * 24 * 60 * 60 * 1000));
                    $('#MR_age').val(age);
                }
            });
        });
        </script>
        <div class="col-md-1">
            <label for="MR_age" class="form-label h6">Age<span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('MR_age') is-invalid @enderror" id="MR_age" name="MR_age" value="{{ old('MR_age') }}" onKeyPress="if(this.value.length==2) return false;" required>
            <div class="invalid-feedback">
                Please enter your age.
            </div>
            <span class="text-danger"> 
                @error('MR_age') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-2">
            <label for="MR_sex" class="form-label h6">Sex<span class="text-danger">*</span></label>
            <select id="MR_sex" class="form-select @error('MR_sex') is-invalid @enderror" name="MR_sex" required>
                <option selected="selected" disabled="disabled" value="">SELECT</option>
                <option value="MALE" {{ old('MR_sex') == 'MALE' ? 'selected' : '' }}>MALE</option>
                <option value="FEMALE" {{ old('MR_sex') == 'FEMALE' ? 'selected' : '' }}>FEMALE</option>
            </select>
            <div class="invalid-feedback">
                Please enter your sex.
            </div>
            <span class="text-danger"> 
                @error('MR_sex') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-2">
            <label for="MR_civilStatus" class="form-label h6 @error('MR_civilStatus') is-invalid @enderror">Civil Status<span class="text-danger">*</span></label>
            <select id="MR_civilStatus" name="MR_civilStatus" class="form-select" required>
                <option selected="selected" disabled="disabled" value="">SELECT</option>
                <option value="SINGLE" {{ old('MR_civilStatus') == 'SINGLE' ? 'selected' : '' }}>SINGLE</option>
                <option value="MARRIED" {{ old('MR_civilStatus') == 'MARRIED' ? 'selected' : '' }} class="alternate">MARRIED</option>
                <option value="DIVORCED" {{ old('MR_civilStatus') == 'DIVORCED' ? 'selected' : '' }}>DIVORCED</option>
                <option value="SEPARATED" {{ old('MR_civilStatus') == 'SEPARATE' ? 'selected' : '' }} class="alternate">SEPARATED</option>
                <option value="WIDOWED" {{ old('MR_civilStatus') == 'WIDOWED' ? 'selected' : '' }}>WIDOWED</option>
            </select>
            <div class="invalid-feedback">
                Please enter your civil status.
            </div>
            <span class="text-danger"> 
                @error('MR_civilStatus') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-2">
            <label for="MR_nationality" class="form-label h6 @error('MR_nationality') is-invalid @enderror">Nationality<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="MR_nationality" name="MR_nationality" value="{{ old('MR_nationality') }}" oninput="this.value = this.value.toUpperCase()" required>
            <div class="invalid-feedback">
                Please enter your nationality.
            </div>
            <span class="text-danger"> 
                @error('MR_nationality') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-2">
            <label for="MR_religion" class="form-label h6 @error('MR_religion') is-invalid @enderror">Religion<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="MR_religion" name="MR_religion" value="{{ old('MR_religion') }}" oninput="this.value = this.value.toUpperCase()" required>
            <div class="invalid-feedback">
                Please enter your religion.
            </div>
            <span class="text-danger"> 
                @error('MR_religion') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-3">
            <label for="MR_studentContactNumber" class="form-label h6 @error('MR_studentContactNumber') is-invalid @enderror">Student's Contact No.<span class="text-danger">*</span></label>
            <input type="number" class="form-control" placeholder="09123456789" id="MR_studentContactNumber" value="{{ old('MR_studentContactNumber') }}" name="MR_studentContactNumber" aria-describedby="studentContactFeedback" onKeyPress="if(this.value.length==11) return false;" required>
            <div class="invalid-feedback" id="studentContactFeedback">
                Please enter your contact number.
            </div>
            <span class="text-danger"> 
                @error('MR_studentContactNumber') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <!-- ADDRESS -->
        @php
            $regions = [
                ['number' => 'REGION I', 'name' => 'ILOCOS REGION'],
                ['number' => 'REGION II', 'name' => 'CAGAYAN VALLEY'],
                ['number' => 'REGION III', 'name' => 'CENTRAL LUZON'],
                ['number' => 'REGION IV-A', 'name' => 'CALABARZON'],
                ['number' => 'MIMAROPA REGION', 'name' => 'MIMAROPA REGION'],
                ['number' => 'REGION V', 'name' => 'BICOL REGION'],
                ['number' => 'REGION VI', 'name' => 'WESTERN VISAYAS'],
                ['number' => 'REGION VII', 'name' => 'CENTRAL VISAYAS'],
                ['number' => 'REGION VIII', 'name' => 'EASTERN VISAYAS'],
                ['number' => 'REGION IX', 'name' => 'ZAMBOANGA PENINSULA'],
                ['number' => 'REGION X', 'name' => 'NORTHERN MINDANAO'],
                ['number' => 'REGION XI', 'name' => 'DAVAO REGION'],
                ['number' => 'REGION XII', 'name' => 'SOCCSKSARGEN'],
                ['number' => 'CARAGA REGION', 'name' => 'CARAGA'],
                ['number' => 'NCR', 'name' => 'NATIONAL CAPITAL REGION'],
                ['number' => 'CAR', 'name' => 'CORDILLERA ADMINISTRATIVE REGION'],
                ['number' => 'BARMM', 'name' => 'BANGSAMORO AUTONOMOUS REGION IN MUSLIM MINDANAO']
            ];
        @endphp
        <div class="col-md-2">
            <label for="MR_addressRegion" class="form-label h6">Region<span class="text-danger">*</span></label>
            <select class="form-select  @error('MR_addressRegion') is-invalid @enderror" id="MR_addressRegion" name="MR_addressRegion" required>
                <option selected="selected" disabled="disabled" value="">SELECT</option>
                @foreach ($regions as $region)
                    <option value="{{ $region['number'] }}" {{ old('region') == $region['number'] ? 'selected' : '' }}>
                        {{ $region['number'] }} - {{ $region['name'] }}
                    </option>
                @endforeach
            </select>
            <div class="invalid-feedback">
                Please enter your Region.
            </div>
            <span class="text-danger"> 
                @error('MR_addressRegion') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-2">
            <label for="MR_addressProvince" class="form-label h6">Province<span class="text-danger">*</span></label>
                <select class="form-select  @error('MR_addressProvince') is-invalid @enderror" id="MR_addressProvince" name="MR_addressProvince" required>
                    <option selected="selected" disabled="disabled" value="">SELECT</option>
                </select>
            <div class="invalid-feedback">
                Please enter your Province.
            </div>
            <span class="text-danger"> 
                @error('MR_addressProvince') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <script>
            var provinces={
                "REGION I": ["ILOCOS NORTE","ILOCOS SUR","LA UNION","PANGASINAN"],
                "REGION II": ["BATANES","CAGAYAN","ISABELA","NUEVA VIZCAYA","QUIRINO"],
                "REGION III": ["AURORA","BATAAN","BULACAN","NUEVA ECIJA","PAMPANGA","TARLAC","ZAMBALES"],
                "REGION IV-A": ["BATANGAS","CAVITE","LAGUNA","QUEZON","RIZAL"],
                "MIMAROPA REGION": ["MARINDUQUE","OCCIDENTAL MINDORO","ORIENTAL MINDORO","PALAWAN","ROMBLON"],
                "REGION V": ["ALBAY","CAMARINES NORTE","CAMARINES SUR","CATANDUANES","MASBATE","SORSOGON"],
                "REGION VI": ["AKLAN","ANTIQUE","CAPIZ","GUIMARAS","ILOILO","NEGROS OCCIDENTAL"],
                "REGION VII": ["BOHOL","CEBU","NEGROS ORIENTAL","SIQUIJOR"],
                "REGION VIII": ["BILIRAN","EASTERN SAMAR","LEYTE","NORTHERN SAMAR","SAMAR","SOUTHERN LEYTE"],
                "REGION IX": ["ZAMBOANGA DEL NORTE","ZAMBOANGA DEL SUR","ZAMBOANGA SIBUGAY"],
                "REGION X": ["BUKIDNON","CAMIGUIN","LANAO DEL NORTE","MISAMIS OCCIDENTAL","MISAMIS ORIENTAL"],
                "REGION XI": ["DAVAO DE ORO","DAVAO DEL NORTE","DAVAO DEL SUR","DAVAO OCCIDENTAL","DAVAO ORIENTAL"],
                "REGION XII": ["COTABATO","SARANGANI","SOUTH COTABATO","SULTAN KUDARAT"],
                "CARAGA REGION": ["AGUSAN DEL NORTE","AGUSAN DEL SUR","DINAGAT ISLANDS","SURIGAO DEL NORTE","SURIGAO DEL SUR"],
                "NCR": ["MANILA","CALOOCAN","LAS PIÑAS","MAKATI","MALABON","MANDALUYONG","MARIKINA","MUNTINLUPA","NAVOTAS","PARAÑAQUE","PASAY","PASIG","QUEZON CITY","SAN JUAN","TAGUIG","VALENZUELA"],
                "CAR": ["ABRA","APAYAO","BENGUET","IFUGAO","KALINGA","MOUNTAIN PROVINCE"],
                "BARMM": ["BASILAN","LANAO DEL SUR","MAGUINDANAO","SULU","TAWI-TAWI"]
            };

            $(document).ready(function() {
                // get the selected region
                var region = $('#MR_addressRegion').val();
                // get the corresponding provinces from the provinces object
                var selectedProvinces = provinces[region];
                // update the list of provinces in the dropdown
                var $provincesDropdown = $('#MR_addressProvince');
                $provincesDropdown.empty();
                $.each(selectedProvinces, function(i, province) {
                    $provincesDropdown.append($('<option>').text(province).attr('value', province));
                });
            

                // when the region selection changes, update the list of provinces
                $('#MR_addressRegion').on('change', function() {
                    var region = $(this).val();
                    var selectedProvinces = provinces[region];
                    var $provincesDropdown = $('#MR_addressProvince');
                    $provincesDropdown.empty();
                    $.each(selectedProvinces, function(i, province) {
                        $provincesDropdown.append($('<option></option>').attr('value', province).text(province));
                    });
                    // update the selected province if it's still in the list of available provinces
                    var selectedProvince = $provincesDropdown.val();
                        if ($.inArray(selectedProvince, selectedProvinces) === -1) {
                            $provincesDropdown.val(selectedProvinces[0]);
                        }
                });
            });
        </script>
        <div class="col-md-2">
            <label for="MR_addressCityMunicipality" class="form-label h6">City/Municipality<span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('MR_addressCityMunicipality') is-invalid @enderror" id="MR_addressCityMunicipality" name="MR_addressCityMunicipality" value="{{ old('MR_addressCityMunicipality') }}" oninput="this.value = this.value.toUpperCase()" required>
            <div class="invalid-feedback">
                Please enter your City/Municipality.
            </div>
            <span class="text-danger"> 
                @error('MR_addressCityMunicipality') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-3">
            <label for="MR_addressBrgySubdVillage" class="form-label h6">Barangay/Subdivision/Village<span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('MR_adressbrgySubdVillage') is-invalid @enderror" id="MR_addressBrgySubdVillage" name="MR_addressBrgySubdVillage" value="{{ old('MR_addressBrgySubdVillage') }}" oninput="this.value = this.value.toUpperCase()" required>
            <div class="invalid-feedback">
                Please enter your Barangay.
            </div>
            <span class="text-danger"> 
                @error('MR_addressBrgySubdVillage') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-3">
            <label for="MR_addressHouseNoStreet" class="form-label h6">House No./Street Name</label>
            <input type="text" class="form-control @error('MR_addressHouseNoStreet') is-invalid @enderror" id="MR_addressHouseNoStreet" name="MR_addressHouseNoStreet" value="{{ old('MR_addressHouseNoStreet') }}" oninput="this.value = this.value.toUpperCase()">
            <div class="invalid-feedback">
                Please enter your House No./Street Name.
            </div>
            <span class="text-danger"> 
                @error('MR_addressHouseNoStreet') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
            <header class="text-center">
                <!-- LINE BREAK -->
            </header>
        </section>
        <div class="col-md-6">
            <label for="MR_fatherName" class="form-label h6">Father's Name<span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('MR_fatherName') is-invalid @enderror" id="MR_fatherName" name="MR_fatherName" value="{{ old('MR_fatherName') }}" oninput="this.value = this.value.toUpperCase()" required>
            <div class="invalid-feedback">
                Please enter your father's name.
            </div>
            <span class="text-danger"> 
                @error('MR_fatherName') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        
        <div class="col-md-6">
            <label for="MR_fatherOccupation" class="form-label h6">Father's Occupation<span class="text-danger">*</span></label>
            <input type="text" class="form-control h6 @error('MR_fatherOccupation') is-invalid @enderror" id="MR_fatherOccupation" name="MR_fatherOccupation" value="{{ old('MR_fatherOccupation') }}" oninput="this.value = this.value.toUpperCase()" required>
            <span class="text-danger"> 
                @error('MR_fatherOccupation') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        

        <!-- FATHER OFFICE ADDRESS -->
        <label for="MR_fatherOffice" class="form-label h6">Office Address of Father<span class="text-danger">*</span></label>
        
        @php
            $regions = [
                ['number' => 'REGION I', 'name' => 'ILOCOS REGION'],
                ['number' => 'REGION II', 'name' => 'CAGAYAN VALLEY'],
                ['number' => 'REGION III', 'name' => 'CENTRAL LUZON'],
                ['number' => 'REGION IV-A', 'name' => 'CALABARZON'],
                ['number' => 'MIMAROPA REGION', 'name' => 'MIMAROPA REGION'],
                ['number' => 'REGION V', 'name' => 'BICOL REGION'],
                ['number' => 'REGION VI', 'name' => 'WESTERN VISAYAS'],
                ['number' => 'REGION VII', 'name' => 'CENTRAL VISAYAS'],
                ['number' => 'REGION VIII', 'name' => 'EASTERN VISAYAS'],
                ['number' => 'REGION IX', 'name' => 'ZAMBOANGA PENINSULA'],
                ['number' => 'REGION X', 'name' => 'NORTHERN MINDANAO'],
                ['number' => 'REGION XI', 'name' => 'DAVAO REGION'],
                ['number' => 'REGION XII', 'name' => 'SOCCSKSARGEN'],
                ['number' => 'CARAGA REGION', 'name' => 'CARAGA'],
                ['number' => 'NCR', 'name' => 'NATIONAL CAPITAL REGION'],
                ['number' => 'CAR', 'name' => 'CORDILLERA ADMINISTRATIVE REGION'],
                ['number' => 'BARMM', 'name' => 'BANGSAMORO AUTONOMOUS REGION IN MUSLIM MINDANAO']
            ];
        @endphp
        <div class="col-md-2">
            <label for="FO_addressRegion" class="form-label h6">Region<span class="text-danger">*</span></label>
            <select class="form-select  @error('FO_addressRegion') is-invalid @enderror" id="FO_addressRegion" name="FO_addressRegion" required>
                <option selected="selected" disabled="disabled" value="">SELECT</option>
                @foreach ($regions as $region)
                    <option value="{{ $region['number'] }}" {{ old('region') == $region['number'] ? 'selected' : '' }}>
                        {{ $region['number'] }} - {{ $region['name'] }}
                    </option>
                @endforeach
            </select>
            <div class="invalid-feedback">
                Please enter your Region.
            </div>
            <span class="text-danger"> 
                @error('FO_addressRegion') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-2">
            <label for="FO_addressProvince" class="form-label h6">Province<span class="text-danger">*</span></label>
                <select class="form-select  @error('FO_addressProvince') is-invalid @enderror" id="FO_addressProvince" name="FO_addressProvince"  required>
                    <option selected="selected" disabled="disabled" value="">SELECT</option>
                </select>
            <div class="invalid-feedback">
                Please enter your Province.
            </div>
            <span class="text-danger"> 
                @error('FO_addressProvince') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <script>
            var provinces={
                "REGION I": ["ILOCOS NORTE","ILOCOS SUR","LA UNION","PANGASINAN"],
                "REGION II": ["BATANES","CAGAYAN","ISABELA","NUEVA VIZCAYA","QUIRINO"],
                "REGION III": ["AURORA","BATAAN","BULACAN","NUEVA ECIJA","PAMPANGA","TARLAC","ZAMBALES"],
                "REGION IV-A": ["BATANGAS","CAVITE","LAGUNA","QUEZON","RIZAL"],
                "MIMAROPA REGION": ["MARINDUQUE","OCCIDENTAL MINDORO","ORIENTAL MINDORO","PALAWAN","ROMBLON"],
                "REGION V": ["ALBAY","CAMARINES NORTE","CAMARINES SUR","CATANDUANES","MASBATE","SORSOGON"],
                "REGION VI": ["AKLAN","ANTIQUE","CAPIZ","GUIMARAS","ILOILO","NEGROS OCCIDENTAL"],
                "REGION VII": ["BOHOL","CEBU","NEGROS ORIENTAL","SIQUIJOR"],
                "REGION VIII": ["BILIRAN","EASTERN SAMAR","LEYTE","NORTHERN SAMAR","SAMAR","SOUTHERN LEYTE"],
                "REGION IX": ["ZAMBOANGA DEL NORTE","ZAMBOANGA DEL SUR","ZAMBOANGA SIBUGAY"],
                "REGION X": ["BUKIDNON","CAMIGUIN","LANAO DEL NORTE","MISAMIS OCCIDENTAL","MISAMIS ORIENTAL"],
                "REGION XI": ["DAVAO DE ORO","DAVAO DEL NORTE","DAVAO DEL SUR","DAVAO OCCIDENTAL","DAVAO ORIENTAL"],
                "REGION XII": ["COTABATO","SARANGANI","SOUTH COTABATO","SULTAN KUDARAT"],
                "CARAGA REGION": ["AGUSAN DEL NORTE","AGUSAN DEL SUR","DINAGAT ISLANDS","SURIGAO DEL NORTE","SURIGAO DEL SUR"],
                "NCR": ["MANILA","CALOOCAN","LAS PIÑAS","MAKATI","MALABON","MANDALUYONG","MARIKINA","MUNTINLUPA","NAVOTAS","PARAÑAQUE","PASAY","PASIG","QUEZON CITY","SAN JUAN","TAGUIG","VALENZUELA"],
                "CAR": ["ABRA","APAYAO","BENGUET","IFUGAO","KALINGA","MOUNTAIN PROVINCE"],
                "BARMM": ["BASILAN","LANAO DEL SUR","MAGUINDANAO","SULU","TAWI-TAWI"]
            };

            $(document).ready(function() {
                // get the selected region
                var region = $('#FO_addressRegion').val();
                // get the corresponding provinces from the provinces object
                var selectedProvinces = provinces[region];
                // update the list of provinces in the dropdown
                var $provincesDropdown = $('#FO_addressProvince');
                $provincesDropdown.empty();
                $.each(selectedProvinces, function(i, province) {
                    $provincesDropdown.append($('<option>').text(province).attr('value', province));
                });
            

                // when the region selection changes, update the list of provinces
                $('#FO_addressRegion').on('change', function() {
                    var region = $(this).val();
                    var selectedProvinces = provinces[region];
                    var $provincesDropdown = $('#FO_addressProvince');
                    $provincesDropdown.empty();
                    $.each(selectedProvinces, function(i, province) {
                        $provincesDropdown.append($('<option></option>').attr('value', province).text(province));
                    });
                    // update the selected province if it's still in the list of available provinces
                    var selectedProvince = $provincesDropdown.val();
                        if ($.inArray(selectedProvince, selectedProvinces) === -1) {
                            $provincesDropdown.val(selectedProvinces[0]);
                        }
                });
            });
        </script>
        <div class="col-md-2">
            <label for="FO_addressCityMunicipality" class="form-label h6">City/Municipality<span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('FO_addressCityMunicipality') is-invalid @enderror" id="FO_addressCityMunicipality" name="FO_addressCityMunicipality" value="{{ old('FO_addressCityMunicipality') }}" oninput="this.value = this.value.toUpperCase()"  required>
            <div class="invalid-feedback">
                Please enter your City/Municipality.
            </div>
            <span class="text-danger"> 
                @error('FO_addressCityMunicipality') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-3">
            <label for="FO_addressBrgySubdVillage" class="form-label h6">Barangay/Subdivision/Village<span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('FO_addressBrgySubdVillage') is-invalid @enderror" id="FO_addressBrgySubdVillage" name="FO_addressBrgySubdVillage" value="{{ old('FO_addressBrgySubdVillage') }}" oninput="this.value = this.value.toUpperCase()"  required>
            <div class="invalid-feedback">
                Please enter your Barangay.
            </div>
            <span class="text-danger"> 
                @error('FO_addressBrgySubdVillage') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-3">
            <label for="FO_addressHouseNoStreet" class="form-label h6">House No./Street Name<span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('FO_addressHouseNoStreet') is-invalid @enderror" id="FO_addressHouseNoStreet" name="FO_addressHouseNoStreet" value="{{ old('FO_addressHouseNoStreet') }}" oninput="this.value = this.value.toUpperCase()"  required>
            <div class="invalid-feedback">
                Please enter your House No./Street Name.
            </div>
            <span class="text-danger"> 
                @error('FO_addressHouseNoStreet') 
                  {{ $message }} 
                @enderror
            </span>
        </div>

        <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
            <header class="text-center">
                <!-- LINE BREAK -->
            </header>
        </section>

        <div class="col-md-6">
            <label for="MR_motherName" class="form-label h6">Mother's Name<span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('MR_motherName') is-invalid @enderror" id="MR_motherName" name="MR_motherName" value="{{ old('MR_motherName') }}" oninput="this.value = this.value.toUpperCase()" required>
            <div class="invalid-feedback">
                Please enter your mother's name.
            </div>
            <span class="text-danger"> 
                @error('MR_motherName') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-6">
            <label for="MR_motherOccupation" class="form-label h6">Mother's Occupation<span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('MR_motherOccupation') is-invalid @enderror" id="MR_motherOccupation" name="MR_motherOccupation" value="{{ old('MR_motherOccupation') }}" oninput="this.value = this.value.toUpperCase()" required>
            <span class="text-danger"> 
                @error('MR_motherOccupation') 
                  {{ $message }} 
                @enderror
              </span>
        </div>

<!-- MOTHER OFFICE ADDRESS -->
<label for="MR_fatherOffice" class="form-label h6">Office Address of Mother<span class="text-danger">*</span></label>
        
@php
    $regions = [
        ['number' => 'REGION I', 'name' => 'ILOCOS REGION'],
        ['number' => 'REGION II', 'name' => 'CAGAYAN VALLEY'],
        ['number' => 'REGION III', 'name' => 'CENTRAL LUZON'],
        ['number' => 'REGION IV-A', 'name' => 'CALABARZON'],
        ['number' => 'MIMAROPA REGION', 'name' => 'MIMAROPA REGION'],
        ['number' => 'REGION V', 'name' => 'BICOL REGION'],
        ['number' => 'REGION VI', 'name' => 'WESTERN VISAYAS'],
        ['number' => 'REGION VII', 'name' => 'CENTRAL VISAYAS'],
        ['number' => 'REGION VIII', 'name' => 'EASTERN VISAYAS'],
        ['number' => 'REGION IX', 'name' => 'ZAMBOANGA PENINSULA'],
        ['number' => 'REGION X', 'name' => 'NORTHERN MINDANAO'],
        ['number' => 'REGION XI', 'name' => 'DAVAO REGION'],
        ['number' => 'REGION XII', 'name' => 'SOCCSKSARGEN'],
        ['number' => 'CARAGA REGION', 'name' => 'CARAGA'],
        ['number' => 'NCR', 'name' => 'NATIONAL CAPITAL REGION'],
        ['number' => 'CAR', 'name' => 'CORDILLERA ADMINISTRATIVE REGION'],
        ['number' => 'BARMM', 'name' => 'BANGSAMORO AUTONOMOUS REGION IN MUSLIM MINDANAO']
    ];
@endphp

<div class="col-md-2">
    <label for="MO_addressRegion" class="form-label h6">Region<span class="text-danger">*</span></label>
    <select class="form-select  @error('MO_addressRegion') is-invalid @enderror" id="MO_addressRegion" name="MO_addressRegion"  required>
        <option selected="selected" disabled="disabled" value="">SELECT</option>
        @foreach ($regions as $region)
            <option value="{{ $region['number'] }}" {{ old('region') == $region['number'] ? 'selected' : '' }}>
                {{ $region['number'] }} - {{ $region['name'] }}
            </option>
        @endforeach
    </select>
    <div class="invalid-feedback">
        Please enter your Region.
    </div>
    <span class="text-danger"> 
        @error('MO_addressRegion') 
          {{ $message }} 
        @enderror
    </span>
</div>
<div class="col-md-2">
    <label for="MO_addressProvince" class="form-label h6">Province<span class="text-danger">*</span></label>
        <select class="form-select  @error('MO_addressProvince') is-invalid @enderror" id="MO_addressProvince" name="MO_addressProvince"  required>
            <option selected="selected" disabled="disabled" value="">SELECT</option>
        </select>
    <div class="invalid-feedback">
        Please enter your Province.
    </div>
    <span class="text-danger"> 
        @error('MO_addressProvince') 
          {{ $message }} 
        @enderror
    </span>
</div>
<script>
    var provinces={
        "REGION I": ["ILOCOS NORTE","ILOCOS SUR","LA UNION","PANGASINAN"],
        "REGION II": ["BATANES","CAGAYAN","ISABELA","NUEVA VIZCAYA","QUIRINO"],
        "REGION III": ["AURORA","BATAAN","BULACAN","NUEVA ECIJA","PAMPANGA","TARLAC","ZAMBALES"],
        "REGION IV-A": ["BATANGAS","CAVITE","LAGUNA","QUEZON","RIZAL"],
        "MIMAROPA REGION": ["MARINDUQUE","OCCIDENTAL MINDORO","ORIENTAL MINDORO","PALAWAN","ROMBLON"],
        "REGION V": ["ALBAY","CAMARINES NORTE","CAMARINES SUR","CATANDUANES","MASBATE","SORSOGON"],
        "REGION VI": ["AKLAN","ANTIQUE","CAPIZ","GUIMARAS","ILOILO","NEGROS OCCIDENTAL"],
        "REGION VII": ["BOHOL","CEBU","NEGROS ORIENTAL","SIQUIJOR"],
        "REGION VIII": ["BILIRAN","EASTERN SAMAR","LEYTE","NORTHERN SAMAR","SAMAR","SOUTHERN LEYTE"],
        "REGION IX": ["ZAMBOANGA DEL NORTE","ZAMBOANGA DEL SUR","ZAMBOANGA SIBUGAY"],
        "REGION X": ["BUKIDNON","CAMIGUIN","LANAO DEL NORTE","MISAMIS OCCIDENTAL","MISAMIS ORIENTAL"],
        "REGION XI": ["DAVAO DE ORO","DAVAO DEL NORTE","DAVAO DEL SUR","DAVAO OCCIDENTAL","DAVAO ORIENTAL"],
        "REGION XII": ["COTABATO","SARANGANI","SOUTH COTABATO","SULTAN KUDARAT"],
        "CARAGA REGION": ["AGUSAN DEL NORTE","AGUSAN DEL SUR","DINAGAT ISLANDS","SURIGAO DEL NORTE","SURIGAO DEL SUR"],
        "NCR": ["MANILA","CALOOCAN","LAS PIÑAS","MAKATI","MALABON","MANDALUYONG","MARIKINA","MUNTINLUPA","NAVOTAS","PARAÑAQUE","PASAY","PASIG","QUEZON CITY","SAN JUAN","TAGUIG","VALENZUELA"],
        "CAR": ["ABRA","APAYAO","BENGUET","IFUGAO","KALINGA","MOUNTAIN PROVINCE"],
        "BARMM": ["BASILAN","LANAO DEL SUR","MAGUINDANAO","SULU","TAWI-TAWI"]
    };

    $(document).ready(function() {
        // get the selected region
        var region = $('#MO_addressRegion').val();
        // get the corresponding provinces from the provinces object
        var selectedProvinces = provinces[region];
        // update the list of provinces in the dropdown
        var $provincesDropdown = $('#MO_addressProvince');
        $provincesDropdown.empty();
        $.each(selectedProvinces, function(i, province) {
            $provincesDropdown.append($('<option>').text(province).attr('value', province));
        });
    

        // when the region selection changes, update the list of provinces
        $('#MO_addressRegion').on('change', function() {
            var region = $(this).val();
            var selectedProvinces = provinces[region];
            var $provincesDropdown = $('#MO_addressProvince');
            $provincesDropdown.empty();
            $.each(selectedProvinces, function(i, province) {
                $provincesDropdown.append($('<option></option>').attr('value', province).text(province));
            });
            // update the selected province if it's still in the list of available provinces
            var selectedProvince = $provincesDropdown.val();
                if ($.inArray(selectedProvince, selectedProvinces) === -1) {
                    $provincesDropdown.val(selectedProvinces[0]);
                }
        });
    });
</script>
        <div class="col-md-2">
            <label for="MO_addressCityMunicipality" class="form-label h6">City/Municipality<span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('MO_addressCityMunicipality') is-invalid @enderror" id="MO_addressCityMunicipality" name="MO_addressCityMunicipality" value="{{ old('MO_addressCityMunicipality') }}" oninput="this.value = this.value.toUpperCase()"  required>
            <div class="invalid-feedback">
                Please enter your City/Municipality.
            </div>
            <span class="text-danger"> 
                @error('MO_addressCityMunicipality') 
                {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-3">
            <label for="MO_addressBrgySubdVillage" class="form-label h6">Barangay/Subdivision/Village<span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('MO_addressBrgySubdVillage') is-invalid @enderror" id="MO_addressBrgySubdVillage" name="MO_addressBrgySubdVillage" value="{{ old('MO_addressBrgySubdVillage') }}" oninput="this.value = this.value.toUpperCase()"  required>
            <div class="invalid-feedback">
                Please enter your Barangay.
            </div>
            <span class="text-danger"> 
                @error('MO_addressBrgySubdVillage') 
                {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-3">
            <label for="MO_addressHouseNoStreet" class="form-label h6">House No./Street Name<span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('MO_addressHouseNoStreet') is-invalid @enderror" id="MO_addressHouseNoStreet" name="MO_addressHouseNoStreet" value="{{ old('MO_addressHouseNoStreet') }}" oninput="this.value = this.value.toUpperCase()"  required>
            <div class="invalid-feedback">
                Please enter your House No./Street Name.
            </div>
            <span class="text-danger"> 
                @error('MO_addressHouseNoStreet') 
                {{ $message }} 
                @enderror
            </span>
        </div>

        <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
            <header class="text-center">
                <!-- LINE BREAK -->
            </header>
        </section>

        <div class="col-md-6">
            <label for="MR_guardian" class="form-label h6">Guardian's Name</label>
            <input type="text" class="form-control @error('MR_guardian') is-invalid @enderror" id="MR_guardian" name="MR_guardianName" value="{{ old('MR_guardianName') }}" placeholder="skip if not applicable" oninput="this.value = this.value.toUpperCase()">
            <span class="text-danger">
                @error('MR_guardianName') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-6">
            <label for="MR_parentGuardianContactNumber" class="form-label h6">Parent's/Guardian's Contact No.<span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('MR_parentGuardianContactNumber') is-invalid @enderror" placeholder="09123456789" value="{{ old('MR_parentGuardianContactNumber') }}" id="MR_parentGuardianContactNumber" onKeyPress="if(this.value.length==11) return false;" name="MR_parentGuardianContactNumber" required>
            <div class="invalid-feedback">
                Please enter your parent's or guardian's contact number.
            </div>
            <span class="text-danger"> 
                @error('MR_parentGuardianContactNumber') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        
         <!--ADDRESS GUARDIAN-->
         <label for="GR_fatherOffice" class="form-label h6">Address of Guardian<span class="text-danger">*</span></label>
        
         @php
             $regions = [
                 ['number' => 'REGION I', 'name' => 'ILOCOS REGION'],
                 ['number' => 'REGION II', 'name' => 'CAGAYAN VALLEY'],
                 ['number' => 'REGION III', 'name' => 'CENTRAL LUZON'],
                 ['number' => 'REGION IV-A', 'name' => 'CALABARZON'],
                 ['number' => 'MIMAROPA REGION', 'name' => 'MIMAROPA REGION'],
                 ['number' => 'REGION V', 'name' => 'BICOL REGION'],
                 ['number' => 'REGION VI', 'name' => 'WESTERN VISAYAS'],
                 ['number' => 'REGION VII', 'name' => 'CENTRAL VISAYAS'],
                 ['number' => 'REGION VIII', 'name' => 'EASTERN VISAYAS'],
                 ['number' => 'REGION IX', 'name' => 'ZAMBOANGA PENINSULA'],
                 ['number' => 'REGION X', 'name' => 'NORTHERN MINDANAO'],
                 ['number' => 'REGION XI', 'name' => 'DAVAO REGION'],
                 ['number' => 'REGION XII', 'name' => 'SOCCSKSARGEN'],
                 ['number' => 'CARAGA REGION', 'name' => 'CARAGA'],
                 ['number' => 'NCR', 'name' => 'NATIONAL CAPITAL REGION'],
                 ['number' => 'CAR', 'name' => 'CORDILLERA ADMINISTRATIVE REGION'],
                 ['number' => 'BARMM', 'name' => 'BANGSAMORO AUTONOMOUS REGION IN MUSLIM MINDANAO']
             ];
         @endphp
         <div class="col-md-2">
             <label for="GR_addressRegion" class="form-label h6">Region</label>
             <select class="form-select  @error('GR_addressRegion') is-invalid @enderror" id="GR_addressRegion" name="GR_addressRegion">
                 <option selected="selected" disabled="disabled" value="">SELECT</option>
                 @foreach ($regions as $region)
                     <option value="{{ $region['number'] }}" {{ old('region') == $region['number'] ? 'selected' : '' }}>
                         {{ $region['number'] }} - {{ $region['name'] }}
                     </option>
                 @endforeach
             </select>
             <div class="invalid-feedback">
                 Please enter your Region.
             </div>
             <span class="text-danger"> 
                 @error('GR_addressRegion') 
                   {{ $message }} 
                 @enderror
             </span>
         </div>
         <div class="col-md-2">
             <label for="GR_addressProvince" class="form-label h6">Province</label>
                 <select class="form-select  @error('GR_addressProvince') is-invalid @enderror" id="GR_addressProvince" name="GR_addressProvince">
                     <option selected="selected" disabled="disabled" value="">SELECT</option>
                 </select>
             <div class="invalid-feedback">
                 Please enter your Province.
             </div>
             <span class="text-danger"> 
                 @error('GR_addressProvince') 
                   {{ $message }} 
                 @enderror
             </span>
         </div>
         <script>
             var provinces={
                 "REGION I": ["ILOCOS NORTE","ILOCOS SUR","LA UNION","PANGASINAN"],
                 "REGION II": ["BATANES","CAGAYAN","ISABELA","NUEVA VIZCAYA","QUIRINO"],
                 "REGION III": ["AURORA","BATAAN","BULACAN","NUEVA ECIJA","PAMPANGA","TARLAC","ZAMBALES"],
                 "REGION IV-A": ["BATANGAS","CAVITE","LAGUNA","QUEZON","RIZAL"],
                 "MIMAROPA REGION": ["MARINDUQUE","OCCIDENTAL MINDORO","ORIENTAL MINDORO","PALAWAN","ROMBLON"],
                 "REGION V": ["ALBAY","CAMARINES NORTE","CAMARINES SUR","CATANDUANES","MASBATE","SORSOGON"],
                 "REGION VI": ["AKLAN","ANTIQUE","CAPIZ","GUIMARAS","ILOILO","NEGROS OCCIDENTAL"],
                 "REGION VII": ["BOHOL","CEBU","NEGROS ORIENTAL","SIQUIJOR"],
                 "REGION VIII": ["BILIRAN","EASTERN SAMAR","LEYTE","NORTHERN SAMAR","SAMAR","SOUTHERN LEYTE"],
                 "REGION IX": ["ZAMBOANGA DEL NORTE","ZAMBOANGA DEL SUR","ZAMBOANGA SIBUGAY"],
                 "REGION X": ["BUKIDNON","CAMIGUIN","LANAO DEL NORTE","MISAMIS OCCIDENTAL","MISAMIS ORIENTAL"],
                 "REGION XI": ["DAVAO DE ORO","DAVAO DEL NORTE","DAVAO DEL SUR","DAVAO OCCIDENTAL","DAVAO ORIENTAL"],
                 "REGION XII": ["COTABATO","SARANGANI","SOUTH COTABATO","SULTAN KUDARAT"],
                 "CARAGA REGION": ["AGUSAN DEL NORTE","AGUSAN DEL SUR","DINAGAT ISLANDS","SURIGAO DEL NORTE","SURIGAO DEL SUR"],
                 "NCR": ["MANILA","CALOOCAN","LAS PIÑAS","MAKATI","MALABON","MANDALUYONG","MARIKINA","MUNTINLUPA","NAVOTAS","PARAÑAQUE","PASAY","PASIG","QUEZON CITY","SAN JUAN","TAGUIG","VALENZUELA"],
                 "CAR": ["ABRA","APAYAO","BENGUET","IFUGAO","KALINGA","MOUNTAIN PROVINCE"],
                 "BARMM": ["BASILAN","LANAO DEL SUR","MAGUINDANAO","SULU","TAWI-TAWI"]
             };
 
             $(document).ready(function() {
                 // get the selected region
                 var region = $('#GR_addressRegion').val();
                 // get the corresponding provinces from the provinces object
                 var selectedProvinces = provinces[region];
                 // update the list of provinces in the dropdown
                 var $provincesDropdown = $('#GR_addressProvince');
                 $provincesDropdown.empty();
                 $.each(selectedProvinces, function(i, province) {
                     $provincesDropdown.append($('<option>').text(province).attr('value', province));
                 });
             
 
                 // when the region selection changes, update the list of provinces
                 $('#GR_addressRegion').on('change', function() {
                     var region = $(this).val();
                     var selectedProvinces = provinces[region];
                     var $provincesDropdown = $('#GR_addressProvince');
                     $provincesDropdown.empty();
                     $.each(selectedProvinces, function(i, province) {
                         $provincesDropdown.append($('<option></option>').attr('value', province).text(province));
                     });
                     // update the selected province if it's still in the list of available provinces
                     var selectedProvince = $provincesDropdown.val();
                         if ($.inArray(selectedProvince, selectedProvinces) === -1) {
                             $provincesDropdown.val(selectedProvinces[0]);
                         }
                 });
             });
         </script>
         <div class="col-md-2">
             <label for="GR_addressCityMunicipality" class="form-label h6">City/Municipality</label>
             <input type="text" class="form-control @error('GR_addressCityMunicipality') is-invalid @enderror" id="GR_addressCityMunicipality" name="GR_addressCityMunicipality" value="{{ old('GR_addressCityMunicipality') }}" oninput="this.value = this.value.toUpperCase()">
             <div class="invalid-feedback">
                 Please enter your City/Municipality.
             </div>
             <span class="text-danger"> 
                 @error('GR_addressCityMunicipality') 
                   {{ $message }} 
                 @enderror
             </span>
         </div>
         <div class="col-md-3">
             <label for="GR_addressBrgySubdVillage" class="form-label h6">Barangay/Subdivision/Village</label>
             <input type="text" class="form-control @error('GR_addressBrgySubdVillage') is-invalid @enderror" id="GR_addressBrgySubdVillage" name="GR_addressBrgySubdVillage" value="{{ old('GR_addressBrgySubdVillage') }}" oninput="this.value = this.value.toUpperCase()">
             <div class="invalid-feedback">
                 Please enter your Barangay.
             </div>
             <span class="text-danger"> 
                 @error('GR_addressBrgySubdVillage') 
                   {{ $message }} 
                 @enderror
             </span>
         </div>
         <div class="col-md-3">
             <label for="GR_addressHouseNoStreet" class="form-label h6">House No./Street Name</label>
             <input type="text" class="form-control @error('GR_addressHouseNoStreet') is-invalid @enderror" id="GR_addressHouseNoStreet" name="GR_addressHouseNoStreet" value="{{ old('GR_addressHouseNoStreet') }}" oninput="this.value = this.value.toUpperCase()">
             <div class="invalid-feedback">
                 Please enter your House No./Street Name.
             </div>
             <span class="text-danger"> 
                 @error('GR_addressHouseNoStreet') 
                   {{ $message }} 
                 @enderror
             </span>
         </div>

        <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark border-lg-end-0">
            <header class="text-center">
                <!-- LINE BREAK -->
            </header>
        </section>
        <div class="col-md-4">
            <label for="MR_emergencyContactPerson" class="form-label h6">In case of emergency, contact:<span class="text-danger">*</span></label>
            <select class="form-select @error('MR_emergencyContactPerson') is-invalid @enderror" name="MR_emergencyContactPerson" id="MR_emergencyContactPerson" required>
                <option value="" selected disabled>SELECT</option>
                <option value="FATHER" {{ old('MR_emergencyContactPerson') == 'FATHER' ? 'selected' : '' }}>Father</option>
                <option value="MOTHER" {{ old('MR_emergencyContactPerson') == 'MOTHER' ? 'selected' : '' }}>Mother</option>
                <option value="GUARDIAN" {{ old('MR_emergencyContactPerson') == 'GUARDIAN' ? 'selected' : '' }}>Guardian</option>
                <option value="OTHERS" {{ old('MR_emergencyContactPerson') == 'OTHERS' ? 'selected' : '' }}>Someone else</option>
            </select>
            <div class="invalid-feedback">
                Please select your emergency contact person.
            </div>
            <script>
                $(document).ready(function() {
                    $('#MR_emergencyContactPerson').on('change', function() {
                        if($(this).val() == 'FATHER') {
                            console.log('Father option is selected');
                            $('#MR_emergencyContactName').val($('#MR_fatherName').val());
                            $('#MR_emergencyContactOccupation').val($('#MR_fatherOccupation').val());
                            $('#MR_emergencyContactRelationship').val('FATHER');
                        /**   
                            $('#EC_addressRegion').val($('#FO_addressRegion').val());
                            $('#EC_addressProvince').val($('#FO_addressProvince').val());
                            $('#EC_addressCityMunicipality').val($('#FO_addressCityMunicipality').val());
                            $('#EC_addressBrgySubdVillage').val($('#FO_addressBrgySubdVillage').val());
                            $('#EC_addressHouseNoStreet').val($('#FO_addressHouseNoStreet').val()); */

                        } else if($(this).val() == 'MOTHER') {
                            console.log('Mother option is selected');
                            $('#MR_emergencyContactName').val($('#MR_motherName').val());
                            $('#MR_emergencyContactOccupation').val($('#MR_motherOccupation').val());
                            $('#MR_emergencyContactRelationship').val('MOTHER');
                        /**   
                            $('#EC_addressRegion').val($('#MO_addressRegion').val());
                            $('#EC_addressProvince').val($('#MO_addressProvince').val());
                            $('#EC_addressCityMunicipality').val($('#MO_addressCityMunicipality').val());
                            $('#EC_addressBrgySubdVillage').val($('#MO_addressBrgySubdVillage').val());
                            $('#EC_addressHouseNoStreet').val($('#MO_addressHouseNoStreet').val()); */

                        } else if($(this).val() == 'GUARDIAN') {
                            console.log('Guardian option is selected');
                            $('#MR_emergencyContactName').val($('#MR_guardian').val());
                            $('#MR_emergencyContactAddress').val($('#MR_guardianAddress').val());
                            $('#MR_emergencyContactRelationship').val('GUARDIAN');
                            $('#MR_emergencyContactOccupation').val($('').val());
                        /**
                            $('#EC_addressRegion').val($('#GR_addressRegion').val());
                            $('#EC_addressProvince').val($('#GR_addressProvince').val());
                            $('#EC_addressCityMunicipality').val($('#GR_addressCityMunicipality').val());
                            $('#EC_addressBrgySubdVillage').val($('#GR_addressBrgySubdVillage').val());
                            $('#EC_addressHouseNoStreet').val($('#GR_addressHouseNoStreet').val()); */

                        } else if($(this).val() == 'OTHERS') {
                            console.log('Others option is selected');
                            $('#MR_emergencyContactName').val('');
                            $('#MR_emergencyContactOccupation').val('');
                            $('#MR_emergencyContactRelationship').val('');

                     /**    $('#EC_addressRegion').val('');
                            $('#EC_addressProvince').val('');
                            $('#EC_addressCityMunicipality').val('');
                            $('#EC_addressBrgySubdVillage').val('');
                            $('#EC_addressHouseNoStreet').val(''); */
                        }
                    });
                });
            </script>
        </div>
        <div class="col-md-4">
            <label for="MR_emergencyContactNumber" class="form-label h6 @error('MR_emergencyContactNumber') is-invalid @enderror">Contact Number<span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="MR_emergencyContactNumber" value="{{ old('MR_emergencyContactNumber') }}" name="MR_emergencyContactNumber" onKeyPress="if(this.value.length==11) return false;" required>
            <div class="invalid-feedback">
                Please enter the contact number of your emergency contact person.
            </div>
            <span class="text-danger"> 
                @error('MR_emergencyContactNumber') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        
        <div class="col-md-4">
            <label for="MR_emergencyContactName" class="form-label h6 @error('MR_emergencyContactName') is-invalid @enderror">Emergency Contact Name<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="MR_emergencyContactName" value="{{ old('MR_emergencyContactName') }}" oninput="this.value = this.value.toUpperCase()" name="MR_emergencyContactName" required>
            <div class="invalid-feedback">
                Please enter the name of your emergency contact person.
            </div>
            <span class="text-danger">
                @error('MR_emergencyContactName') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-6">
            <label for="MR_emergencyContactOccupation" class="form-label h6 @error('MR_emergencyContactOccupation') is-invalid @enderror">Occupation<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="MR_emergencyContactOccupation" value="{{ old('MR_emergencyContactOccupation') }}" oninput="this.value = this.value.toUpperCase()" name="MR_emergencyContactOccupation" required>
            <div class="invalid-feedback">
                Please enter the occupation of your emergency contact person.
            </div>
            <span class="text-danger"> 
                @error('MR_emergencyContactOccupation') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-6">
            <label for="MR_emergencyContactRelationship" class="form-label h6 @error('MR_emergencyContactRelationship') is-invalid @enderror">Relationship<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="MR_emergencyContactRelationship" value="{{ old('MR_emergencyContactRelationship') }}" oninput="this.value = this.value.toUpperCase()" name="MR_emergencyContactRelationship" required>
            <div class="invalid-feedback">
                Please enter your relationship with your emergency contact person.
            </div>
            <span class="text-danger"> 
                @error('MR_emergencyContactRelationship') 
                  {{ $message }} 
                @enderror
            </span>
        </div>

        <!--EMERGENCY CONTACT ADDRESS-->
        <label for="EC_address" class="form-label h6">EMERGENCY CONTACT ADDRESS<span class="text-danger">*</span></label>
        
        @php
            $regions = [
                ['number' => 'REGION I', 'name' => 'ILOCOS REGION'],
                ['number' => 'REGION II', 'name' => 'CAGAYAN VALLEY'],
                ['number' => 'REGION III', 'name' => 'CENTRAL LUZON'],
                ['number' => 'REGION IV-A', 'name' => 'CALABARZON'],
                ['number' => 'MIMAROPA REGION', 'name' => 'MIMAROPA REGION'],
                ['number' => 'REGION V', 'name' => 'BICOL REGION'],
                ['number' => 'REGION VI', 'name' => 'WESTERN VISAYAS'],
                ['number' => 'REGION VII', 'name' => 'CENTRAL VISAYAS'],
                ['number' => 'REGION VIII', 'name' => 'EASTERN VISAYAS'],
                ['number' => 'REGION IX', 'name' => 'ZAMBOANGA PENINSULA'],
                ['number' => 'REGION X', 'name' => 'NORTHERN MINDANAO'],
                ['number' => 'REGION XI', 'name' => 'DAVAO REGION'],
                ['number' => 'REGION XII', 'name' => 'SOCCSKSARGEN'],
                ['number' => 'CARAGA REGION', 'name' => 'CARAGA'],
                ['number' => 'NCR', 'name' => 'NATIONAL CAPITAL REGION'],
                ['number' => 'CAR', 'name' => 'CORDILLERA ADMINISTRATIVE REGION'],
                ['number' => 'BARMM', 'name' => 'BANGSAMORO AUTONOMOUS REGION IN MUSLIM MINDANAO']
            ];
        @endphp
        <div class="col-md-2">
            <label for="EC_addressRegion" class="form-label h6">Region<span class="text-danger">*</span></label>
            <select class="form-select  @error('EC_addressRegion') is-invalid @enderror" id="EC_addressRegion" name="EC_addressRegion"  required>
                <option selected="selected" disabled="disabled" value="">SELECT</option>
                @foreach ($regions as $region)
                    <option value="{{ $region['number'] }}" {{ old('region') == $region['number'] ? 'selected' : '' }}>
                        {{ $region['number'] }} - {{ $region['name'] }}
                    </option>
                @endforeach
            </select>
            <div class="invalid-feedback">
                Please enter your Region.
            </div>
            <span class="text-danger"> 
                @error('EC_addressRegion') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-2">
            <label for="EC_addressProvince" class="form-label h6">Province<span class="text-danger">*</span></label>
                <select class="form-select  @error('EC_addressProvince') is-invalid @enderror" id="EC_addressProvince" name="EC_addressProvince"  required>
                    <option selected="selected" disabled="disabled" value="">SELECT</option>
                </select>
            <div class="invalid-feedback">
                Please enter your Province.
            </div>
            <span class="text-danger"> 
                @error('EC_addressProvince') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <script>
            var provinces={
                "REGION I": ["ILOCOS NORTE","ILOCOS SUR","LA UNION","PANGASINAN"],
                "REGION II": ["BATANES","CAGAYAN","ISABELA","NUEVA VIZCAYA","QUIRINO"],
                "REGION III": ["AURORA","BATAAN","BULACAN","NUEVA ECIJA","PAMPANGA","TARLAC","ZAMBALES"],
                "REGION IV-A": ["BATANGAS","CAVITE","LAGUNA","QUEZON","RIZAL"],
                "MIMAROPA REGION": ["MARINDUQUE","OCCIDENTAL MINDORO","ORIENTAL MINDORO","PALAWAN","ROMBLON"],
                "REGION V": ["ALBAY","CAMARINES NORTE","CAMARINES SUR","CATANDUANES","MASBATE","SORSOGON"],
                "REGION VI": ["AKLAN","ANTIQUE","CAPIZ","GUIMARAS","ILOILO","NEGROS OCCIDENTAL"],
                "REGION VII": ["BOHOL","CEBU","NEGROS ORIENTAL","SIQUIJOR"],
                "REGION VIII": ["BILIRAN","EASTERN SAMAR","LEYTE","NORTHERN SAMAR","SAMAR","SOUTHERN LEYTE"],
                "REGION IX": ["ZAMBOANGA DEL NORTE","ZAMBOANGA DEL SUR","ZAMBOANGA SIBUGAY"],
                "REGION X": ["BUKIDNON","CAMIGUIN","LANAO DEL NORTE","MISAMIS OCCIDENTAL","MISAMIS ORIENTAL"],
                "REGION XI": ["DAVAO DE ORO","DAVAO DEL NORTE","DAVAO DEL SUR","DAVAO OCCIDENTAL","DAVAO ORIENTAL"],
                "REGION XII": ["COTABATO","SARANGANI","SOUTH COTABATO","SULTAN KUDARAT"],
                "CARAGA REGION": ["AGUSAN DEL NORTE","AGUSAN DEL SUR","DINAGAT ISLANDS","SURIGAO DEL NORTE","SURIGAO DEL SUR"],
                "NCR": ["MANILA","CALOOCAN","LAS PIÑAS","MAKATI","MALABON","MANDALUYONG","MARIKINA","MUNTINLUPA","NAVOTAS","PARAÑAQUE","PASAY","PASIG","QUEZON CITY","SAN JUAN","TAGUIG","VALENZUELA"],
                "CAR": ["ABRA","APAYAO","BENGUET","IFUGAO","KALINGA","MOUNTAIN PROVINCE"],
                "BARMM": ["BASILAN","LANAO DEL SUR","MAGUINDANAO","SULU","TAWI-TAWI"]
            };

            $(document).ready(function() {
                // get the selected region
                var region = $('#EC_addressRegion').val();
                // get the corresponding provinces from the provinces object
                var selectedProvinces = provinces[region];
                // update the list of provinces in the dropdown
                var $provincesDropdown = $('#EC_addressProvince');
                $provincesDropdown.empty();
                $.each(selectedProvinces, function(i, province) {
                    $provincesDropdown.append($('<option>').text(province).attr('value', province));

                        // clear the current options in the courseSelect element
/** 
                        if(region != null){
                                $('#EC_addressProvince').empty();
                                // add the new options based on the selected campus
                                $.each(selectedProvinces, function(index, value) {
                                    counter++;
                                    var option = $('<option>').text(value).attr('value', value);
                                    if (value == ($('#EC_addressProvince').val)) {
                                        option.attr('selected', 'selected');
                                    }
                                    if(counter % 2 == 1){
                                        $('#EC_addressProvince').append(option.addClass('alternate'));
                                    }else{
                                        $('#EC_addressProvince').append(option);
                                    }
                                });
                            } */
                });
            

                // when the region selection changes, update the list of provinces
                $('#EC_addressRegion').on('change', function() {
                    var region = $(this).val();
                    var selectedProvinces = provinces[region];
                    var $provincesDropdown = $('#EC_addressProvince');
                    $provincesDropdown.empty();
                    $.each(selectedProvinces, function(i, province) {
                        $provincesDropdown.append($('<option></option>').attr('value', province).text(province));
                    });
                    // update the selected province if it's still in the list of available provinces
                    var selectedProvince = $provincesDropdown.val();
                        if ($.inArray(selectedProvince, selectedProvinces) === -1) {
                            $provincesDropdown.val(selectedProvinces[0]);
                        }
              
                });
            });
        </script>
        <div class="col-md-2">
            <label for="EC_addressCityMunicipality" class="form-label h6">City/Municipality<span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('EC_addressCityMunicipality') is-invalid @enderror" id="EC_addressCityMunicipality" name="EC_addressCityMunicipality" value="{{ old('EC_addressCityMunicipality') }}" oninput="this.value = this.value.toUpperCase()"  required>
            <div class="invalid-feedback">
                Please enter your City/Municipality.
            </div>
            <span class="text-danger"> 
                @error('EC_addressCityMunicipality') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-3">
            <label for="EC_addressBrgySubdVillage" class="form-label h6">Barangay/Subdivision/Village<span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('EC_addressBrgySubdVillage') is-invalid @enderror" id="EC_addressBrgySubdVillage" name="EC_addressBrgySubdVillage" value="{{ old('EC_addressBrgySubdVillage') }}" oninput="this.value = this.value.toUpperCase()"  required>
            <div class="invalid-feedback">
                Please enter your Barangay.
            </div>
            <span class="text-danger"> 
                @error('EC_addressBrgySubdVillage') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-3">
            <label for="EC_addressHouseNoStreet" class="form-label h6">House No./Street Name<span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('EC_addressHouseNoStreet') is-invalid @enderror" id="EC_addressHouseNoStreet" name="EC_addressHouseNoStreet" value="{{ old('EC_addressHouseNoStreet') }}" oninput="this.value = this.value.toUpperCase()"  required>
            <div class="invalid-feedback">
                Please enter your House No./Street Name.
            </div>
            <span class="text-danger"> 
                @error('EC_addressHouseNoStreet') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        

        <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
            <header class="text-center">
                <!-- LINE BREAK -->
            </header>
        </section>

        <h5>Please click the box if one of the following is applicable to you</h5>

        <!--Family and Social History-->
        <div class="mx-auto row row-cols-lg-2 row-cols-md-1"><!-- START DIV FOR FAMILY HISTORY AND PSH -->
            <div class="col-lg-7 col-md-12 p-2 border border-dark border-lg-end-0">
                <h5>Family History</h5>
                <div class="row row-cols-sm-1 row-cols-md-2 row-cols-lg-3">
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" value="0" name="FH_cancer">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('FH_cancer') == '1' ? 'checked' : '' }} name="FH_cancer">
                                <label class="form-check-label" for="FH_cancer">
                                    Cancer
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" value="0" name="FH_heartDisease">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('FH_heartDisease') == '1' ? 'checked' : '' }} name="FH_heartDisease">
                                <label class="form-check-label" for="FH_heartDisease">
                                    Heart Disease
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" value="0" name="FH_hypertension">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('FH_hypertension') == '1' ? 'checked' : '' }} name="FH_hypertension">
                                <label class="form-check-label" for="FH_hypertension">
                                    Hypertension
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" value="0" name="FH_thyroidDisease">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('FH_thyroidDisease') == '1' ? 'checked' : '' }} name="FH_thyroidDisease">
                                <label class="form-check-label" for="FH_thyroidDisease">
                                    Thyroid Disease
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="FH_tuberculosis" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('FH_tuberculosis') == '1' ? 'checked' : '' }} name="FH_tuberculosis">
                                <label class="form-check-label" for="FH_tuberculosis">
                                    Tuberculosis
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div><!-- END OF COL DIV -->
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" value="0" name="FH_diabetesMelittus">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('FH_diabetesMelittus') == '1' ? 'checked' : '' }} name="FH_diabetesMelittus">
                                <label class="form-check-label" for="FH_diabetesMelittus">
                                    Diabetes Melittus
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="FH_mentalDisorder" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('FH_mentalDisorder') == '1' ? 'checked' : '' }} name="FH_mentalDisorder">
                                <label class="form-check-label" for="FH_mentalDisorder">
                                    Mental Disorder
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="FH_asthma" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('FH_asthma') == '1' ? 'checked' : '' }} name="FH_asthma">
                                <label class="form-check-label" for="FH_asthma">
                                    Asthma
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="FH_convulsions" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('FH_convulsions') == '1' ? 'checked' : '' }} name="FH_convulsions">
                                <label class="form-check-label" for="FH_convulsions">
                                    Convulsions
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="FH_bleedingDyscrasia" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('FH_bleedingDyscrasia') == '1' ? 'checked' : '' }} name="FH_bleedingDyscrasia">
                                <label class="form-check-label" for="FH_bleedingDyscrasia">
                                    Bleeding Dyscrasia
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div><!-- END OF COL DIV -->
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="FH_eyeDisorder" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('FH_eyeDisorder') == '1' ? 'checked' : '' }} name="FH_eyeDisorder">
                                <label class="form-check-label" for="FH_eyeDisorder">
                                    Eye Disorder
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="FH_skinProblems" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('FH_skinProblems') == '1' ? 'checked' : '' }} name="FH_skinProblems">
                                <label class="form-check-label" for="FH_skinProblems">
                                    Skin Problems
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="FH_kidneyProblems" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('FH_kidneyProblems') == '1' ? 'checked' : '' }} name="FH_kidneyProblems">
                                <label class="form-check-label" for="FH_kidneyProblems">
                                    Kidney Problems
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="FH_gastroDisease" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('FH_gastroDisease') == '1' ? 'checked' : '' }} name="FH_gastroDisease">
                                <label class="form-check-label" for="FH_gastroDisease">
                                    Gastrointestinal Disease
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div><!-- END OF COL DIV --> 
                </div><!-- END OF ROW of CHECKBOXES DIV -->
            <div class="form-row align-items-center">
                <div class="col">
                    <input type="hidden" name="FH_others" value="0">
                    <input class="form-check-input" type="checkbox" value="1" {{ old('FH_others') == '1' ? 'checked' : '' }} id="FH_others" name="FH_others">
                        <label class="form-check-label" for="FH_others" style="display: contents!important;">
                            Others
                        </label>
                            <input type="text" class="form-control input-sm @error('FH_othersDetails') is-invalid @enderror" id="FH_othersDetails" name="FH_othersDetails" value="{{ old('FH_othersDetails') }}" oninput="this.value = this.value.toUpperCase()" placeholder="separate with comma(,) if multiple" {{ old('FH_others') == '1' ? '' : 'disabled' }}>
                            <div class="invalid-feedback">
                                Please enter the details of the other illnesses or diseases in your family history.
                            </div>
                            <span class="text-danger"> 
                                @error('FH_othersDetails') 
                                  {{ $message }} 
                                @enderror
                              </span>    
                            <!-- SCRIPT FOR INPUT TOGGLE ON CHECKBOX TICK -->
                                <script>
                                    const fhOthers = document.getElementById('FH_others');
                                    const fhOthersDetails = document.getElementById('FH_othersDetails');
                                    
                                    fhOthers.onchange = function() {
                                        if (this.checked) {
                                            fhOthersDetails.disabled = false;
                                            fhOthersDetails.required = true;
                                        } else {
                                            fhOthersDetails.disabled = true;
                                            fhOthersDetails.required = false;
                                        }
                                    };

                                    // Initialize the form state on page load
                                    if (fhOthers.checked) {
                                        fhOthersDetails.disabled = false;
                                        fhOthersDetails.required = true;
                                    } else {
                                        fhOthersDetails.disabled = true;
                                        fhOthersDetails.required = false;
                                    }
                                </script>
                    </div><!-- END OF COL OTHERS DIV -->
                </div><!-- END OF ROW OTHERS DIV -->
            </div><!-- END OF COL FH -->

            <!-- START OF PSH -->
            <div class="col-lg-5 col-md-12 p-2 border border-dark">
                <h6>Personal Social History</h6>
                    <div class="form-check">
                    <input type="hidden" name="PSH_smoking" value="0">
                    <input class="form-check-input" type="checkbox" value="1" id="PSH_smoking" name="PSH_smoking" {{ old('PSH_smoking') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="PSH_smoking" style="display: contents!important;">
                            Smoking
                        </label>
                            <br>
                            <div class="d-flex align-items-center">
                                ( <input type="text" class="form-control col-md-2 mx-1 @error('PSH_smoking_amount') is-invalid @enderror" style="width: 10%;" id="PSH_smoking_amount" name="PSH_smoking_amount" value="{{ old('PSH_smoking_amount') }}" {{ old('PSH_smoking') == '1' ? '' : 'disabled' }}> 
                                <div class="invalid-feedback">
                                    Please enter the amount of stick/s you smoke per/day.
                                </div>
                                <span class="text-danger"> 
                                    @error('PSH_smoking_amount') 
                                    {{ $message }} 
                                    @enderror
                                </span>  
                                sticks/day for 
                                <input type="text" class="form-control col-md-2 mx-1 @error('PSH_smoking_freq') is-invalid @enderror" style="width: 10%;"  id="PSH_smoking_freq" name="PSH_smoking_freq" value="{{ old('PSH_smoking_freq') }}" {{ old('PSH_smoking') == '1' ? '' : 'disabled' }}> year/s )
                            <div class="invalid-feedback">
                                Please enter the amount of year/s you've been smoking.
                            </div>
                            <span class="text-danger"> 
                                @error('PSH_smoking_freq') 
                                  {{ $message }} 
                                @enderror
                            </span>  
                        </div>
                </div><!-- END OF SMOKING FORM DIV -->

                <div class="form-check" style="margin-top:5%;">
                    <input type="hidden" name="PSH_drinking" value="0">
                    <input class="form-check-input" type="checkbox" value="1" id="PSH_drinking" name="PSH_drinking" {{ old('PSH_drinking') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="PSH_drinking" style="display: contents!important;">
                            Drinking 
                        </label>
                            <br>
                            <div class="d-flex align-items-center">
                            ( <input type="text" class="form-control mx-1 @error('PSH_drinking_amountOfBeer') is-invalid @enderror" style="width: 20%;" id="PSH_drinking_amountOfBeer" name="PSH_drinking_amountOfBeer" value="{{ old('PSH_drinking_amountOfBeer') }}" {{ old('PSH_drinking') == '1' ? '' : 'disabled' }}>
                            <div class="invalid-feedback">
                                Please enter the amount of beer you intake.
                            </div>
                            <span class="text-danger"> 
                                @error('PSH_drinking_amountOfBeer') 
                                  {{ $message }} 
                                @enderror
                            </span>  
                            Beer per 
                            <input type="text" class="form-control mx-1 @error('PSH_drinking_freqOfBeer') is-invalid @enderror" style="width: 20%;" id="PSH_drinking_freqOfBeer" name="PSH_drinking_freqOfBeer" value="{{ old('PSH_drinking_freqOfBeer') }}" {{ old('PSH_drinking') == '1' ? '' : 'disabled' }}> ) 
                            <div class="invalid-feedback">
                                Please enter how frequently you drink beer.
                            </div>
                            <span class="text-danger"> 
                                @error('PSH_drinking_freqOfBeer') 
                                  {{ $message }} 
                                @enderror
                            </span>  
                            <br>
                            </div>
                                or
                            <div class="d-flex align-items-center">
                            ( <input type="text" class="form-control mx-1 @error('PSH_drinking_amountofShots') is-invalid @enderror" style="width: 20%;" id="PSH_drinking_amountofShots" name="PSH_drinking_amountofShots" value="{{ old('PSH_drinking_amountofShots') }}" {{ old('PSH_drinking') == '1' ? '' : 'disabled' }}>
                            <div class="invalid-feedback">
                                Please how many shots you intake.
                            </div>
                            <span class="text-danger"> 
                                @error('PSH_drinking_amountofShots') 
                                  {{ $message }} 
                                @enderror
                            </span>  
                            Shots per 
                            <input type="text" class="form-control mx-1 @error('PSH_drinking_freqOfShots') is-invalid @enderror" style="width: 20%;" id="PSH_drinking_freqOfShots" name="PSH_drinking_freqOfShots" value="{{ old('PSH_drinking_freqOfShots') }}" {{ old('PSH_drinking') == '1' ? '' : 'disabled' }}>)
                            <div class="invalid-feedback">
                                Please enter how frequently you intake shots.
                            </div>
                            <span class="text-danger"> 
                                @error('PSH_drinking_freqOfShots') 
                                  {{ $message }} 
                                @enderror
                            </span>  
                        </div>
                </div><!-- END OF DRINKING FORM DIV -->

                    <!-- SCRIPT FOR INPUT TOGGLE ON CHECKBOX TICK -->
                <script>
                   $(document).ready(function() {
                        /* SMOKING */
                        $('#PSH_smoking').change(function() {
                            $('#PSH_smoking_amount').prop('disabled', !this.checked);
                            $('#PSH_smoking_freq').prop('disabled', !this.checked);
                        });
                        
                        /* DRINKING */
                        $('#PSH_drinking').change(function() {
                            $('#PSH_drinking_amountOfBeer').prop('disabled', !this.checked);
                            $('#PSH_drinking_freqOfBeer').prop('disabled', !this.checked);
                            $('#PSH_drinking_amountofShots').prop('disabled', !this.checked);
                            $('#PSH_drinking_freqOfShots').prop('disabled', !this.checked);
                        });
                    });

                </script>

            </div><!-- END OF PSH COL DIV -->
        </div><!-- END OF ROW ENTIRE DIV -->

        <!--Personal History-->
        <h5 class="ms-1">Personal History</h5>
        <div class="mx-auto row row-cols-lg-2 row-cols-md-1"><!-- START DIV FOR PAST AND PRESENT ILLNESS -->
            <div class="col-lg-6 col-md-12 p-2 border border-dark border-lg-end-0">
                <h6>Past Ilness</h6>
                <div class="row row-cols-sm-1 row-cols-md-2 row-cols-lg-3">
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="pi_primaryComplex" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('pi_primaryComplex') == '1' ? 'checked' : '' }} name="pi_primaryComplex">
                            <label class="form-check-label" for="pi_primaryComplex">
                                Primary Complex
                            </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="pi_chickenPox" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('pi_chickenPox') == '1' ? 'checked' : '' }} name="pi_chickenPox">
                            <label class="form-check-label" for="pi_chickenPox">
                                Chicken Pox
                            </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="pi_kidneyDisease" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('pi_kidneyDisease') == '1' ? 'checked' : '' }} name="pi_kidneyDisease">
                            <label class="form-check-label" for="pi_kidneyDisease">
                                Kidney Disease
                            </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="pi_typhoidFever" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('pi_typhoidFever') == '1' ? 'checked' : '' }} name="pi_typhoidFever">
                            <label class="form-check-label" for="pi_typhoidFever">
                                Typhoid Fever
                            </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="pi_earProblems" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('pi_earProblems') == '1' ? 'checked' : '' }} name="pi_earProblems">
                            <label class="form-check-label" for="pi_earProblems">
                                Ear Problems
                            </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="pi_heartDisease" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('pi_heartDisease') == '1' ? 'checked' : '' }} name="pi_heartDisease">
                            <label class="form-check-label" for="pi_heartDisease">
                                Heart Disease
                            </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="pi_leukemia" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('pi_leukemia') == '1' ? 'checked' : '' }} name="pi_leukemia">
                                <label class="form-check-label" for="pi_leukemia">
                                    Leukemia
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div><!-- END OF CHECKBOX 1ST COL DIV -->
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="pi_asthma" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('pi_asthma') == '1' ? 'checked' : '' }} name="pi_asthma">
                            <label class="form-check-label" for="pi_asthma">
                                Asthma
                            </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="pi_diabetes" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('pi_diabetes') == '1' ? 'checked' : '' }} name="pi_diabetes">
                            <label class="form-check-label" for="pi_diabetes">
                                Diabetes
                            </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="pi_eyeDisorder" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('pi_eyeDisorder') == '1' ? 'checked' : '' }} name="pi_eyeDisorder">
                            <label class="form-check-label" for="pi_eyeDisorder">
                                 Eye Disorder
                            </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="pi_pneumonia" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('pi_pneumonia') == '1' ? 'checked' : '' }} name="pi_pneumonia">
                            <label class="form-check-label" for="pi_pneumonia">
                                Pneumonia
                            </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="pi_dengue" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('pi_dengue') == '1' ? 'checked' : '' }} name="pi_dengue">
                            <label class="form-check-label" for="pi_dengue">
                                Dengue
                            </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="pi_measles" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('pi_measles') == '1' ? 'checked' : '' }} name="pi_measles">
                            <label class="form-check-label" for="pi_measles">
                                Measles
                            </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="pi_hepatitis" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('pi_hepatitis') == '1' ? 'checked' : '' }} name="pi_hepatitis">
                            <label class="form-check-label" for="pi_hepatitis">
                                Hepatitis
                            </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div><!-- END OF CHECKBOX 2ND COL DIV -->
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="pi_rheumaticFever" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('pi_rheumaticFever') == '1' ? 'checked' : '' }} name="pi_rheumaticFever">
                            <label class="form-check-label" for="pi_rheumaticFever">
                                Rheumatic Fever
                            </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="pi_mentalDisorder" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('pi_mentalDisorder') == '1' ? 'checked' : '' }} name="pi_mentalDisorder">
                            <label class="form-check-label" for="pi_mentalDisorder">
                                Mental Disorder
                            </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="pi_skinProblems" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('pi_skinProblems') == '1' ? 'checked' : '' }} name="pi_skinProblems">
                            <label class="form-check-label" for="pi_skinProblems">
                                Skin Problems
                            </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="pi_poliomyetis" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('pi_poliomyetis') == '1' ? 'checked' : '' }} name="pi_poliomyetis">
                            <label class="form-check-label" for="pi_poliomyetis">
                                Poliomyetis
                            </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="pi_thyroidDisorder" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('pi_thyroidDisorder') == '1' ? 'checked' : '' }} name="pi_thyroidDisorder">
                            <label class="form-check-label" for="pi_thyroidDisorder">
                                Thyroid Disorder
                            </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="pi_anemia" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('pi_anemia') == '1' ? 'checked' : '' }} name="pi_anemia">
                            <label class="form-check-label" for="pi_anemia">
                                Anemia
                            </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="pi_mumps" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('pi_mumps') == '1' ? 'checked' : '' }} name="pi_mumps">
                            <label class="form-check-label" for="pi_mumps">
                                Mumps
                            </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div><!-- END OF CHECKBOX 3ND COL DIV -->
                </div><!-- END OF PAST ILLNESS CHECKBOX ROW DIV -->
            </div><!-- END OF PAST ILLNESS ROW DIV -->
            <div class="col-lg-6 col-md-12 p-2 border border-dark">
                <h6>Present Ilness</h6>       
                <div class="row row-cols-sm-1 row-cols-md-2 row-cols-lg-3">
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="PI_chestPain" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('PI_chestPain') == '1' ? 'checked' : '' }} name="PI_chestPain">
                            <label class="form-check-label" for="PI_chestPain">
                                Chest Pain
                            </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="PI_insomnia" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('PI_insomnia') == '1' ? 'checked' : '' }} name="PI_insomnia">
                            <label class="form-check-label" for="PI_insomnia">
                                Insomnia
                            </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="PI_jointPains" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('PI_jointPains') == '1' ? 'checked' : '' }} name="PI_jointPains">
                            <label class="form-check-label" for="PI_jointPains">
                                Joint Pains
                            </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="PI_dizziness" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('PI_dizziness') == '1' ? 'checked' : '' }} name="PI_dizziness">
                            <label class="form-check-label" for="PI_dizziness">
                                Dizzines
                            </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="PI_headaches" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('PI_headaches') == '1' ? 'checked' : '' }} name="PI_headaches">
                            <label class="form-check-label" for="PI_headaches">
                                Headaches
                            </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="PI_indigestion" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('PI_indigestion') == '1' ? 'checked' : '' }} name="PI_indigestion">
                            <label class="form-check-label" for="PI_indigestion">
                                Indigestion
                            </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="PI_swollenFeet" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('PI_swollenFeet') == '1' ? 'checked' : '' }} name="PI_swollenFeet">
                            <label class="form-check-label" for="PI_swollenFeet">
                                Swollen Feet
                            </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="PI_weightLoss" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('PI_weightLoss') == '1' ? 'checked' : '' }} name="PI_weightLoss">
                            <label class="form-check-label" for="PI_weightLoss">
                                Weight Loss
                            </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="PI_nauseaOrVomiting" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('PI_nauseaOrVomiting') == '1' ? 'checked' : '' }} name="PI_nauseaOrVomiting">
                            <label class="form-check-label" for="PI_nauseaOrVomiting">
                                Nausea/Vomiting
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="PI_soreThroat" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('PI_soreThroat') == '1' ? 'checked' : '' }} name="PI_soreThroat">
                            <label class="form-check-label" for="PI_soreThroat">
                                Sore Throat
                            </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="PI_frequentUrination" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('PI_frequentUrination') == '1' ? 'checked' : '' }} name="PI_frequentUrination">
                            <label class="form-check-label" for="PI_frequentUrination">
                                Frequent Urination
                            </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-6 col-12">
                        <div class="form-check">
                            <input type="hidden" name="PI_difficultyOfBreathing" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('PI_difficultyOfBreathing') == '1' ? 'checked' : '' }} name="PI_difficultyOfBreathing">
                            <label class="form-check-label" for="PI_difficultyOfBreathing">
                                Diffculty of Breathing
                            </label>
                        </div> <!-- END OF CHECKBOX DIV -->    
                    </div><!-- END OF CHECKBOX 3RD COL DIV -->
                </div><!-- END OF CHECKBOX ROW DIV -->
                <div class="form-row align-items-center">
                    <div class="col p-2">
                        <input type="hidden" name="PI_others" value="0">
                        <input class="form-check-input" type="checkbox" value="1" {{ old('PI_others') == '1' ? 'checked' : '' }} id="PI_others" name="PI_others">
                        <label class="form-check-label" for="PI_others" style="display: contents!important;">
                            <span class="h6">Others</span>
                        </label>
                        <input type="text" class="form-control input-sm @error('PI_othersDetails') is-invalid @enderror" id="PI_othersDetails" name="PI_othersDetails" value="{{ old('PI_othersDetails') }}" oninput="this.value = this.value.toUpperCase()" placeholder="separate with comma(,) if multiple" {{ old('PI_others') == '1' ? '' : 'disabled' }}>
                        <div class="invalid-feedback">
                            Please enter your other present illness/es.
                        </div>
                        <span class="text-danger"> 
                            @error('PI_othersDetails') 
                                {{ $message }} 
                             @enderror
                        </span>     
                        <!-- SCRIPT FOR INPUT TOGGLE ON CHECKBOX TICK -->
                        <script>
                            document.getElementById('PI_others').onchange = function() {
                                document.getElementById('PI_othersDetails').disabled = !this.checked;
                                document.getElementById('PI_othersDetails').required = this.checked;
                            };
                        </script>
                    </div><!-- END OF OTHERS COL DIV -->
                </div><!-- END OF OTHERS ROW DIV -->
            </div><!-- END OF PRESENT ILLNESS DIV -->
        </div><!-- END OF PAST AND PRESENT ILLNESS DIV -->

        <!--Medical Status
                    HOSPITALIZATION-->
        <div class="mx-auto row row-cols-lg-1 mt-2">
            <div class="col-md-12 p-2 border border-dark">  
                <div class="d-flex flex-row">
                    <div class="col-sm">
                        <div class="form-check form-switch">
                            <input type="hidden" name="hospitalization" value="0">
                            <input class="form-check-input border-dark @error('hospitalization') is-invalid @enderror" type="checkbox" role="switch" name="hospitalization" id="hospitalization" value="1" {{ old('hospitalization') == '1' ? 'checked' : '' }}/>
                            <label class="form-check-label fw-bold" for="hospitalization">
                                Do you have history of hospitalization for serious illness, operation, fracture or injury?<span class="text-danger">*</span>
                            </label>
                        </div><!-- END OF YES DIV -->
                        <div class="invalid-feedback">
                            Please select one.
                        </div>
                        <input type="text" class="form-control col-sm-10 @error('hospitalizationDetails') is-invalid @enderror" id="hospitalizationDetails" name="hospitalizationDetails" oninput="this.value = this.value.toUpperCase()" placeholder="If yes, please give details:" value="{{ old('hospitalizationDetails') }}" disabled/>
                        <div class="invalid-feedback">
                            Please enter the details of your hospitalization for serious illness, operation, fracture or injury.
                        </div>
                        <span class="text-danger"> 
                            @error('hospitalizationDetails') 
                              {{ $message }} 
                            @enderror
                        </span>  
                            <!-- SCRIPT FOR TOGGLE DETAILS IF YES/NO -->
                            <script>
                                $(document).ready(function() {
                                    $('#hospitalization').change(function() {
                                        if ($('#hospitalization').is(':checked')) {
                                            $('#hospitalizationDetails').prop('disabled', false);
                                            $('#hospitalizationDetails').prop('required', true);
                                        } else {
                                            $('#hospitalizationDetails').prop('disabled', true);
                                            $('#hospitalizationDetails').prop('required', false);
                                        }
                                    });
                                });
                            </script>
                            <!-- END OF SCRIPT --> 
                    </div><!-- END OF COL DIV -->
                </div><!-- END OF ROW DIV -->

                <!-- REGULAR MEDICINES -->
                <div class="d-flex flex-row pt-2">
                    <div class="col-sm">
                            <div class="form-check form-switch">
                                <input type="hidden" name="regMeds" value="0">
                                <input class="form-check-input border-dark @error('regMeds') is-invalid @enderror" type="checkbox" role="switch" name="regMeds" id="regMeds" value="1" {{ old('regMeds') == '1' ? 'checked' : '' }}/>
                                <label class="form-check-label fw-bold" for="regMeds">
                                        Are you taking any medicine regularly?<span class="text-danger">*</span>
                                </label>
                            </div><!-- END OF YES DIV -->
                            <div class="invalid-feedback">
                                Please select one.
                            </div>
                            <input type="text" class="form-control col-sm-10 @error('regMedsDetails') is-invalid @enderror" id="regMedsDetails" name="regMedsDetails" oninput="this.value = this.value.toUpperCase()" placeholder="If yes, name of drug/s:" value="{{ old('regMedsDetails') }}" disabled/>
                            <div class="invalid-feedback">
                                Please enter the details of the medicine/s you regularly take.
                            </div>
                            <span class="text-danger"> 
                                @error('regMedsDetails') 
                                {{ $message }} 
                                @enderror
                            </span>  
                               <!-- SCRIPT FOR TOGGLE DETAILS IF YES/NO -->
                               <script>
                                   $(document).ready(function() {
                                       $('#regMeds').change(function() {
                                           if ($('#regMeds').is(':checked')) {
                                                $('#regMedsDetails').prop('disabled', false);
                                                $('#regMedsDetails').prop('required', true);
                                           } else {
                                                $('#regMedsDetails').prop('disabled', true);
                                                $('#regMedsDetails').prop('required', false);
                                           }
                                       });
                                   });
                               </script>
                               <!-- END OF SCRIPT --> 
                       </div><!-- END OF COL DIV -->
                   </div><!-- END OF ROW DIV -->

                   <!-- ALLERGIES -->
                   <div class="col-sm" required>
                        <div class="form-check form-switch">
                            <input type="hidden" name="allergy" value="0">
                            <input class="form-check-input border-dark @error('allergy') is-invalid @enderror" type="checkbox" role="switch" name="allergy" id="allergy" value="1" {{ old('allergy') == '1' ? 'checked' : '' }}/>
                            <label class="form-check-label fw-bold" for="allergy">
                                    Are you allergic to any food or medicine?<span class="text-danger">*</span>
                            </label>
                        </div><!-- END OF YES DIV -->                    
                        <div class="invalid-feedback">
                            Please select one.
                        </div>
                        <input type="text" class="form-control col-sm-10 @error('allergyDetails') is-invalid @enderror" id="allergyDetails" name="allergyDetails" oninput="this.value = this.value.toUpperCase()" placeholder="If yes, specify:" value="{{ old('allergyDetails') }}" disabled/>
                        <div class="invalid-feedback">
                            Please enter the details of the food and/or medicine that you are alergic to.
                        </div>
                        <span class="text-danger"> 
                            @error('allergyDetails') 
                            {{ $message }} 
                            @enderror
                        </span> 
                            <!-- SCRIPT FOR TOGGLE DETAILS IF YES/NO -->
                            <script>
                               $(document).ready(function() {
                                   $('#allergy').change(function() {
                                       if ($('#allergy').is(':checked')) {
                                            $('#allergyDetails').prop('disabled', false);
                                            $('#allergyDetails').prop('required', true);
                                       } else {
                                            $('#allergyDetails').prop('disabled', true);
                                            $('#allergyDetails').prop('required', false);
                                       }
                                   });
                               });
                           </script>
                           <!-- END OF SCRIPT --> 
                   </div><!-- END OF COL DIV -->
               </div><!-- END OF ROW DIV -->    
            </div>   
        
        <!--Immunization History-->
        <div class="mx-auto row mt-2">
            <div class="col-md-12 p-2 border border-dark">
                <p class="fs-5 mb-2 h6">Immunization History</p>
                <div class="row row-cols-5 row-cols-1 row-cols-md-2">
                    <div class="col-md-6 col-lg-2 col-sm-12">
                        <div class="form-check">
                            <input type="hidden" name="IH_bcg" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('IH_bcg') == '1' ? 'checked' : '' }} name="IH_bcg">
                                <label class="form-check-label" for="IH_bcg" data-toggle="tooltip" data-placement="top" title="Bacille Calmette-Guerin">
                                    BCG
                                </label>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-12">
                        <div class="form-check">
                            <input type="hidden" name="IH_polio" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('IH_polio') == '1' ? 'checked' : '' }}name="IH_polio">
                                <label class="form-check-label" for="IH_polio">
                                    Polio I, II, II, Booster Dose
                                </label>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2 col-sm-12">
                        <div class="form-check">
                            <input type="hidden" name="IH_mumps" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('IH_mumps') == '1' ? 'checked' : '' }} name="IH_mumps">
                                <label class="form-check-label" for="IH_mumps">
                                    Mumps
                                </label>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2 col-sm-12">
                        <div class="form-check">
                            <input type="hidden" name="IH_typhoid" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('IH_typhoid') == '1' ? 'checked' : '' }} name="IH_typhoid">
                                <label class="form-check-label" for="IH_typhoid">
                                    Typhoid
                                </label>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2 col-sm-12">
                        <div class="form-check">
                            <input type="hidden" name="IH_hepatitisA" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('IH_hepatitisA') == '1' ? 'checked' : '' }} name="IH_hepatitisA">
                                <label class="form-check-label" for="IH_hepatitisA">
                                    Hepatitis A
                                </label>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2 col-sm-12">
                        <div class="form-check">
                            <input type="hidden" name="IH_chickenPox" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('IH_chickenPox') == '1' ? 'checked' : '' }} name="IH_chickenPox">
                                <label class="form-check-label" for="IH_chickenPox">
                                    Chicken Pox
                                </label>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-sm-12">
                        <div class="form-check">
                            <input type="hidden" name="IH_dpt" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('IH_dpt') == '1' ? 'checked' : '' }} name="IH_dpt">
                                <label class="form-check-label" for="IH_dpt">
                                    DPT I, II, III, Booster Dose
                                </label>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2 col-sm-12">
                        <div class="form-check">
                            <input type="hidden" name="IH_measles" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('IH_measles') == '1' ? 'checked' : '' }} name="IH_measles">
                                <label class="form-check-label" for="IH_measles">
                                    Measles
                                </label>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2 col-sm-12">
                        <div class="form-check">
                            <input type="hidden" name="IH_germanMeasles" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('IH_germanMeasles') == '1' ? 'checked' : '' }} name="IH_germanMeasles">
                                <label class="form-check-label" for="IH_germanMeasles">
                                    German Measles
                                </label>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2 col-sm-12">
                        <div class="form-check">
                            <input type="hidden" name="IH_hepatitisB" value="0">
                            <input class="form-check-input" type="checkbox" value="1" {{ old('IH_hepatitisB') == '1' ? 'checked' : '' }} name="IH_hepatitisB">
                                <label class="form-check-label" for="IH_hepatitisB">
                                    Hepatitis B
                                </label>
                        </div>
                    </div>
                    <div class="w-100"></div>
                </div>
                <div class="form-row align-items-center">
                    <div class="col p-2">
                        <input type="hidden" name="IH_others" value="0">
                        <input class="form-check-input" type="checkbox" value="1" {{ old('IH_others') == '1' ? 'checked' : '' }} id="IH_others" name="IH_others">
                        <label class="form-check-label" for="IH_others" style="display: contents!important;">
                            <span class="h6">Others</span>
                        </label>
                        <input type="text" class="form-control input-sm @error('IH_othersDetails') is-invalid @enderror" id="IH_othersDetails" name="IH_othersDetails" value="{{ old('IH_othersDetails') }}" oninput="this.value = this.value.toUpperCase()" placeholder="separate with comma(,) if multiple" {{ old('IH_others') == '1' ? '' : 'disabled' }}>
                        <div class="invalid-feedback">
                            Please enter the details of other immunization you you've taken.
                        </div>
                        <span class="text-danger"> 
                            @error('IH_othersDetails') 
                                {{ $message }} 
                                @enderror
                        </span>     
                        <!-- SCRIPT FOR INPUT TOGGLE ON CHECKBOX TICK -->
                        <script>
                            document.getElementById('IH_others').onchange = function() {
                                document.getElementById('IH_othersDetails').disabled = !this.checked;
                                document.getElementById('IH_othersDetails').required = this.checked;
                            };
                        </script>
                    </div><!-- END OF OTHERS COL DIV -->
                </div><!-- END OF OTHERS ROW DIV -->
            </div>
        </div>
    <!-- ATTACHMENTS -->
    <div class="row mx-auto my-auto mt-2">
        <div class="col-md-12 p-1 border border-dark">
            <p class="fs-5 my-4 fw-bold text-center">Please upload a photo of the official reading and result of the following:</p>
            <div class="flex justify-content-center">
                <div class="row row-cols-xl-4 row-cols-lg-2 row-cols-md-1 row-cols-sm-1 row-cols-1 my-auto px-5 py-4">
                    <div class="mb-3 col-xl-3 col-lg-6 col-md-12 d-flex flex-column justify-content-center align-items-center" >
                        <label for="MR_chestXray" class="form-label fw-bold">Chest X-Ray Findings<span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="MR_chestXray" name="MR_chestXray" accept="image/jpeg, image/png" required>
                        <div class="invalid-feedback">
                            Please select a valid image(.jpeg, .jpg, .png) with maximum size of 5mb.
                        </div>
                        <span class="text-danger"> 
                            @error('MR_chestXray') 
                              {{ $message }} 
                            @enderror
                        </span> 
                    </div>
                    <div class="mb-3 col-xl-3 col-lg-6 col-md-12 d-flex flex-column justify-content-center align-items-center">
                        <label for="MR_cbcresults" class="form-label fw-bold">CBC Results<span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="MR_cbcresults" name="MR_cbcresults" accept="image/jpeg, image/png" required>
                        <div class="invalid-feedback">
                            Please select a valid image(.jpeg, .jpg, .png) with maximum size of 5mb.
                        </div>
                        <span class="text-danger"> 
                            @error('MR_cbcresults') 
                              {{ $message }} 
                            @enderror
                        </span> 
                      </div>                      
                    <div class="mb-3 col-xl-3 col-lg-6 col-md-12 d-flex flex-column justify-content-center align-items-center">
                        <label for="MR_hepaBscreening" class="form-label fw-bold">Hepatitis B Screening<span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="MR_hepaBscreening" name="MR_hepaBscreening" accept="image/jpeg, image/png" required>
                        <div class="invalid-feedback">
                            Please select a valid image(.jpeg, .jpg, .png) with maximum size of 5mb.
                        </div>
                        <span class="text-danger"> 
                            @error('MR_hepaBscreening') 
                              {{ $message }} 
                            @enderror
                        </span> 
                    </div> 
                    <div class="mb-3 col-xl-3 col-lg-6 col-md-12 d-flex flex-column justify-content-center align-items-center">
                        <label for="MR_bloodtype" class="form-label fw-bold">Blood Type<span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="MR_bloodtype" name="MR_bloodtype" accept="image/jpeg, image/png" required>
                        <div class="invalid-feedback">
                            Please select a valid image(.jpeg, .jpg, .png) with maximum size of 5mb.
                        </div>
                        <span class="text-danger"> 
                            @error('MR_bloodtype') 
                              {{ $message }} 
                            @enderror
                        </span>
                    </div>
                </div>
                <!-- Validation for Image only uploads -->
                <script>
                    const xrayInput = document.getElementById('MR_chestXray');
                    const cbcInput = document.getElementById('MR_cbcresults');
                    const hepaInput = document.getElementById('MR_hepaBscreening');
                    const bloodtypeInput = document.getElementById('MR_bloodtype'); 
                  
                    xrayInput.addEventListener('change', function() {
                        let file = this.files[0];
                        let fileType = file.type;
                    
                      if (fileType !== 'image/jpeg' && fileType !== 'image/png') {
                            this.classList.add('is-invalid');
                            this.value = '';
                        } else {
                            this.classList.remove('is-invalid');
                        }
                    });

                    cbcInput.addEventListener('change', function() {
                        let file = this.files[0];
                        let fileType = file.type;
                    
                      if (fileType !== 'image/jpeg' && fileType !== 'image/png') {
                            this.classList.add('is-invalid');
                            this.value = '';
                        } else {
                            this.classList.remove('is-invalid');
                        }
                    });

                    hepaInput.addEventListener('change', function() {
                        let file = this.files[0];
                        let fileType = file.type;
                    
                      if (fileType !== 'image/jpeg' && fileType !== 'image/png') {
                            this.classList.add('is-invalid');
                            this.value = '';
                        } else {
                            this.classList.remove('is-invalid');
                        }
                    });

                    bloodtypeInput.addEventListener('change', function() {
                        let file = this.files[0];
                        let fileType = file.type;
                    
                      if (fileType !== 'image/jpeg' && fileType !== 'image/png') {
                            this.classList.add('is-invalid');
                            this.value = '';
                        } else {
                            this.classList.remove('is-invalid');
                        }
                    });
                  </script>
                    <div id="resultsContainer" class="row row-cols-xl-4 row-cols-lg-2 row-cols-md-1 row-cols-sm-1 my-auto px-5 py-4">
                        <script>
                            let maxResults = 8;
                            let currentResults = 0;
                            let nextResultId = 1;
                            let lastRemovedResultId = null;
                        
                            const addResult = () => {
                                if (currentResults < maxResults) {
                                    if (lastRemovedResultId !== null) {
                                        nextResultId = lastRemovedResultId;
                                        lastRemovedResultId = null;
                                    } else {
                                        nextResultId = currentResults + 1;
                                    }
                        
                                    let container = document.getElementById('resultsContainer');
                                    let resultDiv = document.createElement('div');
                                    resultDiv.id = `result${nextResultId}`;
                                    resultDiv.classList.add('mb-3', 'col-xl-3', 'col-lg-6', 'col-md-12', 'd-flex', 'flex-column', 'justify-content-center', 'align-items-center');
                                    resultDiv.innerHTML = `
                                        <div class="align-items-center" style="display: flex; flex-direction: row;">
                                            <label for="MR_additionalResult${nextResultId}" class="form-label fw-bold me-5" style="margin-right: 20px;">
                                                Results for:<span class="text-danger">*</span>
                                            </label>
                                            <button type="button" class="btn btn-sm btn-light ms-5" style="margin-bottom: 5px; "margin-left: 200px;" onclick="removeResult('${nextResultId}')">&times;</button>
                                        </div>
                                        <input type="text" class="form-control my-1" id="MR_additionalResult${nextResultId}" name="MR_additionalResult${nextResultId}" placeholder="e.g. Urinalisys, Diabetes, ECG" required>
                                        <input type="file" class="form-control my-1" id="MR_additionalUpload${nextResultId}" name="MR_additionalUpload${nextResultId}" accept="image/jpeg, image/png" required>
                                        <div class="invalid-feedback">
                                            Please select enter the title of your additional result.
                                        </div>
                                        <span class="text-danger"> 
                                            @error('MR_additionalResult${nextResultId}') 
                                            {{ $message }} 
                                            @enderror
                                        </span>
                                        <div class="invalid-feedback">
                                            Please select your additional result.
                                        </div>
                                        <span class="text-danger"> 
                                            @error('MR_additionalUpload${nextResultId}') 
                                            {{ $message }} 
                                            @enderror
                                        </span>
                                    `;
                                    container.appendChild(resultDiv);
                                    currentResults++;
                        
                                    if (currentResults == maxResults) {
                                        document.getElementById('addResultButton').disabled = true;
                                    }
                                }
                            }
                        
                            const removeResult = (resultId) => {
                                let resultDiv = document.getElementById(`result${resultId}`);
                                resultDiv.remove();
                                currentResults--;
                                console.log(currentResults);
                                console.log(maxResults);
                        
                                if (currentResults < maxResults) {
                                    document.getElementById('addResultButton').disabled = false;
                                }
                        
                                if (resultId < nextResultId) {
                                    lastRemovedResultId = resultId;
                                }
                            }
                        </script>
                    </div>
                </div>
            <button type="button" id="addResultButton" class="btn btn-primary" onclick="addResult()">Add Result</button>
        </div>
    </div>
    <input type="hidden" name="certify" id="certify" value="0">
    <div class="row no-gutters justify-content-end pt-3 position-relative">
        <div class="col d-flex justify-content-end" style="margin-right:-1  %;">
            <button type="submit" class="btn btn-lg btn-primary btn-login fw-bold mb-2" id="submitButton">
                Submit
            </button>
        </div>
    </div>
    <script>
       $(document).ready(function() {
            $('#submitButton').on('click', function(event) {
                // Check if all required fields are filled
                $('#passwordSpan').text('');
                $('#certifySpan').text('');
                $('#passwordInput').removeClass('is-invalid');
                $('#radioCertify').removeClass('is-invalid');
                var a = '';
                var b = $('#MR_form')[0].checkValidity();
                if ($('#MR_form')[0].checkValidity()) {
                    event.preventDefault();
                    $('#radioCertify').prop('checked', false);
                    $('#radioCertify').val('0');
                    $('#certify').val('0');
                    $('#radioCertify').attr('required', true);
                    $('#passwordInput').attr('required', true);
                    var modal = $('#submitModal');
                    $('body').append(modal);
                    modal.modal('show');
                    // Close modal
                    $('#editSuccessModal .close').on('click', function() {
                        $('#radioCertify').attr('required', false);
                        $('#passwordInput').attr('required', false);
                        $('#editSuccessModal').modal('hide');
                    });
                } else {
                    // If not all required fields are filled, focus on the first one
                    $('#MR_form :input[required]:visible').each(function() {
                        if ($(this).val() == '') {
                            $(this).focus();
                            a = this;
                            $('#radioCertify').attr('required', false);
                            $('#passwordInput').attr('required', false);
                            return false;
                        }
                    });
                }
            });
        });
    </script>
    

    <div class="modal modal-xl fade" id="submitModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="submitModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="submitModalLabel">
                        Medical Form Submission
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <div class="modal-body">
                        <p class="fs-5 fw-bold text-center">Please review your responses carefully before submitting this medical form. </p>
                        <hr>
                        <div class="input-group ms-3">
                            <div class="input-group-text bg-white border-0">
                                <input class="form-check-input" type="radio" name="radioCertify" id="radioCertify" value="0"/>
                            </div>
                            <label for="certify" class="fs-5 text-center mt-1">
                                I hereby certify that the foregoing answers are true and complete, and to the best of my knowledge.
                            </label>
                            <span class="text-danger" id="certifySpan"> 
                                @error('certify') 
                                  {{ $message }} 
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer align-items-center mb-3">
                        <div class="d-flex align-items-center my-auto mx-auto">
                            <div class="input-group">
                                @php
                                    $student = Auth::user()->student_id_number;
                                @endphp
                                @if($student)
                                    <label for="passwordInput" class="form-label h6 mt-2 me-2">Password:</label>
                                    <input type="password" class="form-control" id="passwordInput" name="passwordInput">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <div style="margin-top: -5px;">
                                            <span class="bi bi-eye-fill" aria-hidden="true"></span>
                                        </div>
                                    </button>
                                @else
                                <div class="row row-cols-lg-4 row-cols-md-2 row-cols-sm-1">
                                    <div class="col-lg-3">
                                        <label for="applicantIDinput" class="form-label h6 mt-2 me-2">Applicant ID Number:</label>
                                        <input type="text" class="form-control" id="applicantIDinput" name="applicantIDinput">
                                        <span class="text-danger" id="applicantIDSpan"> 
                                            @error('applicantIDinput') 
                                              {{ $message }} 
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="applicantBirthYear" class="form-label h6 mt-2 me-2">Birth Year:</label>
                                        <input type="text" class="form-control" id="applicantBirthYear" name="applicantBirthYear">
                                        <span class="text-danger" id="birthYearSpan"> 
                                            @error('applicantBirthYear') 
                                              {{ $message }} 
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="applicantBirthMonth" class="form-label h6 mt-2 me-2">Birth Month:</label>
                                        <select class="form-control" name ="applicantBirthMonth" id="applicantBirthMonth" placeholder="Birth Month" autofocus style="height:38px; margin-top: 1px">
                                            <option selected="selected" disabled="disabled" value="">SELECT</option>
                                            <option value="JANUARY" id="januaryMonth" class="align-baseline">JANUARY</option>
                                            <option value="FEBRUARY" id="februaryMonth">FEBRUARY</option>
                                            <option value="MARCH" id="marchMonth">MARCH</option>
                                            <option value="APRIL" id="aprilMonth">APRIL</option>
                                            <option value="MAY" id="mayMonth">MAY</option>
                                            <option value="JUNE" id="juneMonth">JUNE</option>
                                            <option value="JULY" id="julyMonth">JULY</option>
                                            <option value="AUGUST" id="augustMonth">AUGUST</option>
                                            <option value="SEPTEMBER" id="septemberMonth">SEPTEMBER</option>
                                            <option value="OCTOBER" id="octoberMonth">OCTOBER</option>
                                            <option value="NOVEMBER" id="novemberMonth">NOVEMBER</option>
                                            <option value="DECEMBER" id="decemberMonth">DECEMBER</option>
                                        </select>
                                        <span class="text-danger" id="birthMonthSpan"> 
                                            @error('applicantBirthMonth') 
                                              {{ $message }} 
                                            @enderror
                                        </span>
                                    </div>  
                                    <div class="col-lg-2">
                                        <label for="applicantBirthDate" class="form-label h6 mt-2 me-2">Birth Date:</label>
                                        <input type="text" class="form-control" id="applicantBirthDate" name="applicantBirthDate">
                                        <span class="text-danger" id="birthDateSpan"> 
                                            @error('applicantBirthDate') 
                                              {{ $message }} 
                                            @enderror
                                        </span>
                                    </div>  
                                @endif
                            </div>
                            
                        </div>
                        <span class="text-danger" id="passwordSpan"> 
                            @error('passwordInput') 
                              {{ $message }}
                            @enderror
                        </span>
                        
                        <script>
                            const passwordInput = document.getElementById('passwordInput');
                            const togglePassword = document.getElementById('togglePassword');
                            togglePassword.addEventListener('click', function() {
                                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                                passwordInput.setAttribute('type', type);
                                togglePassword.querySelector('span').classList.toggle('bi-eye-fill');
                                togglePassword.querySelector('span').classList.toggle('bi-eye-slash-fill');
                                togglePassword.classList.toggle('active');
                            });
                        </script>
                        <div class="col d-flex justify-content-end align-items-center" style="margin-right:-1  %; margin-top: 3%">
                            <button class="btn btn-primary btn-login fw-bold" type="button" id="medFormSubmitButton">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <script>
        document.getElementById("radioCertify").addEventListener("change", function() {
            if (this.checked) {
                this.value = 1;
                document.getElementById('certify').value = 1;
            }
        });
        $(document).ready(function() {
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#medFormSubmitButton').on('click', function(event) {
                event.preventDefault(); // prevent default form submission behavior
                var student = "<?php echo $student;?>";
                let certify = $('#radioCertify').val();
                
                $('#certifySpan').text('');
                $('#radioCertify').removeClass('is-invalid');

                if(certify != 1){
                    $('#radioCertify').addClass('is-invalid');
                    $('#certifySpan').text('Please certify that the foregoing answers are true and complete.');
                    return false;
                }
                if(student){
                    // If student is an old student (has student id number)
                    let password = $('#passwordInput').val();
                    $('#passwordSpan').text('');
                    $('#passwordInput').removeClass('is-invalid');
                    if(password == ""){
                        $('#passwordInput').addClass('is-invalid');
                        $('#passwordSpan').text('Please provide your password');
                        return false;
                    }
                    
                    $.ajax({
                        url: '/medical-record-check-auth',
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            password: password
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.success) {
                                // password is correct, submit the form
                                $('#MR_form').submit();
                            } else {
                                // password is incorrect, display an error message
                                $('#passwordInput').addClass('is-invalid');
                                $('#passwordSpan').text('Incorrect password');
                            }
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            console.log(xhr.responseText);
                        }
                    });
                }
                else{
                    // If student is new student (only applicant id number)
                    let applicantID = $('#applicantIDinput').val();
                    let birthYear = $('#applicantBirthYear').val();
                    let birthMonth = $('#applicantBirthMonth').val();
                    let birthDate = $('#applicantBirthDate').val();
                    $('#applicantIDSpan').text('');
                    $('#birthYearSpan').text('');
                    $('#birthMonthSpan').text('');
                    $('#birthDateSpan').text('');
                    $('#applicantIDinput').removeClass('is-invalid');
                    $('#applicantBirthYear').removeClass('is-invalid');
                    $('#applicantBirthMonth').removeClass('is-invalid');
                    $('#applicantBirthDate').removeClass('is-invalid');

                    if(applicantID == ""){
                        $('#applicantIDinput').addClass('is-invalid');
                        $('#applicantIDSpan').text('Please provide your Applicant ID Number');
                        return false;
                    }
                    if(birthYear == ""){
                        $('#applicantBirthYear').addClass('is-invalid');
                        $('#birthYearSpan').text('Please provide your Birth Year');
                        return false;
                    }
                    if(birthMonth == ""){
                        $('#applicantBirthMonth').addClass('is-invalid');
                        $('#birthMonthSpan').text('Please provide your Birth Month');
                        return false;
                    }
                    if(birthDate == ""){
                        $('#applicantBirthDate').addClass('is-invalid');
                        $('#birthDateSpan').text('Please provide your Birth Date');
                        return false;
                    }

                    $.ajax({
                        url: '/medical-record-check-auth',
                        method: 'POST',
                        dataType: 'json',
                        data: {
                            applicantID: applicantID,
                            birthYear: birthYear,
                            birthMonth: birthMonth,
                            birthDate: birthDate,
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.success) {
                                // password is correct, submit the form
                                $('#MR_form').submit();
                            } else {
                                // password is incorrect, display an error message for new students
                                $('#passwordInput').addClass('is-invalid');
                                $('#passwordSpan').text('Incorrect authentication.');
                            }
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            console.log(xhr.responseText);
                        }
                    });
                }
            });
        });

        (() => {
            'use strict'

            // Fetch all the forms to apply validation styles to
            const forms = document.querySelectorAll('.needs-validation')

            // Loop and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()

                    // Get all the invalid input fields
                    const invalidInputs = form.querySelectorAll(':invalid')

                    // Focus on the first invalid input field
                    invalidInputs[0].focus()
                }

                form.classList.add('was-validated')
                }, false)
            })
        })()

    </script>

    </form>    
</div> 
@endsection
