<?php

namespace App\Http\Controllers;

use App\Models\Forums\Thread;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $pagination_results = config('forums.paginate.num_of_results', 10);

        $threads = Thread::where('promoted', true)
            ->allowed()
            ->orderBy('last_reply_at', 'desc')->paginate($pagination_results);

        return view('home', compact('threads'));
    }
}
