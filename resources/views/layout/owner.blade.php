<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'default title')</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::asset('assets/images/favicon.png') }}">
    <link href="{{ URL::asset('assets/plugins/tables/css/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet">

    <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet">
    <script src="{{ URL::asset('js/modernizr-3.6.0.min.js') }}"></script>

    @yield('style')

</head>

<body class="v-light horizontal-nav">
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3"
                    stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <div id="main-wrapper">
        <!-- header -->
        <div class="header" style="z-index:10;">
            <div class="nav-header">
                <div class="brand-logo"><a href="/main-home"><b><img src="{{ URL::asset('assets/images/logo.png') }}"
                                alt="">
                        </b><span class="brand-title">GKAdmin</span></a>
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
                        <li class="icons"><a href="javascript:void(0)"><i class="mdi mdi-bell f-s-18"
                                    aria-hidden="true"></i>
                                <div class="pulse-css"></div>
                            </a>
                            <div class="drop-down animated bounceInDown">
                                <div class="dropdown-content-heading"><span class="text-left">Recent
                                        Notifications</span>
                                </div>
                                <div class="dropdown-content-body">
                                    <ul>

                                        @if (auth()->user()->notifications->count() > 0)
                                            @foreach (auth()->user()->notifications->take(5) as $notification)
                                                <li>
                                                    <a href="{{ $notification->data['url'] }}">
                                                        <img class="pull-left m-r-10 avatar-img"
                                                            src="{{ asset('storage/images/logo.png') }}"
                                                            style="max-height: 50px; max-width: 50px;" alt="">
                                                        <div class="notification-content"><small
                                                                class="notification-timestamp pull-right">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</small>
                                                            <div class="notification-heading">
                                                                {{ $notification->data['title'] }}</div>
                                                            <div class="notification-text">
                                                                {{ $notification->data['message'] }}
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                            @endforeach
                                        @else
                                            <div class="text-center">
                                                <strong>No notifications</strong>
                                            </div>
                                        @endif


                                    </ul>
                                </div>
                            </div>
                        </li>


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
                                                    <a class="nav-link"
                                                        href="{{ route('login') }}">{{ __('Login') }}</a>
                                                </li>
                                            @endif

                                            @if (Route::has('register'))
                                                <li class="nav-item">
                                                    <a class="nav-link"
                                                        href="{{ route('register') }}">{{ __('Register') }}</a>
                                                </li>
                                            @endif
                                        @else
                                            <li class="nav-item">
                                                <a id="nav-link" class="nav-link" href="{{ route('owner.profile') }}"
                                                    role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false" v-pre>
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

                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/owner/dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('owner.booking') }}">Bookings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('owner.viewClients') }}">Clients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('owner.package') }}">Packages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('owner.schedule') }}">Schedule</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('owner.profile') }}">Profile</a>
                    </li>



                </ul>
            </div>
            <!-- #/ nk nav scroll -->
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('failed'))
            <div class="alert alert-danger">{{ session('failed') }}</div>
        @endif
        <!-- #/ sidebar -->
        <!-- content body -->
        <div class="content-body">
            @yield('content')
        </div>


        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Useful Links</h5>
                        <ul class="list-unstyled">
                            <li><a href="/privacy-policy">Privacy Policy</a></li>
                            <li><a href="/terms-of-service">Terms of Service</a></li>
                            <li><a href="/faq">FAQ</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h5>Contact Us</h5>
                        <p>Email: support@gambaukita.com</p>
                        <p>Phone: +123 456 7890</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <p class="text-left">&copy; 2023 GambauKita. All rights reserved.</p>
                    </div>
                </div>
            </div>

        </footer>
        <!-- #/ footer -->
    </div>
    <!-- Common JS -->
    <script src="{{ asset('assets/plugins/common/common.min.js') }}"></script>
    <!-- Custom script -->
    <script src="{{ asset('js/custom.min.js') }}"></script>
    <!-- Chartjs chart -->
    <script src="{{ asset('assets/plugins/chartjs/Chart.bundle.js') }}"></script>
    <!-- Custom dashboard script -->
    <script src="{{ asset('js/dashboard-1.js') }}"></script>

    <!-- Common JS -->
    <!-- <script src="{{ asset('assets/plugins/common/common.min.js') }}"></script> -->
    <!-- Custom script -->
    <!-- <script src="{{ asset('js/custom.min.js') }}"></script> -->
    <script src="{{ asset('assets/plugins/tables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/tables/js/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/tables/js/datatable-init/datatable-basic.min.js') }}"></script>
</body>

</html>
