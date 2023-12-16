<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WeaponCategory;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        return view('admin.categories.index', [
            'categories' => WeaponCategory::query()
                ->orderBy('display_order')
                ->get(),
        ]);
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'category_name' => 'required|unique:weapon_categories,category_name',
        ]);

        WeaponCategory::create($request->validate([
            'category_name' => 'required',
        ]));

        return redirect()->route('admin.categories.index');
    }

    public function edit(WeaponCategory $category)
    {
        return view('admin.categories.edit', [
            'category' => $category,
        ]);
    }

    public function update(Request $request, WeaponCategory $category)
    {
        $this->validate($request, [
            'category_name' => 'required',
        ]);

        $category->update($request->validate([
            'category_name' => 'required|unique:weapon_categories,category_name,' . $category->category_id . ',category_id',
        ]));

        return redirect()->route('admin.categories.index');
    }

    public function destroy(WeaponCategory $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index');
    }

    public function up(WeaponCategory $category)
    {
        $category->displayOrderMoveUp();

        return redirect()->route('admin.categories.index');
    }

    public function down(WeaponCategory $category)
    {
        $category->displayOrderMoveDown();

        return redirect()->route('admin.categories.index');
    }
}
