@extends('layouts.chatter')

@section('content')

    {{ Breadcrumbs::render('chatter.thread', $thread) }}

    <show-thread-view :initial-posts='@json($posts)'
                      :thread='@json($thread)'
                      :can-reply='@json(!Auth::guest())'
                      fetch-action='{{ route('chatter.api.threads.posts', $thread->id) }}'
                      reply-action='{{ route('chatter.api.threads.posts.store', $thread->id) }}'
    ></show-thread-view>
@stop
