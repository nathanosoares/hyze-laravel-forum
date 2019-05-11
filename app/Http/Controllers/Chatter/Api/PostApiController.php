<?php


namespace App\Http\Controllers\Chatter\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\Chatter\StorePostRequest;
use App\Http\Requests\Chatter\UpdatePost;
use App\Models\Chatter\Post;
use App\Models\Chatter\Thread;
use Illuminate\Auth\Access\Gate;
use Illuminate\Support\Facades\Auth;

class PostApiController extends Controller
{

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
        $this->authorize('write', $thread->forum);

        $post = Post::fromRequest($request, $thread);

        $post = Post::find($post->id);

        return response()->json($post);
    }

    public function reply(StorePostRequest $request, Post $post)
    {
        $thread = $post->thread;

        $this->authorize('write', $thread->forum);

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
        $this->authorize('read', $post->thread->forum);

        return response()->json($post->replies()->paginate(5));
    }
}