@extends('layouts.app')

@section('content')

    <!-- CONTAINER -->
    <div class="main-container container-fluid">

        <!-- PAGE-HEADER -->
        <div class="page-header">
            <h1 class="page-title">Product Details</h1>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- ROW-1 for Pending Auctions-->
        @if($product->auction_status == 0)
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row row-sm">
                                <div class="col-xl-5 col-lg-12 col-md-12">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <img src="{{asset($product->image1)}}" alt="" style="width:100%;">
                                            <div class="clearfix carousel-slider">
                                                <div id="thumbcarousel" class="carousel slide" data-bs-interval="t">
                                                    <div class="carousel-inner">
                                                        <ul class="carousel-item active">

                                                            @if($product->image2)
                                                            <li data-bs-target="#Slider" data-bs-slide-to="0" class="thumb active m-2"><img src="{{asset($product->image2)}}" alt="" style="width:80%;height:60%;"></li>
                                                            @endif

                                                            @if($product->image3)
                                                            <li data-bs-target="#Slider" data-bs-slide-to="0" class="thumb active m-2"><img src="{{asset($product->image3)}}" alt="" style="width:80%;height:60%;"></li>
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

                                        <div class=" mt-4 mb-5"><span class="fw-bold me-2">Category :</span><span class="fw-bold text-success">{{$product->category->name}}</span></div>

                                        <div class=" mt-4 mb-5"><span class="fw-bold me-2">Auction Time :</span><span class="fw-bold text-success">{{ \Carbon\Carbon::createFromTimestamp(strtotime($product->auction_time))->format('Y-m-d H:i:s A')}}</span></div>

                                        @if($product->status == 1 )
                                        <div class=" mt-4 mb-5"><span class="fw-bold me-2">Status :</span><span class="fw-bold text-success">Active</span></div>
                                        @else
                                        <div class=" mt-4 mb-5"><span class="fw-bold me-2">Status :</span><span class="fw-bold text-success">In-Active</span></div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- ROW-1 CLOSED -->

    </div>
    <!-- CONTAINER CLOSED -->

@endsection('content')