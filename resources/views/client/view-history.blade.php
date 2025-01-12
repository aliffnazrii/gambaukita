@extends('layout.client')

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
                        <label for="packageId">User Name:</label>
                        <input type="text" class="form-control" id="packageId" value="{{ $booking->user->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="packageId">Package:</label>
                        <input type="text" class="form-control" id="packageId" value="{{ $booking->package->name }}"
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
                        <label for="totalPrice">Total Price:</label>
                        <input type="text" class="form-control" id="totalPrice"
                            value="RM{{ number_format($booking->total_price, 2) }}" readonly>
                    </div>
                </form>
                @if ($booking->progress_status == 'Waiting')
                    <button type="submit" class="btn btn-primary" disabled>Paid</button>
                @else
                    <a href="{{ route('booking.payment', $booking->id) }}" class="btn btn-primary">Make Payment</a>
                @endif
            </div>
        </div>

        @if ($booking->progress_status == 'Completed')


            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Receipt Details</h5>
                </div>
                @foreach ($booking->payments as $payment)
                    <div class="card-body">
                        <table class="table table-bordered">
                            {{-- <tr>
                                <th>Invoice ID:</th>
                                <td>INV{{ $invoice->invoice_number }}</td>
                            </tr> --}}
                            <tr>
                                <th>Date:</th>
                                <td>{{ $payment->updated_at }}</td>
                            </tr>
                            <tr>
                                <th>Amount:</th>
                                <td>RM {{ number_format($payment->amount, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>{{ $payment->status }}</td>
                            </tr>
                        </table>

                        <!-- Action Buttons -->
                        <div class="text-center mt-4">
                            <a href="javascript:history.back()" class="btn btn-secondary">Back</a>
                            <a href="{{ route('booking.showInvoice', $payment->id) }}" class="btn btn-info">View
                                Receipt</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Invoice Details Card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Invoice Details</h5>
                </div>
                
                @foreach ($booking->invoices as $invoice)
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Invoice ID:</th>
                                <td>{{ $invoice->invoice_number }}</td>
                            </tr>
                            <tr>
                                <th>Invoice Date:</th>
                                <td>{{ $invoice->invoice_date }}</td>
                            </tr>
                            <tr>
                                <th>Amount:</th>
                                <td>RM {{ number_format($invoice->total_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>{{ $invoice->status }}</td>
                            </tr>
                        </table>

                        <!-- Action Buttons -->
                        <div class="text-center mt-4">
                            <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Back</a>

                            <a href="{{ route('booking.showInvoice', $invoice->id) }}" 
                                class="btn btn-info">View
                                Invoice</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

@endsection
