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
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="https://via.placeholder.com/1792x600/ff7f7f" alt="First slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h3>Capture Your Perfect Moments</h3>
                        <p>Professional Photography Services for Every Occasion</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="https://via.placeholder.com/1792x600/85e085" alt="Second slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h3>Memories to Last a Lifetime</h3>
                        <p>Expert Photography Tailored Just for You</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="https://via.placeholder.com/1792x600/7fbfff" alt="Third slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h3>Stunning Visuals, Incredible Stories</h3>
                        <p>Experience Creativity Through the Lens</p>
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
                <p class="lead">We specialize in capturing your most precious moments and turning them into memories that will last a lifetime. Whether you're celebrating a wedding, a birthday, or a special family event, our professional photographers are here to deliver exceptional service with stunning results.</p>
            </div>
        </section>

        <!-- Photo Packages Section -->
        <section class="photo-packages py-5 bg-light">
            <div class="container">
                <h2 class="text-center mb-5">Our Photo Packages</h2>
                <div class="row">
                    <!-- Basic Package -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            <img class="card-img-top" src="https://via.placeholder.com/400x300/ffcccb" alt="Basic Package">
                            <div class="card-body">
                                <h4 class="card-title text-center">Basic Package</h4>
                                <p class="card-text">A great option for small events, portraits, or personal photoshoots.</p>
                                <ul>
                                    <li>2 hours of photography</li>
                                    <li>30 edited photos</li>
                                    <li>Online gallery access</li>
                                </ul>
                                <div class="text-center">
                                    <h5>RM 500</h5>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <a href="/book-basic" class="btn btn-primary">Book Now</a>
                            </div>
                        </div>
                    </div>
                    <!-- Standard Package -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            <img class="card-img-top" src="https://via.placeholder.com/400x300/90ee90" alt="Standard Package">
                            <div class="card-body">
                                <h4 class="card-title text-center">Standard Package</h4>
                                <p class="card-text">Ideal for family events, birthdays, or small weddings.</p>
                                <ul>
                                    <li>4 hours of photography</li>
                                    <li>60 edited photos</li>
                                    <li>Photo album (20 pages)</li>
                                    <li>Online gallery access</li>
                                </ul>
                                <div class="text-center">
                                    <h5>RM 1000</h5>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <a href="/book-standard" class="btn btn-primary">Book Now</a>
                            </div>
                        </div>
                    </div>
                    <!-- Premium Package -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            <img class="card-img-top" src="https://via.placeholder.com/400x300/87cefa" alt="Premium Package">
                            <div class="card-body">
                                <h4 class="card-title text-center">Premium Package</h4>
                                <p class="card-text">Perfect for large events like weddings and corporate gatherings.</p>
                                <ul>
                                    <li>Full day of photography</li>
                                    <li>100 edited photos</li>
                                    <li>Luxury photo album (50 pages)</li>
                                    <li>USB with all high-resolution photos</li>
                                    <li>Online gallery access</li>
                                </ul>
                                <div class="text-center">
                                    <h5>RM 2000</h5>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <a href="/book-premium" class="btn btn-primary">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Us Section -->
        <section class="contact-us py-5 text-center">
            <div class="container">
                <h2>Get in Touch</h2>
                <p class="lead">Have questions or need more information about our packages? We're here to help! Contact us to discuss your photography needs.</p>
                <a href="/contact" class="btn btn-primary btn-lg">Contact Us</a>
            </div>
        </section>
    </div>
</div>
@endsection