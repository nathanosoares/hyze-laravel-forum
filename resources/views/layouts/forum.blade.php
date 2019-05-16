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
    <link href="{{ mix('/assets/forum/css/app.css') }}" rel="stylesheet">

    {!! NoCaptcha::renderJs() !!}

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
    @include('layouts.components.forum.navbar')

    <main class="py-4 container">
        @yield('content')
    </main>

    <footer class="py-4 text-center w-100 mt-auto">
        <p>&copy; 2018 - {{ now()->year }} HYZE</p>
    </footer>
</div>

<!-- Scripts -->
<script src="{{ mix('/assets/forum/js/app.js') }}"></script>
@yield('js')
</body>
</html>
