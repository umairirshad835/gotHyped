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
        
        <form method="POST" action="{{ route('updateNotification') }}" autocomplete="off" class="card">
            @csrf
            <input type="hidden" name="notification_id" value="{{$notifincation->id}}">
            <div class="card-header" style="background-color:#5ba9dc;color:white;">
                <h3 class="card-title">Edit Notification</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <div class="form-group">
                            <label class="form-label">Title</label>
                            <input id="title" class="form-control @error('title') is-invalid @enderror" value="{{ $notifincation->title }}" name="title" type="text" placeholder="Enter title">
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>

                    <!-- <div class="col-xl-6 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Status</label>
                            <select class="form-control form-select @error('status') is-invalid @enderror" data-placeholder="Choose one" name="status">
                                    <option label="Choose one"></option>
                                    <option value="1" {{$notifincation->status == 1 ? 'selected' : ''}}>Sent</option>
                                    <option value="0" {{$notifincation->status == 0 ? 'selected' : ''}}>Draft</option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div> -->
                </div>
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <div class="form-group">
                            <label class="form-label">Body</label>
                            <textarea name="body" id="body" class="form-control  @error('body') is-invalid @enderror" rows="2" placeholder="Enter description"> {{ $notifincation->body }} </textarea>
                                @error('body')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                </div>
                        <button type="submit" class="btn py-1 px-4 mb-1" style="background-color:#5ba9dc;color:white;">Update Notification</button>
            </div>
        </form>
    </div>
    <!-- CONTAINER CLOSED -->

</div>

@endsection('content')