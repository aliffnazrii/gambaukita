@extends('layout.owner')

@section('title', 'Schedule Management')

@section('style')
    <style>
        .card {
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .card h3 {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 15px;
        }

        .form-group label {
            font-size: 1rem;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .table {
            margin-top: 20px;
        }

        .table th,
        .table td {
            padding: 12px;
            vertical-align: middle;
        }

        .table th {
            background-color: #f8f9fa;
            color: #495057;
        }

        #calendar {
            max-width: 100%;
            margin: 0 auto;
            overflow: hidden;
        }

        .fc-toolbar-title {
            white-space: nowrap;
            /* Prevent overlapping or duplicated titles */
        }

        .fc .fc-daygrid-event {
            overflow: hidden;
            /* Prevent overflow of event names */
            white-space: nowrap;
            text-overflow: ellipsis;
            /* Truncate long event titles */
        }
    </style>

@endsection

@section('content')

    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.8/index.global.min.js"></script>

    <!-- Local Bootstrap CSS -->
    <link href="../..assets/bootstrap.min.css" rel="stylesheet">

    <!-- Local Bootstrap DateTimePicker CSS -->
    <link href="../..assets/bootstrap-datetimepicker.min.css" rel="stylesheet">

    <!-- Local jQuery -->
    <script src="../..assets/jquery.min.js"></script>

    <!-- Local Bootstrap JS -->
    <script src="../..assets/bootstrap.min.js"></script>

    <!-- Local Moment.js -->
    <script src="../..assets/moment.min.js"></script>

    <!-- Local Bootstrap DateTimePicker JS -->
    <script src="../..assets/bootstrap-datetimepicker.min.js"></script>

    <!-- Main Content -->
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <div class="card my-auto">
                    <div class="card-body my-auto">
                        <div class="card-title">
                            <h1>Schedule Calendar</h1>
                        </div>
                        <div class="row justify-content-center my-auto">

                            <div class="col-md-12">
                                <div class="card-box m-b-50">
                                    <div id="calendar"></div>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            var calendarEl = document.getElementById('calendar');

                                            // Create the events array directly in JavaScript
                                            var events = [

                                                @foreach ($schedules as $schedule)
                                                    {
                                                        title: "{{ $schedule->title }}",
                                                        start: "{{ $schedule->start }}T{{ $schedule->time }}", // Combine date and time for the start field
                                                        end: "{{ $schedule->end }}T{{ $schedule->time }}", // Combine date and time for the end field
                                                    },
                                                @endforeach


                                                @foreach ($bookings as $schedule)
                                                    {
                                                        title: "{{ $schedule->user->name }}",
                                                        start: "{{ $schedule->event_date }}T{{ $schedule->event_time }}", // Combine date and time for the start field
                                                        end: "{{ $schedule->event_date }}T{{ $schedule->event_time }}",
                                                    },
                                                @endforeach

                                            ];

                                            var calendar = new FullCalendar.Calendar(calendarEl, {
                                                initialView: 'dayGridMonth', // Switch to a week view with times
                                                events: events, // Use the directly generated array
                                            });

                                            calendar.render();
                                        });
                                    </script>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /# card -->
            </div>
            <!-- /# column -->
        </div>

        <!-- Day Off Application Form -->
        <div class="card p-3 mt-3">
            <h3>Apply for a Day Off</h3>
            <form id="dayOffForm" action="{{ route('schedules.store') }}" method="post">
                @csrf
                <!-- Date Picker -->
                <div class="form-group">
                    <label for="datePicker">Start Date:</label>
                    <div class='input-group date' id='datePicker'>
                        <input type='date' class="form-control" name="start" placeholder="YYYY-MM-DD" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="datePicker">End Date:</label>
                    <div class='input-group date' id='datePicker'>
                        <input type='date' class="form-control" name="end" placeholder="YYYY-MM-DD" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>

                <!-- Time Picker -->
                <div class="form-group">
                    <label for="timePicker">Select Time:</label>
                    <div class='input-group date' id='timePicker'>
                        <input type='time' name="time" class="form-control" placeholder="HH:mm" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-time"></span>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="dayOffReason">Reason</label>
                    <textarea class="form-control" id="dayOffReason" name="title" required></textarea>
                </div>

                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>

        <!-- Day Off Timetable -->
        <div class="card p-3">
            <h3>Schedules</h3>
            <table id="dayOffTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date Start</th>
                        <th>Date End</th>
                        <th>Reason</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($schedules as $schedule)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $schedule['start'] }}</td>
                            <td>{{ $schedule['end'] }}</td>
                            <td>{{ $schedule['title'] }}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-md" data-toggle="modal"
                                    data-target="#modelId{{ $schedule->id }}">
                                    View
                                </button>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary btn-md" data-toggle="modal"
                                    data-target="#modelId">
                                    Delete
                                </button>
                            </td>
                            <!-- Modal -->
                            <div class="modal fade" id="modelId" tabindex="-1" role="dialog"
                                aria-labelledby="modelTitleId" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Delete Schedule</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('schedules.destroy', $schedule->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <p>This action cannot be undone</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Delete</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Modal -->
                            <div class="modal fade" id="modelId{{ $schedule->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="modelTitleId" aria-hidden="true">
                                <div class="modal-dialog modal-lg " role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ $schedule->title }}</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="dayOffForm" action="{{ route('schedules.update', $schedule->id) }}"
                                                method="post">
                                                @csrf
                                                @method('PUT')

                                                <div class="form-group">
                                                    <label for="datePicker">Start Date:</label>
                                                    <div class='input-group date' id='datePicker'>
                                                        <input type='date' class="form-control" name="start"
                                                            value="{{ $schedule->start }}" placeholder="YYYY-MM-DD"
                                                            disabled />
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="datePicker">End Date:</label>
                                                    <div class='input-group date' id='datePicker'>
                                                        <input type='date' class="form-control" name="end"
                                                            value="{{ $schedule->end }}" placeholder="YYYY-MM-DD"
                                                            disabled />
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>

                                                <!-- Time Picker -->
                                                <div class="form-group">
                                                    <label for="timePicker">Select Time:</label>
                                                    <div class='input-group date' id='timePicker'>
                                                        <input type='time' name="time" class="form-control"
                                                            value="{{ $schedule->time }}" placeholder="HH:mm" />
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="dayOffReason">Reason</label>
                                                    <textarea class="form-control" id="dayOffReason" name="title" required>{{ $schedule->title }}</textarea>
                                                </div>



                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <!-- Include necessary JS -->
    <script src="../../assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="../../assets/plugins/moment/moment.js"></script>
    <script src="../../assets/plugins/fullcalender/js/fullcalendar.min.js"></script>
    <script src="../../assets/plugins/fullcalender/js/fullcalendar-init.js"></script>
    <script src="../../assets/plugins/common/common.min.js"></script>
    <script src="../js/custom.min.js"></script>
    <!-- Date Picker Plugin JavaScript -->
    <script src="../../assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- Common JS -->
    <script src="../../assets/plugins/common/common.min.js"></script>
    <!-- Custom script -->
    <script src="../js/custom.min.js"></script>
    <script src="../../assets/plugins/moment/moment.js"></script>


    <script>
        $(document).ready(function() {
            $('#dayOffTable').DataTable(); // Initialize DataTables

        });
    </script>
    <script type="text/javascript">
        $(function() {
            // Initialize Date Picker
            $('#datePicker').datetimepicker({
                format: 'DD-MM-YYYY',
                useCurrent: false // Important for range picking
            });

            // Initialize Time Picker
            $('#timePicker').datetimepicker({
                format: 'HH:mm',
                stepping: 1 // Allows picking minute by minute
            });
        });
    </script>

@endsection
