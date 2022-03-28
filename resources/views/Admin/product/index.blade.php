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
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Product List</h3>
                        <a href="{{route('addProduct')}}" class="btn" style="background-color:#5ba9dc;color:white;">Add Product</a>
                    </div>
                    <div class="card-body">
                            <div class="table-responsive">
                                <table class="table border text-nowrap text-md-nowrap mb-0">
                                    <thead style="background-color:#5ba9dc;">
                                        <tr>
                                            <th style="color:white;">#</th>
                                            <th style="color:white;">Name</th>
                                            <th style="color:white;">Category</th>
                                            <th style="color:white;">Auction Time</th>
                                            <th style="color:white;">Image</th>
                                            <th style="color:white;">Status</th>
                                            <th style="color:white;">Assign Size</th>
                                            <th style="color:white;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($productList as $key => $product)
                                        <tr>
                                            <td>{{++$key}}</td>
                                            <td>{{$product->name}}</td>
                                            <td>{{$product->category->name}}</td>
                                            <td>{{ \Carbon\Carbon::createFromTimestamp(strtotime($product->auction_time))->format('Y-m-d H:i:s A')}}</td>
                                            <td>
                                                @if(!empty($product->image1))
                                                    <img src="{{asset($product->image1)}}" alt="" style="width:100px;height:80px">
                                                @else
                                                    <span>No Image Attached</span>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{route('changeProductStatus',$product->id)}}" method="POST">
                                                    @csrf
                                                <input type="hidden" name="status" value="{{ $product->status == 1 ? 0 : 1 }}"/>

                                                    @if($product->status == 1)
                                                        <button type="submit" class="btn btn-success">Active</button>
                                                    @else
                                                        <button type="submit" class="btn btn-danger">In-active</button>
                                                    @endif
                                                </form>
                                            </td>
                                            <td>
                                                <a href="{{route('assignSize',$product->id)}}" class="btn"  style="background-color:#5ba9dc; color:white">Assign Size</a>
                                            </td>
                                            <td>
                                                <a href="{{route('editProduct', $product->id)}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                                <a href="{{route('previewProduct', $product->id)}}" target="_blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            {{$productList->links()}}
                            <br>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row -->
    </div>  

</div>    
  

@endsection('content')