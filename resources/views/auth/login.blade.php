@extends('auth.layout')

@section('content')
 <div class="card-login">
    <div class="card-header">
        <h3>Login</h3>
    
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('login') }}">
        @csrf
            <div class="input-group form-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input id="username" type="text" class="form-control " placeholder="Username" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                
                
            </div>
            <div class="input-group form-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                </div>
                <input id="password" type="password" class="form-control " placeholder="Password" name="password" required autocomplete="current-password">
                
            </div>
               @if(session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session()->get('error') }}
                        </div>
               @endif
    
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                <label class="form-check-label" for="remember">
                    {{ __('Remember Me') }}
                </label>
            </div>
            <div class="form-group">
                <input type="submit" value="Login" class="btn float-right login_btn">
            </div>
        </form>
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-center links">
            Don't have an account?<a href="{{ route('register') }}">Register</a>
        </div>
        <div class="d-flex justify-content-center">
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}">Forgot your password?</a>
        @endif
        </div>
    </div>
</div>
@endsection