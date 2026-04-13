<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <title>
        @hasSection('title')
            @yield('title') - {{ config('app.name') }}
        @else
            {{ config('app.name') }}
        @endif
    </title>

    <link rel="stylesheet" href="{{ asset('bs/font/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bs/css/bootstrap.min.css') }}">

    @stack('css')
</head>

<body>

    @yield('body')

    <script src="{{ asset('bs/js/bootstrap.bundle.min.js') }}"></script>

    @stack('js')

</body>

</html>
