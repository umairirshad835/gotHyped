@extends('layouts.app')

@section('content')



<div class="side-app">

    <!-- CONTAINER -->
    <div class="main-container container-fluid">

        <!-- PAGE-HEADER -->
        <div class="page-header">
            <h1 class="page-title">Manage Auctions</h1>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Pending Auctions</h3>
                    </div>
                    <div class="card-body">
                            <div class="table-responsive">
                                <table class="table border text-nowrap text-md-nowrap mb-0">
                                    <thead style="background-color:#5ba9dc;">
                                        <tr>
                                            <th style="color:white;">#</th>
                                            <th style="color:white;">Name</th>
                                            <th style="color:white;">Actual price</th>
                                            <th style="color:white;">Market price</th>
                                            <th style="color:white;">Auction price</th>
                                            <th style="color:white;">Auction Time</th>
                                            <th style="color:white;">Status</th>
                                            <th style="color:white;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pendingAuctions as $key => $pending)
                                        <tr>
                                            <td>{{++$key}}</td>
                                            <td>{{$pending->name}}</td>
                                            <td>${{$pending->actual_price}}</td>
                                            <td>${{$pending->market_price}}</td>
                                            <td>${{$pending->auction_price}}</td>
                                            <td>{{ \Carbon\Carbon::createFromTimestamp(strtotime($pending->auction_time))->format('Y-m-d H:i:s A')}}</td>
                                            <td>
                                            <form action="{{route('changeAuctionStatus',$pending->id)}}" method="POST">
                                                    @csrf
                                                <input type="hidden" name="status" value="{{ $pending->status == 1 ? 0 : 1 }}"/>
                                                    @if($pending->status == 1)
                                                        <button type="submit" class="btn btn-success">Active</button>
                                                    @else
                                                        <button type="submit" class="btn btn-danger">In-active</button>
                                                    @endif
                                                </form>
                                            </td>
                                            <td>
                                                <a href="{{route('editProduct', $pending->id)}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                <a href="{{route('previewProduct', $pending->id)}}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            {{$pendingAuctions->links()}}
                            <br>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row -->
    </div>  

</div>    
  

@endsection('content')