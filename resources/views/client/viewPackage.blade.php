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

    <div class="card card-body mb-5">
        <h1 class="text-center m-5">{{ $package->name }}</h1>
        <div class="col-md-9 m-auto">
            <div class="row text-center p-5">

                {{-- Carousel for Package Images --}}
                <div class="col-md-6">
                    <div id="carouselPackage" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($package->images as $key => $image)
                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                    <img src="{{ is_object($image) ? $image->image_url : $image }}" class="d-block w-100"
                                        alt="Package Image">
                                </div>
                            @endforeach
                        </div>

                        @if(count($package->images) >1)
                        <a class="carousel-control-prev" href="#carouselPackage" role="button" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselPackage" role="button" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </a>
                        @endif
                    </div>
                </div>

                {{-- Package Details --}}
                <div class="col-md-6">
                    <div class="package-details">
                        <h3>Package Details</h3>
                        <p>{{ $package->description }}</p>
                        <ul>
                            {!! $package->features !!}
                        </ul>
                        <h4>Price: RM {{ $package->price }}</h4>
                        <a href="{{ route('bookings.create') }}"
                            class="btn btn-primary btn-book mt-3">Book Now</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
