<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Date and Time Picker Example</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"
        rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">
    </script>
    <style>
        .container {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Date and Time Picker Examples</h2>

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

        <!-- Date Range Picker -->
        <div class="form-group">
            <label for="startDatePicker">Start Date:</label>
            <div class='input-group date' id='startDatePicker'>
                <input type='text' class="form-control" placeholder="YYYY-MM-DD" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>

        <div class="form-group">
            <label for="endDatePicker">End Date:</label>
            <div class='input-group date' id='endDatePicker'>
                <input type='text' class="form-control" placeholder="YYYY-MM-DD" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
    </div>

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

            // Initialize Start Date Picker
            $('#startDatePicker').datetimepicker({
                format: 'DD-MM-YYYY',
                useCurrent: false // Important for range picking
            });

            // Initialize End Date Picker
            $('#endDatePicker').datetimepicker({
                format: 'DD-MM-YYYY',
                useCurrent: false // Important for range picking
            });

            // Link the two date pickers for range selection
            $("#startDatePicker").on("dp.change", function(e) {
                $('#endDatePicker').data("DateTimePicker").minDate(e.date);
            });
            $("#endDatePicker").on("dp.change", function(e) {
                $('#startDatePicker').data("DateTimePicker").maxDate(e.date);
            });
        });
    </script>
</body>

</html>
