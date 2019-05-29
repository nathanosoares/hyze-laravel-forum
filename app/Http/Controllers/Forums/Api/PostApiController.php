<?php


namespace App\Http\Controllers\Forums\Api;


use App\Http\Controllers\Controller;
use App\Models\Forums\Post;
use App\Models\Forums\Thread;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class PostApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except('replies');
    }

    public function destroy(Post $post)
    {
        $thread = $post->thread;

        // $this->authorize('write', $thread->forum);

        if ($thread->main_post->id === $post->id) {
            $this->authorize('destroy', $thread);

            $thread->delete();

            return response()->json(null, 204);
        }

        $this->authorize('destroy', $post);

        $post->delete();

        return response()->json(null, 204);
    }

    public function store(Request $request, Thread $thread)
    {
        $this->validate($request, [
            'body' => 'required|min:2'
        ]);
        
        $this->authorize('reply', $thread);

        $post = Post::fromRequest($request, $thread);

        $post = Post::find($post->id);

        return response()->json($post);
    }

    public function reply(Request $request, Post $post)
    {
        $this->validate($request, [
            'body' => 'required|min:2'
        ]);

        $thread = $post->thread;

        $this->authorize('reply', $thread->forum);

        $reply = Post::fromRequest($request, $post->thread, $post);

        $reply = Post::find($reply->id);

        return response()->json($reply);
    }

    public function update(Request $request, Post $post)
    {
        $this->validate($request, [
            'body' => 'required|min:2'
        ]);

        $thread = $post->thread;

        $this->authorize('write', $thread->forum);

        $post->body = $request->body;

        $post->save();

        return response()->json($post);
    }

    public function replies(Post $post)
    {
        if (!Gate::forUser(auth()->guard('api')->user())->allows('read', $post->thread)) {
            throw new AuthorizationException();
        }

        return response()->json($post->replies()->paginate(5));
    }
}
