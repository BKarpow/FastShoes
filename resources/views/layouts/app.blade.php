<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="site-root" content="{{ url('/') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:locale" content="ru_UA" >
    <meta property="og:locale:alternate" content="uk_UA" >
    <meta property="og:site_name" content="{{env('APP_NAME')}}">
    @yield('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> @yield('title') | Fast - магазин кожаной обуви </title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="h-100" background="red">
    <div id="app" >
            @include('inc.heder')
        <main class="py-4 h-100">
            @yield('content')
        </main>
        @include('inc.footer')
    </div>
    @yield('script-b')
</body>
</html>
