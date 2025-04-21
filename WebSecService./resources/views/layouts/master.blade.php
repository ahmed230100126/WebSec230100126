<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Basic Website - @yield('title')</title>
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap-icons.css') }}">
</head>
<body>
    @include('layouts.menu')
    <div class="container">
        @yield('content')
    </div>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>
</body>
</html>