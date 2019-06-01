@extends('layouts.forum')

@section('page.title', 'Comunidade - ' . env('APP_NAME'))

@section('content')
<div class="breadcrumb-scroll rounded">
    {{ Breadcrumbs::render('forums') }}
</div>

<div class="row">
    <div class="col-12">
        <h4 class="mb-2 mt-4 text-secondary">
            Tópicos recentes
        </h4>

        <div class="p-3 mb-4 shadow-sm bg-white rounded">
            @foreach($recent as $thread)
            <div class="d-none d-md-flex flex-nowrap bg-ghost align-items-center">
                <div>
                    <user-avatar :user="{{$thread->author}}" :overlay="{{$thread->author}}"
                        :classes="['mr-3', 'rounded']" size="s"></user-avatar>
                </div>

                <div class="mr-3">
                    <a href="{{ thread_url($thread) }}" class="text-primary text-lg">
                        @if($thread->sticky)<small><i class="fas fa-thumbtack fa-fw"></i></small> @endif
                        {{ $thread->title }}
                    </a>
                    <ul class="list-inline text-secondary mb-0">
                        <li class="list-inline-item">
                            <small>
                                <i class="fas fa-user fa-fw"></i> {{ $thread->author->nick }}
                            </small>
                        </li>
                        <li class="list-inline-item">
                            <small>
                                <i class="fas fa-shield-alt fa-fw"></i>
                                {{ $thread->author->highest_group->value['display_name'] }}
                            </small>
                        </li>
                        <li class="list-inline-item">
                            <small>
                                <i class="fas fa-clock fa-fw"></i>
                                {{ $thread->created_at->diffForHumans() }}
                            </small>
                        </li>
                        <li class="list-inline-item">
                            <small>
                                <i class="far fa-comment-dots fa-fw"></i>
                                {{ plural('resposta', 'respostas', $thread->replies_count, 'nenhuma resposta') }}
                            </small>
                        </li>
                    </ul>
                </div>

                <div class="flex-shrink-0 ml-auto text-right">
                    <div class="d-block">
                        @if ($thread->replies_count > 0)
                        Última resposta
                        @else
                        Postado por
                        @endif
                    </div>
                    <div class="d-block">
                        {{ $thread->last_post->author->nick }}, {{ $thread->last_post->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>

            <div class="d-flex d-md-none flex-nowrap bg-ghost mb-1 ">
                <div class="mr-2">
                    <user-avatar :user="{{$thread->author}}" size="46px" class="rounded mr-2"></user-avatar>
                </div>

                <div class="flex-grow-0 overflow-hidden">
                    <div>
                        <ul class="list-inline text-secondary mb-0">
                            <li class="list-inline-item">
                                <small>
                                    <i class="fas fa-user fa-fw"></i> {{ $thread->author->nick }}
                                </small>
                            </li>
                            <li class="list-inline-item">
                                <small>
                                    <i class="fas fa-shield-alt fa-fw"></i>
                                    {{ $thread->author->highest_group->value['display_name'] }}
                                </small>
                            </li>
                            <li class="list-inline-item">
                                <small>
                                    @if ($thread->replies_count > 0)respondeu @else postou @endif
                                    {{ $thread->last_post->created_at->diffForHumans() }}:</span>
                                </small>
                            </li>
                        </ul>
                    </div>

                    <div class="my-2">
                        {!! str_limit(strip_tags($thread->last_post->body_parsed), 90, '...') !!}
                    </div>

                    <div>
                        <span class="text-muted">em</span> <a href="{{ thread_url($thread) }}"
                            class="text-primary text-decoration-none">{{ $thread->title }}</a>
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
                @foreach($category->forums()->allowed()->get() as $forum)

                <a href="{{ route('forums.forum', [$forum->slug, $forum->id]) }}" class="text-primary text-lg">
                    {{ $forum->name }}
                </a>

                <p class="m-0 text-muted">{{ $forum->description }}</p>

                @if(count($forum->children))
                <div class="d-flex m-0">
                    @foreach($forum->children as $child)
                    <div class="d-inline-block mr-3">
                        <a href="{{ route('forums.forum', [$child->slug, $child->id]) }}" class="text-secondary">
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