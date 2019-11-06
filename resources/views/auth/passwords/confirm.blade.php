@extends('auth.layout')

@section('content')
<div class="card-reset">
    <div class="card-header">
         <h3> {{ __('Confirm Password') }}</h3>      
    </div>

    <div class="card-body">
        <p>{{ __('Please confirm your password before continuing.') }}</p>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="input-group form-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                </div>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="current-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <input type="submit" value="Confirm Password" class="btn float-right confirm_btn">
            </div>
        </form>
    </div>
    <div class="card-footer">             
        <div class="d-flex justify-content-center">
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}">Forgot your password?</a>
        @endif
        </div>
    </div>
</div>
       
@endsection
