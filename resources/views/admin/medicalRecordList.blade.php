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
          <input type="radio" class="btn-check col-3" name="btnradio" id="btnradio1" autocomplete="off" onclick="redirectToPatientMedFormList()" {{ Route::currentRouteName() === 'admin.patientMedFormList.show' ? 'checked' : '' }}>
          <label class="btn btn-outline-primary" for="btnradio1">HEALTH RECORDS</label>
      
          <input type="radio" class="btn-check col-3" name="btnradio" id="btnradio2" autocomplete="off" onclick="redirectToMedPatientRecords()" {{ Route::currentRouteName() === 'admin.medPatientRecords.show' ? 'checked' : '' }}>
          <label class="btn btn-outline-primary" for="btnradio2">MEDICAL PATIENT RECORDS</label>
        
          <input type="radio" class="btn-check col-3" name="btnradio" id="btnradio3" autocomplete="off" onclick="redirectToDailyConsultations()" {{ Route::currentRouteName() === 'admin.medPatientRecordList.show' ? 'checked' : '' }}>
          <label class="btn btn-outline-primary" for="btnradio3">DAILY CONSULTATIONS</label>
        
          <input type="radio" class="btn-check col-3" name="btnradio" id="btnradio4" autocomplete="off" onclick="redirectToReports()" {{ Route::currentRouteName() === 'admin.reports' ? 'checked' : '' }}>
          <label class="btn btn-outline-primary" for="btnradio4">REPORTS</label>
        </div>
      </div>
    
    <script>
      function redirectToPatientMedFormList() {
          window.location.href = "{{ route('admin.patientMedFormList.show') }}";
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

    <div class="col-xl-2 col-lg-12 my-2">
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
                    $('#bannerStudent').show()
                    $('#personnelList').hide();
                    $('#bannerPersonnel').hide()
                }
                else{
                    $('#studentsList').hide();
                    $('#bannerStudent').hide()
                    $('#personnelList').show();
                    $('#bannerPersonnel').show()
                }
            })
        })
    </script>
    <div class="d-flex flex-row">
        <div class="col-sm border p-3 border-dark">
            <header class="text-center">
                <h5 class="display-7 pt-3">
                    <p class="fs-2 fw-bold">Bicol University Health Services</p>
                    <p class="fs-4 fw-normal" id="bannerStudent">Student Health Records List</p>
                    <p class="fs-4 fw-normal" id="bannerPersonnel" style="display: none;">Personnel Health Records List</p>
            </header>
        </div>
    </div>

    <!-- Search function -->
        <form method="GET" action="{{ route('admin.patientMedFormList.show') }}" id="searchForm">
                <div class="row row-cols-lg-2 row-cols-md-2 row-cols-sm-1 align-items-center my-2" style="margin-right: -3%;">
                    <div class="row align-items-center">
                        <div class="col-sm">
                            <input type="text" class="form-control" id="search" name="search" value="{{ request()->input('search') }}" placeholder="Search...">
                        </div>
                        <div class="col-sm">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                    <div class="row justify-content-end mt-2">
                        <div class="col-sm-2">
                            <p class="fs-5 fw-light float-end pt-1">
                                Filter by:
                            </p>
                        </div>
                        <div class="col-lg-5">
                            <select id="campusSelect" name="campusSelect" class="form-select">
                                <option selected="selected" disabled="disabled" value="">CAMPUS</option>
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
                        </div>
                    
                        <!--div class="col-lg-5">
                        <select id="courseSelect" name="courseSelect" class="form-select">
                            <option selected="selected" disabled="disabled" value="">COURSE</option>
                        </select>

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
                            });
                        </script>
                        </div-->
                    </div>
                </div>
            </form>
        <div class="table-responsive" id="studentsList">
            <table class="table table-bordered table-sm">
                <caption style="user-select: none;">End of Student Health Records List</caption>
                <thead>
                    <tr class="text-center">
                        <th class="col-md-2 col-sm-3 custom-col-id border border-dark border-end-0">
                            <span class="fs-4 font-monospace fw-bold">ID</span>
                        </th>
                        <th class="col-md-4 col-sm-3 border border-dark border-end-0">
                            <span class="fs-4 font-monospace fw-bold">NAME</span>
                        </th>
                        <th class="col-md-3 col-sm-3 border border-dark border-end-0">
                            <span class="fs-4 font-monospace fw-bold">CAMPUS</span>
                        </th>
                        <th class="col-md-3 col-sm-3 border border-dark">
                            <span class="fs-4 font-monospace fw-bold">COURSE</span>
                        </th>
                    </tr>
                </thead>
                <tbody id="table-body" class="table-group-divider">
                    @foreach ($students as $student)
                    <tr class="text-center divHover" onClick="window.open('{{ route('admin.studentMedForm.show', ['patientID' => $student->student_id_number ? $student->student_id_number : $student->applicant_id_number]) }}', '_blank'); return false;">
                      <td class="col-md-2 col-sm-3 border border-dark border-end-0 custom-col-id">
                        <div class="d-flex flex-row justify-content-center">
                          <div class="col-sm">
                            <p class="fs-5 fw-normal lessBottomMargin">{{ $student->applicant_id_number }}</p>
                          </div>
                        </div>
                        <div class="d-flex flex-row border-dark">
                          <div class="col-sm">
                            <p class="fs-5 fw-normal lessBottomMargin">{{ $student->student_id_number }}</p>
                          </div>
                        </div>
                      </td>
                      <td class="col-md-4 col-sm-3 border border-dark border-end-0">
                        <p class="fs-5 fw-normal mt-2">{{ $student->first_name }} {{ $student->middle_name }} {{ $student->last_name }}</p>
                      </td>
                      <td class="col-md-3 col-sm-3 border border-dark border-end-0">
                        <p class="fs-5 fw-normal mt-2">{{ $student->medicalRecord->campus }}</p>
                      </td>
                      <td class="col-md-3 col-sm-3 border border-dark">
                        <p class="fs-5 fw-normal mt-2">{{ $student->medicalRecord->course }}</p>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
            </table>
        </div>
        

    <div class="table-responsive" id="personnelList" style="display: none;">
        <table class="table table-bordered table-sm">
            <caption style="user-select: none;">End of Personnel Health Records List</caption>
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
                @foreach ($personnel as $personnel)
                    <tr class="text-center divHover" onClick="window.open('{{ route('admin.personnelMedForm.show', ['patientID' => $personnel->personnel_id_number ]) }}', '_blank'); return false;">
                        <td class="col-md-2 col-sm-3 border border-dark border-end-0 custom-col-id">
                            <p class="fs-5 fw-normal lessBottomMargin">{{ $personnel->personnel_id_number }}</p>
                        </td>
                        <td class="col-md-4 col-sm-3 border border-dark border-end-0">
                            <p class="fs-5 fw-normal mt-2">{{ $personnel->first_name }} {{ $personnel->middle_name }} {{ $personnel->last_name }}</p>
                        </td>
                        <td class="col-md-2 col-sm-3 border border-dark">
                            <p class="fs-5 fw-normal mt-2">{{ $personnel->medicalRecordPersonnel->designation }}</p>
                        </td>
                        <td class="col-md-2 col-sm-3 border border-dark">
                            <p class="fs-5 fw-normal mt-2">{{ $personnel->medicalRecordPersonnel->unitDepartment }}</p>
                        </td>
                        <td class="col-md-2 col-sm-3 border border-dark">
                            <p class="fs-5 fw-normal mt-2">{{ $personnel->medicalRecordPersonnel->campus }}</p>
                        </td>
                        
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
    <!--script>
        const filterSelect = document.querySelector('#campusSelect');
        filterSelect.addEventListener('change', filterTable);

        function filterTable() {
            const selectedValue = document.querySelector('#campusSelect').value;

            fetch(`/filter-table?criteria=${selectedValue}`)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                const arr = Object.values(data);
                console.log(arr);
                const tableBody = document.querySelector('#table-body');
                tableBody.innerHTML = '';

                arr.forEach(row => {
                    const tr = document.createElement('tr');
                    tr.classList.add('text-center', 'divHover');
                    tr.setAttribute('onClick', `window.open('${row.url}', '_blank'); return false;`);

                    const td1 = document.createElement('td');
                    td1.classList.add('col-md-2', 'col-sm-3', 'border', 'border-dark', 'border-end-0', 'custom-col-id');
                    const div1 = document.createElement('div');
                    div1.classList.add('d-flex', 'flex-row', 'justify-content-center');
                    const div1Child = document.createElement('div');
                    div1Child.classList.add('col-sm');
                    const p1 = document.createElement('p');
                    p1.classList.add('fs-5', 'fw-normal', 'lessBottomMargin');
                    p1.textContent = row.id_number;
                    div1Child.appendChild(p1);
                    div1.appendChild(div1Child);
                    const div2 = document.createElement('div');
                    div2.classList.add('d-flex', 'flex-row', 'border-dark');
                    const div2Child = document.createElement('div');
                    div2Child.classList.add('col-sm');
                    const p2 = document.createElement('p');
                    p2.classList.add('fs-5', 'fw-normal', 'lessBottomMargin');
                    p2.textContent = row.student_id_number;
                    div2Child.appendChild(p2);
                    div2.appendChild(div2Child);
                    td1.appendChild(div1);
                    td1.appendChild(div2);

                    const td2 = document.createElement('td');
                    td2.classList.add('col-md-4', 'col-sm-3', 'border', 'border-dark', 'border-end-0');
                    const p3 = document.createElement('p');
                    p3.classList.add('fs-5', 'fw-normal', 'mt-2');
                    p3.textContent = row.medicalRecord?.campus;
                    td2.appendChild(p3);

                    const td4 = document.createElement('td');
                    td4.classList.add('col-md-3', 'col-sm-3', 'border', 'border-dark', 'border-end-0');
                    const p4 = document.createElement('p');
                    p4.classList.add('fs-5', 'fw-normal', 'mt-2');
                    p4.textContent = row.medicalRecord.course;
                    td4.appendChild(p4);

                    tr.appendChild(td1);
                    tr.appendChild(td2);
                    tr.appendChild(td3);
                    tr.appendChild(td4);

                    tableBody.appendChild(tr);
                });
            });
        }

    </script-->
@endsection