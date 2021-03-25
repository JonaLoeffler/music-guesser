<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script src="{{ mix('/js/manifest.js') }}"></script>
    <script src="{{ mix('/js/vendor.js') }}"></script>
    @stack('scripts')

    <title>{{ config('app.name') }}</title>
</head>

<body class="bg-gray-100">
    @if (session()->has('error'))
        <div class="bg-red-300 font-bold text-red-700 text-center p-1">
            {{ session('error') }}
        </div>
    @endif

    @yield('content')
</body>

</html>
