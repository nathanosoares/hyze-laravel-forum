@extends('layouts.chatter')

@section('content')

    {{ Breadcrumbs::render('chatter') }}

    <div class="row">
        <div class="col-12">
            <h4 class="mb-2 mt-4 text-secondary">
                Tópicos recentes
            </h4>

            <div class="p-3 mb-4 shadow bg-white rounded">
                @foreach($recent as $thread)
                    <div class="d-none d-lg-flex flex-nowrap bg-ghost align-items-center">
                        <div>
                            <user-avatar :user="{{$thread->author}}" :classes="['mr-3']" size="s"></user-avatar>
                        </div>

                        <div class="mr-3">
                            <a href="{{ thread_url($thread) }}"
                            class="text-decoration-none text-body h5">{{ $thread->title }}</a>
                            <div>
                                Postado por <user-twitter-anchor :user="{{ $thread->author }}"
                                                                label="{{ $thread->author->nick }}"></user-twitter-anchor>,
                                {{ $thread->created_at->diffForHumans() }}
                            </div>
                        </div>

                        <div class="flex-shrink-0 ml-auto text-right">
                            <div class="d-block">Última resposta</div>
                            <div class="d-block">
                                <user-twitter-anchor :user="{{ $thread->last_post->author }}"
                                                    label="{{ $thread->last_post->author->name }}"></user-twitter-anchor>,
                                {{ $thread->last_post->created_at->diffForHumans() }}
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
                                    {{ $thread->last_post->author->name }} <span class="text-muted">{{ '@' . $thread->last_post->author->username }}</span>
                                </user-twitter-anchor> <span class="text-muted">&#183; respondeu {{ $thread->last_post->created_at->diffForHumans() }}:</span>
                            </div>

                            <div class="my-2">
                                {!! str_limit(strip_tags($thread->last_post->body_parsed, '<p><a><b><strong><i><em><br>'), 90, '...') !!}
                            </div>

                            <div>
                                <span class="text-muted">em</span> <a href="{{ thread_url($thread) }}" class="text-decoration-none">{{ $thread->title }}</a>
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
                    
                    <div class="p-3 shadow bg-white rounded">
                        @foreach($category->items as $item)

                            <h5 class="m-0">
                                <a href="{{ $item->getRoute() }}">
                                    {{ $item->getDisplayName() }}
                                </a>
                            </h5>

                            <p class="m-0 text-muted">{{ $item->getDescription() }}</p>

                            @if(count($item->getChildren()))
                                <ul class="list-inline m-0">
                                    @foreach($item->getChildren() as $child)
                                        <li class="list-inline-item">
                                            <a href="{{ $child->getRoute() }}" class="text-dark">
                                                {{ $child->getDisplayName() }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
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