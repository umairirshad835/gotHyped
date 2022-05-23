@extends('layouts.app')

@section('content')
    <style>
        .carousel-img {
            height:400px;
            width: 300px;
        }

        .list-img {
            height:100px;
        }
    </style>
    <!-- CONTAINER -->
    <div class="main-container container-fluid">

        <!-- PAGE-HEADER -->
        <div class="page-header">
            <h1 class="page-title">Auction Report</h1>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- ROW-3 for Completed Auctions-->
        @if($product->auction_status == 2)
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="row row-sm">
                            <div class="col-xl-5 col-lg-12 col-md-12">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="product-carousel">
                                            <div id="Slider" class="carousel slide border" data-bs-ride="false">
                                                <div class="carousel-inner">
                                                    <div class="carousel-item active"><img src="{{asset($product->image1)}}" alt="img" class="img-fluid mx-auto d-block carousel-img">
                                                        <div class="text-center mt-5 mb-5 btn-list"></div>
                                                        </div>
                                                        @if($product->image2)
                                                    <div class="carousel-item"> <img src="{{asset($product->image2)}}" alt="img" class="img-fluid mx-auto d-block carousel-img">
                                                        <div class="text-center mb-5 mt-5 btn-list"></div>
                                                    </div>
                                                    @endif
                                                    @if($product->image3)
                                                    <div class="carousel-item"> <img src="{{asset($product->image3)}}" alt="img" class="img-fluid mx-auto d-block carousel-img">
                                                        <div class="text-center  mb-5 mt-5 btn-list"></div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix carousel-slider">
                                            <div id="thumbcarousel" class="carousel slide" data-bs-interval="t">
                                                <div class="carousel-inner">
                                                    <ul class="carousel-item active">
                                                        <li data-bs-target="#Slider" data-bs-slide-to="0" class="thumb active m-2"><img src="{{asset($product->image1)}}" alt="img" class="list-img"></li>
                                                        @if($product->image2)
                                                        <li data-bs-target="#Slider" data-bs-slide-to="1" class="thumb m-2"><img src="{{asset($product->image2)}}" alt="img" class="list-img"></li>
                                                        @endif
                                                        @if($product->image3)
                                                        <li data-bs-target="#Slider" data-bs-slide-to="2" class="thumb m-2"><img src="{{asset($product->image3)}}" alt="img" class="list-img"></li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="details col-xl-7 col-lg-12 col-md-12 mt-4 mt-xl-0">
                                <div class="mt-2 mb-4">
                                    <h3 class="mb-3 fw-semibold"> {{$product->name}} </h3>

                                    <h4 class="mt-4"><b> Description</b></h4>
                                    <p>{{$product->description}}</p>
            
                                    <div class=" mt-4 mb-5"><span class="fw-bold me-2">Actual Price :</span><span class="fw-bold text-success">${{$product->actual_price}}</span></div>

                                    <div class=" mt-4 mb-5"><span class="fw-bold me-2">Market Price :</span><span class="fw-bold text-success">${{$product->market_price}}</span></div>

                                    <div class=" mt-4 mb-5"><span class="fw-bold me-2">Auction Price :</span><span class="fw-bold text-success">${{$product->auction_price}}</span></div>
                                    
                                    <div class=" mt-4 mb-5"><span class="fw-bold me-2">Sizes :</span>

                                    @foreach($sizenames as $name)
                                        <span class="fw-bold text-success">{{$name->name}}@if ( ! $loop->last),@endif </span>
                                    @endforeach
                                    
                                    </div>

                                    <div class=" mt-4 mb-5"><span class="fw-bold me-2">Category :</span><span class="fw-bold text-success">{{$product->category->name ?? ''}}</span></div>
                                    <div class=" mt-4 mb-5"><span class="fw-bold me-2">Auction Time :</span><span class="fw-bold text-success">{{ \Carbon\Carbon::createFromTimestamp(strtotime($product->auction_time))->format('Y-m-d H:i:s A')}}</span></div>

                                    @if($product->status == 1 )
                                    <div class=" mt-4 mb-5"><span class="fw-bold me-2">Product Status :</span><span class="fw-bold text-success">Approved</span></div>
                                    @else
                                    <div class=" mt-4 mb-5"><span class="fw-bold me-2">Status :</span><span class="fw-bold text-success">Unapproved</span></div>
                                    @endif

                                    @if($product->auction_status == 2 )
                                    <div class=" mt-4 mb-5"><span class="fw-bold me-2">Auction Status :</span><span class="fw-bold text-success">Completed</span></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Winner Details of Product or Auction -->
                <div class="col-xl-12">
                    <div class="card" id="active-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">{{$product->name}} Preview</h3>
                        </div>
                        <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table border text-nowrap text-md-nowrap mb-0">
                                        <thead style="background-color:#5ba9dc;">
                                            <tr>
                                                <th style="color:white;">#</th>
                                                <th style="color:white;">User</th>
                                                <th style="color:white;">Role</th>
                                                <th style="color:white;">winner</th>
                                                <th style="color:white;">Bid Used</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($completeview as $key => $complete)
                                                <tr>
                                                    <td>{{++$key}}</td>
                                                    <td>{{$complete->users->first()->name}}</td>
                                                    <td>{{$complete->users->first()->roles}}</td>
                                                    <td>
                                                        @if($winner->user_id == $complete->user_id )
                                                            <span class="text-success"> &nbsp(Won)</span>
                                                        @else
                                                        <span class="text-danger"> &nbsp(Lost)</span>
                                                        @endif
                                                    </td>
                                                    <td>{{$complete->bid_used}}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <th colspan="4"><h4>Total Bids</h4></th>
                                                <td>{{$winner->total_bids}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                {{$completeview->links()}}
                                <br>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- ROW-3 CLOSED -->

    </div>
    <!-- CONTAINER CLOSED -->

@endsection('content')