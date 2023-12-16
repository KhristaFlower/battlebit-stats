<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Weapon;
use App\Models\WeaponCategory;
use Illuminate\Http\Request;

class WeaponsController extends Controller
{
    public function index()
    {
        return view('admin.weapons.index', [
            'weapons' => Weapon::query()
                ->with('category')
                ->join('weapon_categories', 'weapons.weapon_category_id', '=', 'weapon_categories.weapon_category_id')
                ->orderBy('weapon_categories.display_order')
                ->get(),
        ]);
    }

    public function create()
    {
        return view('admin.weapons.create', [
            'categories' => WeaponCategory::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'weapon_name' => 'required|string|max:255|unique:weapons,weapon_name',
            'weapon_category_id' => 'required|exists:weapon_categories,weapon_category_id',
            'weapon_rank' => 'required|integer|min:0|max:200',
        ]);

        Weapon::create($validated);

        return redirect()->route('admin.weapons.index');
    }

    public function edit(Weapon $weapon)
    {
        return view('admin.weapons.edit', [
            'weapon' => $weapon,
            'categories' => WeaponCategory::query()
                ->orderBy('display_order')
                ->get(),
        ]);
    }

    public function update(Request $request, Weapon $weapon)
    {
        $validated = $request->validate([
            'weapon_name' => 'required|string|max:255|unique:weapons,weapon_name,'.$weapon->weapon_id.',weapon_id',
            'weapon_category_id' => 'required|exists:weapon_categories,weapon_category_id',
            'weapon_rank' => 'required|integer|min:0|max:200',
        ]);

        $weapon->update($validated);

        return redirect()->route('admin.weapons.index');
    }

    public function destroy(Weapon $weapon)
    {
        $weapon->delete();

        return redirect()->route('admin.weapons.index');
    }
}
