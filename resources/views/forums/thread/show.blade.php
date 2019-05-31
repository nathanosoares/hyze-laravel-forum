@extends('layouts.forum')

@section('page.title', $thread->title . ' - ' . env('APP_NAME'))

@section('content')

    <div class="breadcrumb-scroll rounded">
        {{ Breadcrumbs::render('forums.thread', $thread) }}
    </div>

    <show-thread-view :initial-posts='@json($posts)'
                      :thread='@json($thread)'
                      :can-reply='@json(!Auth::guest())'
                      fetch-action='{{ route('forums.api.threads.posts', $thread->id) }}'
                      reply-action='{{ route('forums.api.threads.posts.store', $thread->id) }}'
    ></show-thread-view>
@stop
