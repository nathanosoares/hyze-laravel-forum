<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="theme-color" content="#0b1828" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page.title', config('app.name', 'Forum'))</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" lazyload>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" lazyload>

    <!-- Styles -->
    <link href="{{ mix('/assets/forums/css/app.css') }}" rel="stylesheet">

    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">

    @yield('css')

    @routes

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-136128947-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-136128947-2');
    </script>

    @stack('styles')
</head>

<body class="d-flex flex-column h-100">

    <noscript>
        This app works best with JavaScript enabled.
    </noscript>

    <main id="app" class="flex-shrink-0">
        @include('layouts.components.forum.navbar')

        <main class="py-4 container">
            @auth
            @if(!auth()->user()->email)
            <div class="alert alert-warning d-flex align-items-center" role="alert">
                <div>
                    <p class="text-lg">Recomendamos que você defina um e-mail para sua conta.</p>
                    <p>Seu email poderá ser usado para recuperar sua conta caso você se esqueça da sua senha.</p>
                </div>

                @if(!request()->routeIs('profile.security'))
                <div class="ml-auto mt-2">
                    <a href="{{ route('profile.security') }}" class="btn btn-primary rounded-pill">
                        Definir email
                    </a>
                </div>
                @endif
            </div>
            @elseif(!auth()->user()->hasVerifiedEmail())
            @include('auth.components.emai_confirmation', ['email' => auth()->user()->email])
            @elseif(session()->has('verified') && session()->get('verified'))
            <div class="alert alert-success">
                Seu e-mail foi confirmado com sucesso!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            @endauth

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

    {!! NoCaptcha::renderJs() !!}
    <script src="{{ mix('/assets/forums/js/app.js') }}"></script>

    @stack('scripts')
</body>

</html>
