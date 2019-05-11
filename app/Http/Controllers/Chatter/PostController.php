<?php


namespace App\Http\Controllers\Chatter;


use App\Http\Controllers\Controller;
use App\Models\Chatter\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function destroy(Request $request, Post $post)
    {
        $thread = $post->thread;

        $this->authorize('write', $thread->forum->category);
        $this->authorize('write', $thread->forum);

        $permanent = $request->has('force_delete') && $request->get('force_delete') == 1;

        $thread = $post->thread;

        if ($thread->posts()->first()->id == $post->id) {
            $this->authorize('delete', $thread);

            if ($permanent) {
                $thread->forceDelete();
            } else {
                $thread->delete();
            }

            return redirect()->to(forum_url($post->forum));
        }

        $this->authorize('delete', $post);

        if ($permanent) {
            $post->forceDelete();
        } else {
            $post->delete();
        }

        return redirect()->to(thread_url($post->thread));
    }
}