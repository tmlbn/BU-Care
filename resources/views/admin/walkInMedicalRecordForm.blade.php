@extends('admin.layouts.app')

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
        
            <div class="col-xl-3 col-lg-6">
                <label for="applicant_ID" class="form-label h6">Applicant ID Number<span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('applicant_ID') is-invalid @enderror" id="applicant_id" name="applicant_id" value="" oninput="this.value = this.value.toUpperCase()" required>
                <div class="invalid-feedback">
                    Please enter your Applicant ID.
                </div>
                <span class="text-danger">
                    @error('applicant_ID') 
                      {{ $message }} 
                    @enderror
                </span>                
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6">
                <label for="student_ID" class="form-label h6">Personnel ID Number<span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('student_ID') is-invalid @enderror" id="student_ID" name="student_ID" value="" oninput="this.value = this.value.toUpperCase()" required>
                <div class="invalid-feedback">
                    Please enter your Student ID.
                </div>
                <span class="text-danger">
                    @error('student_ID') 
                      {{ $message }} 
                    @enderror
                </span>                
            </div>
                    
        </div>

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
            <input type="text" class="form-control @error('MR_lastName') is-invalid @enderror" id="MR_lastName" name="MR_lastName" value="{{ old('MR_lastName') }}" oninput="this.value = this.value.toUpperCase()" required>
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
            <input type="text" class="form-control @error('MR_firstName') is-invalid @enderror" id="MR_firstName" name="MR_firstName" value="{{ old('MR_firstName')  }}" oninput="this.value = this.value.toUpperCase()" required>
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
            <input type="text" class="form-control @error('MR_middleName') is-invalid @enderror" id="MR_middleName" name="MR_middleName" value="{{ old('MR_middleName')   }}" oninput="this.value = this.value.toUpperCase()">
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
            <input type="text" class="form-control @error('MR_dateOfBirth') is-invalid @enderror" id="MR_dateOfBirth" name="MR_dateOfBirth" value="{{ old('MR_dateOfBirth') }}" onkeydown="return false;" required>
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
        <div class="col-md-4">
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
        
        <div class="col-md-3">
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
                "REGION V": ["ALBAY","CAMARINES NORTE","CAMARINES SUR","CATANDUANES","MASBATE","SOROSGON"],
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

        <div class="col-md-6">
            <label for="MR_fatherName" class="form-label h6 @error('MR_fatherName') is-invalid @enderror">Father's Name<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="MR_fatherName" name="MR_fatherName" value="{{ old('MR_fatherName') }}" oninput="this.value = this.value.toUpperCase()" required>
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
            <label for="MR_motherName" class="form-label h6 @error('MR_motherName') is-invalid @enderror">Mother's Name<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="MR_motherName" name="MR_motherName" value="{{ old('MR_motherName') }}" oninput="this.value = this.value.toUpperCase()" required>
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
            <label for="MR_fatherOccupation" class="form-label h6 @error('MR_fatherOccupation') is-invalid @enderror">Father's Occupation<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="MR_fatherOccupation" name="MR_fatherOccupation" value="{{ old('MR_fatherOccupation') }}" oninput="this.value = this.value.toUpperCase()" required>
            <span class="text-danger"> 
                @error('MR_fatherOccupation') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-6">
            <label for="MR_motherOccupation" class="form-label h6 @error('MR_motherOccupation') is-invalid @enderror">Mother's Occupation<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="MR_motherOccupation" name="MR_motherOccupation" value="{{ old('MR_motherOccupation') }}" oninput="this.value = this.value.toUpperCase()" required>
            <span class="text-danger"> 
                @error('MR_motherOccupation') 
                  {{ $message }} 
                @enderror
              </span>
        </div>
        <div class="col-md-6">
            <label for="MR_fatherOffice" class="form-label h6 @error('MR_fatherOffice') is-invalid @enderror">Office Address of Father<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="MR_fatherOffice" name="MR_fatherOffice" value="{{ old('MR_fatherOffice') }}" oninput="this.value = this.value.toUpperCase()" required>
            <span class="text-danger"> 
                @error('MR_fatherOffice') 
                  {{ $message }}
                @enderror
              </span>
        </div>
        <div class="col-md-6">
            <label for="MR_motherOffice" class="form-label h6 @error('MR_motherOffice') is-invalid @enderror">Office Address of Mother<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="MR_motherOffice" name="MR_motherOffice" value="{{ old('MR_motherOffice') }}" oninput="this.value = this.value.toUpperCase()" required>
            <span class="text-danger"> 
                @error('MR_motherOffice') 
                  {{ $message }} 
                @enderror
              </span>
        </div>
        <div class="col-md-6">
            <label for="MR_guardian" class="form-label h6 @error('MR_guardian') is-invalid @enderror">Guardian's Name</label>
            <input type="text" class="form-control" id="MR_guardian" name="MR_guardianName" value="{{ old('MR_guardianName') }}" placeholder="skip if not applicable" oninput="this.value = this.value.toUpperCase()">
            <span class="text-danger">
                @error('MR_guardianName') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-6">
            <label for="MR_parentGuardianContactNumber" class="form-label h6 @error('MR_parentGuardianContactNumber') is-invalid @enderror">Parent's/Guardian's Contact No.<span class="text-danger">*</span></label>
            <input type="number" class="form-control" placeholder="09123456789" value="{{ old('MR_parentGuardianContactNumber') }}" id="MR_parentGuardianContactNumber" onKeyPress="if(this.value.length==11) return false;" name="MR_parentGuardianContactNumber" required>
            <div class="invalid-feedback">
                Please enter your parent's or guardian's contact number.
            </div>
            <span class="text-danger"> 
                @error('MR_parentGuardianContactNumber') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-6">
            <label for="MR_guardianAddress" class="form-label h6 @error('MR_guardianAddress') is-invalid @enderror">Guardian's Address</label>
            <input type="text" class="form-control" id="MR_guardianAddress" name="MR_guardianAddress" value="{{ old('MR_guardianAddress') }}" placeholder="skip if not applicable" oninput="this.value = this.value.toUpperCase()">
            <div class="invalid-feedback">
                Please enter your parent's or guardian's address.
            </div>
            <span class="text-danger"> 
                @error('MR_guardianAddress') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-6">
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
        <section class="container my-2 bg-dark w-100 text-light mt-4 border border-dark">
            <header class="text-center">
                <!-- LINE BREAK -->
            </header>
        </section>
        <div class="col-md-6">
            <p class="h6 me-2">In case of emergency, contact:<span class="text-danger">*</span></p>
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
                        } else if($(this).val() == 'MOTHER') {
                            console.log('Mother option is selected');
                            $('#MR_emergencyContactName').val($('#MR_motherName').val());
                            $('#MR_emergencyContactOccupation').val($('#MR_motherOccupation').val());
                            $('#MR_emergencyContactRelationship').val('MOTHER');
                        } else if($(this).val() == 'GUARDIAN') {
                            console.log('Guardian option is selected');
                            $('#MR_emergencyContactName').val($('#MR_guardian').val());
                            $('#MR_emergencyContactAddress').val($('#MR_guardianAddress').val());
                            $('#MR_emergencyContactRelationship').val('GUARDIAN');
                        } else if($(this).val() == 'OTHERS') {
                            console.log('Others option is selected');
                            $('#MR_emergencyContactName').val('');
                            $('#MR_emergencyContactOccupation').val('');
                            $('#MR_emergencyContactRelationship').val('');
                        }
                    });
                });
            </script>
        </div>
        
        <div class="col-md-6">
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
        <div class="col-md-6">
            <label for="MR_emergencyContactAddress" class="form-label h6 @error('MR_emergencyContactAddress') is-invalid @enderror">Address<span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="MR_emergencyContactAddress" value="{{ old('MR_emergencyContactAddress') }}" oninput="this.value = this.value.toUpperCase()" name="MR_emergencyContactAddress" required>
            <div class="invalid-feedback">
                Please enter the address of your emergency contact person.
            </div>
            <span class="text-danger"> 
                @error('MR_emergencyContactAddress') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-6">
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
                            <input type="text" class="form-control input-sm @error('FH_othersDetails') is-invalid @enderror" id="FH_othersDetails" name="FH_othersDetails" value="{{ old('FH_othersDetails') }}" placeholder="separate with comma(,) if multiple" {{ old('FH_others') == '1' ? '' : 'disabled' }}>
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
                        <input type="text" class="form-control input-sm @error('PI_othersDetails') is-invalid @enderror" id="PI_othersDetails" name="PI_othersDetails" value="{{ old('PI_othersDetails') }}" placeholder="separate with comma(,) if multiple" {{ old('PI_others') == '1' ? '' : 'disabled' }}>
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
                        <input type="text" class="form-control col-sm-10 @error('hospitalizationDetails') is-invalid @enderror" id="hospitalizationDetails" name="hospitalizationDetails" placeholder="If yes, please give details:" value="{{ old('hospitalizationDetails') }}" disabled/>
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
                            <input type="text" class="form-control col-sm-10 @error('regMedsDetails') is-invalid @enderror" id="regMedsDetails" name="regMedsDetails" placeholder="If yes, name of drug/s:" value="{{ old('regMedsDetails') }}" disabled/>
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
                        <input type="text" class="form-control col-sm-10 @error('allergyDetails') is-invalid @enderror" id="allergyDetails" name="allergyDetails" placeholder="If yes, specify:" value="{{ old('allergyDetails') }}" disabled/>
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
                        <input type="text" class="form-control input-sm @error('IH_othersDetails') is-invalid @enderror" id="IH_othersDetails" name="IH_othersDetails" value="{{ old('IH_othersDetails') }}" placeholder="separate with comma(,) if multiple" {{ old('IH_others') == '1' ? '' : 'disabled' }}>
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
  
@endsection
