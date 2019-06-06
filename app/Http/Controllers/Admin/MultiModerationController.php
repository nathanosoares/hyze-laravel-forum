<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Forums\Forum;
use App\Extensions\Permission\Group;
use BenSampo\Enum\Rules\EnumKey;
use Illuminate\Validation\Rule;
use App\Models\Forums\Category;
use App\Models\Forums\MultiModeration;

class MultiModerationController extends Controller
{

    public function index()
    {
        $multimoderations = MultiModeration::all();

        return view('admin.multimoderation.index', compact('multimoderations'));
    }
}
