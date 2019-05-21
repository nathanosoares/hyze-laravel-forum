<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;

class DetailsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('profile.details');
    }
}
