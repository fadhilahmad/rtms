@extends('auth.layout')

@section('content')

<div class="card-reset">
    <div class="card-header"> 
        <h3>{{ __('Reset Password') }}</h3>    
    </div>

    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="input-group form-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                </div>
                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror                
            </div>   
            <div class="form-group">
                <input type="submit" value="Send Password Reset Link" class="btn float-right reset_btn">
            </div>
           
        </form>
    </div>
</div>

@endsection
