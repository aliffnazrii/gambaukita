@extends('layout.client')

@section('title', 'Package Details')

@section('content')

    <style>
        .carousel img {
            max-height: 400px;
            object-fit: cover;
        }

        .package-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease-in-out;
        }

        .package-details:hover {
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
            transform: translateY(-5px);
        }

        .package-details h3 {
            margin-bottom: 20px;
            font-size: 1.8rem;
        }

        .package-details ul {
            list-style: none;
            padding: 0;
        }

        .package-details ul li {
            margin-bottom: 10px;
            font-size: 1rem;
            color: #333;
        }





        @media (max-width: 768px) {
            .carousel img {
                max-height: 250px;
            }

            .package-details h3 {
                font-size: 1.5rem;
            }

            .btn-book {
                width: 100%;
            }

            .col-md-6 {
                margin-bottom: 20px;
            }
        }
    </style>
    <div class="row m-2">
        <div class="col-12"></div>
    </div>
    <div class="col-12 m-auto mt-3 mb-3">

        <div class="card card-body p-0 border m-auto">
            <h1 class="text-center my-5">{{ $package->name }}</h1>
            <div class="col-md-10 col-lg-8 m-auto">
                <div class="row text-center p-4">

                    {{-- Carousel for Package Images --}}
                    <div class="col-md-6 mb-4 mb-md-0">
                        <div id="carouselPackage" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($package->images as $key => $image)
                                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                        <img src="{{ is_object($image) ? asset($image->image_url) : $image }}"
                                            class="d-block w-100" alt="Package Image"
                                            style="max-height: 400px; object-fit: cover;">
                                    </div>
                                @endforeach
                            </div>

                            @if (count($package->images) > 1)
                                <!-- Carousel controls for more than one image -->
                                <a class="carousel-control-prev" href="#carouselPackage" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselPackage" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Package Details --}}
                    <div class="col-md-6 mb-4 mb-md-0" style="height: 400px;">
                        <div class="package-details bg-light p-4 rounded shadow-sm">
                            <h3 class="mb-4">Package Details</h3>
                            <p>{{ $package->description }}</p>
                            <ul class="text-center">
                                @foreach (explode("\n", $package->features) as $index => $feature)
                                    <li>{{ $feature }}</li>
                                @endforeach
                            </ul>
                            <h4 class="text-primary mt-4">Price: RM {{ $package->price }}</h4>
                            <a href="{{ route('bookings.create') }}" class="btn btn-primary btn-lg mt-4">Book Now</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>





@endsection
