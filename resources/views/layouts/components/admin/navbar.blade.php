<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
      aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.dashboard') }}">
            Dashboard
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.tree') }}">
            Árvore
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.multimoderation.index') }}">
            Multi Moderação
          </a>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a href="{{ route('forums.home')}}" target="_blank" class="nav-link">Ver fórum</a>
        </li>
      </ul>
    </div>
  </div>
</nav>