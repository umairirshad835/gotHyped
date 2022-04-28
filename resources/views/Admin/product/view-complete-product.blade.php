@extends('layouts.app')

@section('content')

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
                                                <th style="color:white;">Product Name</th>
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
                                                    <td>{{$complete->product->first()->name}}</td>
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
                                                <th colspan="5"><h4>Total Bids</h4></th>
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