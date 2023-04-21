@extends('layouts.app')
@section('content')
<style>
    table{
        border-collapse: collapse;
        border-color: black;
    }
    .fc-day {
        border-color: #444444;
    }
    .fc-day-number{
        font-weight: bold;
        font-size: 20px;
    }
    .fc-day-header{
        border-color: #444444;
    }
    .fc-view-container{
        margin-top: -1%;
    }
    .fc-today{
        background-color: rgb(240, 240, 190) !important;
    }
    .fc-past{
        background-color: rgb(202, 202, 202);
    }
    .fc-today:hover, .fc-future:hover{
        cursor: pointer;
        background-color:#009edf;
        transition-duration: 0.4s;
    }
    /* For fully-booked */
    td.pointer-events-none{
        cursor: not-allowed !important;
    }
    tr.booked {
        background-color: rgb(255, 95, 95) !important;
        color: rgb(0, 0, 0);
        pointer-events: none;
        opacity: 50%;
    }
    /* For 1 slot remaining */
    tr.lastOne {
        background-color: rgb(250, 250, 119);
    }
    tr.lastOne:hover {
        cursor: pointer;
        background-color: rgb(216, 216, 45) !important;
        transition: background-color 0.4s;
    }
    tr.lastOne.selected{
        background-color: rgb(216, 216, 45) !important;
        font-weight: bold;
        color:black;
        border: black 2px solid;
    }

    /* For 2 slots */
    tr.am.selected, tr.pm.selected {
        font-weight: bold;
        color:black;
        border: black 2px solid;
    }
    tr.am:hover, tr.pm:hover{
        cursor: pointer;
        background-color: rgb(243, 243, 193);
        transition: background-color 0.4s;
    }
    
