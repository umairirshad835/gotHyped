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
            <input type="hidden" name="product_id" id="product_id" value="{{$product->id}}">
            
            <div class="card-header" style="background-color:#5ba9dc;color:white;">
                <h3 class="card-title">Edit Product</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-6 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Product Name</label>
                            <input id="name" class="form-control @error('name') is-invalid @enderror limitinput" value="{{ $product->name }}" name="name" type="text" placeholder="Enter size name">
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
                            <select class="form-control form-select @error('category') is-invalid @enderror" data-placeholder="Choose one" name="category" id="category">
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
                            <input id="actual_price" class="form-control @error('actual_price') is-invalid @enderror" value="{{ $product->actual_price }}" name="actual_price" type="number" placeholder="Enter Actual Price" min="1" step="any">
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
                            <input id="market_price" class="form-control @error('market_price') is-invalid @enderror" value="{{ $product->market_price }}" name="market_price" type="number" placeholder="Enter Market Price" min="1" step="any">
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
                            <input id="auction_price" class="form-control @error('auction_price') is-invalid @enderror" value="{{ $product->auction_price }}" name="auction_price" type="number" placeholder="Enter Auction Price" min="1" step="any">
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
                            <input id="auction_time" name="auction_time" class="form-control" value="{{ \Carbon\Carbon::parse($product->auction_time)->format('m/d/Y h:m A')}}" type="text"  readonly="">
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
                                <img src="{{asset($product->image1)}}" style="width:100px;height:80px">
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
                                <img src="{{asset($product->image2)}}" style="width:100px;height:80px">
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
                                <img src="{{asset($product->image3)}}" style="width:100px;height:80px">
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

                <div class="row" id="size">
                
                </div>
                <br>
                <br>
                <button type="submit" class="btn py-1 px-4 mb-1" style="background-color:#5ba9dc;color:white;">Update auction</button>
            </div>
        </form>
    </div>
    <!-- CONTAINER CLOSED -->

</div>

@endsection('content')

@section('custom-js')

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script>

$(document).ready(function() {

    var productId = $('#product_id').val();
    var categoryID = $('#category').val();

        editSize(categoryID,productId);

    function editSize(categoryID,productId)
    {
        $.ajax({
            url: '/check-size/'+categoryID+'/'+productId,
            type: "GET",
            data : {"_token":"{{ csrf_token() }}"},
            dataType: "json",
            success:function(data)
            {
                $('#size').empty();

                $.each(data.size, function (index, el) {
                    var select_size = '';
                    var flag = 0;
                    
                    $.each(data.productSize, function (key, val)
                    {
                        if(el['id'] == val['size_id'] && val['status'] == 1)
                        {
                            select_size = 'checked';
                            flag = 1;
                        }
                         
                    });
                    $('#size').append('<div class="col-xl-3 col-md-3">'
                    +'<label class="form-label">'
                    +'<input type="checkbox" name="size_id['+index+']" value="'+ el['id'] +'" '+select_size+'>'
                    + el['name']+ ' </label></div>');
                    
                });
            }
        });
    }

    $('#category').on('change', function() {

        var productId = $('#product_id').val();
        var categoryID = $(this).val();

        editSize(categoryID,productId);
    });

    $('input.limitinput').on('keyup', function() {
        limitText(this, 50)
    });

    function limitText(field, maxChar){
        var ref = $(field),
            val = ref.val();
        if ( val.length >= maxChar ){
            ref.val(function() {
                console.log(val.substr(0, maxChar))
                return val.substr(0, maxChar);       
            });
        }
    }
});

</script>

@endsection('custom-js')