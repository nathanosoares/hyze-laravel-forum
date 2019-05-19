<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chatter\Forum;
use App\Extensions\Permission\Group;
use BenSampo\Enum\Rules\EnumKey;
use Illuminate\Validation\Rule;
use App\Models\Chatter\Category;

class ForumController extends Controller
{

    public function edit(Forum $forum)
    {
        $groups = Group::getInstances();
        return view('admin.forums.edit', compact('forum', 'groups'));
    }

    public function create()
    {
        $categories = Category::all();
        $groups = Group::getInstances();
        return view('admin.forums.create', compact('categories', 'groups'));
    }

    public function update(Forum $forum, Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:191', 'min:1'],
            'slug' => ['required', 'max:191', 'min:1', Rule::unique('forums')->ignore($forum->id)],
            'description' => ['max:1024'],
            'restrict_read' => ['required', new EnumKey(Group::class)],
            'restrict_write' => ['required', new EnumKey(Group::class)],
        ]);

        $forum->fill($request->only([
            'name',
            'slug',
            'description',
            'restrict_read',
            'restrict_write'
        ]));

        $forum->save();

        return redirect()->route('admin.tree');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:191', 'min:1'],
            'slug' => ['required', 'max:191', 'min:1'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['max:1024'],
            'restrict_read' => ['required', new EnumKey(Group::class)],
            'restrict_write' => ['required', new EnumKey(Group::class)],
        ]);

        $forum = new Forum();

        $forum->fill($request->only([
            'name',
            'slug',
            'category_id',
            'description',
            'restrict_read',
            'restrict_write'
        ]));

        $forum->save();

        return redirect()->route('admin.tree');
    }
}
