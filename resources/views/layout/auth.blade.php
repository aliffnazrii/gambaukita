<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'default title')</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/favicon.png">
    <link href="../../assets/plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <script src="../js/modernizr-3.6.0.min.js"></script>
</head>

<style>
    .footer {
        width: 100%;
        padding: 20px 0;
        /* Optional: Add some padding for better spacing */
        position: relative;
        bottom: 0;
    }
</style>

<body class="v-light horizontal-nav">
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3"
                    stroke-miterlimit="10" />
            </svg>
        </div>
    </div>

    {{-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">GambauKita.my</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/"><i class="mdi mdi-home"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/about"><i class="mdi mdi-information"></i> About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('packages.index')}}"><i class="mdi mdi-book-open"></i> Catalogue</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/"><i class="mdi mdi-email"></i> Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav> --}}
    <!-- header -->
    <div class="header" style="z-index:10;">
        <div class="nav-header">
            <div class="brand-logo"><a href="/main-home"><b><img src="../../assets/images/logo.png" alt="">
                    </b><span class="brand-title">GambauKita.my</span></a>
            </div>
            <div class="nav-control">
                <div class="hamburger"><span class="line"></span> <span class="line"></span> <span
                        class="line"></span>
                </div>
            </div>
        </div>
        <div class="header-content">

            <div class="header-right">
                <ul>
                    <div class="icons"><a href="javascript:void(0)"><i class="mdi mdi-account f-s-20"
                                aria-hidden="true"></i></a>
                        <div class="drop-down dropdown-profile animated bounceInDown">
                            <div class="dropdown-content-body">
                                <ul>
                                    <li class="nav-item"><a class="nav-link" href="#"><i
                                                class="mdi mdi-email"></i>Inbox</a>
                                    </li>
                                    @guest
                                        @if (Route::has('login'))
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                            </li>
                                        @endif

                                        @if (Route::has('register'))
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                            </li>
                                        @endif
                                    @else
                                        <li class="nav-item">
                                            <a id="nav-link" class="nav-link" href="/profile" role="button"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                <i class="mdi mdi-account"></i>
                                                {{ Auth::user()->name }}
                                            </a>
                                        </li>

                                        <li class="nav-item">

                                            <a class="nav-link" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                                <i class="icon-power"></i>
                                                {{ __('Logout') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        </li>



                                    </ul>
                                @endguest
                            </div>
                        </div>
                </ul>
            </div>
        </div>
    </div>

    <!-- #/ header -->
    <!-- sidebar -->
    <div class="nk-sidebar" style="z-index:5;">
        <div class="nk-nav-scroll">
            <ul class="metismenu" id="menu">
                <li class="nav-label">Main</li>

                <li><a href="/"><i class="mdi mdi-home"></i> <span class="nav-text">Home</span></a></li>


                <li><a href="{{ route('packages.index') }}"><i class="mdi mdi-book-open"></i> <span
                            class="nav-text">Packages</span></a></li>


                <li><a
                        @auth()
                            href="{{ route('bookings.create') }}"
                            @else
                            href="/login"
                            @endauth><i
                            class="mdi mdi-calendar-check"></i> <span class="nav-text">Booking</span></a></li>

                <li><a
                        @auth()
                            href="{{ route('bookings.index') }}"
                            @else
                            href="/login"
                            @endauth><i
                            class="mdi mdi-history"></i> <span class="nav-text">History</span></a></li>
                <li><a href="{{ route('portfolios.index') }}"><i class="mdi mdi-image-multiple"></i> <span
                            class="nav-text">Portfolios</span></a>


                <li><a href="/about"><i class="mdi mdi-information"></i> <span class="nav-text">About Us</span></a>
                </li>
                <li><a
                        @auth()
                                href="{{ route('users.show', AUTH::user()->id) }}"
                                @else
                                href="/login"
                                @endauth><i
                            class="mdi mdi-account"></i> <span class="nav-text">Profile</span></a></li>
                <!-- <li><a href="/login"><i class="mdi mdi-login"></i> <span class="nav-text">Login</span></a></li> -->
            </ul>
        </div>
        <!-- #/ nk nav scroll -->
    </div>


    <!-- content body -->
    <div class="content-body">
        <div class="card card-body">
            @yield('content')
        </div>

        <!-- #/ content body -->
        <!-- footer -->


        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Useful Links</h5>
                        <ul class="list-unstyled">
                            <li><a href="/about">About Us</a></li>
                            <li><a href="/bookings/create">Bookings</a></li>
                            <li><a href="/packages">Packages</a></li>
                            <li><a href="/portfolios">Portfolio</a></li>
                            @auth
                                <li><a href="/users/{{ Auth::user()->id ?? '' }}">Profile</a></li>
                            @else
                                <li><a href="/login}}">Profile</a></li>

                            @endauth
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h5>Contact Us</h5>
                        <p>Email: support@gambaukita.com</p>
                        <p>Phone: +6018-9839423</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p class="text-left">&copy; 2023 GambauKita. All rights reserved.</p>
                    </div>
                </div>
            </div>

        </footer>
    </div>

    <!-- #/ footer -->
    </div>
    <!-- Common JS -->
    <script src="../../assets/plugins/common/common.min.js"></script>
    <!-- Custom script -->
    <script src="../js/custom.min.js"></script>
    <!-- Chartjs chart -->
    <script src="../../assets/plugins/chartjs/Chart.bundle.js"></script>
    <!-- Custom dashboard script -->
    <script src="../js/dashboard-1.js"></script>


    <!-- Common JS -->
    <!-- <script src="../../assets/plugins/common/common.min.js"></script> -->
    <!-- Custom script -->
    <!-- <script src="../js/custom.min.js"></script> -->
    <script src="../../assets/plugins/tables/js/jquery.dataTables.min.js"></script>
    <script src="../../assets/plugins/tables/js/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="../../assets/plugins/tables/js/datatable-init/datatable-basic.min.js"></script>
</body>

</html>
