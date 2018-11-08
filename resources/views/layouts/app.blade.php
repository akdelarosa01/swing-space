<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Swing Space') }}</title>

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500" rel="stylesheet">

    @stack('styles')
    <link rel="stylesheet" href="{{ mix('/css/main.css') }}">
</head>
<body class="compact-menu">
    <div id="vue_app">
        <div id="app">
            @include('partials.sidebar')

            <div class="content-wrapper">
                @include('partials.header')

                <div class="content">
                    <section class="page-content container-fluid">
                        <div class="loading"></div>
                        @yield('content')
                    </section>
                </div>

                @include('partials.footer')
                @include('modals.global')
            </div>
        </div>
    </div>

    <script src="{{ mix('/js/main.js') }}"></script>
    @stack('scripts')
    <script type="text/javascript">
        getLanguage();
    </script>
</body>
</html>
