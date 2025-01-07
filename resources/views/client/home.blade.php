@extends('layout.client')


@section('title', 'Gambaukita.my')




@section('content')

   

    <div class="card card-body">
        <div class="container-fluid">
            <!-- Banner Section -->
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="{{ asset('/storage/banner/banner1.png') }}" alt="First slide">
                        <div class="carousel-caption d-none d-md-block">

                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="{{ asset('/storage/banner/banner2.png') }}" alt="Second slide">
                        <div class="carousel-caption d-none d-md-block">

                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="{{ asset('/storage/banner/banner3.png') }}" alt="Third slide">
                        <div class="carousel-caption d-none d-md-block">

                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="{{ asset('/storage/banner/banner4.png') }}" alt="Third slide">
                        <div class="carousel-caption d-none d-md-block">

                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <!-- #/ Banner Section -->

            <!-- About Us Section -->
            <section class="about-us py-5 text-center">
                <div class="container">
                    <h2>Welcome to GambauKita Photography</h2>
                    <p class="lead">We specialize in capturing your most precious moments and turning them into memories
                        that will last a lifetime. Whether you're celebrating a wedding, a birthday, or a special family
                        event, our professional photographers are here to deliver exceptional service with stunning results.
                    </p>
                </div>
            </section>

            <!-- Photo Packages Section -->
            <section class="photo-packages py-5 bg-light">
                <div class="container">
                    <h2 class="text-center mb-5">Our Photo Packages</h2>
                    <div class="row">
                        <!-- Basic Package -->

                        {{-- @foreach ($packs as $package)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card h-100">
                                    <img class="card-img-top" src="https://via.placeholder.com/400x300/ffcccb"
                                        alt="Basic Package">
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
                                    </div>
                                </div>
                            </div>
                        @endforeach --}}

                        @foreach ($packs as $package)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card h-100 border">
                                    <!-- Bootstrap Carousel -->
                                    <div id="carousel-{{ $package->id }}" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner">
                                            @foreach ($package->images as $key => $image)
                                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                    <img class="d-block w-100"
                                                        src="{{ is_object($image) ? $image->image_url : $image }}"
                                                        alt="Package Image">
                                                </div>
                                            @endforeach
                                        </div>

                                        @if (count($package->images) > 1)
                                            <!-- Controls for Carousel -->
                                            <a class="carousel-control-prev" href="#carousel-{{ $package->id }}"
                                                role="button" data-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#carousel-{{ $package->id }}"
                                                role="button" data-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        @endif
                                    </div>
                                    <!-- End Carousel -->

                                    <div class="card-body">
                                        <h4 class="card-title text-center">{{ $package->name }}</h4>
                                        <p class="card-text text-center">{{ $package->description }}</p>
                                        <ul class="text-center">
                                            @foreach (explode("\n", $package->features) as $index => $feature)
                                                <li>{{ $feature }}</li>
                                            @endforeach
                                        </ul>

                                        <div class="text-center">
                                            <h5>RM {{ $package->price }}</h5>
                                        </div>
                                    </div>
                                    <div class="card-footer text-center">
                                        <a href="{{ route('bookings.index') }}" class="btn btn-primary">Book</a>
                                        <a href="{{ route('packages.view', $package->id) }}"
                                            class="btn btn-primary">View</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach



                    </div>
                </div>
            </section>

            <!-- Contact Us Section -->
            <section class="contact-us py-5 text-center">
                <div class="container">
                    <h2>Get in Touch</h2>
                    <p class="lead">Have questions or need more information about our packages? We're here to help!
                        Contact us to discuss your photography needs.</p>
                    <a href="/contact" class="btn btn-primary btn-lg">Contact Us</a>
                </div>
            </section>
        </div>
    </div>
@endsection
