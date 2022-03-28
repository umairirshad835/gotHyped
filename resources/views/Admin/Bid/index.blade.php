@extends('layouts.app')

@section('content')


<div class="side-app">

    <!-- CONTAINER -->
    <div class="main-container container-fluid">

        <!-- PAGE-HEADER -->
        <div class="page-header">
            <h1 class="page-title">Manage Bid</h1>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Bid List</h3>
                        <a href="{{route('addBid')}}" class="btn" style="background-color:#5ba9dc;color:white;">Add Bid</a>
                    </div>
                    <div class="card-body">
                            <div class="table-responsive">
                                <table class="table border text-nowrap text-md-nowrap mb-0">
                                    <thead style="background-color:#5ba9dc;">
                                        <tr>
                                            <th style="color:white;">#</th>
                                            <th style="color:white;">Pacakage Name</th>
                                            <th style="color:white;">Number Of Bids</th>
                                            <th style="color:white;">Price</th>
                                            <th style="color:white;">Type</th>
                                            <th style="color:white;">Status</th>
                                            <th style="color:white;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bidList as $key => $bid)
                                        <tr>
                                            <td>{{++$key}}</td>
                                            <td>{{$bid->name}}</td>
                                            <td>{{$bid->number_of_bids}}</td>
                                            <td>${{$bid->price}}</td>
                                            <td>{{$bid->type}}</td>
                                            <td>
                                                <form action="{{route('changeBidStatus',$bid->id)}}" method="POST">
                                                    @csrf
                                                <input type="hidden" name="status" value="{{ $bid->status == 1 ? 0 : 1 }}"/>

                                                    @if($bid->status == 1)
                                                        <button type="submit" class="btn btn-success">Active</button>
                                                    @else
                                                        <button type="submit" class="btn btn-danger">In-active</button>
                                                    @endif
                                                </form>
                                            </td>
                                            <td>
                                                <a href="{{route('editBid', $bid->id)}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            {{$bidList->links()}}
                            <br>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row -->
    </div>  

</div>    
  

@endsection('content')