@extends('layouts.app')

@section('content')

@section('custom-css')
    <!-- font awesome icons cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    .card-style {
        height:130px;
    }

@endsection('custom-css')
<div class="side-app">

    <!-- CONTAINER -->
    <div class="main-container container-fluid">

        <!-- PAGE-HEADER -->
        <div class="page-header">
            <h1 class="page-title">Dashboard</h1>
        </div>
        <!-- PAGE-HEADER END -->

            <!-- ROW-1 -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
                <div class="row">

                    <div class="col-sm-6 col-lg-6 col-md-12 col-xl-3">
                        <a href="{{route('userList')}}">
                            <div class="card card-style">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="circle-icon bg-primary text-center align-self-center box-primary-shadow bradius">
                                            <img src="../assets/images/svgs/circle.svg" alt="img" class="card-img-absolute">
                                            <i class="fa fa-user fs-30 text-white mt-4" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="card-body p-3">
                                            <h2 class="mb-2 fw-normal mt-2">{{$totalUsers}}</h2>
                                            <h5 class="fw-normal mb-0">Total Users</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-lg-6 col-md-12 col-xl-3">
                        <a href="{{route('pendingAuctions')}}">
                            <div class="card card-style">
                                <div class="row">
                                    <div class="col-4 ">
                                        <div class="card-img-absolute  circle-icon bg-success align-items-center text-center box-success-shadow bradius">
                                            <img src="../assets/images/svgs/circle.svg" alt="img" class="card-img-absolute">
                                            <i class="fa fa-clock-o fs-30 text-white mt-4" aria-hidden="true"></i>

                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="card-body p-3">
                                            <h2 class="mb-2 fw-normal mt-2">{{$pending}}</h2>
                                            <h5 class="fw-normal mb-0 ">Auctions Pending</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-lg-6 col-md-12 col-xl-3">
                        <a href="{{route('activeAuctions')}}">
                            <div class="card card-style">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="card-img-absolute  circle-icon bg-success align-items-center text-center box-success-shadow bradius">
                                            <img src="../assets/images/svgs/circle.svg" alt="img" class="card-img-absolute">
                                            <i class="fa fa-spinner fs-30 text-white mt-4"></i>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="card-body p-3">
                                            <h2 class="mb-2 fw-normal mt-2">{{$inProgress}}</h2>
                                            <h5 class="fw-normal pr-4 mb-0">Auctions InProgress</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>    
                    </div>
                    <div class="col-sm-6 col-lg-6 col-md-12 col-xl-3">
                        <a href="{{route('completedAuctions')}}">
                            <div class="card card-style"> 
                                <div class="row">
                                    <div class="col-4">
                                        <div class="card-img-absolute  circle-icon bg-success align-items-center text-center box-success-shadow bradius">
                                            <img src="../assets/images/svgs/circle.svg" alt="img" class="card-img-absolute">
                                            <i class="fa fa-check fs-30 text-white mt-4"></i>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="card-body p-3">
                                            <h2 class="mb-2 fw-normal mt-2">{{$completed}}</h2>
                                            <h5 class="fw-normal mb-0">Auctions Completed</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </div>
        <!-- ROW-1 END -->

         <!-- ROW-2 -->
         <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
                <div class="row">

                    <div class="col-sm-6 col-lg-6 col-md-12 col-xl-3">
                        <div class="card card-style">
                            <div class="row">
                                <div class="col-4">
                                    <div class="card-img-absolute  circle-icon bg-success align-items-center text-center box-success-shadow bradius">
                                        <img src="../assets/images/svgs/circle.svg" alt="img" class="card-img-absolute">
                                        <i class="fa fa-database fs-30 text-white mt-4"></i>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="card-body p-3">
                                        <h2 class="mb-2 fw-normal mt-2">{{$bidUsed}}</h2>
                                        <h5 class="fw-normal mb-0">Bids Used </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-6 col-md-12 col-xl-3">
                        <div class="card card-style">
                            <div class="row">
                                <div class="col-4">
                                    <div class="card-img-absolute  circle-icon bg-success align-items-center text-center box-success-shadow bradius">
                                        <img src="../assets/images/svgs/circle.svg" alt="img" class="card-img-absolute">
                                        <i class="lnr lnr-gift fs-30 text-white mt-4"></i>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="card-body p-3">
                                        <h2 class="mb-2 fw-normal mt-2">{{$bids_Sale}}</h2>
                                        <h5 class="fw-normal mb-0">Bid Sale</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-6 col-md-12 col-xl-3">
                        <div class="card card-style">
                            <div class="row">
                                <div class="col-4">
                                    <div class="card-img-absolute  circle-icon bg-success align-items-center text-center box-success-shadow bradius">
                                        <img src="../assets/images/svgs/circle.svg" alt="img" class="card-img-absolute">
                                        <i class="fa fa-money fs-30 text-white mt-4"></i>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="card-body p-3">
                                        <h2 class="mb-2 fw-normal mt-2">{{$itemsDelivered}}</h2>
                                        <h5 class="fw-normal mb-0">Items Delivered </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-6 col-md-12 col-xl-3">
                        <div class="card card-style">
                            <div class="row">
                                <div class="col-4">
                                    <div class="card-img-absolute  circle-icon bg-success align-items-center text-center box-success-shadow bradius">
                                        <img src="../assets/images/svgs/circle.svg" alt="img" class="card-img-absolute">
                                        <i class="fa fa-dollar fs-30 text-white mt-4" aria-hidden="true"></i>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="card-body p-3">
                                        <h2 class="mb-2 fw-normal mt-2">{{$marketvalue}}</h2>
                                        <h5 class="fw-normal mb-0">Market Price </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- ROW-2 END -->

        <!-- ROW-3 -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
                <div class="row">

                    <!-- <div class="col-sm-6 col-lg-6 col-md-12 col-xl-3">
                        <div class="card">
                            <div class="row">
                                <div class="col-4">
                                    <div class="card-img-absolute  circle-icon bg-success align-items-center text-center box-success-shadow bradius">
                                        <img src="../assets/images/svgs/circle.svg" alt="img" class="card-img-absolute">
                                        <i class="lnr lnr-gift fs-30 text-white mt-4"></i>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="card-body p-4">
                                        <h2 class="mb-2 fw-normal mt-2">9,678</h2>
                                        <h5 class="fw-normal mb-0">Total Profit</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->


                </div>
            </div>
        </div>


        <!-- ROW-3 END -->

        <!-- Pending Auction Listing -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Pending Auctions</h3>
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
                                            <th style="color:white;">Auction Price</th>
                                            <th style="color:white;">Auction Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($auction_pending as $key => $pending)
                                        <tr>
                                            <td>{{++$key}}</td>
                                            <td>{{$pending->name}}</td>
                                            <td>
                                                @if(!empty($pending->image1))
                                                    <img src="{{asset($pending->image1)}}" alt="" style="width:100px;height:80px">
                                                @else
                                                    <span>No Image Attached</span>
                                                @endif
                                            </td>
                                            <td>{{$pending->category->first()->name}}</td>
                                            <td>$ {{$pending->auction_price}}</td>
                                            <td>{{ \Carbon\Carbon::createFromTimestamp(strtotime($pending->auction_time))->format('Y-m-d H:i:s A')}}</td>
                                            
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            {{$auction_pending->links()}}
                            <br>
                    </div>
                </div>
            </div>
        </div>


        <!-- Auction Completed Listing -->

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
                                            <th style="color:white;">Category</th>
                                            <th style="color:white;">Auction Price</th>
                                            <th style="color:white;">Winner</th>
                                            <th style="color:white;">Winner Role</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($auction_completed as $key => $completed)
                                        <tr>
                                            <td>{{++$key}}</td>
                                            <td>{{$completed->name}}</td>
                                            <td>
                                                @if(!empty($completed->image1))
                                                    <img src="{{asset($completed->image1)}}" alt="" style="width:100px;height:80px">
                                                @else
                                                    <span>No Image Attached</span>
                                                @endif
                                            </td>
                                            <td>{{$completed->category->first()->name}}</td>
                                            <td>$ {{$completed->auction_price}}</td>
                                            <td>{{ $completed->winner->first()->user->first()->name}}</td>
                                            <td> 
                                                @if($completed->winner->first()->user->first()->roles == 'customer')
                                                    <span class="text-success">{{ $completed->winner->first()->user->first()->roles}}</span>
                                                @else
                                                    <span class="text-danger">{{ $completed->winner->first()->user->first()->roles}}</span>
                                                @endif
                                            </td>
                                            
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            {{$auction_pending->links()}}
                            <br>
                    </div>
                </div>
            </div>
        </div>
       

    </div>                    
</div>                    

@endsection('content')