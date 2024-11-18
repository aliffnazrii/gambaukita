<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/logo/logo.jpg">
    <link rel="stylesheet" href="style.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <!-- Cropper.js CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Google Font -->
    <link href='https://fonts.googleapis.com/css?family=Lato:400,700,900' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Bree+Serif' rel='stylesheet' type='text/css'>

    <!-- all css here -->
    <!-- bootstrap v3.3.6 css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- animate css -->
    <link rel="stylesheet" href="css/animate.min.css">
    <!-- jquery-ui.min css -->
    <link rel="stylesheet" href="css/jquery-ui.min.css">
    <!-- meanmenu css -->
    <link rel="stylesheet" href="css/meanmenu.min.css">
    <!-- nivo-slider css -->
    <link rel="stylesheet" href="lib/css/nivo-slider.css">
    <link rel="stylesheet" href="lib/css/preview.css">
    <!-- slick css -->
    <link rel="stylesheet" href="css/slick.min.css">
    <!-- lightbox css -->
    <link rel="stylesheet" href="css/lightbox.min.css">
    <!-- material-design-iconic-font css -->
    <link rel="stylesheet" href="css/material-design-iconic-font.css">
    <!-- All common css of theme -->
    <link rel="stylesheet" href="css/default.css">
    <!-- style css -->
    <link rel="stylesheet" href="style.min.css">
    <!-- shortcode css -->
    <link rel="stylesheet" href="css/shortcode.css">
    <!-- responsive css -->
    <link rel="stylesheet" href="css/responsive.css">
    <!-- modernizr css -->
    <script src="js/vendor/modernizr-3.11.2.min.js"></script>


    <!-- Link your provided CSS file -->
    @yield('style')

    <style>
        body,
        html {
            height: 100%;
            background-color: #e3e3e3;
        }

        .main-content {
            margin: 30px;
            background-color: #fffafa;
        }

        .card {
            background-color: #ffffff;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.1);
        }

        .card h3 {
            font-size: 20px;
            color: #434343;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->

    <nav class="navbar sticky-top navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/owner">GambauKita</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/owner/dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{route('owner.booking')}}">Bookings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{route('owner.package')}}">Packages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('owner.schedule')}}">Schedule</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('owner.portfolio') }}">Portfolios</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Account
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('owner.profile')}}">Profile</a></li>
                            <li><a class="dropdown-item" href="/logout">Logout</a></li>
                            {{-- <li>
                                <hr class="dropdown-divider">
                            </li> --}}

                        </ul>
                    </li>

                </ul>

            </div>
        </div>
    </nav>


    {{-- <div class="sidebar" style="background-color:rgb(233, 233, 233)">
        <ul>
            <li><a href="/owner">Dashboard</a></li>
            <li><a href="/all-booking">Booking</a></li>
            <li><a href="/owner-profile">Profile</a></li>
            <li><a href="/all-catalogue">Catalogue</a></li>
            <li><a href="/offday">OffDay Application</a></li>
            <li><a href="{{ route('portfolios.index') }}">Portfolio</a></li>
            <li><a href="/logout">Logout</a></li>
        </ul>
    </div> --}}

    <!-- Header -->
    {{-- <div class="header" style="z-index: 999;">
        <h2>@yield('title', 'Default Title')</h2>
    </div> --}}

    <!-- Main Content -->
    <main>

        @yield('content')

    </main>


</body>

</html>


{{--
@extends('layout.owner-app')

@section('title', 'GambauKita')



@section('style')


@endsection

@section('content')


@endsection



--}}
