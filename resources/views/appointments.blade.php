@extends('layouts.app')
@section('content')
<style>
    table{
        border-collapse: collapse;
        border-color: black;
    }
    .am.selected, .pm.selected, .selected{
        background-color: #009edf;
        font-weight: bold;
        color:white;
        border: black 2px solid;
    }
    tr.am:hover, tr.pm:hover{
        cursor: pointer;
        background-color:#009edf;
        transition-duration: 0.4s;
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
    
</style>
    <div class="container pt-3">
      <div class="" id="calendar"></div>
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
            events:'/full-calender',
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
                // Only allow dates in the future
                return selectInfo.start.isSameOrAfter(today);
            },
            selectConstraint: {
                start: '00:00', // Start at midnight
                end: '24:00', // End at midnight the next day
                dow: [1,2,3,4,5] // Monday to Friday only
            },
            
            select:function(start, end, allDay)
            {
                var modal = $('#appointmentModal');
                $('body').append(modal);
                modal.modal('show');

                // set the appointmentDate input value to the selected date
                var selectedDate = moment(start).format('YYYY-MMMM-DD');
                $('#appointmentDate').val(selectedDate);

                $('#appointmentModal .close').on('click', function() {
                    $('#appointmentModal').modal('hide');
                });
            },
            editable:true,
            eventResize: function(event, delta)
            {
                var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
                var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
                var title = event.title;
                var id = event.id;
                $.ajax({
                    url:"/full-calender/action",
                    type:"POST",
                    data:{
                        title: title,
                        start: start,
                        end: end,
                        id: id,
                        type: 'update'
                    },
                    success:function(response)
                    {
                        calendar.fullCalendar('refetchEvents');
                        alert("Event Updated Successfully");
                    }
                })
            },
            eventDrop: function(event, delta)
            {
                var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
                var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
                var title = event.title;
                var id = event.id;
                $.ajax({
                    url:"/full-calender/action",
                    type:"POST",
                    data:{
                        title: title,
                        start: start,
                        end: end,
                        id: id,
                        type: 'update'
                    },
                    success:function(response)
                    {
                        calendar.fullCalendar('refetchEvents');
                        alert("Event Updated Successfully");
                    }
                })
            },
    
            eventClick:function(event)
            {
                if(confirm("Are you sure you want to remove it?"))
                {
                    var id = event.id;
                    $.ajax({
                        url:"/full-calender/action",
                        type:"POST",
                        data:{
                            id:id,
                            type:"delete"
                        },
                        success:function(response)
                        {
                            calendar.fullCalendar('refetchEvents');
                            alert("Event Deleted Successfully");
                        }
                    })
                }
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
                                        <button type="button" class="btn btn-primary float-lg-end float-md-start" id="ambtn" onclick="showAM()" disabled>AM</button>
                                    </div>
                                    <div class="col-lg-6 col-md-3 pb-2">
                                         <button type="button" class="btn btn-primary float-lg-start float-md-end" id="pmbtn" onclick="showPM()">PM</button>
                                    </div>
                                  </div>
                                  <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Time</th>
                                            <th>Slot</th>
                                        </tr>
                                    </thead>
                                    <tbody id="time-slots">
                                        <?php
                                            $start_am = strtotime('8:00 AM');
                                            $end_am = strtotime('11:45 AM');
                                            while ($start_am <= $end_am) {
                                                $time = date('g:i A', $start_am);
                                                echo "<tr class='am t-time' data-time='$time' onClick='handleTimeClick(this);'>";
                                                echo "<td>$time</td>";
                                                echo "<td>" .date('g:i', $start_am) . " - " . date('g:i A', strtotime('+15 minutes', $start_am)) . "</td>";
                                                echo "</tr>";
                                                $start_am = strtotime('+15 minutes', $start_am);
                                            }

                                            $start_pm = strtotime('1:00 PM');
                                            $end_pm = strtotime('4:45 PM');
                                            while ($start_pm <= $end_pm) {
                                                $time = date('g:i A', $start_pm);
                                                echo "<tr class='pm t-time' data-time='$time' onClick='handleTimeClick(this);' style='display:none;'>";
                                                echo "<td>$time</td>";
                                                echo "<td>" .date('g:i', $start_pm) . " - " . date('g:i A', strtotime('+15 minutes', $start_pm)) . "</td>";
                                                echo "</tr>";
                                                $start_pm = strtotime('+15 minutes', $start_pm);
                                            }
                                        ?>
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
                                    </tbody>
                                  </table>
                                </div>

                            <!-- APPOINTMENT DETAILS -->
                            <div class="col-lg-9 col-md-12">
                                <form>
                                    <div class="mx-auto row row-cols-lg-2 row-cols-md-1">
                                    </div>
                                    <div class="row row-cols-lg-2 row-cols-md-1"><!-- DATE/TIME DIV -->
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label for="appointmentDate" class="col-form-label fw-bolder">Date:</label>
                                            <input type="text" class="form-control fw-bold" id="appointmentDate" readonly>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-12">
                                            <label for="appointmentTime" class="col-form-label fw-bolder">Time:</label>
                                            <input type="text" class="form-control fw-bold" id="appointmentTime" placeholder="Select Time" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 p-2 border-lg-end-0">
                                        <h5>Complaints/Reason for Appointments</h5>
                                        <div class="row row-cols-lg-2 row-cols-md-1 checkboxes">
                                            <div class="col-lg-6 col-md-12 p-2">
                                                <div class="form-check">
                                                    <input type="hidden" value="0" name="FH_Headache">
                                                    <input class="form-check-input" type="checkbox" value="1" name="FH_cancer">
                                                        <label class="form-check-label" for="FH_Headache">
                                                            Headache
                                                        </label>
                                                </div><!-- END OF CHECKBOX DIV -->
                                                <div class="form-check">
                                                    <input type="hidden" value="0" name="FH_Dizziness">
                                                    <input class="form-check-input" type="checkbox" value="1" name="FH_heartDisease">
                                                        <label class="form-check-label" for="FH_Dizziness">
                                                            Dizziness
                                                        </label>
                                                </div><!-- END OF CHECKBOX DIV -->
                                                <div class="form-check">
                                                    <input type="hidden" value="0" name="FH_Stomachache">
                                                    <input class="form-check-input" type="checkbox" value="1" name="FH_hypertension">
                                                        <label class="form-check-label" for="FH_Stomachache">
                                                            Stomachache
                                                        </label>
                                                </div><!-- END OF CHECKBOX DIV -->
                                            </div>
                                            <div class="col-lg-6 col-md-12 p-2">
                                                <div class="form-check">
                                                    <input type="hidden" value="0" name="FH_Nausea">
                                                    <input class="form-check-input" type="checkbox" value="1" name="FH_cancer">
                                                        <label class="form-check-label" for="FH_Nausea">
                                                            Nausea
                                                        </label>
                                                </div><!-- END OF CHECKBOX DIV -->
                                                <div class="form-check">
                                                    <input type="hidden" value="0" name="FH_Consiousness">
                                                    <input class="form-check-input" type="checkbox" value="1" name="FH_heartDisease">
                                                        <label class="form-check-label" for="FH_Consiousness">
                                                            Loss of Consiousness
                                                        </label>
                                                </div><!-- END OF CHECKBOX DIV -->
                                                <div class="form-check">
                                                    <input type="hidden" value="0" name="FH_Consiousness">
                                                    <input class="form-check-input" type="checkbox" value="1" name="FH_heartDisease">
                                                        <label class="form-check-label" for="FH_Consiousness">
                                                            Medical Certificate
                                                        </label>
                                                </div><!-- END OF CHECKBOX DIV -->
                                            </div>
                                        </div>
                                        <div class="form-check">
                                            <input type="hidden" value="0" name="FH_Others">
                                                <label for="FH_Others" class="form-check-label">
                                                    Others 
                                                    <input type="text" class="form-control" id="appointmentTitle">
                                                </label>
                                            </div>
                                        </div>
                                    <div class="form-group">
                                        <label for="appointmentDescription" class="col-form-label">Description:</label>
                                        <textarea class="form-control" id="appointmentDescription" style="resize: none; overflow: hidden;"></textarea>
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
                                                <input type="password" class="form-control" id="passwordInput" name="passwordInput" required>
                                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                <span class="bi bi-eye-fill" aria-hidden="true"></span>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="d-flex">
                                            <button type="button" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
