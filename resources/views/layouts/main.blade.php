<!doctype html>
<html lang="en">
<head>
    <base href="/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pool Mates</title>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>

    <script type="application/javascript" src="{{ elixir('js/all.js') }}"></script>
    <link rel="stylesheet" href="{{ elixir('css/all.css') }}"/>
</head>
<body>
    {{--Need to render the navbar on all pages except landing page--}}
    @if(!isset($can_render_navbar) || $can_render_navbar == true)
        @include('layouts.navbar')
    @endif

    {{--Display content of the page--}}
    @yield('content')
</body>
</html>