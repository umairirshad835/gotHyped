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
        
        <form method="POST" action="{{ route('updateBid') }}" autocomplete="off" class="card">
            @csrf
                <input type="hidden" name="bid_edit" value="{{$edit_bid->id}}">
            <div class="card-header" style="background-color:#5ba9dc;color:white;">
                <h3 class="card-title">Edit Bid</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-6 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Package Name</label>
                            <input id="name" class="form-control @error('name') is-invalid @enderror" value="{{$edit_bid->name}}" name="name" type="text" placeholder="Enter package name">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Bid Code</label>
                            <input id="code" class="form-control @error('code') is-invalid @enderror" value="{{$edit_bid->code}}" name="code" type="text" placeholder="Enter bid code">
                                @error('code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Number of Bids</label>
                            <input id="bids" class="form-control @error('bids') is-invalid @enderror" value="{{$edit_bid->number_of_bids}}" name="bids" type="number" placeholder="Enter bid number" min="1">
                                @error('bids')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>

                    <div class="col-xl-6 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Bid price</label>
                            <input id="price" class="form-control @error('price') is-invalid @enderror" value="{{$edit_bid->price}}" name="price" type="number" placeholder="Enter bid price" min="1" step="any">
                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn py-1 px-4 mb-1" style="background-color:#5ba9dc;color:white;">Update Bid</button>
            </div>
        </form>
    </div>
    <!-- CONTAINER CLOSED -->

</div>

@endsection('content')