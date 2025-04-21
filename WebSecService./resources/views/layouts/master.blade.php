<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Basic Website - @yield('title')</title>
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</head>
<body>
    @include('layouts.menu')
    <div class="container">
        @yield('content')
    </div>
</body>
</html>
