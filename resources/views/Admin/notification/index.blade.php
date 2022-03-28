@extends('layouts.app')

@section('content')



<div class="side-app">

    <!-- CONTAINER -->
    <div class="main-container container-fluid">

        <!-- PAGE-HEADER -->
        <div class="page-header">
            <h1 class="page-title">Manage Notification</h1>
        </div>
        <!-- PAGE-HEADER END -->

        <!-- Row -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Notification List</h3>
                    <a href="{{route('addNotification')}}" class="btn" style="background-color:#5ba9dc;color:white;">Add Notification</a>
                    </div>
                    <div class="card-body">
                            <div class="table-responsive">
                                <table class="table border text-nowrap text-md-nowrap mb-0">
                                    <thead style="background-color:#5ba9dc;">
                                        <tr>
                                            <th style="color:white;">#</th>
                                            <th style="color:white;">Name</th>
                                            <th style="color:white;">Description</th>
                                            <th style="color:white;">Status</th>
                                            <th style="color:white;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($notificationList as $key => $notification)
                                        <tr>
                                            <td>{{++$key}}</td>
                                            <td>{{$notification->title}}</td>
                                            <td>{{$notification->body}}</td>
                                            <td>
                                                <form action="{{route('changeNotificationStatus',$notification->id)}}" method="POST">
                                                    @csrf
                                                <input type="hidden" name="status" value="{{ $notification->status == 1 ? 0 : 1 }}"/>

                                                    @if($notification->status == 1)
                                                        <span class="badge bg-success me-1 mb-1 mt-1 p-2">Sent</span>
                                                    @else
                                                        <a href="{{route('editNotification', $notification->id)}}" class="btn btn-default btn-sm">Draft</a>
                                                    @endif
                                                </form>
                                            </td>
                                            <td>
                                                <a href="{{route('editNotification', $notification->id)}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            {{$notificationList->links()}}
                            <br>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row -->
    </div>  

</div>    
  

@endsection('content')