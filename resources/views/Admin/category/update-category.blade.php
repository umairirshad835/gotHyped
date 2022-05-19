@extends('layouts.app')

@section('content')

<div class="side-app">

    <!-- CONTAINER -->
    <div class="main-container container-fluid">

        <!-- PAGE-HEADER -->
        <div class="page-header">
            <h1 class="page-title">Manage Category</h1>
        </div>
        <!-- PAGE-HEADER END -->
        
        <form method="POST" action="{{ route('updateCategory') }}" autocomplete="off" class="card">
            @csrf
                <input type="hidden" name="category_id" id="category_id" value="{{$category->id}}">

            <div class="card-header" style="background-color:#5ba9dc;color:white;">
                <h3 class="card-title">Update Category</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-6 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Name</label>
                            <input id="name" class="form-control @error('name') is-invalid @enderror limitinput" value="{{ $category->name }}" name="name" type="text" placeholder="Enter category name">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    
                    <div class="col-xl-6 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select class="form-control form-select @error('status') is-invalid @enderror" data-placeholder="Choose one" name="status">
                                    <option label="Choose one"></option>
                                    <option value="1" {{$category->status == 1 ? 'selected' : ''}} >Active</option>
                                    <option value="0" {{$category->status == 0 ? 'selected' : ''}} >In-active</option>
                                </select>
                                @error('status')
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

                <button type="submit" class="btn py-1 px-4 mb-1" style="background-color:#5ba9dc;color:white;">Update Category</button>

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
        
        var categoryID = $('#category_id').val();

        editSize(categoryID);

        function editSize(categoryID,productId)
        {
            $.ajax({
                url: '/get-category-size/'+categoryID,
                type: "GET",
                data : {"_token":"{{ csrf_token() }}"},
                dataType: "json",
                success:function(data)
                {
                    $('#size').empty();
                    $.each(data.sizes, function (index, el) {
                        var select_size = '';
                        $.each(data.category_size, function (key, val){
                                if(el['id'] == val['size_id'] && val['status'] == 1) {
                                    select_size = 'checked';
                            }
                        });
                        $('#size').append('<div class="col-xl-3 col-md-3"><label class="form-label"><input type="checkbox" name="size_id['+index+']" value="'+ el['id'] +'" '+select_size+'>' + el['name']+ ' </label></div>');
                    });
                }
            });
        }

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
