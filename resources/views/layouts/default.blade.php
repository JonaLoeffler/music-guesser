<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script src="/js/manifest.js" async></script>
    <script src="/js/vendor.js" async></script>
    <script src="/js/app.js" async></script>

    <title>{{ config('app.name') }}</title>
</head>

<body class="min-h-screen bg-gray-100 my-5">
    @yield('content')
</body>

</html>
