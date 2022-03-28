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
        
        <form method="POST" action="{{ route('saveProduct') }}" autocomplete="off" enctype="multipart/form-data" class="card">
            @csrf
            <div class="card-header" style="background-color:#5ba9dc;color:white;">
                <h3 class="card-title">Add New Product</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-6 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Product Name</label>
                            <input id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" name="name" type="text" placeholder="Enter product name">
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
                                    @foreach($all_category as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
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
                            <input id="actual_price" class="form-control @error('actual_price') is-invalid @enderror" value="{{ old('actual_price') }}" name="actual_price" type="number" placeholder="Enter Actual Price" min="1">
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
                            <input id="market_price" class="form-control @error('market_price') is-invalid @enderror" value="{{ old('market_price') }}" name="market_price" type="number" placeholder="Enter Market Price" min="1">
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
                            <input id="auction_price" class="form-control @error('auction_price') is-invalid @enderror" value="{{ old('auction_price') }}" name="auction_price" type="number" placeholder="Enter Auction Price" min="1">
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
                            <label class="form-label">Time of Auction</label>
                            <input id="auction_time" class="form-control @error('auction_time') is-invalid @enderror" value="{{ old('auction_time') }}" name="auction_time" type="datetime-local" placeholder="Enter size name">
                                @error('auction_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Main Image</label>
                            <input id="main_image" class="form-control @error('main_image') is-invalid @enderror" value="{{ old('main_image') }}" name="main_image" type="file">
                                @error('main_image')
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
                            <label class="form-label">Image 2</label>
                            <input id="imagetwo" class="form-control @error('imagetwo') is-invalid @enderror" value="{{ old('imagetwo') }}" name="imagetwo" type="file">
                                @error('imagetwo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Image 3</label>
                            <input id="imagethree" class="form-control @error('imagethree') is-invalid @enderror" value="{{ old('imagethree') }}" name="imagethree" type="file">
                                @error('imagethree')
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
                            <label class="form-label">Description</label>
                            <input id="descripton" class="form-control @error('descripton') is-invalid @enderror" value="{{ old('descripton') }}" name="descripton" type="text" placeholder="Enter description">
                                @error('descripton')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                </div>
                <div class="row" id="size">

                </div>
                        <button type="submit" class="btn py-1 px-4 mb-1" style="background-color:#5ba9dc;color:white;">Add product</button>
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
    $('#category').on('change', function() {
        // alert('data alert check');
        var categoryID = $(this).val();
        if(categoryID) {
            $.ajax({
                url: '/get-size/'+categoryID,
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                dataType: "json",
                success:function(data)
                {
                    if(data)
                    {
                        $('#size').empty();
                        $.each(data, function(key, size){
                            $('#size').append('<div class="col-xl-3 col-md-3"><label class="form-label"><input type="checkbox" name="size_id['+key+']" value="'+ size.id +'">' + size.name+ ' </label></div>');
                        });
                    }
                    else
                    {
                    $('#size').empty();
                    }
                }
            });
        }
        else
        {
            $('#size').empty();
        }
    });
});
</script>

@endsection('custom-js')