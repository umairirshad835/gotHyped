@extends('layouts.app')

@section('content')

<div class="side-app">

    <!-- CONTAINER -->
    <div class="main-container container-fluid">

        <!-- PAGE-HEADER -->
        <div class="page-header">
            <h1 class="page-title">Auction Report</h1>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Active Auctions</h3>
                    </div>
                    <div class="card-body">
                            <div class="table-responsive">
                                <table class="table border text-nowrap text-md-nowrap mb-0">
                                    <thead style="background-color:#5ba9dc;">
                                        <tr>
                                            <th style="color:white;">#</th>
                                            <th style="color:white;">Name</th>
                                            <th style="color:white;">Image</th>
                                            <th style="color:white;">Category</th>
                                            <th style="color:white;">Actual Price</th>
                                            <th style="color:white;">Market Price</th>
                                            <th style="color:white;">Auction Price</th>
                                            <th style="color:white;">Current Auction Price</th>
                                            <th style="color:white;">Total Bids</th>
                                            <th style="color:white;">Winning User</th>
                                            <th style="color:white;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($activeAuctions as $key => $active)
                                        <tr>
                                            <td>{{++$key}}</td>
                                            <td>{{$active->name}}</td>
                                            <td>
                                                @if(!empty($active->image1))
                                                    <img src="{{asset($active->image1)}}" alt="" style="width:100px;height:80px">
                                                @else
                                                    <span>No Image Attached</span>
                                                @endif
                                            </td>
                                            <td>{{$active->category->name ?? ''}}</td>
                                            <td>${{$active->actual_price ?? ''}}</td>
                                            <td>${{$active->market_price ?? ''}}</td>
                                            <td>${{$active->auction_price ?? ''}}</td>
                                            <td>$ {{$active->AuctionStart->first()->current_price ?? ''}}</td>
                                            <td>{{$active->AuctionStart->first()->current_bid_used ?? ''}}</td>
                                            <td>{{$active->AuctionStart->first()->users->name ?? ''}}</td>
                                            <td>
                                                <a href="{{route('previewActiveProduct', $active->id)}}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            {{$activeAuctions->links()}}
                            <br>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row -->
    </div>  

</div>    
  

@endsection('content')