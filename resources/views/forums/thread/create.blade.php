@extends('layouts.forum')

@section('content')
    {{ Breadcrumbs::render('forums.forum', $forum) }}

    <create-thread-view :forum='@json($forum)'></create-thread-view>
@stop
