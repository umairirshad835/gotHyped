@extends('layouts.app')

@section('content')

<div class="side-app">

    <!-- CONTAINER -->
    <div class="main-container container-fluid">

        <!-- PAGE-HEADER -->
        <div class="page-header">
            <h1 class="page-title">Manage Auction</h1>
        </div>
        <!-- PAGE-HEADER END -->
        
        <form method="POST" action="{{ route('manageAuction') }}" autocomplete="off" class="card">
            @csrf
            <div class="card-header" style="background-color:#5ba9dc;color:white;">
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-6 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Flag</label>
                            <input type="number" name="flag" id="flag" class="form-control">
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Auction</label>
                            <input type="number" name="auction_id" id="auctionId" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-md-6">
                        <div class="form-group">
                            <label class="form-label">User</label>
                            <input type="number" name="userId" id="userId" class="form-control">
                        </div>
                    </div>
                </div>
                        <button type="submit" class="btn py-1 px-4 mb-1" style="background-color:#5ba9dc;color:white;">test</button>
            </div>
        </form>
    </div>
    <!-- CONTAINER CLOSED -->

</div>

@endsection('content')