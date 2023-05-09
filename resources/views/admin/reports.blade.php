@extends('admin.layouts.app')

@section('content')

<div class="container-fluid bg-custom text-dark p-5">
  <div class="col-md-12 p-3 text-decoration-none">    
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
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
  
  <!--button onclick="toggleView()" class="btn btn-primary">Toggle View</button-->
            
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

                        <div class="col-sm-3">
                            <select id="reportsTable" name="reportsTable" class="form-select">
                                    <option value="Table-Morbidities" selected>Morbidities</option>
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
<!--
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

  
    <div id="graph" style="display:none; width:100%; max-height: 50%;">
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
    table1.style.display = "table";
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
  -->
  <script>
    // Change default options for ALL charts
    Chart.defaults.set('plugins.datalabels', {
      color: '#FE777B'
    });

    $(document).ready(function(){
      const dataSelect = $('#appointments-report-select');

      dataSelect.on('change', function (){
        if (dataSelect.val() == 'APPOINTMENTS'){
          $('#appointments-report').show();
          $('#consultations-report').hide();
        }
        else if(dataSelect.val() == 'CONSULTATIONS'){
          $('#consultations-report').show();
          $('#appointments-report').hide();
        }
      });

      const subDataSelect = $('#appointments-sub-report-select');
        subDataSelect.on('change', function (){
          if (subDataSelect.val() == 'MONTHLY'){
            $('#appointmentsMonthly').show();
            $('#appointmentsChartDiv').hide();
            $('#topPatientsChartDiv').hide();
          }
          else if(subDataSelect.val() == 'TOPSERVICES'){
            $('#appointmentsChartDiv').show();
            $('#appointmentsMonthly').hide();
            $('#topPatientsChartDiv').hide();
          }
          else if(subDataSelect.val() == 'TOPPATIENTS'){
            $('#topPatientsChartDiv').show();
            $('#appointmentsMonthly').hide();
            $('#appointmentsChartDiv').hide();
          }
        });
    })

  </script>

<div class="d-flex flex-row">
  <div class="col-2 ps-5">
    <label for="appointments-report-select" class="fw-bold h6">SELECT DATA</label>
    <select id="appointments-report-select" class="form-select fw-bold border-black" name="appointments-report-select">
      <option value="APPOINTMENTS" selected>APPOINTMENTS</option>
      <option value="CONSULTATIONS">CONSULTATIONS</option>
    </select>
  </div>
  <div class="col-4 ps-5">
    <label for="appointments-sub-report-select" class="fw-bold h6">&nbsp;</label>
    <select id="appointments-sub-report-select" class="form-select fw-bold border-black" name="appointments-sub-report-select">
      <option value="MONTHLY" selected>Monthly Appointments</option>
      <option value="TOPSERVICES">Top Services Availed via Appointment</option>
      <option value="TOPPATIENTS">Top Patients with most Appointment Reservation</option>
    </select>
  </div>
</div>

