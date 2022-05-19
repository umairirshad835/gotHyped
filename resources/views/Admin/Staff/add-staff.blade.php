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
        
        <form method="POST" action="{{ route('savestaff') }}" autocomplete="off" class="card">
            @csrf
            <div class="card-header" style="background-color:#5ba9dc;color:white;">
                <h3 class="card-title">Add New Staff</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-6 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Name</label>
                            <input id="name" class="form-control @error('name') is-invalid @enderror limitinput" value="{{ old('name') }}" name="name" type="text" placeholder="Enter name">
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
                            <input id="Email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" name="email" type="email" placeholder="Enter e-mail">
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
                            <input id="phone" class="form-control @error('phone') is-invalid @enderror limitphone" value="{{ old('phone') }}" name="phone" type="number" min="0" placeholder="Enter phone number">
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
                            <input id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}" name="address" type="text" placeholder="Enter address">
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
                            <input id="password" class="form-control @error('password') is-invalid @enderror" name="password" type="password" placeholder="Enter password">
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
                                    <option value="admin">Admin</option>
                                    <option value="manager">Manager</option>
                                    <option value="user">User</option>
                                </select>
                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                </div>
                        <button type="submit" class="btn py-1 px-4 mb-1" style="background-color:#5ba9dc;color:white;">Add staff</button>
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