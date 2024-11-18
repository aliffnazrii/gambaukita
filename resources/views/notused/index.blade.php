@extends('layout.client')


@section('title', 'GambauKita.my')

@section('content')

<div class="container">

    <div class="row">
        <div class="col-lg-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="active-member">
                        <div class="table-responsive">
                            <table class="table table-xs">
                                <thead>
                                    <tr>
                                        <th>Top Active Members</th>
                                        <th>Views</th>
                                        <th>Country</th>
                                        <th>Status</th>
                                        <th>Comments</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <img src="../../assets/images/avatar/1.jpg" class="w-40px rounded-circle m-r-10" alt="">Arden Karn
                                        </td>
                                        <td><span>125</span>
                                        </td>
                                        <td>United States</td>
                                        <td><i class="fa fa-circle-o text-success f-s-12 m-r-10"></i> Active</td>
                                        <td><span>84</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="../../assets/images/avatar/2.jpg" class="w-40px rounded-circle m-r-10" alt="">Arden Karn
                                        </td>
                                        <td><span>547</span>
                                        </td>
                                        <td>Canada</td>
                                        <td><i class="fa fa-circle-o text-success f-s-12 m-r-10"></i> Active</td>
                                        <td><span>36</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="../../assets/images/avatar/3.jpg" class="w-40px rounded-circle m-r-10" alt="">Arden Karn
                                        </td>
                                        <td><span>557</span>
                                        </td>
                                        <td>Germany</td>
                                        <td><i class="fa fa-circle-o text-danger f-s-12 m-r-10"></i> Inactive</td>
                                        <td><span>55</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="../../assets/images/avatar/4.jpg" class="w-40px rounded-circle m-r-10" alt="">Arden Karn
                                        </td>
                                        <td><span>753</span>
                                        </td>
                                        <td>England</td>
                                        <td><i class="fa fa-circle-o text-success f-s-12 m-r-10"></i> Active</td>
                                        <td><span>45</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="../../assets/images/avatar/5.jpg" class="w-40px rounded-circle m-r-10" alt="">Arden Karn
                                        </td>
                                        <td><span>453</span>
                                        </td>
                                        <td>China</td>
                                        <td><i class="fa fa-circle-o text-danger f-s-12 m-r-10"></i> Inactive</td>
                                        <td><span>63</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src="../../assets/images/avatar/6.jpg" class="w-40px rounded-circle m-r-10" alt="">Arden Karn
                                        </td>
                                        <td><span>658</span>
                                        </td>
                                        <td>Japan</td>
                                        <td><i class="fa fa-circle-o text-success f-s-12 m-r-10"></i> Active</td>
                                        <td><span>38</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <img src="../../assets/images/users/2.jpg" class="rounded-circle m-t-15 w-75px" alt="">
                        <h4 class="m-t-15 m-b-2">Paul Custard</h4>
                        <p class="text-muted">Web Developer</p>
                        <ul class="list-inline m-t-15">
                            <li class="list-inline-item"><a href="#"><i class="fa fa-facebook-square f-s-20 text-muted"></i></a>
                            </li>
                            <li class="list-inline-item"><a href="#"><i class="fa fa-twitter f-s-20 text-muted"></i></a>
                            </li>
                            <li class="list-inline-item"><a href="#"><i class="fa fa-pinterest f-s-20 text-muted"></i></a>
                            </li>
                            <li class="list-inline-item"><a href="#"><i class="fa fa-linkedin f-s-20 text-muted"></i></a>
                            </li>
                        </ul>
                        <div class="row">
                            <div class="col-12 border-bottom-1 p-t-20 p-b-10"><span class="pull-left f-w-600">Name:</span> <span class="pull-right">Bob Springer</span>
                            </div>
                            <div class="col-12 border-bottom-1 p-t-10 p-b-10"><span class="pull-left f-w-600">Email:</span> <span class="pull-right">example@examplel.com</span>
                            </div>
                            <div class="col-12 p-t-10 p-b-10"><span class="pull-left f-w-600">Phone:</span> <span class="pull-right">+12 123 124 125</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Activity Timeline</h4>
                    <div class="timeline-">
                        <ul class="timeline">
                            <li>
                                <div class="timeline-badge primary"></div><a href="#" class="timeline-panel text-muted"><span>10 minutes ago</span>
                                    <h6 class="m-t-5">Youtube, a video-sharing website, goes live.</h6>
                                </a>
                            </li>
                            <li>
                                <div class="timeline-badge warning"></div><a href="#" class="timeline-panel text-muted"><span>20 minutes ago</span>
                                    <h6 class="m-t-5">Mashable, a news website and blog, goes live.</h6>
                                </a>
                            </li>
                            <li>
                                <div class="timeline-badge danger"></div><a href="#" class="timeline-panel text-muted"><span>30 minutes ago</span>
                                    <h6 class="m-t-5">Google acquires Youtube.</h6>
                                </a>
                            </li>
                            <li>
                                <div class="timeline-badge success"></div><a href="#" class="timeline-panel text-muted"><span>15 minutes ago</span>
                                    <h6 class="m-t-5">StumbleUpon is acquired by eBay.</h6>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <img src="../../assets/images/users/1.jpg" class="rounded-circle m-t-10 w-50px" alt="">
                        <h6 class="f-w-500 m-t-15">Bob Springer</h6>
                        <p class="m-b-0 f-s-12">Status: <strong>Online</strong>
                        </p>
                        <p class="m-b-0 f-s-12">Response Time: <strong>3 Hours</strong>
                        </p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <img src="../../assets/images/users/2.jpg" class="rounded-circle m-t-10 w-50px" alt="">
                        <h6 class="f-w-500 m-t-15">Bob Springer</h6>
                        <p class="m-b-0 f-s-12">Status: <strong>Online</strong>
                        </p>
                        <p class="m-b-0 f-s-12">Response Time: <strong>3 Hours</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- #/ container -->
@endsection