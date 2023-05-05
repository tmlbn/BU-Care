@extends('admin.layouts.app')

@section('content')

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
  <button onclick="toggleView()" class="btn btn-primary">Toggle View</button>
            
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
                        <div class="col-sm-2 ">
                            <p class="fs-5 fw-light float-end pt-1">
                                Filter by:
                            </p>
                        </div>
                        <div class="col-sm-3">
                            <select id="campusFilter" name="campusFilter" class="form-select" required>
                                <option selected="selected" disabled="disabled" value="">CAMPUS</option>
                                <option value="College of Agriculture and Forestry">College of Agriculture and Forestry</option>
                                <option value="College of Arts and Letters" class="alternate">College of Arts and Letters</option>
                                <option value="Entrepreneurship, and Management">College of Business, Entrepreneurship, and Management</option>
                                <option value="College of Education" class="alternate">College of Education</option>
                                <option value="College of Engineering">College of Engineering</option>
                                <option value="College of Industrial Technology" class="alternate">College of Industrial Technology</option>
                                <option value="College of Medicine">College of Medicine</option>
                                <option value="College of Nursing" class="alternate">College of Nursing</option>
                                <option value="College of Science">College of Science</option>
                                <option value="College of Social Science and Philosoph" class="alternate">College of Social Science and Philosophy</option>
                                <option value="Institute of Design and Architecture">Institute of Design and Architecture</option>
                                <option value="Institute of Physical Education, Sports, and Recreation" class="alternate">Institute of Physical Education, Sports, and Recreation</option>
                                <option value="Gubat Campus">Gubat Campus</option>
                                <option value="Polangui Campus" class="alternate">Polangui Campus</option>
                                <option value="Tabaco Campus">Tabaco Campus</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="course" name="course" value="{{ request()->input('course') }}" placeholder="Filter by course...">
                        </div>

                        <div class="col-sm-3">
                            <select id="reportsTable" name="reportsTable" class="form-select">
                                    <option value="Table-Select">Select table</option>
                                    <option value="Table-Morbidities">Morbidities</option>
                                    <option value="Table-Appointments">Appointments</option>
                                    <option value="Table-Patients">Patients</option>
                            </select>
                          </div>
                    </div>
                </div>
        </form>

    <script>
        $searchQuery = '';
        if (isset($_GET['search'])) {
            $searchQuery = $_GET['search'];
        }
    </script>
        
    </div>
</div>

<div class="table-container p-3" id="table-container">
    <div class="table col-md-12 p-0 m-0">
      <table id="Table-Morbidities" name="Morbidities" class="table table-bordered">
        <thead class="text-center">
          <th>Rank</th>
          <th>Morbidity</th>
          <th>Number of Cases</th>
          <th>Percentage</th>
          <th>Top Course of said Morbidity</th>
        </thead>
      </table>
    </div>
    <div class="table col-md-12 p-0 m-0">
      <table id="Table-Appointments" name="Appointments" class="table table-bordered">
        <thead class="text-center">
          <th>Month</th>
          <th>Number of Appointments</th>
          <th>Purpose of Appointment</th>
          <th>Percentage</th>
          <th>Top Course</th>
        </thead>
      </table>
    </div>
    <div class="table col-md-12 p-0 m-0">
        <table id="Table-Patients" name="Patients" class="table table-bordered">
          <thead class="text-center">
            <th>Patient ID</th>
            <th>Number of Appointments made</th>
            <th>Reason of Appointment</th>
            <th>Percentage</th>
            <th>Course</th>
          </thead>
        </table>
      </div>
  </div>

  
    <div id="graph" style="display:none;">
        <canvas id="Graph-Morbidities"></canvas>
    </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
  <script>

     
    // Get the dropdown element
    const tableSelector = document.getElementById("reportsTable");
  
    // Get the tables
    const table1 = document.getElementById("Table-Morbidities");
    const table2 = document.getElementById("Table-Appointments");
    const table3 = document.getElementById("Table-Patients");
  
    // Hide the tables initially
    table1.style.display = "none";
    table2.style.display = "none";
    table3.style.display = "none";
  
    // Add an event listener to the dropdown
    tableSelector.addEventListener("change", function() {
      // Get the selected option value
      const selectedTable = tableSelector.value;
  
      // Hide all tables
      table1.style.display = "none";
      table2.style.display = "none";
      table3.style.display = "none";
  
      // Show the selected table
      document.getElementById(selectedTable).style.display = "table";
    });   
    

    // Toggle Graph
        function toggleView() {
          var table = document.getElementById("table-container");
          var graph = document.getElementById("graph");
          var options = document.getElementById("reportsTable");


          
          if (table.style.display === "none") {
            // Switch to table view
            table.style.display = "";
            graph.style.display = "none";

             // Show table options and hide graph options in dropdown
            for (var i = 0; i < options.options.length; i++) {
                var option = options.options[i];
                if (option.value.indexOf("Table-") === 0) {
                option.style.display = "";
                } else if (option.value.indexOf("Graph-") === 0) {
                option.style.display = "none";
                }
            }

          } else {
            // Switch to graph view
            table.style.display = "none";
            graph.style.display = "";
            options.disabled = false;

             // Show graph options and hide table options in dropdown
            for (var i = 0; i < options.options.length; i++) {
                var option = options.options[i];
                if (option.value.indexOf("Table-") === 0) {
                option.style.display = "none";
                } else if (option.value.indexOf("Graph-") === 0) {
                option.style.display = "";
                }
            }
        

     
    // Generate graph data
     var ctx = document.getElementById('Graph-Morbidities').getContext('2d');
     var chart = new Chart(ctx, {
       type: 'bar',
       data: {
         labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
         datasets: [{
           label: 'Age',
           backgroundColor: 'rgba(54, 162, 235, 0.5)',
           borderColor: 'rgba(54, 162, 235, 1)',
           borderWidth: 1,
           data: [25, 30, 40, 35]
         }]
       },
       options: {
         scales: {
           yAxes: [{
             ticks: {
               beginAtZero: true
             }
           }]
         }
       }
     });
   }
 } 
  
    </script> 
  

@endsection