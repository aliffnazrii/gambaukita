@extends('layout.owner')

@section('title', 'Dashboard')

@section('content')


    <div class="row mt-3">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4>Active Users <span class="pull-right"><i class="ion-android-download f-s-30 text-primary"></i></span>
                    </h4>
                    <h6 class="m-t-20 f-s-14">50% Complete</h6>
                    <div class="progress m-t-0 h-7px">
                        <div role="progressbar" class="progress-bar bg-primary wow animated progress-animated w-50pc h-7px">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4>Booking made <span class="pull-right"><i class="ion-android-upload f-s-30 text-success"></i></span></h4>
                    <h6 class="m-t-20 f-s-14">90% Complete</h6>
                    <div class="progress m-t-0 h-7px">
                        <div role="progressbar" class="progress-bar bg-success wow animated progress-animated w-90pc h-7px">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4>Packages <span class="pull-right"><i class="ion-android-list f-s-30 text-danger"></i></span></h4>
                    <h6 class="m-t-20 f-s-14">65% Ticket Checked</h6>
                    <div class="progress m-t-0 h-7px">
                        <div role="progressbar" class="progress-bar bg-danger wow animated progress-animated w-65pc h-7px">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-7">
            <div class="card">
                <div class="card-body">
                    <h4 class=" card-title">Monthly Income</h4>
                    <div class="f-s-30 f-w-300 text-success">3500 <span class="f-s-16 text-uppercase">MYR</span>
                    </div>
                 
                    <canvas id="sales-graph-top"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Messages</h4>
                    <div class="media border-bottom-1 p-t-15 p-b-15">
                        <img src="../../assets/images/avatar/1.jpg" class="mr-3 rounded-circle" alt="">
                        <div class="media-body">
                            <h5>John Tomas</h5>
                            <p class="m-b-0">I shared this on my fb wall a few months back,</p>
                        </div><span class="text-muted f-s-12">April 24, 2018</span>
                    </div>
                    <div class="media border-bottom-1 p-t-15 p-b-15">
                        <img src="../../assets/images/avatar/2.jpg" class="mr-3 rounded-circle" alt="">
                        <div class="media-body">
                            <h5>John Tomas</h5>
                            <p class="m-b-0">I shared this on my fb wall a few months back,</p>
                        </div><span class="text-muted f-s-12">April 24, 2018</span>
                    </div>
                    <div class="media p-t-15 p-b-15">
                        <img src="../../assets/images/avatar/3.jpg" class="mr-3 rounded-circle" alt="">
                        <div class="media-body">
                            <h5>John Tomas</h5>
                            <p class="m-b-0">I shared this on my fb wall a few months back,</p>
                        </div><span class="text-muted f-s-12">April 24, 2018</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-body">
                    <h2 class="f-s-30 m-b-0">$6,932.60</h2><span class="f-w-600">Total Revenue</span>
                    <div class="m-t-30">
                        <h4 class="f-w-600">2,365</h4>
                        <h6 class="m-t-10 text-muted">Online Earning <span class="pull-right">70%</span></h6>
                        <div class="progress m-t-15 h-6px">
                            <div class="progress-bar bg-primary wow animated progress-animated w-70pc h-6px"
                                role="progressbar"></div>
                        </div>
                    </div>
                    <div class="m-t-20 m-b-20">
                        <h4 class="f-w-600">1,250</h4>
                        <h6 class="m-t-10">Offline Earning <span class="pull-right">50%</span></h6>
                        <div class="progress m-t-15 h-6px">
                            <div class="progress-bar bg-success wow animated progress-animated w-50pc h-6px"
                                role="progressbar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      
    </div>

@endsection
