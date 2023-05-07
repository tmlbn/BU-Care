@extends(Auth::check() ? 'layouts.app' : (Auth::guard('employee')->check() ? 'personnel.layouts.app' : 'layouts.appForUnAuth'))
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
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="container-flui  d pt-3">
        <div class="d-flex row-flex">
            <div class="col-sm text-center mt-5">
                <span class="text-center fw-bold" style="user-select: none;"> 
                    Legend:
                </span>
                <span class="text-center my-3 fw-light legend-pill available">
                    <!-- Green - Yellow - Red -->
                    Available Slots
                </span>
                <span class="text-center my-3 fw-light legend-box" style="background-color: #f0f0be;">
                    <!-- Yellow -->
                    Today
                </span>
                <span class="text-center my-3 fw-light legend-box" style="background-color: rgb(230, 230, 230);">
                    <!-- RED -->
                    Past
                </span>
                <span class="text-center my-3 fw-light legend-box" style="background-color: #cf908f;">
                    <!-- RED -->
                    Weekend
                </span>
            </div>
            <div class="align-items-center justify-content-center col-6 mb-5" style="width:55%; padding-right: 0; padding-left: 0;" id="calendar">
                <!-- CALENDAR HERE -->
            </div>
            <div class="col-sm">
                <div class="text-center mt-5">
                    <span class="text-center fw-bold"> 
                        My Appointments:
                        <br style="user-select: none;"><br style="user-select: none;">
                    </span>
                    <?php
                    $counter = 0;
                        foreach ($myAppointments as $appointment) {
                            // Create DateTime objects
                            $counter++;
                            $date = new DateTime($appointment->appointmentDate);
                            $time = DateTime::createFromFormat('H:i:s', $appointment->appointmentTime);

                            // Format date as "Y F d" (e.g. "2023 April 24")
                            $formattedDate = $date->format('Y F d');
                            // Format time as "g:i A" (e.g. "8:00 AM")
                            $formattedTime = $time->format('g:i A');

                            echo '<p class="m-0 fw-bold">';
                            echo $counter . '.&nbsp;&nbsp;'. $formattedDate . ' @ ' . $formattedTime;
                            echo '</p>';
                            echo '<p class="m-0">';
                            echo 'Ticket# '. $appointment->ticket_id;
                            echo '</p>';
                            echo '<p class="m-0">';
                            if(Auth::user()){
                                echo 'PATIENT: '. $appointment->usersStudent->first_name.' '.$appointment->usersStudent->middle_name.' '.$appointment->usersStudent->last_name;
                            }
                            elseif(Auth::guard('employee')->user()){
                                echo 'PATIENT: '. $appointment->usersPersonnel->first_name.' '.$appointment->usersPersonnel->middle_name.' '.$appointment->usersPersonnel->last_name;
                            }
                            echo '</p>';
                            echo '<p class="m-0">';
                            echo 'Service: ' . ($appointment->services ?: $appointment->others);
                            echo '<br style="user-select: none;">';
                            if($appointment->appointmentDescription){
                                echo 'Description: ' . $appointment->appointmentDescription;
                            }
                            echo '</p>';
                            echo '<hr class="mx-auto " style="width:300px;">';
                        }
                    ?>
                </div>
                @if($counter)
                    <div class="row justify-content-between">
                        <div class="col-4">
                            <button type="button" class="btn btn-info float-end" data-bs-toggle="modal" data-bs-target="#editAppointmentModal">Edit</button>
                        </div>
                        <div class="col-4">
                            <button type="button" class="btn btn-danger float-start" data-bs-toggle="modal" data-bs-target="#deleteAppointmentModal">Delete</button>
                        </div>
                    </div>
                @endif

                <!-- GET APPOINTMENT TO EDIT MODAL -->
                <div class="modal fade" id="editAppointmentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editAppointmentModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editAppointmentModalLabel">Edit Appointment Reservation</h5>
                                <button type="button" class="btn-close close" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php
                                    $counter = 0;
                                    foreach ($myAppointments as $appointment) {
                                        // Create DateTime objects
                                        $counter++;
                                        $date = new DateTime($appointment->appointmentDate);
                                        $time = DateTime::createFromFormat('H:i:s', $appointment->appointmentTime);

                                        // Format date as "Y F d" (e.g. "2023 April 24")
                                        $formattedDate = $date->format('Y F d');
                                        // Format time as "g:i A" (e.g. "8:00 AM")
                                        $formattedTime = $time->format('g:i A');

                                        echo '<p class="m-0 fw-bold text-center">';
                                        echo $counter . '.&nbsp;&nbsp;'. $formattedDate . ' @ ' . $formattedTime;
                                        echo '</p>';
                                        echo '<p class="m-0 text-center" onclick="copyTicket(this);">';
                                        echo 'Ticket# <u class="hoverTicket" id="ticketToEdit'.$counter.'">'. $appointment->ticket_id;
                                        echo '</u></p>';
                                        echo '<p class="m-0 text-center">';
                                        echo 'Service: ' . ($appointment->services ?: $appointment->others);
                                        echo '<br style="user-select: none;">';
                                        echo 'Description: ' . $appointment->appointmentDescription;
                                        echo '</p>';
                                        echo '<hr class="mx-auto" style="width:300px;">';
                                    }
                                ?>
                                <p class="text-center">
                                    Which Appointment Reservation would you like to edit?
                                </p>
                                    <div class="d-flex my-auto mx-autop">
                                        <label for="ticketInputEdit" class="form-label h6 mt-2 me-2">Ticket#</label>
                                        <input type="text" class="form-control" id="ticketInputEdit" name="ticketInputEdit" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="align-items-center">
                                        <span class="text-center text-danger" id="invalidTicket"></span>
                                    </div>
                                    <button type="submit" id="editButton" class="btn btn-info">Edit</button>
                                <!-- AJAX request to fetch the entry that the user wants to edit -->
                                    <script>
                                        $(document).ready(function() {
                                            $.ajaxSetup({
                                                headers:{
                                                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                                                }
                                            });
                                            $('#editButton').on('click', function(event) {
                                                $('#invalidTicket').text('');
                                                var ticketID = $('#ticketInputEdit').val();
                                                if (ticketID == ""){
                                                    $('#invalidTicket').text('Please input your ticket number!');
                                                    return false;
                                                }
                                                //console.log(ticketID);
                                                $.ajax({
                                                    url: '/get-appointment/update',
                                                    method: 'GET',
                                                     dataType: 'json',
                                                     data: {
                                                        ticketID: ticketID
                                                    },
                                                    success: function(response) {
                                                        if(response.fail){
                                                            $('#invalidTicket').text('Appointment #'+ ticketID +' not found!');
                                                        }
                                                        else{
                                                            var appointment = response.appointment;
                                                            var appointmentsForTheDay = response.appointmentsForTheDay;
                                                            $('#editAppointmentModal').modal('hide');
                                                            $('#appointmentModal_ticketID').text('#'+ ticketID);

                                                            var AformattedDate = moment(appointment.appointmentDate).format('YYYY-MMMM-DD');
                                                            var AformattedTime = moment(appointment.appointmentTime, 'HH:mm:ss').format('h:mm A');
                                                            var afternoonThreshold = moment('13:00:00','HH:mm:ss').format('h:mm A');
                                                            console.log(afternoonThreshold);
                                                            $('#appointmentDate').val(AformattedDate);

                                                            $('#time-slots tr').removeClass('booked lastOne selected');
                                                            $('#time-slots tr #timeSlot, #time-slots tr #numberOfSlots').removeClass('pointer-events-none');
                                                            $('#time-slots tr #numberOfSlots').text('2');
                                                            $('#appointmentTime').val(AformattedTime);

                                                            if (AformattedTime >= afternoonThreshold) {
                                                                $('#pmbtn').trigger('click');
                                                            }
                                                            //loop through the data
                                                            $.each(appointmentsForTheDay, function(index, appointment) {
                                                                //console.log(appointment.appointmentTime);
                                                                //get the time of appointments
                                                                console.log(AformattedTime);
                                                                //console.log(appt_time);
                                                                //loop through each table cell and check if it matches the appointment date and time
                                                                $('#time-slots tr').each(function() {
                                                                    var cell_time = $(this).find('#timeSlot').text();
                                                                    //console.log(cell_time);
                                                                    if (AformattedTime == cell_time) {
                                                                    //if there is a match, add a class to the table cell that corresponds to the appointment status
                                                                        if (appointment.booked_slots == 2) {
                                                                            $(this).addClass('booked');
                                                                            $(this).find('#timeSlot').addClass('pointer-events-none');
                                                                            $(this).find('#numberOfSlots').addClass('pointer-events-none').text('FULL');
                                                                        } else if (appointment.booked_slots == 1) {
                                                                            $(this).addClass('lastOne');
                                                                            $(this).find('#numberOfSlots').text('1 (you)');
                                                                        }
                                                                    }
                                                                });
                                                            });

                                                            $('tr[data-time="'+AformattedTime+'"]').addClass('selected');
                                                            $('#saveButton').prop('hidden', true);
                                                            $('#editButtonSubmit').prop('hidden', false);
                                                            
                                                            var modal = $('#appointmentModal');
                                                            $('body').append(modal);
                                                            modal.modal('show');
                                                            // Close modal
                                                            $('#appointmentModal .close').on('click', function() {
                                                                $('#appointmentModal').modal('hide');
                                                            });
                                                        }
                                                    },
                                                });
                                            });
                                            $(document).ready(function() {
                                                $('#editAppointmentModal .close').on('click', function() {
                                                    $('#editAppointmentModal').modal('hide');
                                                    $('#invalidTicket').text('');
                                                    $('#ticketInputEdit').val('');
                                                });
                                            });
                                        });
                                    </script>
                            </div>
                        </div>
                    </div>
                </div>

                
                <!-- Delete Modal -->
                <div class="modal modal-lg fade" id="deleteAppointmentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteAppointmentModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteAppointmentModalLabel">Delete Appointment Reservation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php
                                    $counter = 0;
                                    foreach ($myAppointments as $appointment) {
                                        // Create DateTime objects
                                        $counter++;
                                        $date = new DateTime($appointment->appointmentDate);
                                        $time = DateTime::createFromFormat('H:i:s', $appointment->appointmentTime);

                                        // Format date as "Y F d" (e.g. "2023 April 24")
                                        $formattedDate = $date->format('Y F d');
                                        // Format time as "g:i A" (e.g. "8:00 AM")
                                        $formattedTime = $time->format('g:i A');

                                        echo '<p class="m-0 fw-bold text-center">';
                                        echo $counter . '.&nbsp;&nbsp;'. $formattedDate . ' @ ' . $formattedTime;
                                        echo '</p>';
                                        echo '<p class="m-0 text-center" onclick="copyTicketToDelete(this);">';
                                        echo 'Ticket# <u class="hoverTicket" id="ticketToDelete'.$counter.'">'. $appointment->ticket_id;
                                        echo '</u></p>';
                                        echo '<p class="m-0 text-center">';
                                        echo 'Service: ' . ($appointment->services ?: $appointment->others);
                                        echo '<br style="user-select: none;">';
                                        echo 'Description: ' . $appointment->appointmentDescription;
                                        echo '</p>';
                                        echo '<hr class="mx-auto" style="width:300px;">';
                                    }
                                ?>
                                <p class="text-center">
                                    Which Appointment Reservation would you like to delete?
                                </p>
                            <form method="post" id="appointmentDelete" action="{{ route('appointment.destroy') }}">
                                @csrf
                                @method('DELETE')
                                    <div class="d-flex my-auto mx-autop">
                                        <label for="ticketInputDelete" class="form-label h6 mt-2 me-2">Ticket#</label>
                                        <input type="text" class="form-control" id="ticketInputDelete" name="ticketInputDelete" required>
                                    </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="d-flex my-auto">
                                            @php
                                                if (Auth::user()){
                                                    $student = Auth::user()->student_id_number;
                                                }
                                                else{
                                                    $student = 0;
                                                }
                                            @endphp
                                            @if($student || Auth::guard('employee')->user())
                                            <div class="input-group">
                                                    <label for="passwordInputDelete" class="form-label h6 mt-2 me-2">Password:</label>
                                                    <input type="password" class="form-control" id="passwordInputDelete" name="passwordInputDelete">
                                                    <button class="btn btn-outline-secondary" type="button" id="togglePasswordDelete">
                                                        <div style="margin-top: -5px;">
                                                            <span class="bi bi-eye-fill" aria-hidden="true"></span>
                                                        </div>
                                                    </button>
                                                    <script>
                                                        const passwordInputDelete = document.getElementById('passwordInputDelete');
                                                        const togglePasswordDelete = document.getElementById('togglePasswordDelete');
                                                        togglePasswordDelete.addEventListener('click', function() {
                                                            const type = passwordInputDelete.getAttribute('type') === 'password' ? 'text' : 'password';
                                                            passwordInputDelete.setAttribute('type', type);
                                                            togglePasswordDelete.querySelector('span').classList.toggle('bi-eye-fill');
                                                            togglePasswordDelete.querySelector('span').classList.toggle('bi-eye-slash-fill');
                                                            togglePasswordDelete.classList.toggle('active');
                                                        });
                                                    </script>
                                                @else
                                                <div class="row row-cols-lg-4 row-cols-md-2 row-cols-sm-1">
                                                    <div class="col-lg-4">
                                                        <label for="applicantIDinputDelete" class="form-label h6 mt-2 me-2">Applicant ID Number:</label>
                                                        <input type="text" class="form-control" id="applicantIDinputDelete" name="applicantIDinputDelete">
                                                        <span class="text-danger" id="applicantIDSpan"> 
                                                            @error('applicantIDinputDelete') 
                                                            {{ $message }} 
                                                            @enderror
                                                        </span>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <label for="applicantBirthYearDelete" class="form-label h6 mt-2 me-2">Birth Year:</label>
                                                        <input type="text" class="form-control" id="applicantBirthYearDelete" name="applicantBirthYearDelete">
                                                        <span class="text-danger" id="birthYearSpan"> 
                                                            @error('applicantBirthYearDelete') 
                                                            {{ $message }} 
                                                            @enderror
                                                        </span>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <label for="applicantBirthMonthDelete" class="form-label h6 mt-2 me-2">Birth Month:</label>
                                                        <select class="form-control" name ="applicantBirthMonthDelete" id="applicantBirthMonthDelete" placeholder="Birth Month" autofocus style="height:38px; margin-top: 1px">
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
                                                            @error('applicantBirthMonthDelete') 
                                                            {{ $message }} 
                                                            @enderror
                                                        </span>
                                                    </div>  
                                                    <div class="col-lg-2">
                                                        <label for="applicantBirthDateDelete" class="form-label h6 mt-2 me-2">Birth Date:</label>
                                                        <input type="text" class="form-control" id="applicantBirthDateDelete" name="applicantBirthDateDelete">
                                                        <span class="text-danger" id="birthDateSpan"> 
                                                            @error('applicantBirthDateDelete') 
                                                            {{ $message }} 
                                                            @enderror
                                                        </span>
                                                    </div>  
                                                @endif
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </div>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                        if(/*date.format('YYYY-MM-DD') <=*/ (moment(currentLoopedAppointmentDate).format('YYYY-MM-DD')) && !(date.isoWeekday() === 6 || date.isoWeekday() === 7)){
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
                    $('#appointmentModal_ticketID').text('');
                    $('#saveButton').prop('hidden', false);
                    $('#saveButton').attr('disabled', true);
                    $('#editButtonSubmit').prop('hidden', true);
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
    <!-- Modal for Time -->
    <div class="modal modal-dialog-scrollable modal-xl fade" data-bs-backdrop="static" id="appointmentModal" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title fs-5 fw-bold" id="appointmentModalLabel">BU-Care Appointment <span id="appointmentModal_ticketID"></span></p>
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
                                        
                                        // Get the text inside the clicked u element
                                        function copyTicket(element) {
                                            var ticketID = $(element).find('u').text().trim();
                                            $('#ticketInputEdit').val(ticketID);
                                            //console.log(ticketID);
                                        }
                                        function copyTicketToDelete(element){
                                            var ticketID = $(element).find('u').text().trim();
                                            $('#ticketInputDelete').val(ticketID);
                                            //console.log(ticketID);
                                        }
                                    </script>
                                  </table>
                                </div>

                            <!-- APPOINTMENT DETAILS -->
                            <div class="col-lg-9 col-md-12" id="services">
                                <form method="post" id="appointmentForm" action="{{ route('appointmentDetails.store') }}">
                                    @csrf
                                    <div class="mx-auto row row-cols-lg-2 row-cols-md-1">
                                    </div>
                                    <input type="hidden" name="patientID" value={{ Auth::check() ? Auth::user()->id : Auth::guard('employee')->user()->id }}>
                                    <input type="hidden" name="patientType" value={{ Auth::check() ? Auth::user()->user_type : Auth::guard('employee')->user()->user_type }}>
                                    <div class="row row-cols-lg-2 row-cols-md-1"><!-- DATE/TIME DIV -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label for="appointmentDate" class="col-form-label fw-bolder">Date<span class="text-danger">*</span>:</label>
                                            <input type="text" class="form-control fw-bold" name="appointmentDate" id="appointmentDate" required readonly>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label for="appointmentTime" class="col-form-label fw-bolder">Time<span class="text-danger">*</span>:</label>
                                            <input type="text" class="form-control fw-bold" name="appointmentTime" id="appointmentTime" placeholder="Select Time" required readonly>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 p-2 border-lg-end-0">
                                        <h5>Service to Avail</h5>
                                        <div class="row row-cols-lg-2 row-cols-md-1 checkboxes">
                                            <div class="col-lg-6 col-md-12 p-2">
                                                <div class="form-group col-lg-6 col-md-12">
                                                    <select id="servicesAvail" name="servicesAvail" class="form-select" required>
                                                        <option value="" selected disabled>SELECT</option>
                                                        <option value="medcert">Medical Certificate</option>
                                                        <option value="opd">OPD Consultant</option>
                                                        <option value="others">Others</option>
                                                        @if(Auth::guard('employee')->check())
                                                        <option value="reinstatement">Reinstatement</option>
                                                        <option value="sickleave">Sick Leave</option>
                                                        <option value="newlyhired">Newly Hired</option>
                                                        @endif
                                                    </select>
                                                </div><!-- END OF DIV -->

                                                <div class="col-lg-6 col-md-12 p-2" id="ojt">
                                                    <div class="col-lg-40 col-md-12 p-2" id="textbox-container" style="display:none">
                                                            <label class="form-check-label" for="others">
                                                                Other Reason 
                                                            </label>
                                                            <div class="form-check" id="otherInput">
                                                                <label for="othersInput" class="form-check-label">
                                                                    <input type ="text" class="form-control" name="othersInput" id="othersInput" style="width: 350px;">
                                                                </label>
                                                            </div>       
                                                    </div><!-- END OF CHECKBOX DIV -->
                                                </div>                                                                                                                           
                                                <script>
                                                    var firstMenu = document.getElementById("patientType");
                                                    var secondMenu = document.getElementById("servicesAvail");
                                                    var textboxContainer = document.getElementById("textbox-container");

                                                    secondMenu.addEventListener("change", function() {
                                                        if (secondMenu.value === "others") {
                                                        textboxContainer.style.display = ""; // show the textbox container
                                                        } else {
                                                        textboxContainer.style.display = "none"; // hide the textbox container
                                                        }
                                                    });                                                  
                                            </script>
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
                                        <div class="d-flex my-auto">
                                            @php
                                                if (Auth::user()){
                                                    $student = Auth::user()->student_id_number;
                                                }
                                                else{
                                                    $student = 0;
                                                }
                                            @endphp
                                            @if($student || Auth::guard('employee')->user())
                                            <div class="input-group">
                                                <label for="passwordInput" class="form-label h6 mt-2 me-2">Password:</label>
                                                <input type="password" class="form-control" id="passwordInput" name="passwordInput">
                                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                    <div style="margin-top: -5px;">
                                                        <span class="bi bi-eye-fill" aria-hidden="true"></span>
                                                    </div>
                                                </button>
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
                                            </div>
                                            @else
                                            <div class="row row-cols-lg-5 row-cols-md-2 row-cols-sm-1">
                                                <div class="col-lg-4">
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
                                                    <input type="text" class="form-control" id="applicantBirthYear" name="applicantBirthYear" maxlength="4" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                                                    <span class="text-danger" id="birthYearSpan"> 
                                                        @error('applicantBirthYear') 
                                                        {{ $message }} 
                                                        @enderror
                                                    </span>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label for="applicantBirthMonth" class="form-label h6 mt-2 me-2">Birth Month:</label>
                                                    <select class="form-control" name ="applicantBirthMonth" id="applicantBirthMonth" placeholder="Birth Month" autofocus style="height:38px; margin-top: 1px" required>
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
                                                    <input type="text" class="form-control" id="applicantBirthDate" name="applicantBirthDate"maxlength="2" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required>
                                                    <span class="text-danger" id="birthDateSpan"> 
                                                        @error('applicantBirthDate') 
                                                        {{ $message }} 
                                                        @enderror
                                                    </span>
                                                </div>  
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-2 mt-auto">
                                                <button type="submit" id="saveButton" class="btn btn-primary" disabled>Save</button>
                                                <button type="submit" id="editButtonSubmit" class="btn btn-info" hidden>Update</button>
                                            </div>
                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                $.ajaxSetup({
                                                    headers:{
                                                        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                                                    }
                                                });
                                                $('#editButtonSubmit').on('click', function(event) {
                                                    event.preventDefault(); // prevent default form submission behavior
                                                    var student = "<?php echo $student;?>";

                                                    if(student){
                                                        let patientID = $('#patientID').val();
                                                        let patientType = $('#patientType').val();
                                                        let appointmentDate = $('#appointmentDate').val();
                                                        let appointmentTime = $('#appointmentTime').val();
                                                        let appointmentDescription = $('#appointmentDescription').val();
                                                        let services = $('input[name="services"]:checked').val();
                                                        let othersInput = $('#othersInput').val();
                                                        let password = $('#passwordInput').val();
                                                        let ticketID = $('#ticketInputEdit').val();
                                                        
                                                        $.ajax({
                                                            url: '/update-appointment/'+ticketID+'/edit',
                                                            method: 'POST',
                                                            dataType: 'json',
                                                            data: {
                                                                '_method': 'PATCH',
                                                                patientID: patientID,
                                                                patientType: patientType,
                                                                appointmentDate: appointmentDate,
                                                                appointmentTime: appointmentTime,
                                                                appointmentDescription: appointmentDescription,
                                                                services: services,
                                                                othersInput: othersInput,
                                                                password: password,
                                                                ticketID: ticketID
                                                            },
                                                            success: function(response) {
                                                                //console.log(othersInput);
                                                                $('#appointmentModal').modal('hide');

                                                                $('#successDateTime').text(appointmentDate+' @ '+appointmentTime);
                                                                $('#successTicketID').text('Ticket# '+ticketID);
                                                                if(!services){
                                                                    $('#successService').text('Service: '+othersInput);
                                                                }
                                                                else{
                                                                    $('#successService').text('Service: '+services);
                                                                }
                                                                $('#successDescription').text('Description: '+appointmentDescription);

                                                                var modal = $('#editSuccessModal');
                                                                $('body').append(modal);
                                                                modal.modal('show');
                                                                // Close modal
                                                                $('#editSuccessModal .close').on('click', function() {
                                                                    $('#editSuccessModal').modal('hide');
                                                                    $("#appointmentForm")[0].reset();
                                                                    location.reload();
                                                                });
                                                                
                                                            },
                                                            error: function(jqXHR, textStatus, errorThrown) {
                                                                console.log('AJAX error: ' + textStatus + ' - ' + errorThrown);
                                                                // handle error
                                                            }
                                                        });
                                                    }
                                                    else{
                                                        let patientID = $('#patientID').val();
                                                        let patientType = $('#patientType').val();
                                                        let appointmentDate = $('#appointmentDate').val();
                                                        let appointmentTime = $('#appointmentTime').val();
                                                        let appointmentDescription = $('#appointmentDescription').val();
                                                        let services = $('input[name="services"]:checked').val();
                                                        let othersInput = $('#othersInput').val();
                                                        let applicantIDinput = $('#applicantIDinput').val();
                                                        let applicantBirthYear = $('#applicantBirthYear').val();
                                                        let applicantBirthMonth = $('#applicantBirthMonth').val();
                                                        let applicantBirthDate = $('#applicantBirthDate').val();
                                                        let ticketID = $('#ticketInputEdit').val();
                                                        
                                                        $.ajax({
                                                            url: '/update-appointment/'+ticketID+'/edit',
                                                            method: 'POST',
                                                            dataType: 'json',
                                                            data: {
                                                                '_method': 'PATCH',
                                                                patientID: patientID,
                                                                patientType: patientType,
                                                                appointmentDate: appointmentDate,
                                                                appointmentTime: appointmentTime,
                                                                appointmentDescription: appointmentDescription,
                                                                services: services,
                                                                othersInput: othersInput,
                                                                applicantIDinput: applicantIDinput,
                                                                applicantBirthYear: applicantBirthYear,
                                                                applicantBirthMonth: applicantBirthMonth,
                                                                applicantBirthDate: applicantBirthDate,
                                                                ticketID: ticketID
                                                            },
                                                            success: function(response) {
                                                                //console.log(othersInput);
                                                                $('#appointmentModal').modal('hide');

                                                                $('#successDateTime').text(appointmentDate+' @ '+appointmentTime);
                                                                $('#successTicketID').text('Ticket# '+ticketID);
                                                                if(!services){
                                                                    $('#successService').text('Service: '+othersInput);
                                                                }
                                                                else{
                                                                    $('#successService').text('Service: '+services);
                                                                }
                                                                $('#successDescription').text('Description: '+appointmentDescription);

                                                                var modal = $('#editSuccessModal');
                                                                $('body').append(modal);
                                                                modal.modal('show');
                                                                // Close modal
                                                                $('#editSuccessModal .close').on('click', function() {
                                                                    $('#editSuccessModal').modal('hide');
                                                                    $("#appointmentForm")[0].reset();
                                                                    location.reload();
                                                                });
                                                                
                                                            },
                                                            error: function(jqXHR, textStatus, errorThrown) {
                                                                console.log('AJAX error: ' + textStatus + ' - ' + errorThrown);
                                                                // handle error
                                                            }
                                                        });
                                                    }
                                                });
                                            });
                                        </script>
                                        <!-- Edit Success Modal -->
                                        <div class="modal fade" id="editSuccessModal" tabindex="-1" aria-labelledby="editSuccessModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editSuccessModalLabel">Appointment successfully updated!</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="m-0 fw-bold text-center" id="successDateTime">
                                                        </p>
                                                        <p class="m-0 text-center" id="successTicketID">
                                                        </p>
                                                        <p class="m-0 text-center" id="successService">
                                                        </p>
                                                        <p class="m-0 text-center" id="successDescription">
                                                        </p>
                                                        <hr class="mx-auto" style="width:300px;">
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-success close">Okay!</button>
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
            </div>
        </div>
    </div>
</form>
@endsection
