@extends('admin.layouts.app')
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
        background-color: rgb(230, 230, 230);
    }
    .fc-today:hover, .fc-future:hover{
        cursor: pointer;
        background-color:#deecf1;
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
        background-color: rgb(243, 243, 193);
    }
    tr.am:hover, tr.pm:hover{
        cursor: pointer;
        background-color: rgb(243, 243, 193);
        transition: background-color 0.4s;
    }
    .appointment-count {
        color: black;
        border-radius: 50px;
        margin-left: 25%;
        margin-right: 25%;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .fc-future:hover .appointment-count{
        margin-left: 24%;
        margin-right: 24%;
        transition: all 0.4s;
    }
    .legend-box {
        color: black;
        border-radius: 0;
        margin-left: 25%;
        margin-right: 25%;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 2px 4px 2px -2px gray;
        user-select: none;
    }
    .legend-pill {
        color: black;
        border-radius: 50px;
        margin-left: 30%;
        margin-right: 30%;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 2px 4px 2px -2px gray;
        user-select: none;
    }
    .legend-pill.available {
        animation: color-animation 8s infinite;
    }
    @keyframes color-animation {
        0% {
            background-color: #8deb8d;
        }
        60% {
            background-color: #fceaa2;
        }
        90% {
            background-color: #eb7c7c;
        }
        100% {
            background-color: #8deb8d;
        }
    }
    .hoverTicket:hover{
        cursor: pointer;
    }

</style>
<div class="mx-auto d-flex justify-content-center align-items-center">
    <div class="align-items-center justify-content-center col-6 mb-5" style="width:55%; padding-right: 0; padding-left: 0;" id="calendar">
        <!-- CALENDAR HERE -->
    </div>
            
        <script class="pt-2">
            const maxAppointment = 64;
            $(document).ready(function () {
        
                $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                    }
                });
                // All Appointment Entries starting today's date
                let appointmentEntry = @json($entries);
                let now = moment().format('YYYY-MM-DD');
            
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
                            cell.css('background-color', '#cf908f');
                        }
                        cell.css('border-color', '#444444');

                        cell.on('click', function() {
                            // Remove the 'selected' class from all cells
                            $('td.fc-selected').removeClass('selected');
                            // Add the 'selected' class to the clicked cell
                            cell.addClass('selected');
                        });
                        // Loop through the entries and count the number of appointments for the day.
                        var countValue = 0;
                        if(appointmentEntry[0]){
                            let currentLoopedAppointmentDate = appointmentEntry[0].appointmentDate;
                            $.each(appointmentEntry, function(i){
                                $.each(appointmentEntry[i], function (key, loopedAppointmentDate) {
                                    if(loopedAppointmentDate == date.format('YYYY-MM-DD')){
                                        countValue++;
                                        
                                    }
                                });
                            });
                            if(date.format('YYYY-MM-DD') >= (moment(currentLoopedAppointmentDate).format('YYYY-MM-DD')) && !(date.isoWeekday() === 6 || date.isoWeekday() === 7)){
                                if(countValue > 0 && countValue < 25){
                                    cell.append('<p class="appointment-count mt-5 text-center" style="background-color: #8deb8d;">' + (maxAppointment - countValue) + '</p>');
                                }
                                else if (countValue >= 25 && countValue <= 55) {
                                    cell.append('<p class="appointment-count mt-5 text-center" style="background-color: #fceaa2;">' + (maxAppointment - countValue) + '</p>');
                                }
                                else if (countValue >= 56 && countValue <= 63) {
                                    cell.append('<p class="appointment-count mt-5 text-center" style="background-color: #eb7c7c;">' + (maxAppointment - countValue) + '</p>');
                                }
                                else if (countValue == 64){
                                    cell.append('<p class="appointment-count mt-5 text-center" style="background-color: #eb7c7c;"> FULL </p>');
                                    cell.off('click');
                                    cell.css('cursor', 'default');
                                }
                            }
                        }
                    },
                    selectable:true,
                    selectHelper: true,
                    selectAllow: function(selectInfo) {
                        var today = moment();
                        var currentHour = moment().hour();
                        var selectedDate = moment(selectInfo.start.format('YYYY-MM-DD'));
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
                            url: '/check-availability',
                            method: 'GET',
                            data: {
                                date: selectedDate
                            },
                            success: function(entries) {
                                //console.log(entries);
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
        <!-- Modal for Appointments Set -->
        <div class="modal modal-dialog-scrollable modal-xl fade" data-bs-backdrop="static" id="patientsappointmentModal" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="modal-title fs-5 fw-bold" id="patientsappointmentModalLabel">BU-Care Appointment <span id="appointmentModal_ticketID"></span></p>
                        <button type="butto" class="btn btn-danger close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row"><!-- MODAL DIV -->
                                <div class="col-lg-12 col-md-12">
                                    <div class="col-sm">
                                        <div class="text-center mt-5">
                                            <span class="text-center fw-bold"> 
                                                Patient Appointments:
                                                <br style="user-select: none;"><br style="user-select: none;">
                                            </span>
                                            <div class="d-flex flex-row">
                                            <?php
                                            $counter = 0;
                                                foreach ($entries as $appointment) {
                                                    // Create DateTime objects
                                                    $counter++;
                                                    $date = new DateTime($appointment->appointmentDate);
                                                    $time = DateTime::createFromFormat('H:i:s', $appointment->appointmentTime);
                        
                                                    // Format date as "Y F d" (e.g. "2023 April 24")
                                                    $formattedDate = $date->format('Y F d');
                                                    // Format time as "g:i A" (e.g. "8:00 AM")
                                                    $formattedTime = $time->format('g:i A');
                                                    
                                                  
                                                    echo '<div class="col-sm-3">';
                                                    echo '<p class="m-0 fw-bold">';
                                                    echo $counter . '.&nbsp;&nbsp;'. $formattedDate . ' @ ' . $formattedTime;
                                                    echo '</p>';
                                                    echo '<p class="m-0">';
                                                    echo 'Ticket# '. $appointment->ticket_id;
                                                    echo '</p>';
                                                    echo '<p class="m-0">';
                                                    echo 'Service: ' . ($appointment->services ?: $appointment->others);
                                                    echo '<br style="user-select: none;">';
                                                    echo 'Description: ' . $appointment->appointmentDescription;
                                                    echo '</p>';
                                                    echo '<hr class="mx-auto " style="width:300px;">';
                                                    echo '</div>';
                                                    
                                                }
                                            ?>
                                            </div>
                                        </div>                      
                                        <div class="row justify-content-end">
                                            <div class="col-4">
                                              <button type="button" class="btn btn-info float-end" onclick='swapmodal();'>set appointments</button>
                                        </div>                                        
                                    </div>
                                    <!-- Modal for Time -->
                                    <div class="modal modal-dialog-scrollable modal-xl fade" data-bs-backdrop="static" id="appointmentModal" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <p class="modal-title fs-5 fw-bold" id="appointmentModalLabel">BU-Care Appointment <span id="appointmentModal_ticketID"></span></p>
                                                    <button type="button" class="btn btn-danger close" data-dismiss="modal" aria-label="Close">
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
                                                                            document.getElementById('saveButton').disabled = false;
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
                                </div>
                            </div>       
                        </div>
                    </div>
                </div>
            </div>
        </div>
             
    </div>

@endsection