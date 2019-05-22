<?php


namespace App\Http\Controllers\Chatter;


use App\Http\Controllers\Controller;
use App\Models\Chatter\Forum;

class ForumController extends Controller
{
    public function index(Forum $forum)
    {
        $this->authorize('read', $forum->category);
        $this->authorize('read', $forum);

        $threads = $forum->threads()
            ->orderBy('sticky', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('chatter.forum', compact('forum', 'threads'));
    }
}
