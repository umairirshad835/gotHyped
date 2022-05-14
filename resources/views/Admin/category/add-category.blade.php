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
        
        <form method="POST" action="{{ route('saveCategory') }}" autocomplete="off" class="card">
            @csrf
            <div class="card-header" style="background-color:#5ba9dc;color:white;">
                <h3 class="card-title">Add New Category</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-6 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Name</label>
                            <input id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" name="name" type="text" placeholder="Enter category name">
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
                                    <option value="1">Active</option>
                                    <option value="0">In-active</option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($sizes as $key => $size)
                        <div class="col-xl-3 col-md-3">
                            <label class="form-label"><input type="checkbox" name="size_id[{{$key}}]" id="cat_size" value="{{$size->id}}"> {{$size->name}} </label>
                        </div>
                    @endforeach    
                </div>
                        <button type="submit" class="btn py-1 px-4 mb-1" style="background-color:#5ba9dc;color:white;">Add Category</button>
            </div>
        </form>
    </div>
    <!-- CONTAINER CLOSED -->

</div>

@endsection('content')