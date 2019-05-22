<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Forums\Category;
use Illuminate\Http\Request;
use App\Extensions\Permission\Group;
use Illuminate\Validation\Rule;
use BenSampo\Enum\Rules\EnumKey;

class CategoryController extends Controller
{

    public function edit(Category $category)
    {
        $groups = Group::getInstances();
        return view('admin.categories.edit', compact('category', 'groups'));
    }

    public function create()
    {
        $groups = Group::getInstances();
        return view('admin.categories.create', compact('groups'));
    }

    public function update(Category $category, Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:191', 'min:1'],
            'slug' => ['required', 'max:191', 'min:1', Rule::unique('categories')->ignore($category->id)],
            'restrict_read' => ['nullable', new EnumKey(Group::class)],
            'restrict_write' => ['required', new EnumKey(Group::class)],
        ]);

        $category->fill($request->only(['name', 'slug', 'restrict_read', 'restrict_write']));

        $category->save();

        return redirect()->route('admin.tree');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:191', 'min:1'],
            'slug' => ['required', 'max:191', 'min:1'],
            'restrict_read' => ['nullable', new EnumKey(Group::class)],
            'restrict_write' => ['required', new EnumKey(Group::class)],
        ]);

        $category = new Category();

        $category->fill($request->only(['name', 'slug', 'restrict_read', 'restrict_write']));

        $category->save();

        return redirect()->route('admin.tree');
    }
}
