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
        
        <form method="POST" action="{{ route('updatestaff') }}" class="card">
            @csrf
            <input type="hidden" name="staff_id" value="{{$staff->id}}">
            <div class="card-header" style="background-color:#5ba9dc;color:white;">
                <h3 class="card-title">Update Staff</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-6 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Name</label>
                            <input id="name" class="form-control @error('name') is-invalid @enderror limitinput" value="{{ $staff->name }}" name="name" type="text">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input id="Email" class="form-control @error('email') is-invalid @enderror" value="{{ $staff->email }}" name="email" type="email">
                                @error('email')
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
                            <label class="form-label">Phone</label>
                            <input id="phone" class="form-control @error('phone') is-invalid @enderror limitphone" value="{{ $staff->phone }}"" name="phone" type="text">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Address</label>
                            <input id="address" class="form-control @error('address') is-invalid @enderror" value="{{ $staff->address }}" name="address" type="text">
                                @error('address')
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
                            <label class="form-label">password</label>
                            <input id="password" class="form-control @error('password') is-invalid @enderror" name="password" type="text">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Role</label>
                            <select class="form-control form-select @error('role') is-invalid @enderror" data-placeholder="Choose one" name="role">
                                    <option label="Choose one"></option>
                                    <option value="admin" {{$staff->roles == 'admin' ? 'selected' : ''}}>Admin</option>
                                    <option value="manager" {{$staff->roles == 'manager' ? 'selected' : ''}}>Manager</option>
                                    <option value="user" {{$staff->roles == 'user' ? 'selected' : ''}}>User</option>
                                </select>
                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                </div>
                        <button type="submit" class="btn py-1 px-4 mb-1" style="background-color:#5ba9dc;color:white;">Update staff</button>
            </div>
        </form>
    </div>
    <!-- CONTAINER CLOSED -->

</div>

@endsection('content')

@section('custom-js')
<script>
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

    $('input.limitphone').on('keyup', function() {
        limitPhone(this, 13)
    });

    function limitPhone(field, maxChar){
        var ref = $(field),
            val = ref.val();
        if ( val.length >= maxChar ){
            ref.val(function() {
                console.log(val.substr(0, maxChar))
                return val.substr(0, maxChar);       
            });
        }
    }

</script>
@endsection('custom-js')