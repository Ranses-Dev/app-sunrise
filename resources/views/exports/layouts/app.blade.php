<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Export')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/exports/app.css') }}">
</head>

<body>
    <div class="container">
        @yield('content')
    </div>
</body>

</html>
