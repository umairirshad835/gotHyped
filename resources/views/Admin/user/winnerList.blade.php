@extends('layouts.app')

@section('content')



<div class="side-app">

    <!-- CONTAINER -->
    <div class="main-container container-fluid">

        <!-- PAGE-HEADER -->
        <div class="page-header">
            <h1 class="page-title">Winner Report</h1>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Winner List</h3>
                    </div>
                    <div class="card-body">
                            <div class="table-responsive">
                                <table class="table border text-nowrap text-md-nowrap mb-0">
                                    <thead style="background-color:#5ba9dc;">
                                        <tr>
                                            <th style="color:white;">#</th>
                                            <th style="color:white;">Winner Name</th>
                                            <th style="color:white;">Winner Role</th>
                                            <th style="color:white;">Auction Name</th>
                                            <th style="color:white;">Image</th>
                                            <th style="color:white;">Winner Bid Used</th>
                                            <th style="color:white;">Total Bid Used</th>
                                            <th style="color:white;">Winning Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($winnerList as $key => $winner)
                                        <tr>
                                            <td>{{++$key}}</td>
                                            <td>{{$winner->user->first()->name ?? ''}}</td>
                                            <td>
                                            @if($winner->user->first()->roles == 'customer')
                                                    <span class="text-success">{{ $winner->user->first()->roles ?? ''}}</span>
                                                @else
                                                    <span class="text-danger">{{ $winner->user->first()->roles ?? ''}}</span>
                                                @endif
                                            </td>
                                            <td>{{$winner->product->first()->name ?? ''}}</td>
                                            <td>
                                                @if(!empty($winner->product->first()->image1))
                                                    <img src="{{asset($winner->product->first()->image1)}}" alt="" style="width:100px;height:80px">
                                                @else
                                                    <span>No Image Attached</span>
                                                @endif
                                            </td>
                                            <td>{{$winner->WinnerBid->first()->bid_used ?? ''}}</td>
                                            <td>{{$winner->total_bids ?? ''}}</td>
                                            <td>$ {{$winner->auction_close_price ?? ''}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            {{$winnerList->links()}}
                            <br>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row -->
    </div>  

</div>    
  

@endsection('content')