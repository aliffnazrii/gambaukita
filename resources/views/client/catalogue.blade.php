@extends('layout.client')


@section('title', 'Packages')


@section('content')

    <style>


    </style>

    <div class="card card-body ">
        <h1 class="text-center m-5">GambauKita Packages</h1>
        <div class="col-md-9 m-auto">
            <div class="row text-center p-5">



                @foreach ($packages as $package)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 border border-2">
                            @if ($package->images->isNotEmpty())
                                <img src="{{ asset($package->images->first()->image_url) }}" alt="Package Image"
                                    class="card-img-top m-auto border-bottom" >
                            @else
                                <img src="https://via.placeholder.com/300" class="card-img-top">
                            @endif
                            <div class="card-body">
                                <h4 class="card-title text-center">{{ $package->name }}</h4>
                                <p class="card-text">{{ $package->description }}</p>
                                <ul>
                                    <li>2 hours of photography</li>
                                    <li>30 edited photos</li>
                                    <li>Online gallery access</li>
                                </ul>
                                <div class="text-center">
                                    <h5>RM {{ $package->price }}</h5>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <a href="{{route('bookings.create')}}" class="btn btn-primary">Book Now</a>
                            </div>
                        </div>
                    </div>
                    <!-- Photography Package Card 2 -->
                    {{-- <div class="col-sm-4 mb-4">
                    <div class="card border border-5">
                        @if ($package->images->isNotEmpty())
                            <img src="{{ asset($package->images->first()->image_url) }}" alt="Package Image"
                                class="card-img-top m-auto border-bottom" style="height: 300px; width:300px">
                        @else
                            <img src="https://via.placeholder.com/300" class="card-img-top">
                        @endif

                        <div class="card-body">
                            <h5 class="card-title">{{ $package->name }}</h5>
                            <p class="card-text">{{ $package->description }}</p>
                            <h6 class="card-price">{{ $package->price }}</h6>
                            <a href="#" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div> --}}
                @endforeach


            </div>
        </div>

    </div>

@endsection
