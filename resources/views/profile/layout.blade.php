@extends('layouts.forum')

@section('content')

<div class="row">
    <div class="col-3">
        <div class="list-group shadow-sm">
            <a href="{{ route('profile.details') }}"
                class="list-group-item list-group-item-action {{ request()->route()->getName() == 'profile.details' ? 'active' : '' }}">
                <i class="fas fa-info fa-fw mr-2"></i> Detalhes
            </a>
            <a href="{{ route('profile.security') }}"
                class="list-group-item list-group-item-action {{ request()->route()->getName() == 'profile.security' ? 'active' : '' }}">
                <i class="fas fa-user-lock fa-fw mr-2"></i> Segurança
            </a>
        </div>
    </div>

    <div class="col-9 d-flex d-lg-block">
        @yield('profile.content')
    </div>
</div>
@stop