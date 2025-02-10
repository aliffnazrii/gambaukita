@extends('layout.owner')

@section('title', 'Client Management')

@section('content')

    <!-- Main Content -->
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0">Client List</h3>
            </div>
            <div class="card-body">
                <table id="clientTable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">No</th>
                            <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">Client</th>
                            <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">Email</th>
                            <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">Phone</th>

                            <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-700">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="bg-gray-50">
                                <td class="py-2 px-4 border-b border-gray-300">{{ $loop->iteration }}</td>
                                <td class="py-2 px-4 border-b border-gray-300">
                                    @if ($user->picture != '')
                                        <img src="{{ asset($user->picture) }}" alt="User Picture"
                                            style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover; margin-right: 10px; display: inline-block;">
                                    @else
                                        <img src="{{ asset('assets/images/avatar/3.jpg') }}" alt="Default Picture"
                                            style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover; margin-right: 10px; display: inline-block;">
                                    @endif
                                    {{ $user->name }}
                                </td>
                                <td class="py-2 px-4 border-b border-gray-300">{{ $user->email }}</td>
                                <td class="py-2 px-4 border-b border-gray-300">
                                    {{ $user->phone ? $user->phone : 'Not Available' }}</td>

                                <td class="py-2 px-4 border-b border-gray-300">
                                    <!-- Trigger Modal -->
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#clientModal{{ $user->id }}">
                                        View
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="clientModal{{ $user->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="clientModalLabel{{ $user->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="clientModalLabel{{ $user->id }}">Client
                                                Information</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="text-center">
                                                @if ($user->picture)
                                                    <img src="{{ asset($user->picture) }}" alt="User Picture"
                                                        style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-bottom: 15px;">
                                                @else
                                                    <img src="{{ asset('assets/images/avatar/3.jpg') }}"
                                                        alt="Default Picture"
                                                        style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-bottom: 15px;">
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="name"><strong>Name:</strong></label>
                                                <input type="text" class="form-control" id="name"
                                                    value="{{ $user->name }}" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label for="email"><strong>Email:</strong></label>
                                                <input type="email" class="form-control" id="email"
                                                    value="{{ $user->email }}" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label for="phone"><strong>Phone:</strong></label>
                                                <input type="text" class="form-control" id="phone"
                                                    value="{{ $user->phone ? $user->phone : 'Not Available' }}" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label for="address"><strong>Address:</strong></label>
                                                <textarea class="form-control" id="address" rows="3" readonly>{{ $user->address ? $user->address : 'Not Available' }}</textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="postcode"><strong>Postcode:</strong></label>
                                                <input type="text" class="form-control" id="postcode"
                                                    value="{{ $user->postcode ? $user->postcode : 'Not Available' }}"
                                                    readonly>
                                            </div>

                                            <div class="form-group">
                                                <label for="city"><strong>City:</strong></label>
                                                <input type="text" class="form-control" id="city"
                                                    value="{{ $user->city ? $user->city : 'Not Available' }}" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label for="state"><strong>State:</strong></label>
                                                <input type="text" class="form-control" id="state"
                                                    value="{{ $user->state ? $user->state : 'Not Available' }}" readonly>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </tr>
                        @endforeach
                    </tbody>
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
            $('#clientTable').DataTable(); // Initialize DataTables
        });
    </script>
@endsection
