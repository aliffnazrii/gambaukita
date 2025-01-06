@extends('layout.owner')

@section('title', 'Booking Management')

@section('content')

    <!-- Main Content -->
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">Booking List</h3>
            </div>
            <div class="card-body">
                <table id="bookingTable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
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
                            <tr class="bg-gray-50">

                                <td class="py-2 px-4 border-b border-gray-300">{{ $loop->iteration }}</td>
                                <td class="py-2 px-4 border-b border-gray-300">{{ $booking->package->name }}</td>
                                <td class="py-2 px-4 border-b border-gray-300"><a href="{{ $booking->venue }}" target="_blank" rel="noopener noreferrer">Open Maps</a></td>
                                <td class="py-2 px-4 border-b border-gray-300">{{ $booking->event_date }}</td>
                                <td class="py-2 px-4 border-b border-gray-300">{{ $booking->event_time }}</td>

                                <td class="py-2 px-4 border-b border-gray-300">
                                    RM{{ number_format($booking->total_price, 2) }}</td>
                                <td class="py-2 px-4 border-b border-gray-300">
                                    {{ $booking->progress_status }}</td>
                                    
                                <td class="py-2 px-4 border-b border-gray-300">
                                    <a href="{{ route('bookings.edit', $booking->id) }}"
                                        class="view-btn btn btn-primary">View</a>
                                    {{-- <button class="view-btn btn btn-primary" data-toggle="modal"
                                        data-target="#modalJohnDoe">View</button> --}}
                                </td>
                            </tr>
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


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#bookingTable').DataTable(); // Initialize DataTables
        });
    </script>
@endsection
