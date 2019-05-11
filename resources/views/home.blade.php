@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">

                @foreach ($threads as $thread)
                    <a class="text-decoration-none text-body bg-ghost d-block" href="{{ thread_url($thread) }}">
                        <div class="p-4">
                            <div class="h2 text-primary ">
                                {{ $thread->title }}
                            </div>

                            <p>{!! html_cut($thread->main_post->body, 300) !!}</p>

                            <div class="d-flex flex-row">
                                <div>{{ $thread->created_at->diffForHumans() }}</div>
                                <div class="ml-auto">
                                    Postado por {{ $thread->author->name }}
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach

                <div class="mx-auto">
                    {{ $threads->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
