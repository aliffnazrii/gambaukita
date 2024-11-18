@extends('layout.owner')

@section('title', 'Booking Details')

@section('content')

    <div class="container mt-5">
        <h1 class="text-center mb-4">Booking Details</h1>



        <!-- Booking Details Card -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Booking Information</h5>
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label for="userId">User ID:</label>
                        <input type="text" class="form-control" id="userId" value="{{ $booking->user_id }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="packageId">Package ID:</label>
                        <input type="text" class="form-control" id="packageId" value="{{ $booking->package_id }}"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label for="venue">Venue:</label>
                        <input type="text" class="form-control" id="venue" value="{{ $booking->venue }}" readonly>
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
                        <label for="progressStatus">Progress Status:</label>
                        <input type="text" class="form-control" id="progressStatus"
                            value="{{ $booking->progress_status }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="bookingStatus">Booking Status:</label>
                        <input type="text" class="form-control" id="bookingStatus" value="{{ $booking->booking_status }}"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label for="totalPrice">Total Price:</label>
                        <input type="text" class="form-control" id="totalPrice"
                            value="RM{{ number_format($booking->total_price, 2) }}" readonly>
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
                    <a href="javascript:history.back()" class="btn btn-secondary">Back</a>
                    <button class="btn btn-primary" onclick="window.print()">Print Invoice</button>
                    <a href="{{ route('booking.showInvoice', $booking->id) }}" class="btn btn-info">View Invoice</a>
                </div>
            </div>
        </div>
    </div>

@endsection
