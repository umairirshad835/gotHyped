@extends('layouts.app')

@section('content')

<div class="side-app">

    <!-- CONTAINER -->
    <div class="main-container container-fluid">

        <!-- PAGE-HEADER -->
        <div class="page-header">
            <h1 class="page-title">Manage Product</h1>
        </div>
        <!-- PAGE-HEADER END -->
        
        <form method="POST" action="{{ route('updateProduct') }}" autocomplete="off" enctype="multipart/form-data" class="card">
            @csrf
            <input type="hidden" name="product_id" value="{{$product->id}}">
            <div class="card-header" style="background-color:#5ba9dc;color:white;">
                <h3 class="card-title">Edit Product</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-6 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Product Name</label>
                            <input id="name" class="form-control @error('name') is-invalid @enderror" value="{{ $product->name }}" name="name" type="text" placeholder="Enter size name">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <div class="form-group">
                            <label class="form-label"> Category</label>
                            <select class="form-control form-select @error('category') is-invalid @enderror" data-placeholder="Choose one" name="category">
                                    <option label="Choose one"></option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" {{$product->category_id == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-md-4">
                        <div class="form-group">
                            <label class="form-label">Actual Price</label>
                            <input id="actual_price" class="form-control @error('actual_price') is-invalid @enderror" value="{{ $product->actual_price }}" name="actual_price" type="number" placeholder="Enter Actual Price" min="1">
                                @error('actual_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-4">
                        <div class="form-group">
                            <label class="form-label">Market Price</label>
                            <input id="market_price" class="form-control @error('market_price') is-invalid @enderror" value="{{ $product->market_price }}" name="market_price" type="number" placeholder="Enter Market Price" min="1">
                                @error('market_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-4">
                        <div class="form-group">
                            <label class="form-label">Auction Price</label>
                            <input id="auction_price" class="form-control @error('auction_price') is-invalid @enderror" value="{{ $product->auction_price }}" name="auction_price" type="number" placeholder="Enter Auction Price" min="1">
                                @error('auction_price')
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
                            <label class="form-label">Previous Time of Auction</label>
                            <input id="auction_time" class="form-control" value="{{ \Carbon\Carbon::parse($product->auction_time)->format('m/d/Y h:m A')}}" type="text"  readonly="">
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Select New Time of Auction</label>
                            <input id="new_auction_time" class="form-control @error('new_auction_time') is-invalid @enderror" name="new_auction_time" type="datetime-local" placeholder="Enter Auction Time">
                                @error('new_auction_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <input id="descripton" class="form-control @error('descripton') is-invalid @enderror" value="{{ $product->description }}" name="descripton" type="text" placeholder="Enter description">
                                @error('descripton')
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
                            <label class="form-label">Main Image</label>
                            @if(!empty($product->image1))
                                <img src="{{asset($product->image1)}}" style="width:100px;height:60px">
                            @else
                            <span>NO IMAGE FOUND</span>
                            @endif
                            
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Main Image</label>
                            <input id="new_main_image" class="form-control @error('new_main_image') is-invalid @enderror" value="{{ asset($product->image1) }}" name="new_main_image" type="file">
                                @error('new_main_image')
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
                            <label class="form-label">Image Two</label>
                            @if(!empty($product->image2))
                                <img src="{{asset($product->image2)}}" style="width:100px;height:60px">
                            @else
                            <span>No image attached</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-xl-6 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Image Two</label>
                            <input id="imagetwo" class="form-control @error('imagetwo') is-invalid @enderror" value="{{ $product->image2 }}" name="imagetwo" type="file">
                                @error('imagetwo')
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
                            <label class="form-label">Image Three</label>
                            @if(!empty($product->image3))
                                <img src="{{asset($product->image3)}}" style="width:100px;height:60px">
                            @else
                            <span>No image attached</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-xl-6 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Image Three</label>
                            <input id="imagethree" class="form-control @error('imagethree') is-invalid @enderror" value="{{ $product->image3 }}" name="imagethree" type="file">
                                @error('imagethree')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                </div>    
                
                <button type="submit" class="btn py-1 px-4 mb-1" style="background-color:#5ba9dc;color:white;">Update product</button>
            </div>
        </form>
    </div>
    <!-- CONTAINER CLOSED -->

</div>

@endsection('content')