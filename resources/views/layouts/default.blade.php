<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script src="{{ mix('/js/manifest.js') }}" async></script>
    <script src="{{ mix('/js/vendor.js') }}" async></script>
    @stack('scripts')

    <title>{{ config('app.name') }}</title>
</head>

<body class="min-h-screen bg-gray-100 my-5">
    @yield('content')
</body>

</html>
