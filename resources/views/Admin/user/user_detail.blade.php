@extends('layouts.app')

@section('content')

@section('custom-css')
   
@endsection('custom-css')


<div class="side-app">

    <!-- CONTAINER -->
    <div class="main-container container-fluid">

        <!-- PAGE-HEADER -->
        <div class="page-header">
            <h1 class="page-title"> {{$user->name}} Details</h1>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <nav>
                            <div class="nav nav-tabs nav-fill border-bottom-0" id="nav-tab" role="tablist">

                                <a class="nav-item nav-link active " role="tab" aria-selected="true" href="#WalletBid" data-toggle="tab">
                                Wallet Bids
                                </a>
                                <a class="nav-item nav-link" href="#BidPurchase" role="tab" aria-selected="false" data-toggle="tab">
                                Bids Purchase
                                </a>
                                <a class="nav-item nav-link" href="#BidHistory" role="tab" aria-selected="false" data-toggle="tab">
                                Bids History
                                </a>
                                <!-- <a class="nav-item nav-link" href="#AuctionWon" role="tab" aria-selected="false" data-toggle="tab">
                                Auction Won
                                </a> -->
                                <a class="nav-item nav-link" href="#AuctionLost" role="tab" aria-selected="false" data-toggle="tab">
                                Auction Lost
                                </a>
                            </div>
                        </nav> 

                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="tab-content">

                                <!-- WalletBid Tab content -->
                                <div class="tab-pane active" id="WalletBid">
                                    <table id="userTable" class="table border text-nowrap text-md-nowrap mb-0">
                                        <thead style="background-color:#5ba9dc;">
                                            <tr>
                                                <th style="color:white;">Current Bid</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr role="row">
                                                @if(!empty($user_bids->total_bids))
                                                    <td>{{$user_bids->total_bids ?? ''}}</td>
                                                @else
                                                    <tr><td class="text-center">No Data Found</td></tr>
                                                @endif
                                            </tr>
                                        </tbody>    
                                    </table>
                                </div>

                                <!-- BidPurchase Tab content -->
                                <div class="tab-pane" id="BidPurchase">
                                    <table id="userTable" class="table border text-nowrap text-md-nowrap mb-0">
                                        <thead style="background-color:#5ba9dc;">
                                            <tr>
                                                <th style="color:white;">Bid Purchase</th>
                                                <th style="color:white;">Purchase Price</th>
                                                <th style="color:white;">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($purchased_bids as $purchase)
                                                <tr role="row">
                                                    <td>{{$purchase->purchase_bids}}</td>
                                                    <td>${{$purchase->purchase_price}}</td>
                                                    <td>{{date('d-M-Y H:i A', strtotime($purchase->created_at))}}</td>
                                                </tr>
                                            @empty
                                                <tr><td class="text-center">No Data Found</td></tr>
                                            @endforelse
                                        </tbody>    
                                    </table>
                                </div>

                                <!-- Bid History Tab content -->
                                <div class="tab-pane" id="BidHistory">
                                    <table id="userTable" class="table border text-nowrap text-md-nowrap mb-0">
                                        <thead style="background-color:#5ba9dc;">
                                            <tr>
                                                <th style="color:white;">Auction Name</th>
                                                <th style="color:white;">Image</th>
                                                <th style="color:white;">Bid Used</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr role="row">
                                                @forelse($bid_history as $history)
                                                    <tr role="row">
                                                        <td>{{$history->product->first()->name}}</td>
                                                        <td> @if(!empty($history->product->first()->image1))
                                                                <img src="{{asset($history->product->first()->image1)}}" alt="" style="width:100px;height:80px">
                                                            @else
                                                                <span>No Image Attached</span>
                                                            @endif
                                                        </td>
                                                        <td>{{$history->bid_used}}</td>
                                                    </tr>
                                                @empty
                                                    <tr><td class="text-center">No Data Found</td></tr>
                                                @endforelse
                                            </tr>
                                        </tbody>    
                                    </table>
                                </div>

                                <!-- Auction Won Tab content -->
                               

                                <!-- Auction Lost Tab content -->
                                <div class="tab-pane" id="AuctionLost">
                                    <table id="userTable" class="table border text-nowrap text-md-nowrap mb-0">
                                        <thead style="background-color:#5ba9dc;">
                                            <tr>
                                                <th style="color:white;">Auction Name</th>
                                                <th style="color:white;">Image</th>
                                                <th style="color:white;">Bids Lost</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($auction_lost as $lost)
                                                <tr role="row">
                                                    <td>{{$lost->ProductLost->first()->name}}</td>
                                                    <td> @if(!empty($lost->ProductLost->first()->image1))
                                                    <img src="{{asset($lost->ProductLost->first()->image1)}}" alt="" style="width:100px;height:80px">
                                                    @else
                                                        <span>No Image Attached</span>
                                                    @endif
                                                </td>
                                                    <td>{{$lost->lost_bids}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>    
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row -->
    </div>  

</div>    
  

@endsection('content')

@section('custom-js')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>


@endsection