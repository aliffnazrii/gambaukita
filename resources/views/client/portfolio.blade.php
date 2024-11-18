@extends('layout.client')

@section('title', 'Portfolio')

@section('content')

    <style>
        /* You can add custom styles here */
    </style>

    <div class="card card-body ">
        <h1 class="text-center m-5">Photographers' Masterpieces</h1>
        <div class="col-md-9 m-auto">
            <div class="row text-center p-5">

                @foreach ($portfolios as $portfolio)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 border border-2">
                            @if ($portfolio->image_url)
                                <img src="{{ $portfolio->image_url }}" alt="Portfolio Image"
                                    class="card-img-top m-auto border-bottom">
                            @else
                                <img src="https://via.placeholder.com/300" class="card-img-top">
                            @endif
                            <div class="card-body">
                                <h4 class="card-title text-center">{{ $portfolio->title }}</h4>
                                <p class="card-text">{{ Str::limit($portfolio->description, 100) }}</p>
                                <div class="text-center">
                                    <h5>By: {{ $portfolio->user->name }}</h5>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <button type="button" class="btn btn-primary btn-md" data-toggle="modal"
                                data-target="#basicModal{{ $portfolio->id }}">View</button>
                               
                            </div>
                        </div>
                    </div>


                 
                    <!--  Modal -->
                    <div class="modal fade" id="basicModal{{ $portfolio->id }}">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ $portfolio->title }}</h5>
                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @if ($portfolio->image_url)
                                        <img src="{{ $portfolio->image_url }}" alt="Portfolio Image"
                                            class="img-fluid mb-3">
                                    @else
                                        <img src="https://via.placeholder.com/300" class="img-fluid mb-3">
                                    @endif
                                    <p>{{ $portfolio->description }}</p>
                                    <h5>By: {{ $portfolio->user->name }}</h5>
                                </div>
                                <div class="modal-footer">

                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>



                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

@endsection
