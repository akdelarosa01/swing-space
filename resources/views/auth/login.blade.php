@extends('layouts.auth')

@section('content')
<form class="sign-in-form" action="{{ route('login') }}" method="POST">
    @csrf
    <div class="card">
        <div class="card-body">
            <a href="{{ url('/') }}" class="brand text-center d-block m-b-20">
                <h2>Swing Space</h2>
                {{-- <img src="/img/swingspace_logo.png" alt="Swing Space" height="100px" /> --}}
            </a>
            <h5 class="sign-in-heading text-center m-b-20">Sign in to your account</h5>

            <div class="form-group">
                <label for="email" class="sr-only">{{ __('E-Mail Address') }}</label>
                <input type="email" id="email" class="form-control form-control-sm{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email address" name="email" value="{{ old('email') }}" required autofocus>

                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="password" class="sr-only">{{ __('Password') }}</label>
                <input type="password" id="password" class="form-control form-control-sm{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>

                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>


            <div class="checkbox m-b-10 m-t-20">
                <div class="custom-control custom-checkbox checkbox-primary form-check">
                    <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="custom-control-label" for="remember"> {{ __('Remember Me') }}</label>
                </div>
                <a href="{{ route('password.request') }}" class="float-right">Forgot Password?</a>
            </div>
            <button class="btn btn-info btn-sm btn-floating btn-block" type="submit">{{ __('Login') }}</button>
        </div>

    </div>
</form>
@endsection
