@extends('layouts.app')
@section('content')
    <div class="container pt-2">
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
            editable:true,
            header:{
                left:'prev,next today',
                center:'title',
                right:'month,agendaWeek,agendaDay'
            },
            events:'/full-calender',
            selectable:true,
            selectHelper: true,
            select:function(start, end, allDay)
            {
                var modal = $('#appointmentModal');
                $('body').append(modal);
                modal.modal('show');

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
                                                echo "<td><a id='' href='#' onClick='alert(\"You clicked on " . date('g:i A', $start_am) . "\"); return false; DateForm;' >" . date('g:i A', $start_am) . "</a></td>";
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
                                                function DateForm() {
                                                    var appointmentDateInput = document.getElementIdBy("appointmentDate");

                                                    appointmentDateInput.value = ('g:i A', strtotime('+15 minutes', $start_pm));
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
                                    <div class="form-group">
                                        <label for="appointmentTitle" class="col-form-label">Appointment Reason:</label>
                                        <input type="text" class="form-control" id="appointmentTitle">
                                    </div>
                                    <div class="form-group">
                                        <label for="appointmentDate" class="col-form-label">Date:</label>
                                        <input type="text" class="form-control" id="appointmentDate" onclick="alert('You clicked on <?php echo date('g:i A', $start_am); ?>');">
                                    </div>
                                    <div class="form-group">
                                        <label for="appointmentTime" class="col-form-label">Time:</label>
                                        <input type="text" class="form-control" id="appointmentTime">
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
