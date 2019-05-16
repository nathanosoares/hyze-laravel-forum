<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="theme-color" content="#0b1828"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('/assets/admin/css/app.css') }}" rel="stylesheet">

    @yield('css')

    @routes
</head>
<body>

<noscript>
    This app works best with JavaScript enabled.
</noscript>
@auth
    <script>
        window.user = @json(auth()->user())
    </script>
@endauth

<div id="app" class="d-flex flex-column">
    @include('layouts.components.admin.navbar')

    <main class="py-4 container">
        @yield('content')
    </main>
</div>

<!-- Scripts -->
<script src="{{ mix('/assets/admin/js/app.js') }}"></script>
@yield('js')
</body>
</html>
