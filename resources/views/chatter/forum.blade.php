@extends('layouts.chatter')

@section('content')
    {{ Breadcrumbs::render('chatter.forum', $forum) }}

    @if($forum->children()->exists())
        <div class="mb-3">
            <div class="bg-ghost p-3">
                <ul class="list-inline m-0">
                    @foreach($forum->children as $child)
                        <li class="list-inline-item">
                            <a href="{{ route('chatter.forum', [$child->slug, $child->id]) }}">
                                {{ $child->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{ $threads->links() }}

    @if(count($threads))
        @can('write', $forum)
            <a href="{{ route('chatter.forum.create_thread', [$forum->slug, $forum->id]) }}"
               class="mb-3 btn btn-custom-secondary">
                {{ __('Criar novo post') }}
            </a>
        @endcan
    @endif

    <div class="bg-ghost p-3">
        @forelse ($threads as $thread)
            <div class="d-flex {{ $loop->count == 1 ? '' : ($loop->last ? 'pt-3' : 'border-bottom ' . ($loop->first ? 'pb-3' : 'py-3'))}}">
                <div>
                    <user-avatar :user="{{$thread->author}}" :classes="['mr-3']" size="s"></user-avatar>
                </div>
                <div>
                    <h5>
                        <a href="{{ route('chatter.thread', [$thread->slug, $thread->id]) }}">
                            {{ $thread->title }}
                        </a>
                    </h5>
                    <div>
                        <span class="font-weight-light">
                            Por <span class="font-weight-normal">{{ $thread->author->name }}</span>,
                            {{ $thread->created_at->format('d \d\e M. Y') }}
                            em <span class="font-weight-normal">{{ $thread->forum->name }}</span>
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center p-4">
                <img src="{{ asset('images/kweeback.png') }}" alt="">

                @can('write', $forum)
                    <p class="m-4">Nenhuma postagem até o momento. Seja o primeiro a postar algo!</p>
                    <a href="{{ route('chatter.forum.create_thread', [$forum->slug, $forum->id]) }}"
                       class="btn btn-lg btn-custom-secondary">
                        {{ __('Criar novo post') }}
                    </a>
                @else
                    <p class="m-4">Nenhuma postagem até o momento.</p>
                @endcan
            </div>
        @endforelse
    </div>
@stop