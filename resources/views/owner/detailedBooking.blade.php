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
                        <input type="text" class="form-control" id="remark" value="{{ $booking->remark == ''? 'No Remark' : $booking->remark }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="acceptanceStatus">Acceptance Status:</label>
                        <input type="text" class="form-control" id="acceptanceStatus"
                            value="{{ $booking->acceptance_status }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="totalPrice">Total Price:</label>
                        <input type="text" class="form-control" id="totalPrice"
                            value="RM{{ number_format($booking->total_price, 2) }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="progressStatus">Booking Status:</label>
                        <select class="form-control" name="progress_status" id="progressStatus"
                            onchange="toggleGoogleDriveField()"
                            {{ $booking->progress_status == 'Completed' ? 'Disabled' : '' }}>
                            <option value="Pending"
                                {{ $booking->progress_status == 'Booked' || $booking->progress_status == 'Completed' || $booking->progress_status == 'Waiting' ? 'disabled' : '' }}
                                {{ $booking->progress_status == 'Pending' ? 'selected' : '' }}>Pending
                            </option>

                            <option value="Booked"
                                {{ $booking->progress_status == 'Completed' || $booking->progress_status == 'Waiting' ? 'disabled' : '' }}{{ $booking->progress_status == 'Booked' ? 'selected' : '' }}>
                                Booked
                            </option>

                            <option value="Waiting"
                                {{ $booking->progress_status == 'Waiting' || $booking->progress_status == 'Completed' ? 'disabled' : '' }}
                                {{ $booking->progress_status == 'Waiting' ? 'selected' : '' }}>Waiting
                            </option>

                            <option value="Completed" {{ $booking->progress_status == 'Completed' ? 'disabled' : '' }}
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
                            placeholder="Enter Google Drive link" {{ $booking->link ? 'Disabled' : '' }}>
                        @if ($booking->link == null)
                        @else
                            <a class="btn btn-sm btn-primary my-3" href="{{ $booking->link }}" target="_blank"
                                rel="noopener noreferrer">Open Link</a>
                        @endif
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



                    @if ($booking->link)
                    @else
                        <div class="form-group">
                            <button type="submit" class="btn btn-md btn-primary">Save</button>
                        </div>
                    @endif
                </form>
            </div>
        </div>

        @if ($booking->progress_status == 'Completed' || $booking->invoices->where('status', 'Paid')->count() == 2)



            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Receipt Details</h5>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        {{-- <tr>
                            <th>Invoice ID:</th>
                            <td>INV{{ $invoice->invoice_number }}</td>
                        </tr> --}}
                        @php
                            $total = 0; // Initialize the total amount
                            $status = ''; // Initialize status
                            $date = ''; // Initialize date
                        @endphp
                        @foreach ($booking->payments as $payment)
                            @php
                                $total = $total + $payment->amount;
                                $status = $payment->status;
                                $date = $payment->updated_at;
                            @endphp
                        @endforeach
                        <tr>
                            <th>Date:</th>
                            <td>{{ \Carbon\Carbon::parse($date)->format('d M Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Amount:</th>
                            <td>RM {{ number_format($total, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>{{ $status }}</td>
                        </tr>
                    </table>

                    <!-- Action Buttons -->
                    <div class="text-center mt-4">
                        <a href="{{ route('owner.booking') }}" class="btn btn-secondary">Back</a>
                        <a href="{{ route('booking.showReceipt', $payment->id) }}" class="btn btn-info">View
                            Receipt</a>
                    </div>
                </div>

            </div>
        @else
            <!-- Invoice Details Card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Invoice Details</h5>
                </div>


                <div class="card-body">
                    <table class="table table-bordered">
                        @php
                            $total = 0; // Initialize the total amount
                            $status = ''; // Initialize status
                            $date = ''; // Initialize date
                            $invnum = '';
                            $invoiceId = '';
                        @endphp
                        @foreach ($booking->invoices as $payment)
                            @php
                                if ($payment->status == 'Unpaid') {
                                    $total = $total + $payment->total_amount;
                                    $status = $payment->status;
                                    $date = $payment->invoice_date;
                                    $invnum = $payment->invoice_number;
                                    $invoiceId = $payment->id;
                                }
                            @endphp
                        @endforeach
                        <tr>
                            <th>Invoice ID:</th>
                            <td>{{ $invnum }}</td>
                        </tr>
                        <tr>
                            <th>Invoice Date:</th>
                            <td>{{ \Carbon\Carbon::parse($date)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Amount:</th>
                            <td>RM {{ number_format($total, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>{{ $status }}</td>
                        </tr>

                    </table>
                    @if ($booking->progress_status == 'Waiting')
                        <button class="btn btn-primary" readonly>Paid</button>
                    @elseif($booking->progress_status == 'Completed')
                        <button class="btn btn-primary" readonly>Paid</button>
                    @endif

                    <!-- Action Buttons -->
                    <div class="text-center mt-4">
                        <a href="{{ route('owner.booking') }}" class="btn btn-secondary">Back</a>
                        <a href="{{ route('booking.showInvoice', $invoiceId) }}" class="btn btn-info">View
                            Invoice</a>
                    </div>
                </div>

            </div>
        @endif
    </div>

@endsection
