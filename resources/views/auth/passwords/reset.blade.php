@extends('layouts.auth')

@section('content')
<form class="sign-in-form" method="POST" action="{{ route('password.update') }}">
    @csrf
    <div class="card">
        <div class="card-body">
            <a href="{{ url('/') }}" class="brand text-center d-block m-b-20">
                <h2>SwingSpace</h2>
                {{-- <img src="../assets/img/qt-logo%402x.png" alt="QuantumPro Logo" /> --}}
            </a>
            <h5 class="sign-in-heading text-center">Forgotten Password?</h5>
            <p class="text-center text-muted">Enter your email to reset your password</p>

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <input type="hidden" name="token" value="{{ $token }}">
                    
            <div class="form-group">
                <label for="email" class="sr-only">{{ __('E-Mail Address') }}</label>
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="E-mail Address" required>

                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="password" class="sr-only">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>

                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="password-confirm" class="sr-only">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation" required>
            </div>

            <button class="btn btn-primary btn-rounded btn-floating btn-lg btn-block" type="submit">
                {{ __('Reset Password') }}
            </button>
        </div>
    </div>
</form>
@endsection
