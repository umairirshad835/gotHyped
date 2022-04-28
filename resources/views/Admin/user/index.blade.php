@extends('layouts.app')

@section('content')



<div class="side-app">

    <!-- CONTAINER -->
    <div class="main-container container-fluid">

        <!-- PAGE-HEADER -->
        <div class="page-header">
            <h1 class="page-title">Manage User</h1>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">User List</h3>
                    </div>
                    <div class="card-body">
                            <div class="table-responsive">
                                <table class="table border text-nowrap text-md-nowrap mb-0">
                                    <thead style="background-color:#5ba9dc;">
                                        <tr>
                                            <th style="color:white;">#</th>
                                            <th style="color:white;">Name</th>
                                            <th style="color:white;">Email</th>
                                            <th style="color:white;">Phone</th>
                                            <th style="color:white;">Address</th>
                                            <th style="color:white;">Status</th>
                                            <th style="color:white;">Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($userList as $key => $user)
                                        <tr>
                                            <td>{{++$key}}</td>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>{{$user->phone}}</td>
                                            <td>{{$user->address}}</td>
                                            <td>
                                                <form action="{{route('changeStaffStatus',$user->id)}}" method="POST">
                                                    @csrf
                                                <input type="hidden" name="user_status" value="{{ $user->status == 1 ? 0 : 1 }}"/>

                                                    @if($user->status == 1)
                                                        <button type="submit" class="btn btn-success">Active</button>
                                                    @else
                                                        <button type="submit" class="btn btn-danger">In-active</button>
                                                    @endif

                                                    <td><a href="{{route('userdetail',$user->id)}}" class="btn btn-primary">Details</a></td>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            {{$userList->links()}}
                            <br>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row -->
    </div>  

</div>    
  

@endsection('content')