<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Forums\Category;
use App\Models\Forums\Thread;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('super.admin');
    }

    public function index()
    {
        return view('admin.dashboard');
    }
}