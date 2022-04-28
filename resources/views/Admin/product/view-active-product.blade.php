@extends('layouts.app')

@section('content')

    <!-- CONTAINER -->
    <div class="main-container container-fluid">

        <!-- PAGE-HEADER -->
        <div class="page-header">
            <h1 class="page-title">Auction Report</h1>
        </div>
        <!-- PAGE-HEADER END -->


        <!-- ROW-2 for Active Auctions Auctions-->
        @if($product->auction_status == 1)
            <div class="row">
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
                                                <th style="color:white;">Name</th>
                                                <th style="color:white;">Role</th>
                                                <th style="color:white;">Status</th>
                                                <th style="color:white;">Bid Used</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($activepreview as $key => $active)
                                            <tr>
                                                <td>{{++$key}}</td>
                                                <td>{{$active->users->first()->name}}</td>
                                                <td>{{$active->users->first()->roles}}</td>
                                                <td>
                                                    @if($auctin_start->last_user_id == $active->user_id)
                                                        <span class="text-success">Winning</span>
                                                    @else
                                                        <span class="text-danger">Losing</span>
                                                    @endif
                                                </td>
                                                <td>{{$active->bid_used}}</td>
                                            </tr>
                                            @endforeach()
                                            <tr>
                                                <th colspan="4"><h4>Total Bids</h4></th>
                                                <td>{{$active->auctionStart->first()->current_bid_used}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                {{$activepreview->links()}}
                                <br>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- ROW-2 CLOSED -->

    </div>
    <!-- CONTAINER CLOSED -->

@endsection('content')

@section('custom-js')

    <script>    

        $(document).ready(function () {

            // reload page after 10 sec
            setTimeout(function () {
                location.reload(true);
            }, 10000);

        });
    
    </script>

@endsection('custom-js')