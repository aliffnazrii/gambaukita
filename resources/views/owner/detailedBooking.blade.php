@extends('layout.owner')

@section('title', 'Booking Details')

@section('content')

    <div class="container">
        <h1 class="text-center mb-4">Booking Details</h1>



        <!-- Booking Details Card -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Booking Information</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('bookings.update', $booking->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="userId">User Name:</label>
                        <input type="text" class="form-control" id="userId"
                            value="{{ $booking->user->name ? $booking->user->name : 'Not Available' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="userId">Phone:</label>
                        <input type="text" class="form-control" id="userId"
                            value="{{ $booking->user->phone ? $booking->user->phone : 'Not Available' }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="packageId">Package ID:</label>
                        <input type="text" class="form-control" id="packageId" value="{{ $booking->package->name }}"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label for="venue">Venue:</label>
                        <input type="text" class="form-control" id="venue" value="{{ $booking->venue }}" readonly>
                        <a class="btn btn-sm btn-primary my-3" href="{{ $booking->venue }}" target="_blank"
                            rel="noopener noreferrer">Open Maps</a>
                    </div>
                    <div class="form-group">
                        <label for="eventDate">Event Date:</label>
                        <input type="text" class="form-control" id="eventDate" value="{{ $booking->event_date }}"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label for="eventTime">Event Time:</label>
                        <input type="text" class="form-control" id="eventTime" value="{{ $booking->event_time }}"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label for="remark">Remark:</label>
                        <input type="text" class="form-control" id="remark" value="{{ $booking->remark }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="acceptanceStatus">Acceptance Status:</label>
                        <input type="text" class="form-control" id="acceptanceStatus"
                            value="{{ $booking->acceptance_status }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="progressStatus">Booking Status:</label>
                        <select class="form-control" name="progress_status" id="progressStatus"
                            onchange="toggleGoogleDriveField()">
                            <option value="Pending"
                                {{ $booking->progress_status == 'Booked' || $booking->progress_status == 'Completed' || $booking->progress_status == 'Waiting' ? 'disabled' : '' }}
                                {{ $booking->progress_status == 'Pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="Booked"
                                {{ $booking->progress_status == 'Completed' || $booking->progress_status == 'Waiting' ? 'disabled' : '' }}{{ $booking->progress_status == 'Booked' ? 'selected' : '' }}>
                                Booked
                            </option>
                            <option value="Waiting"
                                {{ $booking->progress_status == 'Booked' || $booking->progress_status == 'Completed' ? 'disabled' : '' }}
                                {{ $booking->progress_status == 'Waiting' ? 'selected' : '' }}>Waiting
                            </option>
                            <option value="Completed" {{ $booking->progress_status == 'Booked' ? 'disabled' : '' }}
                                {{ $booking->progress_status == 'Completed' ? 'selected' : '' }}>
                                Completed</option>
                            <option value="Cancelled" {{ $booking->progress_status == 'Cancelled' ? 'selected' : '' }}>
                                Cancelled</option>
                        </select>
                    </div>

                    <!-- Google Drive Link Field -->
                    <div class="form-group" id="googleDriveField" style="display: none;">
                        <label for="googleDriveLink">Google Drive Link:</label>
                        <input type="url" class="form-control" name="link" id="googleDriveLink"
                            value="{{ old('google_drive_link', $booking->link ?? '') }}"
                            placeholder="Enter Google Drive link">
                    </div>

                    <script>
                        function toggleGoogleDriveField() {
                            const progressStatus = document.getElementById('progressStatus').value;
                            const googleDriveField = document.getElementById('googleDriveField');

                            if (progressStatus === 'Completed') {
                                googleDriveField.style.display = 'block';
                            } else {
                                googleDriveField.style.display = 'none';
                            }
                        }

                        // Ensure the correct state is displayed on page load
                        document.addEventListener('DOMContentLoaded', function() {
                            toggleGoogleDriveField();
                        });
                    </script>

                    <div class="form-group">
                        <label for="totalPrice">Total Price:</label>
                        <input type="text" class="form-control" id="totalPrice"
                            value="RM{{ number_format($booking->total_price, 2) }}" readonly>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-md btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Invoice Details Card -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Invoice Details</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Invoice ID:</th>
                        <td>#INV001</td>
                    </tr>
                    <tr>
                        <th>Invoice Date:</th>
                        <td>2023/11/28</td>
                    </tr>
                    <tr>
                        <th>Amount:</th>
                        <td>$2,000</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>Pending</td>
                    </tr>
                </table>

                <!-- Action Buttons -->
                <div class="text-center mt-4">
                    <a href="{{ route('owner.booking') }}" class="btn btn-secondary">Back</a>
                    <button class="btn btn-primary" onclick="window.print()">Print Invoice</button>
                    <a href="{{ route('booking.showInvoice', $booking->id) }}" class="btn btn-info">View Invoice</a>
                </div>
            </div>
        </div>
    </div>

@endsection
