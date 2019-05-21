<?php

namespace App\Http\Controllers\Chatter;


use App\Http\Controllers\Controller;
use App\Models\Chatter\Category;
use App\Models\Chatter\Thread;
use Illuminate\Support\Facades\Gate;
use App\Extensions\Permission\Group;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index()
    {
        $recent = Thread::orderBy('last_reply_at', 'desc')->limit(10)->get();

        $recent = $recent->filter(function ($thread) {
            return Gate::allows('read', $thread);
        });

        $categories = Category::orderBy('order')->get();

        $categories = $categories->filter(function ($category) {
            return Gate::allows('read', $category);
        })->map(function ($category) {
            $category->forums = $category->forums()
                ->doesntHave('parent')
                ->get()
                ->filter(function ($forum) {
                    return Gate::allows('read', $forum);
                });

            $category->forums->map(function ($forum) {
                $forum->children = $forum->children()
                    ->get()
                    ->filter(function ($child) {
                        return Gate::allows('read', $child);
                    });
            });

            return $category;
        });

        return view('chatter.home', compact('recent', 'categories'));
    }
}