<div class="px-5" id="appointments-report">

  <div id="appointmentsMonthly">
    <!-- MONTHLY REPORTS OF APPOINTMENTS -->
    <h1 class="text-center pt-5">Monthly Appointments</h1>
    <div id="appointmentsMonthlyGraphs">
        <div id="monthlyBarGraph" class="col-12">
          <canvas id="appointmentsMonth" style="max-width: 100%; max-height: 100%;"></canvas>
        </div>
    </div>
    <div class="d-flex flex-row">
      <div class="table-responsive col-4 pt-2">
        <table class="table table-sm table-striped table-bordered border-dark">
          <caption>Monthly Number of Appointments</caption>
          <thead>
            <tr>
              <th style="width: 16.66%">#</th>
              <th style="width: 50%">Name</th>
              <th style="width: 16.66%">Total</th>
            </tr>
          </thead>
            <tbody>
              @foreach(array_combine($months, $count) as $month => $counts)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $month }}</td>
                  <td>{{ $counts }}</td>
                </tr>
              @endforeach
            </tbody>
        </table>
      </div>

      <div class="table-responsive col-3 ps-3 pt-2">
        <table class="table table-striped table-bordered border-dark">
          <thead>
          <tr>
            <th>#</th>
            <th>Reason</th>
            <th>Total</th>
          </tr>
          </thead>
          <tbody>
            @foreach($data as $row)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row['status'] }}</td>
                <td>{{ $row['count'] }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      
        <!-- PIE CHART FOR STATUS -->
        <div id="monthlyStatusChart" class="col-4">
          <canvas id="appointmentChart" style=""></canvas>
        </div>
      </div>
    </div>

  <div id="appointmentsChartDiv" class="col-12" style="display: none;">
    <h1 class="text-center">Top Services Availed via Appointment</h1>
      <canvas id="appointmentsChart" style="max-height: 60%; min-width: 100%;"></canvas>
      <div class="table-responsive col-4">
        <table class="table table-sm table-striped table-bordered border-dark col-3">
          <thead>
          <tr>
            <th>#</th>
            <th>Reason</th>
            <th>Total</th>
          </tr>
          </thead>
          <tbody>
          @foreach($studentAppointments as $studentAppointment)
              <tr>
                <td style="width: 16.66%%">{{ $loop->iteration }}</td>
                <td style="width: 50%">{{ $studentAppointment->services }}</td>
                <td style="width: 16.66%%">{{ $studentAppointment->total }}</td>
              </tr>
          @endforeach
          </tbody>
        </table>
      </div>
      <script>
          const dataPoints = {!! $studentDataPoints !!};
          const chart = new Chart('appointmentsChart', {
              type: 'bar',
              data: {
                  labels: dataPoints.map(dataPoint => dataPoint.label),
                  datasets: [
                      {
                          label: 'Appointments by Reason',
                          data: dataPoints.map(dataPoint => dataPoint.y),
                          backgroundColor: 'rgba(0, 158, 223, 0.2)',
                          borderColor: 'rgba(0, 158, 223, 1)',
                          borderWidth: 3
                      },
                  ],
              },
              options: {
                  scales: {
                      y: {
                          beginAtZero: true,
                          stepSize: 1,
                      },
                  },
              },
          });
      </script>
  </div>

  <div id="topPatientsChartDiv" style="display: none;">
    <h1 class="text-center">Top Patients with most Appointment Reservation</h1>
    <canvas id="topPatientsChart" style="max-width: 100%; max-height: 50%;"></canvas>
    <div class="table-responsive col-4">
      <table class="table table-sm table-striped table-bordered border-dark">
        <caption>Top Patients with most Appointment Reservation</caption>
        <thead>
        <tr>
            <th style="width: 16.66%">#</th>
            <th style="width: 50%">Name</th>
            <th style="width: 16.66%">Total</th>
        </tr>
        </thead>
        <tbody>
          @foreach($topPatients as $topPatient)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $topPatient->full_name }}</td>
              <td>{{ $topPatient->total }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
      <script>
          var ctx = document.getElementById('topPatientsChart').getContext('2d');
          var topPatientsChart = new Chart('topPatientsChart', {
            type: 'bar',
            data: {
              labels: <?php echo json_encode($topPatientsLabels); ?>,
              datasets: [{
                label: 'Total Appointments',
                data: <?php echo json_encode($topPatientsData); ?>,
                backgroundColor: 'rgba(0, 158, 223, 0.2)',
                borderColor: 'rgba(0, 158, 223, 1)',
                borderWidth: 3
              }]
            },
            options: {
              scales: {
                yAxes: [{
                  ticks: {
                    beginAtZero: true
                  },
                  scaleLabel: {
                    display: true,
                    labelString: 'Total Appointments'
                  }
                }]
              },
              plugins: {
                datalabels: {
                  align: 'end',
                  anchor: 'end',
                  font: {
                    size: 10,
                    weight: 'bold'
                  },
                  formatter: function(value, context) {
                    return value;
                  }
                }
              }
            }
          });
      </script>
  </div>
    <script>
    var data = @json($data);
    var labels = [];
    var values = [];

    // Group data by status
    var groups = data.reduce(function (groups, row) {
        if (!groups[row.status]) {
            groups[row.status] = {
                label: row.status,
                data: []
            };
        }

        groups[row.status].data.push(row.count);

        return groups;
    }, {});

    // Generate chart data
    Object.keys(groups).forEach(function (status) {
        labels.push(status);
        values.push(groups[status].data.reduce(function (a, b) { return a + b; }, 0));
    });

    // Generate chart
    var ctx = document.getElementById('appointmentChart').getContext('2d');
    var statusChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                backgroundColor: [
                    '#36A2EB',
                    '#FFCE56',
                    '#FF6384',
                ],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                position: 'bottom',
            },
        }
    });
  </script>
    
    <script>
      var appointmentsMonth = document.getElementById('appointmentsMonth').getContext('2d');
      var myChart = new Chart(appointmentsMonth, {
        type: 'bar',
        data: {
          labels: <?php echo json_encode($months); ?>,
          datasets: [{
            label: 'Number of Appointments',
            data: <?php echo json_encode($count); ?>,
            backgroundColor: 'rgba(0, 158, 223, 0.2)',
            borderColor: 'rgba(0, 158, 223, 1)',
            borderWidth: 3
          }]
        },
        options: {
          plugins: {
            datalabels: {
              color: '#fff',
              anchor: 'end',
              align: 'top',
              font: {
                size: 10,
                weight: 'bold'
              },
              formatter: function(value, context) {
                return value;
              }
            }
          },
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }
      });
    </script>
  </div>
</div>

<div class="px-5" id="consultations-report" style="display: none;">
  HAHAXD
</div>

@endsection