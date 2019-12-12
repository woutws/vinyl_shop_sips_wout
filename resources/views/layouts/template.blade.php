<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" >
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @yield("css_after")
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" />
    <title>@yield('title', 'The Vinyl Shop')</title>
</head>
<body>
    {{--  Navigation  --}}
    @include('shared.navigation')

    <main class="container mt-3">
        @yield('main', 'Page under construction ...')

    </main>

    {{--  Footer  --}}
    <div class="container">
    @include("shared.footer")
    </div>
   {{--  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script> --}}
    <script src="{{ mix('js/app.js') }}"></script>
    @yield("script_after")
    @if(env('APP_DEBUG'))
    <script>
        $('form').attr('novalidate', 'true');
    </script>
@endif
</body>
</html>
