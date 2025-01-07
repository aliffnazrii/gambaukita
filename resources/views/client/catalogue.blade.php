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
                        <div class="card h-100 border">
                            <!-- Bootstrap Carousel -->
                            <div id="carousel-{{ $package->id }}" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach ($package->images as $key => $image)
                                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                            <img class="d-block w-100"
                                                src="{{ is_object($image) ? $image->image_url : $image }}"
                                                alt="Package Image">
                                        </div>
                                    @endforeach

                                </div>

                                @if ($package->images->count() > 1)
                                    <!-- Controls for Carousel -->
                                    <a class="carousel-control-prev" href="#carousel-{{ $package->id }}" role="button"
                                        data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carousel-{{ $package->id }}" role="button"
                                        data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </a>
                                @endif
                            </div>
                            <!-- End Carousel -->

                            <div class="card-body">
                                <h4 class="card-title text-center">{{ $package->name }}</h4>
                                <p class="card-text">{{ $package->description }}</p>
                                <ul>
                                    {{ $package->features }}
                                </ul>
                                <div class="text-center">
                                    <h5>RM {{ $package->price }}</h5>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <a href="{{ route('bookings.index') }}" class="btn btn-primary">Book Now</a>
                                <a href="{{ route('packages.view', $package->id) }}" class="btn btn-primary">View</a>
                            </div>
                        </div>
                    </div>
                @endforeach



            </div>
        </div>

    </div>

@endsection
