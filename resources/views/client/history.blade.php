@extends('layout.client')


@section('title', 'History')

@section('content')


    <div class="row p-5">
        <div class="col">

            <div class="card card-body">

                <h1 class="text-center m-3">Active Booking</h1>

                <div class="table-responsive mt-1">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration">
                            <thead>

                                <tr>

                                    <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">No</th>
                                    <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">Package</th>
                                    <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">Venue</th>
                                    <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">Event Date</th>
                                    <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">Event Time</th>
                                    <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">Total Price</th>
                                    <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">Status</th>
                                    <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $booking)
                                    @if ($booking->progress_status != 'Completed')
                                        <tr class="bg-gray-50">

                                            <td class="py-2 px-4 border-b border-gray-300">{{ $loop->iteration }}</td>
                                            <td class="py-2 px-4 border-b border-gray-300">{{ $booking->package->name }}
                                            </td>
                                            <td class="py-2 px-4 border-b border-gray-300"><a href="{{ $booking->venue }}" target="_blank" rel="noopener noreferrer">Open Maps</a></td>
                                            <td class="py-2 px-4 border-b border-gray-300">
                                                {{ \Carbon\Carbon::parse($booking->event_date)->format('l, d M Y') }}
                                            </td>
                                            <td class="py-2 px-4 border-b border-gray-300">{{ $booking->event_time }}</td>

                                            <td class="py-2 px-4 border-b border-gray-300">
                                                RM{{ number_format($booking->total_price, 2) }}</td>
                                            <td class="py-2 px-4 border-b border-gray-300">{{ $booking->progress_status }}
                                            </td>
                                            <td class="py-2 px-4 border-b border-gray-300">
                                                <a href="{{ route('bookings.show', $booking->id) }}"
                                                    class="view-btn btn btn-primary">View</a>

                                            </td>
                                        </tr>
                                    @endif
                                @endforeach


                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">No</th>
                                    <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">Package</th>
                                    <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">Venue</th>
                                    <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">Event Date</th>
                                    <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">Event Time</th>
                                    <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">Total Price</th>
                                    <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">Status</th>
                                    <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">Action</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>

            </div>


            <div class="card card-body">

                <h1 class="text-center m-3">History</h1>

                <div class="table-responsive mt-1">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration">
                            <thead>

                                <tr>

                                    <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">No</th>
                                    <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">Package</th>
                                    <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">Venue</th>
                                    <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">Event Date</th>
                                    <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">Event Time</th>
                                    <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">Total Price</th>
                                    <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">Status</th>
                                    <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $booking)
                                    @if ($booking->progress_status == 'Completed')
                                        <tr class="bg-gray-50">

                                            <td class="py-2 px-4 border-b border-gray-300">{{ $loop->iteration }}</td>
                                            <td class="py-2 px-4 border-b border-gray-300">{{ $booking->package->name }}
                                            </td>
                                            <td class="py-2 px-4 border-b border-gray-300">{{ $booking->venue }}</td>
                                            <td class="py-2 px-4 border-b border-gray-300">{{ $booking->event_date }}</td>
                                            <td class="py-2 px-4 border-b border-gray-300">{{ $booking->event_time }}</td>

                                            <td class="py-2 px-4 border-b border-gray-300">
                                                RM{{ number_format($booking->total_price, 2) }}</td>
                                            <td class="py-2 px-4 border-b border-gray-300">{{ $booking->progress_status }}
                                            </td>
                                            <td class="py-2 px-4 border-b border-gray-300">
                                                <a href="{{ route('bookings.show', $booking->id) }}"
                                                    class="view-btn btn btn-primary">View</a>
                                                {{-- <button class="view-btn btn btn-primary" data-toggle="modal"
                                                data-target="#modalJohnDoe">View</button> --}}
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach


                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">No</th>
                                    <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">Package</th>
                                    <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">Venue</th>
                                    <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">Event Date</th>
                                    <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">Event Time</th>
                                    <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">Total Price</th>
                                    <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">Action</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
