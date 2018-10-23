@extends('layouts.auth')

@section('content')
<form class="sign-in-form" method="POST" action="{{ route('password.email') }}">
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


            <div class="form-group">
                <label for="inputEmail" class="sr-only">{{ __('E-Mail Address') }}</label>
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="E-Mail Address" required>

                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <button class="btn btn-primary btn-rounded btn-floating btn-lg btn-block" type="submit">
                {{ __('Send Password Reset Link') }}
            </button>
        </div>
    </div>
</form>
@endsection
