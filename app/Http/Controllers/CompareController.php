<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\PlayerWeapon;
use App\Models\WeaponCategory;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    public function index()
    {
        return view('compare');
    }

    public function postCompare(Request $request)
    {
        $this->validate($request, [
            'player1' => 'required|exists:players,player_name',
            'player2' => 'required|exists:players,player_name|different:player1',
        ]);

        return redirect()->route('compare.show', [
            'player1' => $request->input('player1'),
            'player2' => $request->input('player2'),
        ]);
    }

    public function showCompare(Player $player1, Player $player2)
    {
        $player1Stats = PlayerWeapon::getKillsFor($player1);
        $player1StatsMapped = $player1Stats
            ->mapWithKeys(fn($weapon) => [$weapon->weapon_id => $weapon->kill_count]);
        $player2Stats = PlayerWeapon::getKillsFor($player2);
        $player2StatsMapped = $player2Stats
            ->mapWithKeys(fn($weapon) => [$weapon->weapon_id => $weapon->kill_count]);

        $comparison = [];
        foreach ($player1StatsMapped as $weaponId => $kills) {
            $comparison[$weaponId] = [
                'player1' => $kills,
                'player2' => $player2StatsMapped[$weaponId],
                'difference' => $kills - $player2StatsMapped[$weaponId],
                'min' => min($kills, $player2StatsMapped[$weaponId]),
            ];
        }

        $categoryKills = [];
        foreach ($player1Stats->groupBy('weapon_category_id') as $categoryId => $weapons) {
            $categoryKills[$categoryId] = [
                'player1' => $weapons->sum('kill_count'),
                'player2' => 0,
            ];
        }
        foreach ($player2Stats->groupBy('weapon_category_id') as $categoryId => $weapons) {
            $categoryKills[$categoryId]['player2'] = $weapons->sum('kill_count');
        }

        return view('compare', [
            'player1' => $player1,
            'player2' => $player2,
            'comparison' => $comparison,
            'categories' => WeaponCategory::getWeapons(),
            'categoryKills' => $categoryKills,
        ]);
    }
}