</style>
    <div class="container pt-3" onload="checkAvailability()">
        <div></div>
        <div class="mx-auto align-items-center justify-content-center" style="width:80%;" id="calendar"></div>
        <div></div>
    </div>

    <script class="pt-2">
        $(document).ready(function () {
    
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                }
            });
        
            var calendar = $('#calendar').fullCalendar({
                themeSystem: 'bootstrap4',
                editable:true,
                header:{
                    left:'today',
                    center:'title',
                    right:'prev, next'
                },
                dayRender: function(date, cell) {
                    if (date.isoWeekday() === 6 || date.isoWeekday() === 7) {
                        cell.css('background-color', '#f1807d');
                    }
                    cell.css('border-color', '#444444');

                    cell.on('click', function() {
                        // Remove the 'selected' class from all cells
                        $('td.fc-selected').removeClass('selected');
                        // Add the 'selected' class to the clicked cell
                        cell.addClass('selected');
                    });
                },
                selectable:true,
                selectHelper: true,
                selectAllow: function(selectInfo) {
                    var today = moment();
                    var currentHour = moment().hour();
                    var selectedDate = moment(selectInfo.start.format('YYYY-MM-DD'));
                    console.log(selectedDate);
                    console.log(today);

                    // Only allow dates in the future
                    if (selectedDate.isBefore(today, 'day')) {
                        return false;
                    }
                    
                    // Only allow selecting today if current time is before 4pm
                    if (selectedDate.isSame(today, 'day') && currentHour >= 16) {
                        return false;
                    }

                    // Only return true if selected date is a future date and if today, time must be before 4pm
                    return true;
                },
                selectConstraint: {
                    start: '00:00', // Start at midnight
                    end: '24:00', // End at midnight the next day
                    dow: [1,2,3,4,5] // Monday to Friday only
                },
                
                select:function(start, end, allDay)
                {
                    // set the appointmentDate input value to the selected date
                    var selectedDate = moment(start).format('YYYY-MMMM-DD');
                    $('#appointmentDate').val(selectedDate);
                    
                    // make an AJAX request to fetch appointments for the selected date
                    $.ajax({
                        url: '/get-appointments',
                        method: 'GET',
                        data: {
                            date: selectedDate
                        },
                        success: function(entries) {
                            console.log(entries);
                            // remove classes before looping through the data
                            $('#time-slots tr').removeClass('booked lastOne selected');
                            $('#time-slots tr #timeSlot, #time-slots tr #numberOfSlots').removeClass('pointer-events-none');
                            $('#time-slots tr #numberOfSlots').text('2');
                            $('#appointmentTime').val('');
                            //loop through the data
                            $.each(entries, function(index, appointment) {
                                //console.log(appointment.appointmentTime);
                            //get the time of appointments
                                var appt_time = appointment.appointmentTime;
                                var formatted_time = moment(appt_time, 'HH:mm:ss').format('h:mm A');
                                //console.log(formatted_time);
                                //console.log(appt_time);
                                //loop through each table cell and check if it matches the appointment date and time
                                $('#time-slots tr').each(function() {
                                    var cell_time = $(this).find('#timeSlot').text();
                                    //console.log(cell_time);
                                    if (formatted_time == cell_time) {
                                    //if there is a match, add a class to the table cell that corresponds to the appointment status
                                        if (appointment.booked_slots == 2) {
                                            $(this).addClass('booked');
                                            $(this).find('#timeSlot').addClass('pointer-events-none');
                                            $(this).find('#numberOfSlots').addClass('pointer-events-none').text('FULL');
                                        } else if (appointment.booked_slots == 1) {
                                            $(this).addClass('lastOne');
                                            $(this).find('#numberOfSlots').text('1');
                                        }
                                    }
                                });
                            });
                        },
                        error: function(entries) {
                            console.log(entries.entriesJSON.error);
                        }
                    });

                    /*
                     *  Need to convert the loop of time and slots here
                     */

                    // Show modal
                    var modal = $('#appointmentModal');
                    $('body').append(modal);
                    modal.modal('show');
                    // Close modal
                    $('#appointmentModal .close').on('click', function() {
                        $('#appointmentModal').modal('hide');
                    });
                }
            });
        });
    </script>
    <!-- Modal for Time -->
    <div class="modal modal-dialog-scrollable modal-xl fade" data-bs-backdrop="static" id="appointmentModal" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title fs-5 fw-bold" id="appointmentModalLabel">BU-Care Appointment</p>
                    <button type="butto" class="btn btn-danger close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row row-cols-lg-2 rol-cols-md-1"><!-- MODAL DIV -->
                            <div class="col-lg-3 col-md-12">
                                <!-- APPOINTMENT TIME SELECT -->
                                <div class="row row-cols-lg-2 justify-content-center">
                                    <div class="col-lg-6 col-md-3 pb-2">
                                        <?php
                                            echo "Current date and time: " . date("Y-m-d H:i:s");
                                            ?>
                                        <button type="button" class="btn btn-primary float-lg-end float-md-start" id="ambtn" onclick="showAM()" disabled>AM</button>
                                    </div>
                                    <div class="col-lg-6 col-md-3 pb-2">
                                         <button type="button" class="btn btn-primary float-lg-start float-md-end" id="pmbtn" onclick="showPM()">PM</button>
                                    </div>
                                  </div>
                                  <table class="table table-bordered border-dark">
                                    <thead>
                                        <tr>
                                            <th>Time</th>
                                            <th>Slots</th>
                                        </tr>
                                    </thead>
                                    <tbody id="time-slots">
                                        <?php
                                            $start_am = strtotime('8:00 AM');
                                            $end_am = strtotime('11:45 AM');
                                            while ($start_am <= $end_am) {
                                                $time = date('g:i A', $start_am);
                                                echo "<tr id='timeAndSlots' class='am t-time' data-time='$time' onClick='handleTimeClick(this);'>";
                                                echo "<td id='timeSlot'>$time</td>";
                                                echo "<td id='numberOfSlots'> 2 </td>";
                                                echo "</tr>";
                                                $start_am = strtotime('+15 minutes', $start_am);
                                            }
                                            $start_pm = strtotime('1:00 PM');
                                            $end_pm = strtotime('4:45 PM');
                                            while ($start_pm <= $end_pm) {
                                                $time = date('g:i A', $start_pm);
                                                echo "<tr id='timeAndSlots' class='pm t-time' data-time='$time' onClick='handleTimeClick(this);' style='display:none;'>";
                                                echo "<td id='timeSlot'>$time</td>";
                                                echo "<td id='numberOfSlots'> 2 </td>";
                                                echo "</tr>";
                                                $start_pm = strtotime('+15 minutes', $start_pm);
                                            }
                                        ?>
                                    </tbody>
                                    <script>
                                        function handleTimeClick(row) {
                                            const time = row.getAttribute('data-time');
                                            document.getElementById('appointmentTime').value = time;  // set the input value to the clicked time
                                            const rows = document.querySelectorAll('.t-time');
                                            rows.forEach((r) => r.classList.remove('selected'));  // remove the 'selected' class from all rows
                                            row.classList.add('selected');  // add the 'selected' class to the clicked row
                                        }
                                        function showAM() {
                                            document.querySelectorAll("#time-slots tr").forEach(function(e) {
                                                e.style.display = "none";
                                            });
                                            document.querySelectorAll("#time-slots .am").forEach(function(e) {
                                                e.style.display = "";
                                            });
                                            document.getElementById('ambtn').disabled = true;
                                            document.getElementById('pmbtn').disabled = false;
                                        }
                                        function showPM() {
                                            document.querySelectorAll("#time-slots tr").forEach(function(e) {
                                                e.style.display = "none";
                                            });
                                            document.querySelectorAll("#time-slots .pm").forEach(function(e) {
                                                e.style.display = "";
                                            });
                                            document.getElementById('ambtn').disabled = false;
                                            document.getElementById('pmbtn').disabled = true;
                                        }
                                    </script>
                                  </table>
                                </div>

                            <!-- APPOINTMENT DETAILS -->
                            <div class="col-lg-9 col-md-12" id="services">
                                <form method="post" action="{{ route('appointmentDetails.store') }}">
                                    @csrf
                                    <div class="mx-auto row row-cols-lg-2 row-cols-md-1">
                                    </div>
                                    <input type="hidden" name="patientID" value={{ Auth::user()->id ?: Auth::guard('employee')->user()->id }}>
                                    <input type="hidden" name="patientType" value={{ Auth::user()->user_type ?: Auth::guard('employee')->user()->user_type }}>
                                    <div class="row row-cols-lg-2 row-cols-md-1"><!-- DATE/TIME DIV -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label for="appointmentDate" class="col-form-label fw-bolder">Date:</label>
                                            <input type="text" class="form-control fw-bold" name="appointmentDate" id="appointmentDate" required readonly>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label for="appointmentTime" class="col-form-label fw-bolder">Time:</label>
                                            <input type="text" class="form-control fw-bold" name="appointmentTime" id="appointmentTime" placeholder="Select Time" required   readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 p-2 border-lg-end-0">
                                        <h5>Services Availed</h5>
                                        <div class="row row-cols-lg-2 row-cols-md-1 checkboxes">
                                            <div class="col-lg-6 col-md-12 p-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" value="Medical Certificate" name="services">
                                                        <label class="form-check-label" for="services">
                                                            Medical Certificate
                                                        </label>    
                                                </div><!-- END OF CHECKBOX DIV -->
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" value="OPD Consultant" name="services">
                                                        <label class="form-check-label" for="services">
                                                            OPD Consultant
                                                        </label>
                                                </div><!-- END OF CHECKBOX DIV -->
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" value="others" id="others" name="services">
                                                        <label class="form-check-label" for="others">
                                                            Others
                                                        </label>
                                                        <div class="form-check">
                                                            <label for="othersInput" class="form-check-label">
                                                                <input type ="text" class="form-control" name="othersInput" id="othersInput" disabled>
                                                            </label>
                                                        </div>
                                                       
                                                </div><!-- END OF CHECKBOX DIV -->
                                            </div>
                                            <div class="col-lg-6 col-md-12 p-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" value="Reinstatement" name="services">
                                                        <label class="form-check-label" for="Reinstatement">
                                                            Reinstatement
                                                        </label>
                                                </div><!-- END OF CHECKBOX DIV -->
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" value="Sick Leave" name="services">
                                                        <label class="form-check-label" for="Sick Leave">
                                                            Sick Leave
                                                        </label>
                                                </div><!-- END OF CHECKBOX DIV -->
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" value="Unkown" name="services">
                                                        <label class="form-check-label" for="Unkown">
                                                            Unkown
                                                        </label>
                                                </div><!-- END OF CHECKBOX DIV -->
                                                <script>
                                                    $(document).ready(function(){
                                                        $('input[name="services"]').change(function(){
                                                            if($('#others').is(':checked')){
                                                                $('#othersInput').prop('disabled', false);
                                                            }else{
                                                                $('#othersInput').prop('disabled', true);    
                                                            }
                                                        });
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                        
                                        </div>
                                    <div class="form-group">
                                        <label for="appointmentDescription" class="col-form-label">Description:</label>
                                        <textarea class="form-control" name="appointmentDescription" id="appointmentDescription" style="resize: none; overflow: hidden;"></textarea>
                                    </div>  
                                    <script>
                                        var textarea = document.getElementById('appointmentDescription');

                                        textarea.addEventListener('input', function() {
                                        this.style.height = 'auto';
                                        this.style.height = this.scrollHeight + 'px';
                                        });
                                    </script>
                                    <div class="modal-footer mt-4 justify-content-between">
                                        <div class="d-flex my-auto mx-autop">
                                            <div class="input-group">
                                                <label for="passwordInput" class="form-label h6 mt-2 me-2">Password:</label>
                                                <input type="password" class="form-control" id="passwordInput" name="passwordInput">
                                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                <span class="bi bi-eye-fill" aria-hidden="true"></span>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="d-flex">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                </div>
                            
                        </div>
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
