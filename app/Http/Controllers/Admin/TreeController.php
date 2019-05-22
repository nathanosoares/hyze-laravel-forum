<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Forums\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Forums\Forum;

class TreeController extends Controller
{
    public function __construct()
    {
        $this->middleware('super.admin');
    }

    public function editForum(Forum $forum)
    {
        dd($forum);
    }

    public function editCategory(Category $category)
    {
        dd($category);
    }

    public function index()
    {
        $categories = Category::with(['forums' => function ($query) {
            $query->where('parent_id', null);
        }, 'forums.children'])->get();

        return view('admin.forums', compact('categories'));
    }

    public function sort(Request $request)
    {
        $this->validate($request, [
            'categories' => 'required|array',
            'categories.*.id' => 'required|integer|exists:categories,id',
            'categories.*.forums' => 'array',
            'categories.*.forums.*.id' => 'required|integer|exists:forums,id',
        ]);

        $categories = collect($request->get('categories'));

        $categories->each(function ($item, $key) {
            $category = Category::find($item['id']);

            if ($category) {
                $category->order = $key;
                $category->save();

                $process = function ($forums, $parentId = null) use ($category, &$process) {

                    $forums->each(function ($item, $key) use ($parentId, $category, &$process) {
                        $forum = Forum::find($item['id']);

                        if ($forum) {
                            $forum->category_id = $category->id;
                            $forum->order = $key;
                            $forum->parent_id = $parentId;

                            $forum->save();

                            if ($item['children']) {
                                $process(collect($item['children']), $forum->id);
                            }
                        }
                    });
                };

                if (isset($item['forums'])) {
                    $process(collect($item['forums']));
                }
            }
        });

        return response()->json($categories);
    }
}
