@extends('layout.owner')

@section('title', 'Dashboard')

@section('content')

    <div class="card card-body border mt-3">
        <div class="row mt-3">
            <div class="col-lg-4">
                <div class="card border">
                    <div class="card-body">
                        <h4>Clients <span class="pull-right"><i class="ion-android-download f-s-30 text-primary"></i></span>
                        </h4>
                        <h6 class="m-t-20 f-s-14">{{ count($clients) }} Users</h6>
                        <div class="progress m-t-0 h-7px">
                            <div role="progressbar" class="progress-bar bg-primary wow animated progress-animated"
                                style="width: {{ count($clients) }}px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border">
                    <div class="card-body">
                        <h4>Booking Made <span class="pull-right"><i
                                    class="ion-android-upload f-s-30 text-success"></i></span>
                        </h4>
                        <h6 class="m-t-20 f-s-14">{{ count($bookings) }} Bookings</h6>
                        <div class="progress m-t-0 h-7px">
                            <div role="progressbar" class="progress-bar bg-success wow animated progress-animated"
                                style="width: {{ count($bookings) }}px;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border">
                    <div class="card-body">
                        <h4>Packages <span class="pull-right"><i class="ion-android-list f-s-30 text-danger"></i></span>
                        </h4>
                        <h6 class="m-t-20 f-s-14">{{ count($packages) }} Packages</h6>
                        <div class="progress m-t-0 h-7px">
                            <div role="progressbar" class="progress-bar bg-danger wow animated progress-animated"
                                style="width: {{ count($packages) }}px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-7">
                <div class="card border" style="min-height: 130px;"> <!-- Set a minimum height here -->
                    <div class="card-body">
                        <h4 class="card-title">Monthly Income</h4>
                        <div class="f-s-30 f-w-300 text-success">
                            {{ number_format($monthlyEarnings, 2) }} <span class="f-s-16 text-uppercase">MYR</span>
                        </div>
                    </div>
                </div>

                <div class="card border" style="min-height: 130px;"> <!-- Set the same min-height -->
                    <div class="card-body">
                        <h2 class="f-s-30 m-b-0">MYR{{ number_format($totalEarnings, 2) }}</h2><span class="f-w-600">Total
                            Revenue</span>
                    </div>
                </div>
            </div>





            <div class="col-xl-5">
                <div class="card border">
                    <div class="card-body">
                        <h4 class="card-title">Messages</h4>
                        @if (auth()->user()->notifications->count() > 0)
                            @foreach (auth()->user()->notifications->take(5) as $notification)
                                <div class="media border-bottom-1 p-t-15 p-b-15">
                                    <img src="{{ asset('storage/images/logo.png') }}" class="mr-3 rounded-circle"
                                        style="max-height: 50px; max-width: 50px;" alt="...">
                                    <div class="media-body">
                                        <h5>{{ $notification->data['title'] }}</h5>
                                        <p class="m-b-0"> {{ $notification->data['message'] }}</p>
                                    </div><span
                                        class="text-muted f-s-12">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                    </span>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center">
                                <strong>No notifications</strong>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>



    </div>

@endsection
