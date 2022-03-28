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

        <!-- Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="background-color:#5ba9dc;color:white;">
                        <h3 class="card-title">Assign Size's</h3>
                    </div>
                    
                    <div class="card-body">
                        <form method="POST" class="form-material" action="{{route('saveProductSize')}}">
                            <div class="row">
                                @csrf
                                <input type="hidden" name="product_id" value ="{{$product->id}}">
                                @foreach($sizes as $key => $size)
                                    <div class="col-xl-3 col-md-3">
                                        <label for=""> <input type="checkbox" name="size_id[{{$key}}]"  value="{{ $size->id }}"> {{$size->name}}</label>
                                    </div>
                                @endforeach
                            </div>
                            <br>
                            <button type="submit" class="btn waves-effect waves-light" style="background-color:#5ba9dc;color:white;">Save size</button>
                        </form>    
                    </div>
                </div>
            </div>
        </div>
        <!-- Row -->
    </div>  

</div>    
  

@endsection('content')