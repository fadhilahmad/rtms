@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
           
        <div class="card-profile">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
             @if ($message = Session::get('error'))
                <div class="alert alert-danger">
                   <p>{{ $message }}</p>
                </div>
            @endif
            <div class="card-header d-flex align-items-center">
                <h4><i class="fa fa-lock"></i>  Change Password</h4>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('customer.updatePassword', $customer) }}" >
                <!-- <form > -->
                {{ csrf_field() }}
                {{ method_field('patch') }}

                    <div class="card-body">
                    <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Current Password</label>
                            <div class="col-sm-6">
                                <input id="password" type="password" class="form-control"  name="old_password" required  autocomplete="current-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                 @enderror
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">New Password</label>
                            <div class="col-sm-6">
                                <input id="password" type="password" class="form-control"  name="new_password" required autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                 @enderror
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">New Confirm Password</label>
                            <div class="col-sm-6">
                            <input id="password-confirm" type="password" class="form-control"  name="confirm_password" required autocomplete="new-password">                        
                            </div>
                        </div>  
                    </div>                                                          
                   
                    <div class="form-group row">       
                        <div class="col-sm-8 offset-sm-2">
                            <input type="submit" value="Update" class="btn btn-primary float-right ">
                        </div>
                      
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
