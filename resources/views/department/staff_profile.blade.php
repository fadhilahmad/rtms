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
                <h4><i class="fa fa-edit"></i> Edit Profile</h4>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('staff.update', $staff) }}" >
                <!-- <form > -->
                {{ csrf_field() }}
                {{ method_field('patch') }}
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-8">
                        <input type="text" id="username"  value= "{{ old('username', $staff->username) }}" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Position</label>
                        <div class="col-sm-8">
                        @switch($staff->u_type)
                            @case('3') 
                            <input type="text" id="department"  value= "Designer" class="form-control" disabled>
                                @break
                            @case('4') 
                            <input type="text" id="department"  value= "Tailor" class="form-control" disabled>
                            
                                @break
                            @case('5') 
                            <input type="text" id="department"  value= "Printing" class="form-control" disabled>
                           
                                @break
                        @endswitch
                       
                        </div>
                    </div>
                   
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Full Name</label>
                        <div class="col-sm-8">
                        <input type="text" id="name" name="name" value= "{{ old('u_fullname', $staff->u_fullname) }}" class="form-control" required>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                                </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-8">
                           <input type="email" id="email"  name="email" value= "{{ old('email', $staff->email) }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-sm-8">
                            <input type="text" id="phone"  name="phone" value= "{{ old('phone', $staff->phone) }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-8">
                            <input type="text" id="address"  name="address" value= "{{ old('address', $staff->address) }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="card-header d-flex align-items-right flex-column">
                        <h5><i class="fa fa-lock"></i> Change Password</h5>
                        <p>**Only fill in this field if you want to change password!</p>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-8">
                                <input id="password" type="password" class="form-control"  name="password"  autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                 @enderror
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Confirm Password</label>
                            <div class="col-sm-8">
                            <input id="password-confirm" type="password" class="form-control"  name="password_confirmation"  autocomplete="new-password">                        
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
