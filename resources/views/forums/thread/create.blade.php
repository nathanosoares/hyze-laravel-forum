@extends('layouts.forum')

@section('content')
<div class="breadcrumb-scroll rounded">
    {{ Breadcrumbs::render('forums.forum', $forum) }}
</div>

<create-thread-view :forum='@json($forum)' @if($forum->template) :template='@json($forum->template)' @endif>
</create-thread-view>
@stop