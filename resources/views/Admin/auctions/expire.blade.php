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
                        <h3 class="card-title">Completed Auctions</h3>
                    </div>
                    <div class="card-body">
                            <div class="table-responsive">
                                <table class="table border text-nowrap text-md-nowrap mb-0">
                                    <thead style="background-color:#5ba9dc;">
                                        <tr>
                                            <th style="color:white;">#</th>
                                            <th style="color:white;">Name</th>
                                            <th style="color:white;">Image</th>
                                            <th style="color:white;">Actual Price</th>
                                            <th style="color:white;">Market Price</th>
                                            <th style="color:white;">Auction Price</th>
                                            <th style="color:white;">Close Price</th>
                                            <th style="color:white;">Total Bids</th>
                                            <th style="color:white;">Winner Role</th>
                                            <th style="color:white;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($completedAuctions as $key => $complete)
                                        <tr>
                                            <td>{{++$key}}</td>
                                            <td>{{$complete->name}}</td>
                                            <td>
                                                @if(!empty($complete->image1))
                                                    <img src="{{asset($complete->image1)}}" alt="" style="width:100px;height:80px">
                                                @else
                                                    <span>No Image Attached</span>
                                                @endif
                                            </td>
                                            <td>${{$complete->actual_price}}</td>
                                            <td>${{$complete->market_price}}</td>
                                            <td>${{$complete->auction_price}}</td>
                                            <td>$ {{$complete->winner->first()->auction_close_price}}</td>
                                            <td>{{$complete->winner->first()->total_bids}}</td>
                                            <td>
                                                @if($complete->winner->first()->user->first()->roles == 'customer')
                                                    <span class="text-success">{{ $complete->winner->first()->user->first()->roles}}</span>
                                                @else
                                                    <span class="text-danger">{{ $complete->winner->first()->user->first()->roles}}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{route('previewCompletedProduct', $complete->id)}}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            {{$completedAuctions->links()}}
                            <br>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row -->
    </div>  

</div>    
  

@endsection('content')