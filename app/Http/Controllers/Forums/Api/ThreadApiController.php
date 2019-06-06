<?php


namespace App\Http\Controllers\Forums\Api;


use App\Http\Controllers\Controller;
use App\Models\Forums\Forum;
use App\Models\Forums\Post;
use App\Models\Forums\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Extensions\Permission\Group;
use Illuminate\Support\Facades\Gate;
use BenSampo\Enum\Rules\EnumKey;
use App\Models\Forums\MultiModeration;

class ThreadApiController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

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
            'slug' => $slug,
            'restrict_read' => $forum->threads_restrict_read,
            'restrict_write' => $forum->threads_restrict_write
        ];

        $thread = $forum->threads()->create($new_thread);

        $new_post = [
            'user_id' => $user_id,
            'body' => $request->body,
        ];

        $post = $thread->posts()->create($new_post);

        return response()->json($thread, 201);
    }

    public function update(Request $request, Thread $thread)
    {
        $this->validate($request, [
            'title' => 'required|min:3|max:60',
            'promoted' => 'required|boolean',
            'sticky' => 'required|boolean',
            'restrict_read' => ['nullable', new EnumKey(Group::class)],
            'restrict_write' => ['required', new EnumKey(Group::class)],
            'multimoderation' => 'nullable|exists:multimoderations,id'
        ]);

        if (Gate::allows('rename', $thread)) {
            $thread->title = $request->get('title', $thread->title);
            $thread->slug = str_slug($request->title, '-');
        }

        if (Gate::allows('promote', $thread)) {
            $thread->promoted = $request->get('promoted', $thread->promoted);
        }

        if (Gate::allows('sticky', $thread)) {
            $thread->sticky = $request->get('sticky', $thread->sticky);
        }

        if (Gate::allows('close', $thread)) {
            $oldStatus = $thread->closed;
            $thread->closed = $request->get('closed', $thread->closed);

            if (!$oldStatus && $thread->closed && $thread->forum->fallback) {
                $thread->forum_id = $thread->forum->fallback->id;
            }
        }

        if (auth()->user()->hasGroup(Group::ADMINISTRATOR())) {
            $thread->restrict_read = $request->get('restrict_read', $thread->restrict_read);
        }

        if (auth()->user()->hasGroup(Group::MANAGER())) {
            $thread->restrict_write = $request->get('restrict_write', $thread->restrict_write);
        }

        $autoReplied = false;

        if (!is_null($request->get('multimoderation'))) {
            $multimoderation = MultiModeration::find($request->get('multimoderation'));

            if ($multimoderation && auth()->user()->hasGroup(Group::getInstances()[$multimoderation->restrict_use])) {

                if ($multimoderation->close_thread) {
                    $thread->closed = true;
                }

                if ($multimoderation->move_thread_to) {
                    $thread->forum_id = $multimoderation->move_thread_to;
                }

                if ($multimoderation->delete_thread) {
                    $thread->deleted_at = now();
                }

                if ($multimoderation->auto_reply_thread) {
                    $autoReplied = true;
                    Post::createNew(auth()->user(), $thread, $multimoderation->auto_reply_thread);
                }
            }
        }

        if ($thread->isDirty() || $autoReplied) {
            if ($thread->isDirty()) {
                $thread->save();
            }

            return response()->json(null, 202);
        }

        return response()->json(null, 204);
    }
}
