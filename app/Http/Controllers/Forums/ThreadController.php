<?php


namespace App\Http\Controllers\Forums;


use App\Http\Controllers\Controller;
use App\Models\Forums\Forum;
use App\Models\Forums\Thread;

class ThreadController extends Controller
{

    public function create(Forum $forum)
    {
        $this->authorize('write', $forum);

        return view('forums.thread.create', compact('forum'));
    }

    public function show(Thread $thread)
    {
        $this->authorize('read', $thread);

        $thread->load(['forum', 'forum.multimoderations' => function ($query) {
            $query->allowed();
        }]);

        $posts = $thread->posts()
            ->whereNull('parent_id')
            ->orderBy('created_at')
            ->paginate(config('forum.thread_posts_per_page'));

        return view('forums.thread.show', compact('thread', 'posts'));
    }
}
