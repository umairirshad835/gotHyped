@extends('layouts.app')

@section('content')



<div class="side-app">

    <!-- CONTAINER -->
    <div class="main-container container-fluid">

        <!-- PAGE-HEADER -->
        <div class="page-header">
            <h1 class="page-title">Manage Staff</h1>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Staff List</h3>
                        <a href="{{route('addstaff')}}" class="btn" style="background-color:#5ba9dc;color:white;">Add Staff</a>
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
                                            <th style="color:white;">Role</th>
                                            <th style="color:white;">Status</th>
                                            <th style="color:white;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($staffList as $key => $staff)
                                        <tr>
                                            <td>{{++$key}}</td>
                                            <td>{{$staff->name}}</td>
                                            <td>{{$staff->email}}</td>
                                            <td>{{$staff->phone}}</td>
                                            <td>{{$staff->roles}}</td>
                                            <td>
                                                <form action="{{route('changeStaffStatus',$staff->id)}}" method="POST">
                                                    @csrf
                                                <input type="hidden" name="user_status" value="{{ $staff->status == 1 ? 0 : 1 }}"/>

                                                    @if($staff->status == 1)
                                                        <button type="submit" class="btn btn-success">Active</button>
                                                    @else
                                                        <button type="submit" class="btn btn-danger">In-active</button>
                                                    @endif
                                                </form>
                                            </td>
                                            <td>
                                                <a href="{{route('editstaff', $staff->id)}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            {{$staffList->links()}}
                            <br>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row -->
    </div>  

</div>    
  

@endsection('content')