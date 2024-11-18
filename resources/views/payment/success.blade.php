<!-- resources/views/booking/success.blade.php -->

@extends('layout.client')

@section('content')
    <div class="container mb-5">
        <div class="card col-md-12 p-5 m-5 m-auto">
            <div class="card-body">
                <h5 class="card-title">Booking Information</h5>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Booking ID:</strong> {{ $booking->id }}</p>
                        <p><strong>Status:</strong> <span class="badge badge-success">{{ ucfirst($booking->status) }}</span>
                        </p>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <p><strong>Date:</strong> {{ \Carbon\Carbon::now()->format('d M Y') }}</p>
                    </div>
                </div>

                <h5 class="mt-4">Payment Summary</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th class="text-right">Amount (MYR)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Total Price:</strong></td>
                            <td class="text-right">{{ number_format($booking->total_price, 2) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Deposit Paid:</strong></td>
                            <td class="text-right">{{ number_format($booking->deposit_amount, 2) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Remaining Balance:</strong></td>
                            <td class="text-right">{{ number_format($booking->total_price - $booking->deposit_amount, 2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>

                <h5 class="mt-4">Customer Details</h5>
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td><strong>Name:</strong></td>
                            <td>{{ $booking->customer_name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>{{ $booking->customer_email }}</td>
                        </tr>
                        <tr>
                            <td><strong>Phone:</strong></td>
                            <td>{{ $booking->customer_phone }}</td>
                        </tr>
                    </tbody>
                </table>

                <h5 class="mt-4">Booking Details</h5>
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <td><strong>Check-in Date:</strong></td>
                            <td>{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Check-out Date:</strong></td>
                            <td>{{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Number of Guests:</strong></td>
                            <td>{{ $booking->number_of_guests }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="btn btn-outline-primary">Go to Home</a>
                </div>
            </div>
        </div>
    </div>
@endsection
