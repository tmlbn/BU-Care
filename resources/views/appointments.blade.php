@extends('layouts.app')
@section('content')
<style>
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
            },
            selectable:true,
            selectHelper: true,
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
                    <h5 class="modal-title" id="appointmentModalLabel">BU-Care Appointment Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="row">
                                    <div class="col pb-2">
                                        <button type="button" class="btn btn-primary float-end" onclick="showAM()">AM</button>
                                    </div>
                                    <div class="col pb-2">
                                         <button type="button" class="btn btn-primary float-start" onclick="showPM()">PM</button>
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
                                                echo "<tr class='am'>";
                                                echo "<td><a id='' href='#' onClick='DateForm(\"" . date('g:i A', $start_am) . "\"); return false;' >" . date('g:i A', $start_am) . "</a></td>";
                                                echo "<td>" . date('g:i', $start_am) . " - " . date('g:i A', strtotime('+15 minutes', $start_am)) . "</td>";
                                                echo "</tr>";
                                                $start_am = strtotime('+15 minutes', $start_am);
                                            }

                                            $start_pm = strtotime('1:00 PM');
                                            $end_pm = strtotime('4:45 PM');
                                            while ($start_pm <= $end_pm) {
                                                echo "<tr class='pm' style='display: none'>";
                                                echo "<td><a href='#' onClick='alert(\"You clicked on " . date('g:i A', $start_pm) . "\"); return false;'>" . date('g:i A', $start_pm) . "</a></td>";
                                                echo "<td>" . date('g:i', $start_pm) . " - " . date('g:i A', strtotime('+15 minutes', $start_pm)) . "</td>";
                                                echo "</tr>";
                                                $start_pm = strtotime('+15 minutes', $start_pm);
                                            }
                                        ?>
                                            <script>
                                                function DateForm(time) {
                                                    var appointmentTimeInput = document.getElementById("appointmentTime");
                                                    appointmentTimeInput.value = time;
                                                }


                                                function showAM() {
                                                    document.querySelectorAll("#time-slots tr").forEach(function(e) {
                                                        e.style.display = "none";
                                                    });
                                                    document.querySelectorAll("#time-slots .am").forEach(function(e) {
                                                        e.style.display = "";
                                                    });
                                                }

                                                function showPM() {
                                                    document.querySelectorAll("#time-slots tr").forEach(function(e) {
                                                        e.style.display = "none";
                                                    });
                                                    document.querySelectorAll("#time-slots .pm").forEach(function(e) {
                                                        e.style.display = "";
                                                    });
                                                }
                                            </script>
                                    </tbody>
                                  </table>
                                </div>
                            <div class="col-md">
                                <form>
                                    <div class="mx-auto row row-cols-lg-2 row-cols-md-1">
                                        <div class="col-lg-7 col-md-12 p-2 border-lg-end-0">
                                            <h5>Complaints/Reason for Appointments</h5>
                                            <div class="d-flex flex-row checkboxes">
                                                <div class="col-md-4 p-2">
                                                    <div class="form-check">
                                                        <input type="hidden" value="0" name="FH_cancer">
                                                        <input class="form-check-input" type="checkbox" value="1" name="FH_cancer">
                                                            <label class="form-check-label" for="FH_cancer">
                                                                Headache
                                                            </label>
                                                    </div><!-- END OF CHECKBOX DIV -->
                                                    <div class="form-check">
                                                        <input type="hidden" value="0" name="FH_heartDisease">
                                                        <input class="form-check-input" type="checkbox" value="1" name="FH_heartDisease">
                                                            <label class="form-check-label" for="FH_heartDisease">
                                                                Dizziness
                                                            </label>
                                                    </div><!-- END OF CHECKBOX DIV -->
                                                    <div class="form-check">
                                                        <input type="hidden" value="0" name="FH_Stomachache">
                                                        <input class="form-check-input" type="checkbox" value="1" name="FH_hypertension">
                                                            <label class="form-check-label" for="FH_hypertension">
                                                                Stomachache
                                                            </label>
                                                    </div><!-- END OF CHECKBOX DIV -->
                                                </div>
                                                <div class="col-md-4 p-2">
                                                    <div class="form-check">
                                                        <input type="hidden" value="0" name="FH_cancer">
                                                        <input class="form-check-input" type="checkbox" value="1" name="FH_cancer">
                                                            <label class="form-check-label" for="FH_cancer">
                                                                Headache
                                                            </label>
                                                    </div><!-- END OF CHECKBOX DIV -->
                                                    <div class="form-check">
                                                        <input type="hidden" value="0" name="FH_heartDisease">
                                                        <input class="form-check-input" type="checkbox" value="1" name="FH_heartDisease">
                                                            <label class="form-check-label" for="FH_heartDisease">
                                                                Dizziness
                                                            </label>
                                                    </div><!-- END OF CHECKBOX DIV -->
                                                </div>
                                            </div>
                                            <div class="form-check">
                                                <div class="col-sm" style="margin-left: 8px; margin-top: -7px;">
                                                <input type="hidden" value="0" name="FH_Others">
                                                <input class="form-check-input" type="checkbox" value="1" name="FH_Others">
                                                    <label for="FH_Others" class="form-check-label">
                                                        Others 
                                                        <input type="text" class="form-control" id="appointmentTitle">
                                                    </label>    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="appointmentDate" class="col-form-label">Date:</label>
                                        <input type="text" class="form-control" id="appointmentDate" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="appointmentTime" class="col-form-label">Time:</label>
                                        <input type="text" class="form-control" id="appointmentTime" placeholder="Select Time" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="appointmentDescription" class="col-form-label">Description:</label>
                                        <textarea class="form-control" id="appointmentDescription"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="col-form-label">Password:</label>
                                        <input type="password" class="form-control" id="password">
                                    </div>
                                </form>
                            </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
