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
    </style>
@endsection

@section('content')
    <link href="../../assets/plugins/fullcalender/css/fullcalendar.css" rel="stylesheet">

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
    <div class="container mt-4">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h1>Calendar</h1>
                        </div>
                        <div class="row justify-content-center">

                            <div class="col-md-12">
                                <div class="card-box m-b-50">
                                    <div id="calendar"></div>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            var calendarEl = document.getElementById('calendar');

                                            var calendar = new FullCalendar.Calendar(calendarEl, {
                                                plugins: ['dayGrid'],
                                                initialView: 'dayGridMonth',
                                                events: {{ route('owner.getEvents') }}, // URL to fetch events
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
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- Day Off Application Form -->
        <div class="card p-3">
            <h3>Apply for a Day Off</h3>
            <form id="dayOffForm" action="{{ route('schedules.store') }}" method="post">
                @csrf
                <!-- Date Picker -->
                <div class="form-group">
                    <label for="datePicker">Select Date:</label>
                    <div class='input-group date' id='datePicker'>
                        <input type='text' class="form-control" placeholder="YYYY-MM-DD" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>

                <!-- Time Picker -->
                <div class="form-group">
                    <label for="timePicker">Select Time:</label>
                    <div class='input-group date' id='timePicker'>
                        <input type='text' class="form-control" placeholder="HH:mm" />
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
            <h3>Approved Day Off Timetable</h3>
            <table id="dayOffTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>Date Start</th>
                        <th>Date End</th>
                        <th>Reason</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Existing approved off days will be dynamically populated here -->
                    @foreach ($schedules as $schedule)
                        <tr>
                            <td>{{ $schedule->start }}</td>
                            <td>{{ $schedule->end }}</td>
                            <td>{{ $schedule->title }}</td>
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
