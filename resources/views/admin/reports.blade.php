@extends('admin.layouts.app')

@section('content')

<div class="col-md-12 p-3">    
    <div class="col-md-12 p-1">
        
            
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
                              <option value="Select">Select table</option>
                              <option value="Morbidities">Morbidities</option>
                              <option value="Appointments">Appointments</option>
                              <option value="Patients">Patients</option>
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

<div class="table-container p-3 ">
    <div class="table col-md-12 p-0 m-0">
      <table id="Morbidities" name="Morbidities" class="table table-bordered">
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
      <table id="Appointments" name="Appointments" class="table table-bordered">
        <thead class="text-center">
          <th>Month</th>
          <th>Number of Appointments</th>
          <th>Top Reason of Appointment</th>
          <th>Percentage</th>
          <th>Top Course</th>
        </thead>
      </table>
    </div>
    <div class="table col-md-12 p-0 m-0">
        <table id="Patients" name="Patients" class="table table-bordered">
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

  
  <script>
    
    // Get the dropdown element
    const tableSelector = document.getElementById("reportsTable");
  
    // Get the tables
    const table1 = document.getElementById("Morbidities");
    const table2 = document.getElementById("Appointments");
    const table3 = document.getElementById("Patients");
  
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
  
  
    </script> 
  

@endsection