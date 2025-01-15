@extends('layout.invoice')

@section('title', 'Invoice')


@section('content')

    <div class="container mt-5">
        <h1 class="text-center mb-4">Receipt Details</h1>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Receipt Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Receipt ID:</th>
                        <td>{{ $transaction_id }}</td>
                    </tr>
                    <tr>
                        <th>Receipt Date:</th>
                        <td> {{ \Carbon\Carbon::parse($created_at)->format('d M, Y H:i:s') }}</td>
                    </tr>
                    <tr>
                        <th>Amount:</th>
                        <td>RM {{ number_format($amount, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>{{ $status }}</td>
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
                        <td>{{ \Carbon\Carbon::parse($booking->event_date)->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <th>Event Time:</th>
                        <td>{{ \Carbon\Carbon::parse($booking->event_time)->format('H:i:s') }}</td>
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
                    <button class="btn btn-primary" onclick="window.print()">Print Receipt</button>
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
