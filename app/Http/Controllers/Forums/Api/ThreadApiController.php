<?php


namespace App\Http\Controllers\Forums\Api;


use App\Http\Controllers\Controller;
use App\Models\Forums\Forum;
use App\Models\Forums\Post;
use App\Models\Forums\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ThreadApiController extends Controller
{

    public function posts(Thread $thread)
    {
        $this->authorize('read', $thread->forum->category);
        $this->authorize('read', $thread->forum);

        $posts = $thread->posts()
            ->doesntHave('parent')
            ->orderBy('created_at')
            ->paginate(config('forum.thread_posts_per_page'));

        return response()->json($posts);
    }

    public function store(Request $request, Forum $forum)
    {
        $this->authorize('write', $forum->category);
        $this->authorize('write', $forum);

        $stripped_tags_body = [
            'body' => strip_tags($request->body),
            'title' => $request->title
        ];

        $validator = Validator::make($stripped_tags_body, [
            'body' => 'required|min:10',
            'title' => 'required|min:3|max:60'
        ]);

        $this->validateWith($validator, $request);

        $user_id = Auth::user()->id;

        $slug = str_slug($request->title, '-');

        $new_thread = [
            'title' => $request->title,
            'forum_id' => $forum->id,
            'user_id' => $user_id,
            'slug' => $slug
        ];

        $thread = $forum->threads()->create($new_thread);

        $new_post = [
            'user_id' => $user_id,
            'body' => $request->body,
        ];

        $post = $thread->posts()->create($new_post);

        return response()->json($thread, 201);
    }
}