<?php


namespace App\Http\Controllers\Forums\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\Forums\StorePostRequest;
use App\Http\Requests\Forums\UpdatePost;
use App\Models\Forums\Post;
use App\Models\Forums\Thread;

class PostApiController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api')->except('replies');
    }

    public function destroy(Post $post)
    {
        $thread = $post->thread;

        $this->authorize('write', $thread->forum);

        if ($thread->posts()->first()->id == $post->id) {
            $this->authorize('destroy', $thread);

            $thread->delete();

            return response()->json(null, 204);
        }

        $this->authorize('destroy', $post);

        $post->delete();

        return response()->json(null, 204);
    }

    public function store(StorePostRequest $request, Thread $thread)
    {
        $this->authorize('reply', $thread);

        $post = Post::fromRequest($request, $thread);

        $post = Post::find($post->id);

        return response()->json($post);
    }

    public function reply(StorePostRequest $request, Post $post)
    {
        $thread = $post->thread;

        $this->authorize('reply', $thread->forum);

        $reply = Post::fromRequest($request, $post->thread, $post);

        $reply = Post::find($reply->id);

        return response()->json($reply);
    }

    public function update(UpdatePost $request, Post $post)
    {
        $thread = $post->thread;

        $this->authorize('write', $thread->forum);

        $post->body = $request->body;

        $post->save();

        return response()->json($post);
    }

    public function replies(Post $post)
    {
        $this->authorize('read', $post->thread);

        return response()->json($post->replies()->paginate(5));
    }
}