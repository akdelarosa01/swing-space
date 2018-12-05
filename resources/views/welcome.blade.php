<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Swing Space') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{{ asset('css/main.css') }}">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #ffffff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/dashboard') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="row justify-content-center">
                    <div class="title col-md-7">
                        <img src="/img/logo.png" alt="" class="img-fluid animated infinite swing delay-3s slower" height="300px">
                    </div>
                </div>
                <br>
                    

                <div class="links">
                    <a href="https://facebook.com">
                        <i class="fa fa-facebook-square fa-3x" style="color:#3b5998"></i>
                    </a>
                    <a href="https://instagram.com">
                        <i class="fa fa-instagram fa-3x" style="color:#231F20"></i>
                    </a>
                    <a href="https://twitter.com">
                        <i class="fa fa-twitter fa-3x" style="color:#38A1F3"></i>
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
