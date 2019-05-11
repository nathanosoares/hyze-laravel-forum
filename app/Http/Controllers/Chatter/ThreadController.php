<?php


namespace App\Http\Controllers\Chatter;


use App\Http\Controllers\Controller;
use App\Models\Chatter\Forum;
use App\Models\Chatter\Thread;

class ThreadController extends Controller
{

    public function create(Forum $forum)
    {
        $this->authorize('write', $forum->category);
        $this->authorize('write', $forum);

        return view('chatter.thread.create', compact('forum'));
    }

    public function show(Thread $thread)
    {
        $this->authorize('read', $thread->forum->category);
        $this->authorize('read', $thread->forum);

        $thread->load(['forum']);

        $posts = $thread->posts()
            ->whereNull('parent_id')
            ->orderBy('created_at')
            ->paginate(config('forum.thread_posts_per_page'));

        return view('chatter.thread.show', compact('thread', 'posts'));
    }
}