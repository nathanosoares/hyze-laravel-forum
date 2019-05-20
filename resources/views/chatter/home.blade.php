@extends('layouts.forum')

@section('content')

{{ Breadcrumbs::render('chatter') }}

<div class="row">
    <div class="col-12">
        <h4 class="mb-2 mt-4 text-secondary">
            Tópicos recentes
        </h4>

        <div class="p-3 mb-4 shadow-sm bg-white rounded">
            @foreach($recent as $thread)
            <div class="d-none d-lg-flex flex-nowrap bg-ghost align-items-center">
                <div>
                    <user-avatar :user="{{$thread->author}}" :classes="['mr-3', 'rounded']" size="s"></user-avatar>
                </div>

                <div class="mr-3">
                    <a href="{{ thread_url($thread) }}" class="text-primary h5">
                        {{ $thread->title }}
                    </a>
                    <div class="">
                        <ul class="list-inline text-secondary mt-1 mb-0">
                            <li class="list-inline-item">
                                <small><i class="fas fa-user"></i> {{ $thread->author->nick }}</small>
                            </li>
                            <li class="list-inline-item">
                                <small><i class="fas fa-clock"></i>
                                    {{ $thread->author->highest_group->value->display_name }}</small>
                            </li>
                            <li class="list-inline-item">
                                <small><i class="fas fa-clock"></i> {{ $thread->created_at->diffForHumans() }}</small>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="flex-shrink-0 ml-auto text-right">
                    <div class="d-block">Última resposta</div>
                    <div class="d-block">
                        {{ $thread->last_post->author->nick }}, {{ $thread->last_post->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>

            <div class="d-flex d-lg-none flex-nowrap bg-ghost mb-1 p-3 pb-2">
                <div class="mr-2">
                    <user-avatar :user="{{$thread->author}}" size="46px"></user-avatar>
                </div>

                <div class="flex-grow-0 overflow-hidden">
                    <div>
                        <user-twitter-anchor :user="{{ $thread->last_post->author }}">
                            {{ $thread->last_post->author->name }} <span
                                class="text-muted">{{ '@' . $thread->last_post->author->username }}</span>
                        </user-twitter-anchor> <span class="text-muted">&#183; respondeu
                            {{ $thread->last_post->created_at->diffForHumans() }}:</span>
                    </div>

                    <div class="my-2">
                        {!! str_limit(strip_tags($thread->last_post->body_parsed, '<p><a><b><strong><i><em><br>'), 90,
                                                '...') !!}
                    </div>

                    <div>
                        <span class="text-muted">em</span> <a href="{{ thread_url($thread) }}"
                            class="text-decoration-none">{{ $thread->title }}</a>
                    </div>
                </div>
            </div>

            @if (!$loop->last)
            <hr class="dashed">
            @endif
            @endforeach
        </div>

        @foreach($categories as $category)
        <div class="mb-4">
            <h4 class="mb-2 mt-4 text-secondary">
                {{ $category->name }}
            </h4>

            <div class="p-3 shadow-sm bg-white rounded">
                @foreach($category->forums as $forum)

                <h5 class="m-0">
                    <a href="{{ route('chatter.forum', [$forum->slug, $forum->id]) }}">
                        {{ $forum->name }}
                    </a>
                </h5>

                <p class="m-0 text-muted">{{ $forum->description }}</p>

                @if(count($forum->children))
                <div class="d-flex m-0">
                    @foreach($forum->children as $child)
                    <div class="d-inline-block mr-3">
                        <a href="{{ route('chatter.forum', [$child->slug, $child->id]) }}" class="text-dark">
                            {{ $child->name }}
                        </a>
                    </div>
                    @endforeach
                </div>
                @endif

                @if (!$loop->last)
                <hr class="dashed">
                @endif
                @endforeach
            </div>
        </div>

        @endforeach
    </div>
</div>
@stop