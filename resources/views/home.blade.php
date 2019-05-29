@extends('layouts.forum')

@section('content')
<div class="row">
    <div class="col-12">

        @foreach ($threads as $thread)
        <div class="row mb-3">
            <div class="d-none d-lg-block col-lg-2">
                <author-card-normal :author='@json($thread->author)'></author-card-normal>
            </div>

            <div class="d-flex d-lg-block col-lg-10">
                <div class="shadow-sm rounded bg-white h-100 p-3 d-flex flex-column w-100">
                    <a href="{{ thread_url($thread) }}" class="h3 text-primary">
                        {{ $thread->title }}
                    </a>

                    <p>{!! html_cut(strip_tags($thread->main_post->body_parsed), 400) !!}...</p>

                    <div class="d-flex align-items-center mt-1">
                        <a href="{{ thread_url($thread) }}" class="btn btn-primary rounded-pill">
                            Continuar lendo...
                        </a>

                        <div class="ml-auto">
                            <span class="mr-1">
                                <i class="fas fa-clock"></i> {{ $thread->created_at->diffForHumans() }}
                            </span>
                            <span>
                                <i class="far fa-comment-dots"></i>
                                {{ plural('resposta', 'respostas', $thread->replies_count, 'nenhuma resposta') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <div class="mx-auto">
            {{ $threads->links() }}
        </div>
    </div>
</div>
@endsection