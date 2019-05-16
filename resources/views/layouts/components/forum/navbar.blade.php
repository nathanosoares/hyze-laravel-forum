<header>
    <div class="container">
        <nav class="navbar navbar-expand-lg bd-navbar navbar-dark navbar-hyze">
            <a class="navbar-brand mr-0 mr-md-2" href="{{ route('home') }}">
                <span></span>
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item {{ request()->route()->getName() == 'home' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('home') }}">Início</a>
                    </li>

                    <li class="nav-item {{ starts_with(request()->route()->getName(), 'chatter') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('chatter.home') }}">
                            Comunidade
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-warning" href="https://loja.hyze.net" target="_blank">
                            <i class="fa fa-star"></i> Loja
                        </a>
                    </li>

                    @guest
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link text-white">
                                Entrar
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link text-white dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->nick }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @if (Auth::user()->isSuperAdmin())
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        Admin
                                    </a>
                                @endif

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                    Sair
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>

                    @endguest
                </ul>
            </div>
        </nav>
    </div>
</header>