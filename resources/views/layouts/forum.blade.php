<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="theme-color" content="#0b1828" />
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

<body class="d-flex flex-column h-100">

    <noscript>
        This app works best with JavaScript enabled.
    </noscript>


    <main id="app" class="flex-shrink-0">
        @include('layouts.components.forum.navbar')

        <main class="py-4 container">
            @yield('content')
        </main>
    </main>

    <footer class="footer mt-auto py-3">
        <div class="container">
            <div class="d-flex align-items-center">
                <div>
                    <p class="m-0">
                        &copy; {{ now()->year }} <a href="{{ route('home') }}">Hyze</a>. Todos direitos reservados.
                    </p>
                    <small>O Hyze não é, de maneira alguma, afiliado à ou endossado pela Mojang.</small>
                </div>
                <div class="ml-auto d-flex text-right mt-auto">
                    <a href="https://twitter.com/nathanosoares" target="_blank" data-toggle="tooltip"
                        title="Desenvolvido por Nathan Soares." class="text-secondary mr-3">
                        <small><i class="fas fa-heart"></i> N</small>
                    </a>

                    <a href="http://twitter.com/srkadoo" target="_blank" data-toggle="tooltip"
                        title="Layout por Ricardo Vinicius." class="text-secondary">
                        <small><i class="fas fa-heart"></i> R</small>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    @auth
    <script>
        window.user = @json(auth()->user())
    </script>
    @endauth
    <script src="{{ mix('/assets/forum/js/app.js') }}"></script>
    @yield('js')
</body>

</html>