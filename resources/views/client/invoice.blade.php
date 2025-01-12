@extends('layout.invoice')

@section('title', 'Invoice')


@section('content')

    <div class="container mt-5">
        <h1 class="text-center mb-4">Invoice Details</h1>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Invoice Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Invoice ID:</th>
                        <td>{{ $invoice->id }}</td>
                    </tr>
                    <tr>
                        <th>Invoice Date:</th>
                        <td>{{ $invoice->invoice_date }}</td>
                    </tr>
                    <tr>
                        <th>Amount:</th>
                        <td>{{ number_format($invoice->total_amount) }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>{{ $invoice->status }}</td>
                    </tr>
                </table>

                <h5 class="mt-4">Booking Details</h5>
                <table class="table table-bordered">
                    <tr>
                        <th>User ID:</th>
                        <td>{{ $booking->user_id }}</td>
                    </tr>
                    <tr>
                        <th>Package ID:</th>
                        <td>{{ $booking->package_id }}</td>
                    </tr>
                    <tr>
                        <th>Venue:</th>
                        <td>{{ $booking->venue }}</td>
                    </tr>
                    <tr>
                        <th>Event Date:</th>
                        <td>{{ $booking->event_date }}</td>
                    </tr>
                    <tr>
                        <th>Event Time:</th>
                        <td>{{ $booking->event_time }}</td>
                    </tr>
                    <tr>
                        <th>Remark:</th>
                        <td>{{ $booking->remark }}</td>
                    </tr>
                    <tr>
                        <th>Acceptance Status:</th>
                        <td>{{ $booking->acceptance_status }}</td>
                    </tr>
                    <tr>
                        <th>Progress Status:</th>
                        <td>{{ $booking->progress_status }}</td>
                    </tr>

                    <tr>
                        <th>Total Price:</th>
                        <td>RM{{ number_format($booking->total_price, 2) }}</td>
                    </tr>
                </table>

                <div class="text-center mt-4">
                    <button class="btn btn-primary" onclick="window.print()">Print Invoice</button>
                    @if (Auth::user()->role == 'Owner')
                        <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-secondary">Back to Booking
                            Details</a>
                    @else
                        <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-secondary">Back to Booking
                            Details</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
