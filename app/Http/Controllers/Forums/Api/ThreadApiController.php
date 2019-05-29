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

class ThreadApiController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth:api');
    }

    public function posts(Thread $thread)
    {
        dd('posts', $thread);

        $this->authorize('read', $thread->thread);

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

    public function update(Request $request, Thread $thread)
    {
        $this->validate($request, [
            'title' => 'required|min:3|max:60',
            'promoted' => 'required|boolean',
            'sticky' => 'required|boolean',
            'restrict_read' => ['nullable', new EnumKey(Group::class)],
            'restrict_write' => ['required', new EnumKey(Group::class)],
        ]);

        if (Gate::allows('promote', $thread)) {
            $thread->promoted = $request->get('promoted');
        }

        if (Gate::allows('sticky', $thread)) {
            $thread->sticky = $request->get('sticky');
        }

        if (auth()->user()->hasGroup(Group::ADMINISTRATOR())) {
            $thread->restrict_read = $request->get('restrict_read');
        }

        if (auth()->user()->hasGroup(Group::MANAGER())) {
            $thread->restrict_write = $request->get('restrict_write');
        }

        if ($thread->isDirty()) {
            $thread->save();

            return response()->json(null, 200);
        }

        return response()->json(null, 304);
    }
}
