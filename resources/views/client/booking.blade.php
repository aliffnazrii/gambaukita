@extends('layout.client')


@section('title', 'Bookings')

@section('content')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA08tler_Ei6E7v6peMa9VWVu1MEtrhll0&libraries=places&callback=initMap"
        async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.8/index.global.min.js"></script>
    <style>
        #map {
            height: 400px;
            width: 100%;
        }

        #autocomplete {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }
    </style>

    <div class="row mt-3">
        <div class="col-9 m-auto">
            <div class="card card-body text-center">
                <h1>Bookings</h1>


                <div class="customer-login text-left">
                    @if ($errors->any())
                        <h4 class="title-1 title-border text-uppercase mb-4">Check Booking Date</h4>
                    @elseif(Session::has('msg'))
                        <h4 class="title-1 title-border text-uppercase mb-4">Booking Form</h4>
                    @else
                        <h4 class="title-1 title-border text-uppercase mb-4">Check Booking Date</h4>
                    @endif



                    <!-- Event Date -->
                    <div class="mb-3">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>

                            <form action="{{ route('booking.checkdate') }}" method="post">
                                @csrf

                                <label for="event_date" class="form-label">Event Date</label>
                                <input type="date" class="form-control" id="event_date" name="checkdate_input" required>
                                <button type="submit" class="btn btn-primary mt-3">Check</button>
                            </form>
                        @elseif(Session::has('msg'))
                            <div class="alert alert-success">
                                <ul>
                                    <li>{{ Session::get('msg') }}</li>

                                </ul>
                            </div>

                            <form class="form-valide" action="{{ route('bookings.store') }}" method="post">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label text-right" for="user_id">Name <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-6">
                                        <input type="hidden" class="form-control" id="user_id" name="user_id"
                                            value="{{ Auth::user()->id }}" required>
                                        <input type="text" class="form-control" value="{{ Auth::user()->name }}"
                                            disabled>
                                    </div>
                                </div>


                                @if (session('bookingDate'))
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label text-right" for="event_date">Event Date <span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-6">
                                            <input type="date" class="form-control" id="event_date" name="event_date"
                                                value="{{ session('bookingDate') }}" required>
                                        </div>
                                    </div>
                                @else
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-form-label text-right" for="event_date">Event Date <span
                                                class="text-danger">*</span></label>
                                        <div class="col-lg-6">
                                            <input type="date" class="form-control" id="event_date" name="event_date"
                                                required>
                                        </div>
                                    </div>
                                @endif

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label text-right" for="event_time">Event Time <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-6">
                                        <input type="time" class="form-control" id="event_time" name="event_time"
                                            required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label text-right" for="venue">Venue <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-6">
                                        {{-- <input type="text" class="form-control" id="venue" name="venue"
                                            placeholder="Enter venue name" required> --}}
                                        <input id="autocomplete" type="text" placeholder="Enter a location">
                                        <div id="map"></div>
                                        <input type="hidden" name="venue" id="locationUrl">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label text-right" for="remark">Remark</label>
                                    <div class="col-lg-6">
                                        <textarea class="form-control" id="remark" name="remark" rows="3" placeholder="Any additional remarks"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label text-right" for="acceptance_status">Package
                                        <span class="text-danger">*</span></label>
                                    <div class="col-lg-6">
                                        <select class="form-control" id="package" name="package_id" required>
                                            <option value="">Please select</option>
                                            @foreach ($packages as $package)
                                                <option value="{{ $package->id }}">{{ $package->name }} -
                                                    RM{{ $package->price }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label text-right">Deposit Percentage:
                                        <span class="text-danger">*</span></label>
                                    <div class="col-lg-6">
                                        <select class="form-control" name="deposit_percentage" required>
                                            <option value="">Please select</option>
                                            <option value="25">25%</option>
                                            <option value="50">50%</option>
                                        </select>
                                    </div>
                                </div>


                                <input type="hidden" name="acceptance_status" value="pending">
                                <input type="hidden" name="progress_status" value="pending">
                                <input type="hidden" name="booking_status" value="pending">

                                <div class="form-group row">
                                    <div class="col-lg-8 ml-auto">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <form action="{{ route('booking.checkdate') }}" method="post">
                                @csrf

                                <label for="event_date" class="form-label">Event Date</label>
                                <input type="date" class="form-control" id="event_date" name="checkdate_input"
                                    required>
                                <button type="submit" class="btn btn-primary mt-3">Check</button>
                            </form>
                    </div>
                </div>
                <div class="card my-auto border my-5">
                    <div class="card-body my-auto">
                        <div class="card-title">
                            <h1>Booking Calendar</h1>
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
                                                        title: "{{ 'Booked' }}",
                                                        start: "{{ $schedule->start }}T{{ $schedule->time }}", // Combine date and time for the start field
                                                        end: "{{ $schedule->end }}T{{ $schedule->time }}", // Combine date and time for the end field
                                                    },
                                                @endforeach


                                                @foreach ($bookings as $schedule)
                                                    {
                                                        title: "{{ 'Booked' }}",
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
                @endif


            </div>


        </div>

    </div>
    </div>
    </div>
    {{-- API KEY : AIzaSyA08tler_Ei6E7v6peMa9VWVu1MEtrhll0 --}}
    {{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA08tler_Ei6E7v6peMa9VWVu1MEtrhll0&callback=initMap&v=weekly" async defer></script> --}}

    <script>
        let map, marker, autocomplete;

        function initMap() {
            // Initialize map centered on a default location
            map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: 51.505,
                    lng: -0.09
                }, // Default coordinates (London)
                zoom: 13
            });

            // Initialize the autocomplete input field
            autocomplete = new google.maps.places.Autocomplete(document.getElementById('autocomplete'), {
                types: ['geocode']
            });

            // Bind the autocomplete listener to update the marker and form
            autocomplete.addListener('place_changed', onPlaceChanged);
        }

        function onPlaceChanged() {
            const place = autocomplete.getPlace();
            if (!place.geometry) {
                // User selected a place without geometry (invalid place)
                alert("No details available for the selected place");
                return;
            }

            // Center the map on the selected location
            map.setCenter(place.geometry.location);
            map.setZoom(15);

            // Place a marker at the selected location
            if (marker) {
                marker.setPosition(place.geometry.location);
            } else {
                marker = new google.maps.Marker({
                    position: place.geometry.location,
                    map: map
                });
            }

            // Update the hidden input field with the Google Maps URL for the selected location
            const locationUrl =
                `https://www.google.com/maps?q=${place.geometry.location.lat()},${place.geometry.location.lng()}`;
            document.getElementById('locationUrl').value = locationUrl;
        }
    </script>

@endsection
