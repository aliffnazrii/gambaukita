<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'default title')</title>
    <!-- Favicon icon -->

    <link rel="icon" type="image/png" sizes="16x16" href=" {{ URL::asset('assets/images/favicon.png') }}">
    <link href=" {{ URL::asset('assets/plugins/tables/css/datatable/dataTables.bootstrap4.min.css') }}"
        rel="stylesheet">
    <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet">
    <script src=" {{ URL::asset('js/modernizr-3.6.0.min.js') }}"></script>
    @yield('header')
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

    <!-- header -->
    <div class="header" style="z-index:10;">
        <div class="nav-header">
            <div class="brand-logo"><a href="/main-home"><b><img src="{{ URL::asset('assets/images/logo.png') }}"
                            alt="">
                    </b><span class="brand-title">GambauKita.com</span></a>
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
                            <div class="dropdown-content-heading"><span class="text-left">Recent Notifications</span>
                            </div>
                            <div class="dropdown-content-body">
                                <ul>
                                    <li>
                                        <a href="#">
                                            <img class="pull-left m-r-10 avatar-img"
                                                src="{{ URL::asset('assets/images/avatar/1.jpg') }}" alt="">
                                            <div class="notification-content"><small
                                                    class="notification-timestamp pull-right">02:34 PM</small>
                                                <div class="notification-heading">Mr. Dmitry</div>
                                                <div class="notification-text">5 members joined today</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img class="pull-left m-r-10 avatar-img"
                                                src="{{ URL::asset('assets/images/avatar/1.jpg') }}" alt="">
                                            <div class="notification-content"><small
                                                    class="notification-timestamp pull-right">02:34 PM</small>
                                                <div class="notification-heading">Mariam</div>
                                                <div class="notification-text">likes a photo of you</div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img class="pull-left m-r-10 avatar-img"
                                                src="{{ URL::asset('assets/images/avatar/1.jpg') }}" alt="">
                                            <div class="notification-content"><small
                                                    class="notification-timestamp pull-right">02:34 PM</small>
                                                <div class="notification-heading">Tasnim</div>
                                                <div class="notification-text">Hi Teddy, Just wanted to let you ...
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img class="pull-left m-r-10 avatar-img"
                                                src="{{ URL::asset('assets/images/avatar/1.jpg') }}" alt="">
                                            <div class="notification-content"><small
                                                    class="notification-timestamp pull-right">02:34 PM</small>
                                                <div class="notification-heading">Ishrat Jahan</div>
                                                <div class="notification-text">Hi Teddy, Just wanted to let you ...
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="text-center"><a href="#" class="more-link">See All</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="icons"><a href="javascript:void(0)"><i class="mdi mdi-comment f-s-18"
                                aria-hidden="true"></i>
                            <div class="pulse-css"></div>
                        </a>
                        <div class="drop-down animated bounceInDown">
                            <div class="dropdown-content-heading"><span class="text-left">2 New Messages</span>
                            </div>
                            <div class="dropdown-content-body">
                                <ul>

                                    <li class="notification-unread">
                                        <a href="#">
                                            <img class="pull-left m-r-10 avatar-img"
                                                src="{{ URL::asset('assets/images/avatar/1.jpg') }}" alt="">
                                            <div class="notification-content"><small
                                                    class="notification-timestamp pull-right">02:34 PM</small>
                                                <div class="notification-heading">Ishrat Jahan</div>
                                                <div class="notification-text">Hi Teddy, Just wanted to let you ...
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img class="pull-left m-r-10 avatar-img"
                                                src="{{ URL::asset('assets/images/avatar/1.jpg') }}" alt="">
                                            <div class="notification-content"><small
                                                    class="notification-timestamp pull-right">02:34 PM</small>
                                                <div class="notification-heading">Saiul Islam</div>
                                                <div class="notification-text">Hi Teddy, Just wanted to let you ...
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img class="pull-left m-r-10 avatar-img"
                                                src="{{ URL::asset('assets/images/avatar/1.jpg') }}" alt="">
                                            <div class="notification-content"><small
                                                    class="notification-timestamp pull-right">02:34 PM</small>
                                                <div class="notification-heading">Ishrat Jahan</div>
                                                <div class="notification-text">Hi Teddy, Just wanted to let you ...
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="text-center"><a href="#" class="more-link">See All</a>
                                    </li>
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
                                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
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
                                            <a id="nav-link" class="nav-link" href="/profile" role="button"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                v-pre>
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
                <li><a href="{{ route('portfolios.index') }}"><i class="mdi mdi-camera"></i> <span
                            class="nav-text">Portfolio</span></a></li>

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
                <li><a
                        @auth()
                                    href="{{ route('users.show', AUTH::user()->id) }}"
                                    @else
                                    href="/login"
                                    @endauth><i
                            class="mdi mdi-account"></i> <span class="nav-text">Profile</span></a></li>
                <li><a href="/about"><i class="mdi mdi-information"></i> <span class="nav-text">About Us</span></a>
                </li>
                <!-- <li><a href="/login"><i class="mdi mdi-login"></i> <span class="nav-text">Login</span></a></li> -->
            </ul>
        </div>
        <!-- #/ nk nav scroll -->
    </div>
    <!-- #/ sidebar -->
    <!-- content body -->
    <div class="content-body">
        @yield('content')
    </div>
    <!-- #/ content body -->
    <!-- footer -->
    <!-- <div class="footer">
            <div class="copyright">
                <p>Copyright &copy; <a href="">GambauKita</a> 2024, by <a href="" target="_blank">aliffnazrii</a></p>
            </div>
        </div> -->

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

    <!-- Common JS -->
    <script src="{{ URL::asset('assets/plugins/common/common.min.js') }}"></script>
    <!-- Custom script -->
    <script src="{{ URL::asset('js/custom.min.js') }}"></script>
    <!-- Chartjs chart -->
    <script src="{{ URL::asset('assets/plugins/chartjs/Chart.bundle.js') }}"></script>
    <!-- Custom dashboard script -->
    <script src="{{ URL::asset('js/dashboard-1.js') }}"></script>



    <!-- Common JS -->
    <!-- <script src="../../assets/plugins/common/common.min.js"></script> -->
    <!-- Custom script -->
    <!-- <script src="../js/custom.min.js"></script> -->
    <script src="{{ URL::asset('assets/plugins/tables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/tables/js/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/tables/js/datatable-init/datatable-basic.min.js') }}"></script>
</body>

</html>
