<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Swing Space') }}</title>

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('/css/main.css') }}">
</head>
<body class="compact-menu">
    <div class="container">
        @yield('content')
    </div>

    <script src="{{ mix('/js/main.js') }}"></script>
</body>
</html>
