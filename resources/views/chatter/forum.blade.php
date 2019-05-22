@extends('layouts.forum')

@section('content')
{{ Breadcrumbs::render('chatter.forum', $forum) }}

@if($forum->children()->exists())
<div class="mb-3">
    <div class="bg-white rounded shadow-sm p-3">
        <ul class="list-inline m-0">
            @foreach($forum->children as $child)
            <li class="list-inline-item">
                <a href="{{ route('chatter.forum', [$child->slug, $child->id]) }}" class="text-lg text-secondary">
                    {{ $child->name }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endif

{{-- {{ $threads->links() }} --}}

@if(count($threads))
@can('write', $forum)
<a href="{{ route('chatter.forum.create_thread', [$forum->slug, $forum->id]) }}"
    class="btn btn-primary mb-3 rounded-pill">
    {{ __('Criar novo post') }}
</a>
@endcan
@endif

<div class="bg-white rounded shadow-sm p-3">
    @forelse ($threads as $thread)
    <div class="d-flex align-items-center">
        <div>
            <user-avatar :user="{{$thread->author}}" :classes="['mr-3', 'rounded']" size="s"></user-avatar>
        </div>
        <div class="d-flex w-100 align-items-center">
            <div>
                <a href="{{ route('chatter.thread', [$thread->slug, $thread->id]) }}" class="text-primary text-lg">
                    @if($thread->sticky)<small><i class="fas fa-thumbtack fa-fw"></i></small> @endif
                    {{ $thread->title }}
                </a>
                <ul class="list-inline text-secondary mt-1 mb-0">
                    <li class="list-inline-item">
                        <small><i class="fas fa-user"></i> {{ $thread->author->nick }}</small>
                    </li>
                    <li class="list-inline-item">
                        <small><i class="fas fa-shield-alt"></i>
                            {{ $thread->author->highest_group->value['display_name'] }}</small>
                    </li>
                    <li class="list-inline-item">
                        <small><i class="fas fa-clock"></i> {{ $thread->created_at->diffForHumans() }}</small>
                    </li>
                    <li class="list-inline-item">
                        <small>
                            <i class="far fa-comment-dots"></i>
                            {{ plural('resposta', 'respostas', $thread->replies_count, 'nenhuma resposta') }}
                        </small>
                    </li>
                </ul>
            </div>
            <div class="ml-auto text-right">
                <div class="d-block">Última resposta</div>
                <div class="d-block">
                    {{ $thread->last_post->author->nick }}, {{ $thread->last_post->created_at->diffForHumans() }}
                </div>
            </div>
        </div>
    </div>

    @if(!$loop->last)
    <hr class="dashed">
    @endif

    @empty
    <div class="text-center p-4">
        @can('write', $forum)
        <p class="m-4">Nenhuma postagem até o momento. Seja o primeiro a postar algo!</p>
        <a href="{{ route('chatter.forum.create_thread', [$forum->slug, $forum->id]) }}"
            class="btn btn-lg btn-primary rounded-pill">
            {{ __('Criar novo post') }}
        </a>
        @else
        <p class="m-4">Nenhuma postagem até o momento.</p>
        @endcan
    </div>
    @endforelse
</div>
@stop