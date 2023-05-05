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
    .ui-state-default:hover{
        background-color: #009edf !important;
    }
    .form-floating>.form-control,
    .form-floating>.form-control-plaintext {
      padding: 0rem 0.75rem;
    }
    .form-floating>.form-control,
    .form-floating>.form-control-plaintext,
    .form-floating>.form-select {
      height: calc(2.5rem + 2px);
      line-height: 1rem;
    }
    .form-floating>label {
      padding: 0.5rem 2.5rem;
    }
    @media (min-width: 1200px) {
    .container{
        max-width: 1500px;
    }
}
</style>
<!-- Header -->
<div class="container-lg w-20 position-relative my-2 bg-light text-dark pt-5 px-3 headMargin checkboxes">
    <div class="d-flex flex-row">
        <div class="col-6 border border-dark border-end-0 d-flex align-items-center justify-content-center">
            <div class="row">
                <div class="col-2 d-flex align-items-center justify-content-center">
                    <img src="{{ asset('media/BU-logo.png') }}" class="rounded" alt="BUHS-LOGO" style="width:100%; margin-left: 30%;">
                  </div>                  
                <div class="col-sm">
                    <header class="text-center px-auto py-auto">
                        <h5 class="display-7 pt-3 fs-3 font-monospace">
                            Republic of the Philippines<br>
                        </h5>
                        <h6 class="fw-bold fs-5 font-monospace">Bicol University</h6>
                        <h6 class="fs-5 font-monospace">Bicol University Health Services</h6>
                    </header>
                </div>
                <div class="col-2 d-flex align-items-center justify-content-center">
                    <img src="{{ asset('media/BUHS-logo.png') }}" class="rounded float-end" alt="BUHS-LOGO" style="width:100%; margin-right: 30%;">
                </div>
            </div>
        </div>
        <div class="col-6 border border-dark d-flex align-items-center justify-content-center">
            <header class="text-center px-auto py-auto">
              <h2 class="display-7 fs-3 pt-auto font-monospace">Personnel Health Record</h2>
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
<form method="POST" action="{{ route('personnel.medicalForm.store') }}" id="MRP_form" enctype="multipart/form-data" class="row g-3 pt-5 px-4 needs-validation" novalidate>
    @csrf

    <div class="row row-cols-lg-3 row-cols-md-1 mt-2">
        
        <div class="col-xl-4 col-lg-12 mt-2">
            <label for="personnel_id" class="form-label h6">Personnel ID<span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('personnel_id') is-invalid @enderror" id="personnel_id" name="personnel_id" value="" oninput="this.value = this.value.toUpperCase()" required>
            <div class="invalid-feedback">
                Please enter your Personnel ID.
            </div>

            <span class="text-danger">
                @error('personnel_id') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
                
    </div>

        <div class="row row-cols-lg-3 row-cols-md-1 mt-2">
            <div class="col-xl-4 col-lg-12 mt-2">
                <label for="designation" class="form-label h6">Designation<span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('designation') is-invalid @enderror" id="personnel_id" name="personnel_id" value="{{ old('designation') }}" oninput="this.value = this.value.toUpperCase()" required>
                <div class="invalid-feedback">
                    Please enter your Designation.
                </div>

                <span class="text-danger">
                    @error('designation') 
                      {{ $message }} 
                    @enderror
                </span>
            </div>

            <div class="col-xl-4 col-lg-12 mt-2">
                <label for="unitDepartment" class="form-label h6">Unit/Department<span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('unitDepartment') is-invalid @enderror" id="unitDepartment" name="unitDepartment" value="{{ old('unitDepartment') }}" oninput="this.value = this.value.toUpperCase()" required>
                <div class="invalid-feedback">
                    Please enter your Unit/Department.
                </div>
                <span class="text-danger"> 
                    @error('unitDepartment') 
                      {{ $message }} 
                    @enderror
                </span>
            </div> 
            <div class="col-xl-4 col-lg-12 mt-2">
                <label for="campusSelect" class="form-label h6">Campus<span class="text-danger">*</span></label>
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
        </div>   

    <div class="d-flex flex-row">
        <h4 class="pb-3"></h4>
    </div>
    <div class="row row-cols-1 row-cols-xl-7 row-cols-lg-4">
        <div class="col-xl-2 col-lg-3">
            <label for="MRP_lastName" class="form-label h6">Last Name<span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('MRP_lastName') is-invalid @enderror" id="MRP_lastName" name="MRP_lastName" value="{{ old('MRP_lastName') }}" oninput="this.value = this.value.toUpperCase()" required>
            <div class="invalid-feedback">
                Please enter your last name.
            </div>
            <span class="text-danger"> 
                @error('MRP_lastName') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-xl-2 col-lg-3">
            <label for="MRP_firstName" class="form-label h6">First Name<span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('MRP_firstName') is-invalid @enderror" id="MRP_firstName" name="MRP_firstName" value="{{ old('MRP_firstName') }}" oninput="this.value = this.value.toUpperCase()" required>
            <div class="invalid-feedback">
                Please enter your first name.
            </div>
            <span class="text-danger"> 
                @error('MRP_firstName') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-xl-2 col-lg-3">
            <label for="MRP_middleName" class="form-label h6">Middle Name</label>
            <input type="text" class="form-control @error('MRP_middleName') is-invalid @enderror" id="MRP_middleName" name="MRP_middleName" value="{{ old('MRP_middleName') }}" oninput="this.value = this.value.toUpperCase()">
            <span class="text-danger"> 
                @error('MRP_middleName') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-xl-1 col-lg-3">
            <label for="MRP_age" class="form-label h6">Age<span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('MRP_age') is-invalid @enderror" id="MRP_age" name="MRP_age" value="{{ old('MRP_age') }}" onKeyPress="if(this.value.length==2) return false;" required>
            <div class="invalid-feedback">
                Please enter your age.
            </div>
            <span class="text-danger"> 
                @error('MRP_age') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-xl-2 col-lg-3">
            <label for="MRP_sex" class="form-label h6">Sex<span class="text-danger">*</span></label>
            <select id="MRP_sex" class="form-select @error('MRP_sex') is-invalid @enderror" name="MRP_sex" required>
                <option selected="selected" disabled="disabled" value="">SELECT</option>
                <option value="MALE" {{ old('MRP_sex') == 'MALE' ? 'selected' : '' }}>MALE</option>
                <option value="FEMALE" {{ old('MRP_sex') == 'FEMALE' ? 'selected' : '' }}>FEMALE</option>
            </select>
            <div class="invalid-feedback">
                Please select your sex.
            </div>
            <span class="text-danger"> 
                @error('MRP_sex') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-xl-2 col-lg-3">
            <label for="MRP_gender" class="form-label h6">Gender<span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('MRP_gender') is-invalid @enderror" id="MRP_gender" name="MRP_gender" value="{{ old('MRP_gender') }}" oninput="this.value = this.value.toUpperCase()" required>
            <div class="invalid-feedback">
                Please enter your gender.
            </div>
            <span class="text-danger"> 
                @error('MRP_gender') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-xl-1 col-lg-3 mt-2">
            <div class="form-check mt-4">
                <input type="hidden" name="MRP_pwd" value="0">
                <label for="MRP_pwd" class="form-label h6">PWD</label>
                <input class="form-check-input" type="checkbox" value="1" name="MRP_pwd" id="MRP_pwd" {{ old('MRP_pwd') == 1 ? 'checked' : '' }}>
            </div>
        </div>
    </div>
        <div class="col-md-3">
            <label for="MRP_dateOfBirth" class="form-label h6">Date of Birth<span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('MRP_dateOfBirth') is-invalid @enderror" id="MRP_dateOfBirth" name="MRP_dateOfBirth" value="{{ old('MRP_dateOfBirth') }}" required onkeydown="return false;">
            <div class="invalid-feedback">
                Please select your date of birth.
            </div>
            <span class="text-danger"> 
                @error('MRP_dateOfBirth') 
                    {{ $message }} 
                @enderror
            </span>
        </div>      
        <script>
        $(document).ready(function() {
                $("#MRP_dateOfBirth").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy MM d',
                    showButtonPanel: true,
                    yearRange: "1900:c",
                    showAnim: 'slideDown',
                });
            });
        </script>

        <div class="col-md-3">
            <label for="MRP_civilStatus" class="form-label h6">Civil Status<span class="text-danger">*</span></label>
            <select id="MRP_civilStatus" name="MRP_civilStatus" class="form-select @error('MRP_civilStatus') is-invalid @enderror" value="{{ old('MRP_civilStatus') }}" required>
                <option selected="selected" disabled="disabled" value="">SELECT</option>
                <option value="SINGLE" {{ old('MRP_civilStatus') == 'SINGLE' ? 'selected' : '' }}>SINGLE</option>
                <option value="MARRIED" {{ old('MRP_civilStatus') == 'MARRIED' ? 'selected' : '' }} class="alternate">MARRIED</option>
                <option value="DIVORCED" {{ old('MRP_civilStatus') == 'DIVORCED' ? 'selected' : '' }}>DIVORCED</option>
                <option value="SEPARATED" {{ old('MRP_civilStatus') == 'SEPARATED' ? 'selected' : '' }} class="alternate">SEPARATED</option>
                <option value="WIDOWED" {{ old('MRP_civilStatus') == 'SINGWIDOWEDLE' ? 'selected' : '' }}>WIDOWED</option>
            </select>
            <div class="invalid-feedback">
                Please select your civil status.
            </div>
            <span class="text-danger"> 
                @error('MRP_civilStatus') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-3">
            <label for="MRP_nationality" class="form-label h6">Nationality<span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('MRP_nationality') is-invalid @enderror" id="MRP_nationality" name="MRP_nationality" value="{{ old('MRP_nationality') }}" oninput="this.value = this.value.toUpperCase()" required>
            <div class="invalid-feedback">
                Please enter your nationality.
            </div>
            <span class="text-danger"> 
                @error('MRP_nationality') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-3">
            <label for="MRP_religion" class="form-label h6">Religion<span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('MRP_religion') is-invalid @enderror" id="MRP_religion" name="MRP_religion" value="{{ old('MRP_religion') }}" oninput="this.value = this.value.toUpperCase()" required>
            <div class="invalid-feedback">
                Please enter your religion.
            </div>
            <span class="text-danger"> 
                @error('MRP_religion') 
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

        
        <div class="col-md-2">
            <label for="MRP_personnelContactNumber" class="form-label h6">Contact Number<span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('MRP_personnelContactNumber') is-invalid @enderror" value="{{ old('MRP_personnelContactNumber') }}" placeholder="09XXXXXXXXX" id="MRP_personnelContactNumber" name="MRP_personnelContactNumber" onKeyPress="if(this.value.length==11) return false;" required>
            <div class="invalid-feedback">
                Please enter your contact number.
            </div>
            <span class="text-danger"> 
                @error('MRP_personnelContactNumber') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <h5 class="pt-2">Contact Person in case of Emergency:</h5>
        <div class="col-md-6">
            <label for="MRP_emergencyContactName" class="form-label h6">Name<span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('MRP_emergencyContactName') is-invalid @enderror" id="MRP_emergencyContactName" name="MRP_emergencyContactName" value="{{ old('MRP_emergencyContactName') }}" oninput="this.value = this.value.toUpperCase()" required>
            <div class="invalid-feedback">
                Please enter the name of your emergency contact person.
            </div>
            <span class="text-danger">
                @error('MRP_emergencyContactName') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-6">
            <label for="MRP_emergencyContactNumber" class="form-label h6">Contact Number<span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('MRP_emergencyContactNumber') is-invalid @enderror" value="{{ old('MRP_emergencyContactNumber') }}" placeholder="09XXXXXXXXX" id="MRP_emergencyContactNumber" name="MRP_emergencyContactNumber" onKeyPress="if(this.value.length==11) return false;" required>
            <div class="invalid-feedback">
                Please enter the contact number of your emergency contact person.
            </div>
            <span class="text-danger"> 
                @error('MRP_emergencyContactNumber') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-6">
            <label for="MRP_emergencyContactOccupation" class="form-label h6">Occupation<span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('MRP_emergencyContactOccupation') is-invalid @enderror" value="{{ old('MRP_emergencyContactOccupation') }}" id="MRP_emergencyContactOccupation" name="MRP_emergencyContactOccupation" oninput="this.value = this.value.toUpperCase()" required>
            <div class="invalid-feedback">
                Please enter the occupation of your emergency contact person.
            </div>
            <span class="text-danger"> 
                @error('MRP_emergencyContactOccupation') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-6">
            <label for="MRP_emergencyContactRelationship" class="form-label h6">Relationship<span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('MRP_emergencyContactRelationship') is-invalid @enderror" value="{{ old('MRP_emergencyContactRelationship') }}" id="MRP_emergencyContactRelationship" name="MRP_emergencyContactRelationship" oninput="this.value = this.value.toUpperCase()" required>
            <div class="invalid-feedback">
                Please enter your relationship with your emergency contact person.
            </div>
            <span class="text-danger"> 
                @error('MRP_emergencyContactRelationship') 
                  {{ $message }} 
                @enderror
            </span>
        </div>
        <div class="col-md-12">
            <label for="MRP_emergencyContactAddress" class="form-label h6">Work/Home Address<span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('MRP_emergencyContactAddress') is-invalid @enderror" value="{{ old('MRP_emergencyContactAddress') }}" id="MRP_emergencyContactAddress" name="MRP_emergencyContactAddress" oninput="this.value = this.value.toUpperCase()" required>
            <div class="invalid-feedback">
                Please enter the address of your emergency contact person.
            </div>
            <span class="text-danger"> 
                @error('MRP_emergencyContactAddress') 
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
                <div class="d-flex flex-row checkboxes">
                    <div class="col-md-4 p-2">
                        <div class="form-check">
                            <input type="hidden" value="0" name="FHP_cancer">
                            <input class="form-check-input" type="checkbox" value="1" name="FHP_cancer" {{ old('FHP_cancer') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="FHP_cancer">
                                    Cancer
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input type="hidden" value="0" name="FHP_heartDisease">
                            <input class="form-check-input" type="checkbox" value="1" name="FHP_heartDisease" {{ old('FHP_heartDisease') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="FHP_heartDisease">
                                    Heart Disease
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input type="hidden" value="0" name="FHP_hypertension">
                            <input class="form-check-input" type="checkbox" value="1" name="FHP_hypertension" {{ old('FHP_hypertension') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="FHP_hypertension">
                                    Hypertension
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input type="hidden" value="0" name="FHP_thyroidDisease">
                            <input class="form-check-input" type="checkbox" value="1" name="FHP_thyroidDisease" {{ old('FHP_thyroidDisease') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="FHP_thyroidDisease">
                                    Thyroid Disease
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input type="hidden" name="FHP_tuberculosis" value="0">
                            <input class="form-check-input" type="checkbox" value="1" name="FHP_tuberculosis" {{ old('FHP_tuberculosis') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="FHP_tuberculosis">
                                    Tuberculosis
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input type="hidden" name="FHP_hivAids" value="0">
                            <input class="form-check-input" type="checkbox" value="1" name="FHP_hivAids" {{ old('FHP_hivAids') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="FHP_hivAids">
                                    HIV/AIDS
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div><!-- END OF COL DIV -->
                    <div class="col-md-4 p-2">
                        <div class="form-check">
                            <input type="hidden" value="0" name="FHP_diabetesMelittus">
                            <input class="form-check-input" type="checkbox" value="1" name="FHP_diabetesMelittus" {{ old('FHP_diabetesMelittus') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="FHP_diabetesMelittus">
                                    Diabetes Melittus
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input type="hidden" name="FHP_mentalDisorder" value="0">
                            <input class="form-check-input" type="checkbox" value="1" name="FHP_mentalDisorder" {{ old('FHP_mentalDisorder') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="FHP_mentalDisorder">
                                    Mental Disorder
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input type="hidden" name="FHP_asthma" value="0">
                            <input class="form-check-input" type="checkbox" value="1" name="FHP_asthma" {{ old('FHP_asthma') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="FHP_asthma">
                                    Asthma
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input type="hidden" name="FHP_convulsions" value="0">
                            <input class="form-check-input" type="checkbox" value="1" name="FHP_convulsions" {{ old('FHP_convulsions') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="FHP_convulsions">
                                    Convulsions
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input type="hidden" name="FHP_bleedingDyscrasia" value="0">
                            <input class="form-check-input" type="checkbox" value="1" name="FHP_bleedingDyscrasia" {{ old('FHP_bleedingDyscrasia') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="FHP_bleedingDyscrasia">
                                    Bleeding Dyscrasia
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input type="hidden" name="FHP_arthritis" value="0">
                            <input class="form-check-input" type="checkbox" value="1" name="FHP_arthritis" {{ old('FHP_arthritis') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="FHP_arthritis">
                                    Arthritis
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div><!-- END OF COL DIV -->
                    <div class="col-md-4 p-2">
                        <div class="form-check">
                            <input type="hidden" name="FHP_eyeDisorder" value="0">
                            <input class="form-check-input" type="checkbox" value="1" name="FHP_eyeDisorder" {{ old('FHP_eyeDisorder') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="FHP_eyeDisorder">
                                    Eye Disorder
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input type="hidden" name="FHP_skinProblems" value="0">
                            <input class="form-check-input" type="checkbox" value="1" name="FHP_skinProblems" {{ old('FHP_skinProblems') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="FHP_skinProblems">
                                    Skin Problems
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input type="hidden" name="FHP_kidneyProblems" value="0">
                            <input class="form-check-input" type="checkbox" value="1" name="FHP_kidneyProblems" {{ old('FHP_kidneyProblems') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="FHP_kidneyProblems">
                                    Kidney Problems
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input type="hidden" name="FHP_gastroDisease" value="0">
                            <input class="form-check-input" type="checkbox" value="1" name="FHP_gastroDisease" {{ old('FHP_gastroDisease') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="FHP_gastroDisease">
                                    Gastrointestinal Disease
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="form-check">
                            <input type="hidden" name="FHP_hepatitis" value="0">
                            <input class="form-check-input" type="checkbox" value="1" name="FHP_hepatitis" {{ old('FHP_hepatitis') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="FHP_hepatitis">
                                    Hepatitis
                                </label>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div><!-- END OF COL DIV --> 
                </div><!-- END OF ROW of CHECKBOXES DIV -->
            <div class="form-row align-items-center">
                <div class="col p-2">
                    <input type="hidden" name="FHP_others" value="0">
                    <input class="form-check-input" type="checkbox" value="1" id="FHP_others" name="FHP_others" {{ old('FHP_others') == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="FHP_others" style="display: contents!important;">
                            Others
                        </label>
                            <input type="hidden" name="FHP_othersDetails" value="N/A">
                            <input type="text" class="form-control input-sm @error('FHP_othersDetails') is-invalid @enderror" value="{{ old('FHP_othersDetails') }}" id="FHP_othersDetails" name="FHP_othersDetails" placeholder="separate with comma(,) if multiple" {{ old('FHP_others') == 1 ? '' : 'disabled' }}>
                            <span class="text-danger"> 
                                @error('FHP_othersDetails') 
                                  {{ $message }} 
                                @enderror
                              </span>    
                            <!-- SCRIPT FOR INPUT TOGGLE ON CHECKBOX TICK -->
                                <script>
                                    const fhPOthers = document.getElementById('FHP_others');
                                    const fhPOthersDetails = document.getElementById('FHP_othersDetails');
                                    
                                    fhPOthers.onchange = function() {
                                        if (this.checked) {
                                            fhPOthersDetails.disabled = false;
                                            fhPOthersDetails.required = true;
                                        } else {
                                            fhPOthersDetails.disabled = true;
                                            fhPOthersDetails.required = false;
                                        }
                                    };

                                    // Initialize the form state on page load
                                    if (fhPOthers.checked) {
                                        fhPOthersDetails.disabled = false;
                                        fhPOthersDetails.required = true;
                                    } else {
                                        fhPOthersDetails.disabled = true;
                                        fhPOthersDetails.required = false;
                                    }
                                </script>
                    </div><!-- END OF COL OTHERS DIV -->
                </div><!-- END OF ROW OTHERS DIV -->
            </div><!-- END OF COL FHP -->

            <!-- START OF PPSH -->
            <div class="col-lg-5 col-md-12 p-2 border border-dark">
                <h6>Personal Social History</h6>
                    <div class="form-check">
                    <input type="hidden" name="PPSH_smoking" value="0">
                    <input class="form-check-input" type="checkbox" value="1" id="PPSH_smoking" name="PPSH_smoking" {{ old('PPSH_smoking') == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="PPSH_smoking" style="display: contents!important;">
                            Smoking
                        </label>
                            <br>
                            <div class="d-flex align-items-center">
                            ( <input type="text" class="form-control col-sm-2 mx-1 @error('PPSH_smoking_amount') is-invalid @enderror" value="{{ old('PPSH_smoking_amount') }}" style="width: 10%;" id="PPSH_smoking_amount" name="PPSH_smoking_amount" {{ old('PPSH_smoking') == 1 ? '' : 'disabled' }}> 
                            <div class="invalid-feedback">
                                Please enter the amount of sticks you smoke per/day.
                            </div>
                            <span class="text-danger"> 
                                @error('PPSH_smoking_amount') 
                                  {{ $message }} 
                                @enderror
                            </span>  
                            sticks/day for 
                            <input type="text" class="form-control col-sm-2 mx-1 @error('PPSH_smoking_freq') is-invalid @enderror" value="{{ old('PPSH_smoking_freq') }}" style="width: 10%;" id="PPSH_smoking_freq" name="PPSH_smoking_freq" {{ old('PPSH_smoking') == 1 ? '' : 'disabled' }}>
                            year/s )
                            <div class="invalid-feedback">
                                Please enter how many years you've been smoking.
                            </div>
                            <span class="text-danger"> 
                                @error('PPSH_smoking_freq') 
                                  {{ $message }} 
                                @enderror
                            </span>
                            </div>
                        
                    </div>
                    <div class="form-check mt-3">
                        <input type="hidden" name="PPSH_eCig" value="0">
                        <input class="form-check-input" type="checkbox" value="1" id="PPSH_eCig" name="PPSH_eCig" {{ old('PPSH_eCig') == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="PPSH_eCig" style="display: contents!important;">
                            E-Cigarette
                        </label>
                        <span class="text-danger"> 
                            @error('PPSH_eCig') 
                              {{ $message }} 
                            @enderror
                        </span>    
                    </div>
                    <div class="form-check">
                        <input type="hidden" name="PPSH_vape" value="0">
                        <input class="form-check-input" type="checkbox" value="1" id="PPSH_vape" name="PPSH_vape" {{ old('PPSH_vape') == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="PPSH_vape" style="display: contents!important;">
                            Vape
                        </label>
                        <span class="text-danger"> 
                            @error('PPSH_vape') 
                              {{ $message }} 
                            @enderror
                        </span>    
                    </div>

                <!-- END OF SMOKING FORM DIV -->

                <div class="form-check mt-3">
                    <input type="hidden" name="PPSH_drinking" value="0">
                    <input class="form-check-input" type="checkbox" value="1" id="PPSH_drinking" name="PPSH_drinking" {{ old('PPSH_drinking') == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="PPSH_drinking" style="display: contents!important;">
                            Liquor Consumption:
                            <br>
                            How often?
                            <input type="text" class="form-control col-sm-10 @error('PPSH_drinkingDetails') is-invalid @enderror" value="{{ old('PPSH_drinkingDetails') }}" id="PPSH_drinkingDetails" name="PPSH_drinkingDetails" oninput="this.value = this.value.toUpperCase()" {{ old('PPSH_drinking') == 1 ? '' : 'disabled' }}/>
                            <div class="invalid-feedback">
                                Please enter how often you drink liqour.
                            </div>
                            <span class="text-danger"> 
                                @error('PPSH_drinkingDetails') 
                                  {{ $message }} 
                                @enderror
                            </span>                   
                        </label>
                </div><!-- END OF DRINKING FORM DIV -->

                    <!-- SCRIPT FOR INPUT TOGGLE ON CHECKBOX TICK -->
                <script>
                   $(document).ready(function() {
                        /* SMOKING */
                        $('#PPSH_smoking').change(function() {
                            $('#PPSH_smoking_amount').prop('disabled', !this.checked);
                            $('#PPSH_smoking_freq').prop('disabled', !this.checked);
                            $('#PPSH_smoking_amount').prop('required', this.checked);
                            $('#PPSH_smoking_freq').prop('required', this.checked);
                        });
                        
                        /* DRINKING */
                        $('#PPSH_drinking').change(function() {
                            $('#PPSH_drinkingDetails').prop('disabled', !this.checked);
                            $('#PPSH_drinkingDetails').prop('required', this.checked);
                        });
                    });

                </script>

            </div><!-- END OF PPSH COL DIV -->
        </div><!-- END OF ROW ENTIRE DIV -->

        <!--Personal History-->
        
        <h5 class="ms-1">Personal Medical Condition</h5>
        <div class="mx-auto row row-cols-lg-1 mt-2">
            <div class="col-md-12 p-2 border border-dark">  
                <div class="d-flex row row-cols-xl-3 row-cols-md-1 justify-content-between">
                    <div class="col-xl-2 p-2">
                        <div class="mx-auto row row-cols-xl-1 row-cols-md-2 row-cols-sm-2 mt-2 ">
                            <div class="col mb-2">
                                <input type="hidden" name="PMC_hypertension" value="0">
                                <input class="form-check-input" type="checkbox" value="1" name="PMC_hypertension" {{ old('PMC_hypertension') == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="PMC_hypertension">
                                    Hypertension
                                </label>
                            </div><!-- END OF CHECKBOX DIV -->
                            <div class="col mb-2">
                                <input type="hidden" name="PMC_asthma" value="0">
                                <input class="form-check-input" type="checkbox" value="1" name="PMC_asthma" {{ old('PMC_asthma') == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="PMC_asthma">
                                        Asthma
                                    </label>
                            </div><!-- END OF CHECKBOX DIV -->
                            <div class="col mb-2">
                                <input type="hidden" name="PMC_diabetes" value="0">
                                <input class="form-check-input" type="checkbox" value="1" name="PMC_diabetes" {{ old('PMC_diabetes') == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="PMC_diabetes">
                                        Diabetes
                                    </label>
                            </div><!-- END OF CHECKBOX DIV -->
                            <div class="col mb-2">
                                <input type="hidden" name="PMC_arthritis" value="0">
                                <input class="form-check-input" type="checkbox" value="1" name="PMC_arthritis" {{ old('PMC_arthritis') == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="PMC_arthritis">
                                        Arthritis
                                    </label>
                            </div><!-- END OF CHECKBOX DIV -->
                            <div class="col mb-2">
                                <input type="hidden" name="PMC_chickenPox" value="0">
                                <input class="form-check-input" type="checkbox" value="1" name="PMC_chickenPox" {{ old('PMC_chickenPox') == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="PMC_chickenPox">
                                        Chicken Pox
                                    </label>
                            </div><!-- END OF CHECKBOX DIV -->
                            <div class="col mb-2">
                                <input type="hidden" name="PMC_dengue" value="0">
                                <input class="form-check-input" type="checkbox" value="1" name="PMC_dengue" {{ old('PMC_dengue') == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="PMC_dengue">
                                        Dengue
                                    </label>
                            </div><!-- END OF CHECKBOX DIV -->
                            <div class="col mb-2">
                                <input type="hidden" name="PMC_tuberculosis" value="0">
                                <input class="form-check-input" type="checkbox" value="1" name="PMC_tuberculosis" {{ old('PMC_tuberculosis') == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="PMC_tuberculosis">
                                        Tuberculosis
                                    </label>
                            </div><!-- END OF CHECKBOX DIV -->
                            <div class="col mb-2">
                                <input type="hidden" name="PMC_pneumonia" value="0">
                                <input class="form-check-input" type="checkbox" value="1" name="PMC_pneumonia" {{ old('PMC_pneumonia') == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="PMC_pneumonia">
                                        Pneumonia
                                    </label>
                            </div><!-- END OF CHECKBOX DIV -->
                            <div class="col mb-2">
                                <input type="hidden" name="PMC_covid19" value="0">
                                <input class="form-check-input" type="checkbox" value="1" name="PMC_covid19" {{ old('PMC_covid19') == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="PMC_covid19">
                                        Covid-19
                                    </label>
                            </div><!-- END OF CHECKBOX DIV -->
                            <div class="col mb-2">
                                <input type="hidden" name="PMC_hivAids" value="0">
                                <input class="form-check-input" type="checkbox" value="1" name="PMC_hivAids" {{ old('PMC_hivAids') == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="PMC_hivAids">
                                        HIV/AIDS
                                    </label>
                            </div><!-- END OF CHECKBOX DIV -->
                        </div>
                    </div>
                <!-- START OF CHECKBOXES WITH INPUT -->
                    <div class="col-xl-5 p-2">
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                                <div class="input-group-text bg-light border-0">
                                    <input type="hidden" name="PMC_hepatitis" value="0">
                                    <input class="form-check-input mt-0" type="checkbox" value="1" name="PMC_hepatitis" style="margin-right: -10px;" {{ old('PMC_hepatitis') == 1 ? 'checked' : '' }}>
                                </div>
                                <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Hepatitis: </span>
                                <input type="text" class="form-control @error('PMC_hepatitisDetails') is-invalid @enderror" id="PMC_hepatitisDetails" name="PMC_hepatitisDetails" value="{{ old('PMC_hepatitisDetails') }}" oninput="this.value = this.value.toUpperCase()" {{ old('PMC_hepatitis') == 1 ? '' : 'disabled' }}>
                            </div>
                            <div class="invalid-feedback">
                                Please enter some details.
                            </div>
                            <span class="text-danger"> 
                                @error('PMC_hepatitisDetails') 
                                {{  $message }} 
                                @enderror
                            </span>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                                <div class="input-group-text bg-light border-0">
                                    <input type="hidden" name="PMC_thyroidDisorder" value="0">
                                    <input class="form-check-input mt-0" type="checkbox" value="1" name="PMC_thyroidDisorder" style="margin-right: -10px;" {{ old('PMC_thyroidDisorder') == 1 ? 'checked' : '' }}>
                                </div>
                                <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Thyroid Disorder: </span>
                                <input type="text" class="form-control @error('PMC_thyroidDisorderDetails') is-invalid @enderror" id="PMC_thyroidDisorderDetails" name="PMC_thyroidDisorderDetails" value="{{ old('PMC_thyroidDisorderDetails') }}" oninput="this.value = this.value.toUpperCase()" {{ old('PMC_thyroidDisorder') == 1 ? '' : 'disabled' }}>
                            </div>
                            <div class="invalid-feedback">
                                Please enter some details.
                            </div>
                            <span class="text-danger"> 
                                @error('PMC_thyroidDisorderDetails') 
                                {{  $message }} 
                                @enderror
                            </span>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                                <div class="input-group-text bg-light border-0">
                                    <input type="hidden" name="PMC_eyeDisorder" value="0">
                                    <input class="form-check-input mt-0" type="checkbox" value="1" name="PMC_eyeDisorder" style="margin-right: -10px;" {{ old('PMC_eyeDisorder') == 1 ? 'checked' : '' }}>
                                </div>
                                <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Eye Disorder: </span>
                                <input type="text" class="form-control @error('PMC_eyeDisorderDetails') is-invalid @enderror" id="PMC_eyeDisorderDetails" name="PMC_eyeDisorderDetails" value="{{ old('PMC_eyeDisorderDetails') }}" oninput="this.value = this.value.toUpperCase()" {{ old('PMC_eyeDisorder') == 1 ? '' : 'disabled' }}>        
                            </div>
                            <div class="invalid-feedback">
                                Please enter some details.
                            </div>
                            <span class="text-danger"> 
                                @error('PMC_eyeDisorderDetails') 
                                {{  $message }} 
                                @enderror
                            </span>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                                <div class="input-group-text bg-light border-0">
                                    <input type="hidden" name="PMC_mentalDisorder" value="0">
                                    <input class="form-check-input mt-0" type="checkbox" value="1" name="PMC_mentalDisorder" style="margin-right: -10px;" {{ old('PMC_mentalDisorder') == 1 ? 'checked' : '' }}>
                                </div>
                                <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Mental Disorder: </span>
                                <input type="text" class="form-control @error('PMC_mentalDisorderDetails') is-invalid @enderror" id="PMC_mentalDisorderDetails" name="PMC_mentalDisorderDetails" value="{{ old('PMC_mentalDisorderDetails') }}" oninput="this.value = this.value.toUpperCase()" {{ old('PMC_mentalDisorder') == 1 ? '' : 'disabled' }}>
                            </div>
                            <div class="invalid-feedback">
                                Please enter some details.
                            </div>
                            <span class="text-danger"> 
                                @error('PMC_mentalDisorderDetails') 
                                {{  $message }} 
                                @enderror
                            </span>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                                <div class="input-group-text bg-light border-0">
                                    <input type="hidden" name="PMC_gastroDisease" value="0">
                                    <input class="form-check-input mt-0" type="checkbox" value="1" name="PMC_gastroDisease" style="margin-right: -10px;" {{ old('PMC_gastroDisease') == 1 ? 'checked' : '' }}>
                                </div>
                                <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Gastrointestinal Disease: </span>
                                <input type="text" class="form-control @error('PMC_gastroDiseaseDetails') is-invalid @enderror" id="PMC_gastroDiseaseDetails" name="PMC_gastroDiseaseDetails" value="{{ old('PMC_gastroDiseaseDetails') }}" oninput="this.value = this.value.toUpperCase()" {{ old('PMC_gastroDisease') == 1 ? '' : 'disabled' }}>
                            </div>
                            <div class="invalid-feedback">
                                Please enter some details.
                            </div>
                            <span class="text-danger"> 
                                @error('PMC_gastroDiseaseDetails') 
                                {{  $message }} 
                                @enderror
                            </span>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                                <div class="input-group-text bg-light border-0">
                                    <input type="hidden" name="PMC_kidneyDisease" value="0">
                                    <input class="form-check-input mt-0" type="checkbox" value="1" name="PMC_kidneyDisease" style="margin-right: -10px;" {{ old('PMC_kidneyDisease') == 1 ? 'checked' : '' }}>
                                </div>
                                 <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Kidney Disease: </span>
                                 <input type="text" class="form-control @error('PMC_kidneyDiseaseDetails') is-invalid @enderror" id="PMC_kidneyDiseaseDetails" name="PMC_kidneyDiseaseDetails" value="{{ old('PMC_kidneyDiseaseDetails') }}" oninput="this.value = this.value.toUpperCase()" {{ old('PMC_kidneyDisease') == 1 ? '' : 'disabled' }}>
                             </div>
                             <div class="invalid-feedback">
                                Please enter some details.
                            </div>
                             <span class="text-danger"> 
                                @error('PMC_kidneyDiseaseDetails') 
                                {{  $message }} 
                                @enderror
                            </span>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                    <div class="col-xl-5 p-2">
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                                <div class="input-group-text bg-light border-0">
                                    <input type="hidden" name="PMC_heartDisease" value="0">
                                    <input class="form-check-input mt-0" type="checkbox" value="1" name="PMC_heartDisease" style="margin-right: -10px;" {{ old('PMC_heartDisease') == 1 ? 'checked' : '' }}>
                                </div>
                                <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Heart Disease: </span>
                                <input type="text" class="form-control @error('PMC_heartDiseaseDetails') is-invalid @enderror" id="PMC_heartDiseaseDetails" name="PMC_heartDiseaseDetails" value="{{ old('PMC_heartDiseaseDetails') }}" oninput="this.value = this.value.toUpperCase()" {{ old('PMC_heartDisease') == 1 ? '' : 'disabled' }}>
                            </div>
                            <div class="invalid-feedback">
                                Please enter some details.
                            </div>
                            <span class="text-danger"> 
                                @error('PMC_heartDiseaseDetails') 
                                {{ $message }} 
                                @enderror
                                </span>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                                <div class="input-group-text bg-light border-0">
                                    <input type="hidden" name="PMC_skinDisease" value="0">
                                    <input class="form-check-input mt-0" type="checkbox" value="1" name="PMC_skinDisease" style="margin-right: -10px;" {{ old('PMC_skinDisease') == 1 ? 'checked' : '' }}>
                                </div>
                                <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Skin Disease: </span>
                                <input type="text" class="form-control @error('PMC_skinDiseaseDetails') is-invalid @enderror" id="PMC_skinDiseaseDetails" name="PMC_skinDiseaseDetails" value="{{ old('PMC_skinDiseaseDetails') }}" oninput="this.value = this.value.toUpperCase()" {{ old('PMC_skinDisease') == 1 ? '' : 'disabled' }}>
                            </div>
                            <div class="invalid-feedback">
                                Please enter some details.
                            </div>
                            <span class="text-danger"> 
                                @error('PMC_skinDiseaseDetails') 
                                {{  $message }} 
                                @enderror
                            </span>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                                <div class="input-group-text bg-light border-0">
                                    <input type="hidden" name="PMC_earDisease" value="0">
                                    <input class="form-check-input mt-0" type="checkbox" value="1" name="PMC_earDisease" style="margin-right: -10px;" {{ old('PMC_earDisease') == 1 ? 'checked' : '' }}>
                                </div>
                                <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Ear Disease: </span>
                                <input type="text" class="form-control @error('PMC_earDiseaseDetails') is-invalid @enderror" id="PMC_earDiseaseDetails" name="PMC_earDiseaseDetails" value="{{ old('PMC_earDiseaseDetails') }}" oninput="this.value = this.value.toUpperCase()" {{ old('PMC_earDisease') == 1 ? '' : 'disabled' }}>
                            </div>
                            <div class="invalid-feedback">
                                Please enter some details.
                            </div>
                            <span class="text-danger"> 
                                @error('PMC_earDiseaseDetails') 
                                {{  $message }} 
                                @enderror
                            </span>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                                <div class="input-group-text bg-light border-0">
                                    <input type="hidden" name="PMC_cancer" value="0">
                                    <input class="form-check-input mt-0" type="checkbox" value="1" name="PMC_cancer" style="margin-right: -10px;" {{ old('PMC_cancer') == 1 ? 'checked' : '' }}>
                                </div>
                                <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Cancer: </span>
                                <input type="text" class="form-control @error('PMC_cancerDetails') is-invalid @enderror" id="PMC_cancerDetails" name="PMC_cancerDetails" value="{{ old('PMC_cancerDetails') }}" oninput="this.value = this.value.toUpperCase()" {{ old('PMC_cancer') == 1 ? '' : 'disabled' }}>
                            </div>
                            <div class="invalid-feedback">
                                Please enter some details.
                            </div>
                            <span class="text-danger"> 
                                @error('PMC_cancerDetails') 
                                {{  $message }} 
                                @enderror
                            </span>
                        </div><!-- END OF CHECKBOX DIV -->
                        <div class="col-md-11">
                            <div class="input-group mb-3">
                            <div class="input-group-text bg-light border-0">
                                    <input type="hidden" name="PMC_others" value="0">
                                    <input class="form-check-input mt-0" type="checkbox" value="1" name="PMC_others" style="margin-right: -10px;" {{ old('PMC_others') == 1 ? 'checked' : '' }}>
                                </div>
                            <span class="input-group-text bg-light border-0" style="margin-left: -1px;">Others: </span>
                                <input type="text" class="form-control @error('PMC_othersDetails') is-invalid @enderror" id="PMC_othersDetails" name="PMC_othersDetails" value="{{ old('PMC_othersDetails') }}" oninput="this.value = this.value.toUpperCase()" {{ old('PMC_others') == 1 ? '' : 'disabled' }}>
                            </div>
                            <div class="invalid-feedback">
                                Please enter some details.
                            </div>
                            <span class="text-danger"> 
                                @error('PMC_othersDetails') 
                                {{  $message }} 
                                @enderror
                            </span>
                        </div><!-- END OF CHECKBOX DIV -->
                    </div>
                </div>
            </div>
        </div>
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
                                Do you have history of hospitalization for serious illness, operation, fracture or injury?
                            </label>
                        </div><!-- END OF YES DIV -->
                        <input type="text" class="form-control col-sm-10 @error('hospitalizationDetails') is-invalid @enderror" id="hospitalizationDetails" name="hospitalizationDetails" placeholder="If yes, please give details:" value="{{ old('hospitalizationDetails') }}" oninput="this.value = this.value.toUpperCase()" {{ old('hospitalization') == 1 ? '' : 'disabled' }}/>
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
                                    Are you taking any medicine regularly?
                            </label>
                        </div><!-- END OF YES DIV -->
                        <input type="text" class="form-control col-sm-10 @error('regMedsDetails') is-invalid @enderror" id="regMedsDetails" name="regMedsDetails" placeholder="If yes, name of drug/s:" value="{{ old('regMedsDetails') }}" oninput="this.value = this.value.toUpperCase()" {{ old('regMeds') == 1 ? '' : 'disabled' }}/>
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
            <div class="d-flex flex-row pt-2">
                <div class="col-sm" required>
                    <div class="form-check form-switch">
                        <input type="hidden" name="allergy" value="0">
                        <input class="form-check-input border-dark @error('allergy') is-invalid @enderror" type="checkbox" role="switch" name="allergy" id="allergy" value="1" {{ old('allergy') == '1' ? 'checked' : '' }}/>
                        <label class="form-check-label fw-bold" for="allergy">
                            Are you allergic to any food or medicine?
                        </label>
                    </div><!-- END OF YES DIV -->                    
                    <input type="text" class="form-control col-sm-10 @error('allergyDetails') is-invalid @enderror" id="allergyDetails" name="allergyDetails" placeholder="If yes, specify:" value="{{ old('allergyDetails') }}" oninput="this.value = this.value.toUpperCase()" {{ old('allergy') == 1 ? '' : 'disabled' }}/>
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
    </div>
        
        <!--Immunization History-->
        <div class="mx-auto row row-cols-lg-1 mt-2">
            <div class="col-md-12 p-2 border border-dark">
                <h6>Immunization History</h6>
                <div class="my-auto row row-cols-xl-2 row-cols-sm-1 align-items-center" style="margin-left: 5%;">
                    <div class="col-6">
                        <div class="row row-cols-2 row-cols-sm-1 align-items-center">
                            <div class="col-sm-4 p-2">
                                <input type="hidden" name="IH_bcg" value="0">
                                <input class="form-check-input" type="checkbox" value="1" name="IH_bcg">
                                    <label class="form-check-label" for="IH_bcg" data-toggle="tooltip" data-placement="top" title="Bacille Calmette-Guerin" {{ old('IH_bcg') == 1 ? 'checked' : '' }}>
                                        BCG
                                    </label>
                            </div>
                            <div class="col-sm-8 p-2">
                                <input type="hidden" name="IH_polio" value="0">
                                <input class="form-check-input" type="checkbox" value="1" name="IH_polio" {{ old('IH_polio') == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="IH_polio">
                                        Polio I, II, II, Booster Dose
                                    </label>
                            </div>
                            <div class="col-sm-4 p-2">
                                <input type="hidden" name="IH_chickenPox" value="0">
                                <input class="form-check-input" type="checkbox" value="1" name="IH_chickenPox" {{ old('IH_chickenPox') == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="IH_chickenPox">
                                        Chicken Pox
                                    </label>
                            </div>
                            <div class="col-sm-8 p-2">
                                <input type="hidden" name="IH_dpt" value="0">
                                <input class="form-check-input" type="checkbox" value="1" name="IH_dpt" {{ old('IH_dpt') == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="IH_dpt">
                                        DPT I, II, III, Booster Dose
                                    </label>
                            </div>
                        </div>
                        <div class="row row-cols-1 row-cols-sm-1 align-items-center">
                            <div class="col-sm-12 d-flex align-items-center p-2">
                                <input type="hidden" name="IH_covidVacc" value="0">
                                <input class="form-check-input mb-1" style="margin-top:6px;" type="checkbox" value="1" id="IH_covidVacc" name="IH_covidVacc" {{ old('IH_covidVacc') == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label mx-1" for="IH_covidVacc">
                                        Covid-19 Vaccine I, II
                                    </label>
                                        <input type="text" class="form-control @error('IH_covidVaccName') is-invalid @enderror" style="width: 20%;" id="IH_covidVaccName" name="IH_covidVaccName" value="{{ old('IH_covidVaccName') }}" oninput="this.value = this.value.toUpperCase()" {{ old('IH_covidVacc') == 1 ? '' : 'disabled' }}>
                                        <label class="form-check-label mx-1" for="IH_dpt">
                                            Booster I, II
                                        </label>
                                        <input type="text" class="form-control @error('IH_covidBoosterName') is-invalid @enderror" style="width: 20%;" id="IH_covidBoosterName" name="IH_covidBoosterName" value="{{ old('IH_covidBoosterName') }}" oninput="this.value = this.value.toUpperCase()" {{ old('IH_covidVacc') == 1 ? '' : 'disabled' }}>
                                        <script>
                                            $(document).ready(function() {
                                                $('#IH_covidVacc').change(function() {
                                                    $('#IH_covidVaccName').prop('disabled', !this.checked);
                                                    $('#IH_covidBoosterName').prop('disabled', !this.checked);
                                                    $('#IH_covidVaccName').prop('required', this.checked);
                                                    $('#IH_covidBoosterName').prop('required', this.checked);
                                                });
                                            });
                                        </script>
                            </div>
                            <span class="text-danger"> 
                                @error('IH_covidVaccName') 
                                {{  $message }} 
                                @enderror
                            </span>
                            <span class="text-danger"> 
                                @error('IH_covidBoosterName') 
                                {{  $message }} 
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row row-cols-xl-3 row-cols-lg-2 row-cols-sm-3 align-items-center">
                                <div class="col-4 p-2">
                                    <input type="hidden" name="IH_typhoid" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="IH_typhoid" {{ old('IH_typhoid') == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="IH_typhoid">
                                            Typhoid
                                        </label>
                                </div>
                                <div class="col-4 ps-lg-3 p-2">
                                    <input type="hidden" name="IH_mumps" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="IH_mumps" {{ old('IH_mumps') == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="IH_mumps">
                                            Mumps
                                        </label>
                                </div>
                                <div class="col-4 ps-lg-3 p-2">
                                    <input type="hidden" name="IH_hepatitisA" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="IH_hepatitisA" {{ old('IH_hepatitisA') == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="IH_hepatitisA">
                                            Hepatitis A
                                        </label>
                                </div>
                                <div class="col-4 p-2">
                                    <input type="hidden" name="IH_measles" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="IH_measles" {{ old('IH_measles') == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="IH_measles">
                                            Measles
                                        </label>
                                </div>
                                <div class="col-4 ps-lg-3 p-2">
                                    <input type="hidden" name="IH_germanMeasles" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="IH_germanMeasles" {{ old('IH_germanMeasles') == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="IH_germanMeasles">
                                            German Measles
                                        </label>
                                </div>
                                <div class="col-4 ps-lg-3 p-2">
                                    <input type="hidden" name="IH_hepatitisB" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="IH_hepatitisB" {{ old('IH_hepatitisB') == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="IH_hepatitisB">
                                            Hepatitis B
                                        </label>
                                </div>
                                <div class="col-4 p-2">
                                    <input type="hidden" name="IH_pneumococcal" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="IH_pneumococcal" {{ old('IH_pneumococcal') == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="IH_pneumococcal">
                                            Pneumococcal
                                        </label>
                                </div>
                                <div class="col-4 ps-lg-3 p-2">
                                    <input type="hidden" name="IH_influenza" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="IH_influenza" {{ old('IH_influenza') == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="IH_influenza">
                                            Influenza
                                        </label>
                                </div>
                                <div class="col-4 ps-lg-3 p-2">
                                    <input type="hidden" name="IH_hpv" value="0">
                                    <input class="form-check-input" type="checkbox" value="1" name="IH_hpv" {{ old('IH_hpv') == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="IH_hpv">
                                            HPV
                                        </label>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="my-auto pt-2 row row-cols-1 align-items-center" style="margin-left: 5%;">
                    <div class="form-group align-items-center col-sm-12 d-flex p-2">
                        <input type="hidden" name="IH_others" value="0">
                        <input class="form-check-input mb-1" type="checkbox" value="1" id="IH_others" name="IH_others" {{ old('IH_others') == 1 ? 'checked' : '' }}>
                            <label class="form-check-label mx-1" for="IH_others">
                                Others
                            </label>
                        <input type="text" class="form-control @error('IH_othersDetails') is-invalid @enderror" value="{{ old('IH_othersDetails') }}" style="width: 90%;" id="IH_othersDetails" name="IH_othersDetails" {{ old('IH_others') == 1 ? '' : 'disabled' }}>
                    </div>
                    <span class="text-danger"> 
                        @error('IH_othersDetails') 
                        {{ $message }} 
                        @enderror
                    </span> 
                    <script>
                        document.getElementById('IH_others').onchange = function() {
                            document.getElementById('IH_othersDetails').disabled = !this.checked;
                            document.getElementById('IH_othersDetails').required = this.checked;
                        };
                    </script>
                </div>
            </div>
        </div>

    <!-- ATTACHMENTS -->
    <div class="mx-auto row row-cols-lg-1 mt-2">
        <div class="col-md-12 p-2 border border-dark">
            <p class="fs-5 text-center">Please upload a photo of the official reading and result of the following:</p>
            <div class="flex justify-content-center">
                <div class="row row-cols-xl-4 row-cols-lg-2 row-cols-md-1 row-cols-sm-1 my-auto px-5 py-4">
                    <div class="mb-3 col-3 d-flex flex-column justify-content-center align-items-center" >
                        <label for="MRP_chestXray" class="form-label fw-bold @error('MRP_chestXray') is-invalid @enderror">Chest X-Ray Findings<span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="MRP_chestXray" name="MRP_chestXray" accept="image/jpeg, image/png" required>
                        <div class="invalid-feedback">
                            Please select a valid image(.jpeg, .jpg, .png) with maximum size of 5mb.
                        </div>
                    </div>
                    <div class="mb-3 col-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="MRP_cbcresults" class="form-label fw-bold @error('MRP_cbcresults') is-invalid @enderror">CBC Results<span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="MRP_cbcresults" name="MRP_cbcresults" accept="image/jpeg, image/png" required>
                        <div class="invalid-feedback">
                            Please select a valid image(.jpeg, .jpg, .png) with maximum size of 5mb.
                        </div>
                      </div>                      
                    <div class="mb-3 col-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="MRP_hepaBscreening" class="form-label fw-bold @error('MRP_hepaBscreening') is-invalid @enderror">Hepatitis B Screening<span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="MRP_hepaBscreening" name="MRP_hepaBscreening" accept="image/jpeg, image/png" required>
                        <div class="invalid-feedback">
                            Please select a valid image(.jpeg, .jpg, .png) with maximum size of 5mb.
                        </div>
                    </div> 
                    <div class="mb-3 col-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="MRP_bloodtype" class="form-label fw-bold @error('MRP_bloodtype') is-invalid @enderror">Blood Type<span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="MRP_bloodtype" name="MRP_bloodtype" accept="image/jpeg, image/png" required>
                        <div class="invalid-feedback">
                            Please select a valid image(.jpeg, .jpg, .png) with maximum size of 5mb.
                        </div>
                    </div>
                </div>
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
                                    resultDiv.classList.add('mb-3', 'col-3', 'd-flex', 'flex-column', 'justify-content-center', 'align-items-center');
                                    resultDiv.innerHTML = `
                                        <div class="align-items-center" style="display: flex; flex-direction: row;">
                                            <label for="MRP_additionalResult${nextResultId}" class="form-label fw-bold me-5" style="margin-right: 20px;">
                                                Results for:
                                            </label>
                                            <button type="button" class="btn btn-sm btn-light ms-5" style="margin-bottom: 5px; "margin-left: 200px;" onclick="removeResult('${nextResultId}')">&times;</button>
                                        </div>
                                        <input type="text" class="form-control my-1 @error('MRP_additionalResult${nextResultId}') is-invalid @enderror" id="MRP_additionalResult${nextResultId}" name="MRP_additionalResult${nextResultId}" placeholder="e.g. Urinalisys, Diabetes, ECG" oninput="this.value = this.value.toUpperCase()" required>
                                        <div class="invalid-feedback">
                                            Please enter the name of your additional results and findings.
                                        </div>
                                        <input type="file" class="form-control my-1 @error('MRP_additionalUpload${nextResultId}') is-invalid @enderror" id="MRP_additionalUpload${nextResultId}" name="MRP_additionalUpload${nextResultId}" accept="image/jpeg, image/png" required>
                                        <div class="invalid-feedback">
                                            Please select a valid image(.jpeg, .jpg, .png) with maximum size of 5mb.
                                        </div>
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
                    var b = $('#MRP_form')[0].checkValidity();
                    if ($('#MRP_form')[0].checkValidity()) {
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
                        $('#MRP_form :input[required]:visible').each(function() {
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
        </div>
    </div>
    <!-- Modal -->
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
                                <input class="form-check-input @error('radioCertify') is-invalid @enderror" type="radio" name="radioCertify" id="radioCertify" value="0"/>
                            </div>
                            <label for="radioCertify" class="fs-5 text-center mt-1">
                                I hereby certify that the foregoing answers are true and complete, and to the best of my knowledge.<span class="text-danger">*</span>
                            </label>
                            <div class="invalid-feedback">
                                Please tick the button, certifying that your foregoing answers are true and complete, and to the best of your knowledge.
                            </div>
                            <span class="text-danger" id="certifySpan"> 
                                @error('radioCertify') 
                                  {{ $message }} 
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer align-items-center mb-3">
                        <div class="d-flex align-items-center my-auto mx-auto">
                            <div class="input-group">
                                <label for="passwordInput" class="form-label h6 mt-2 me-2">Password<span class="text-danger">*</span>:</label>
                                <input type="password" class="form-control @error('passwordInput') is-invalid @enderror" id="passwordInput" name="passwordInput">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <div style="margin-top: -5px;">
                                        <span class="bi bi-eye-fill" aria-hidden="true"></span>
                                    </div>
                                </button>
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
    </div> 
    <script>
        $(document).ready(function() {
            $('input[type=checkbox]').change(function() {
                var input = $(this).closest('.input-group').find('input[type=text]');
                input.prop('disabled', !this.checked);
                input.prop('required', this.checked);
            });
        });
    </script>
    <script>
        function form_submit() {
            document.getElementById("MRP_form").submit();
        }

        (() => {
            'use strict'

            // Fetch all forms to apply validation styles to
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
                let certify = $('#radioCertify').val();
                
                $('#certifySpan').text('');
                $('#radioCertify').removeClass('is-invalid');

                if(certify != 1){
                    $('#radioCertify').addClass('is-invalid');
                    $('#certifySpan').text('Please certify that the foregoing answers are true and complete.');
                    return false;
                }
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
                            $('#MRP_form').submit();
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
            });
        });
    </script>
    
</form>
@endsection