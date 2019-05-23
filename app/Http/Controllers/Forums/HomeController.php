<?php

namespace App\Http\Controllers\Forums;


use App\Http\Controllers\Controller;
use App\Models\Forums\Category;
use App\Models\Forums\Thread;
use Illuminate\Support\Facades\Gate;

class HomeController extends Controller
{

    public function index()
    {
        $recent = Thread::orderBy('last_reply_at', 'desc')
            ->allowed()
            ->limit(10)
            ->get();

        $categories = Category::allowed()
            ->orderBy('order')
            ->with(['forums' => function ($query) {
                $query->allowed();
            }])
            ->get();

        return view('forums.home', compact('recent', 'categories'));
    }
}
