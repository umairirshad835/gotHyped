@extends('layouts.app')

@section('content')

@section('custom-css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.css">
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
                                <a class="nav-item nav-link" href="#AuctionWon" role="tab" aria-selected="false" data-toggle="tab">
                                Auction Won
                                </a>
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
                                    <table class="table border text-nowrap text-md-nowrap mb-0" id="purchase-bid-datatable">
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
                                    <table id="bid-history-datatable" class="table border text-nowrap text-md-nowrap mb-0">
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
                                <div class="tab-pane" id="AuctionWon">
                                    <table id="auction-won-datatable" class="table border text-nowrap text-md-nowrap mb-0">
                                        <thead style="background-color:#5ba9dc;">
                                            <tr>
                                                <th style="color:white;">Auction Name</th>
                                                <th style="color:white;">Image</th>
                                                <th style="color:white;">Check Out Method</th>
                                                <th style="color:white;">Delivery Address</th>
                                                <th style="color:white;">Market Price</th>
                                                <th style="color:white;">Size</th>
                                                <th style="color:white;">Bid's Won</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($winner_auctions as $win)
                                                <tr>
                                                    <td>{{$win->winproduct->name}}</td>
                                                    <td>
                                                        @if(!empty($win->winproduct->image1))
                                                            <img src="{{asset($win->winproduct->image1)}}" alt="" style="width:100px;height:80px">
                                                        @else
                                                            <span>No Image Attached</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($win->market_value_status == 1)
                                                            <span>Market Price</span>
                                                        @else
                                                            <span>Delivery Address</span>
                                                        @endif
                                                    </td>
                                                    <td>{{$win->shippingAddressNew->address->address}}</td>
                                                    <td>
                                                        @if($win->market_value_status == 1)
                                                            <span>{{$win->winproduct->market_price}}</span>
                                                        @else
                                                            <span>N/A</span>
                                                        @endif
                                                    </td>
                                                    <td>{{$win->shippingAddressNew->size->name}}</td>
                                                    <td>{{App\Models\AuctionBidUsed::where('user_id', $win->user_id)->where('auction_id', $win->product_id)->first()->bid_used}}</td>
                                                </tr>
                                                
                                            @endforeach
                                        </tbody>    
                                    </table>
                                </div>

                                <!-- Auction Lost Tab content -->
                                <div class="tab-pane" id="AuctionLost">
                                    <table id="auction-lost-datatable" class="table border text-nowrap text-md-nowrap mb-0">
                                        <thead style="background-color:#5ba9dc;">
                                            <tr>
                                                <th style="color:white;">Auction Name</th>
                                                <th style="color:white;">Image</th>
                                                <th style="color:white;">Bid's Lost</th>
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

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.js"></script>

<script>
$(document).ready( function () {
        $('#purchase-bid-datatable').DataTable();

    if (location.hash) {
        $("a[href='" + location.hash + "']").tab("show");
    }
    $(document.body).on("click", "a[data-toggle='tab']", function(event) {
        location.hash = this.getAttribute("href");
    });

    $(window).on("popstate", function() {
        var anchor = location.hash || $("a[data-toggle='tab']").first().attr("href");
        $("a[href='" + anchor + "']").tab("show");
    });

});

   

</script>
@endsection