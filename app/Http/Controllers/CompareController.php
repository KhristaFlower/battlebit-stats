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
        $player1Stats = PlayerWeapon::getKillsFor($player1)
            ->mapWithKeys(fn($weapon) => [$weapon->weapon_id => $weapon->kill_count]);
        $player2Stats = PlayerWeapon::getKillsFor($player2)
            ->mapWithKeys(fn($weapon) => [$weapon->weapon_id => $weapon->kill_count]);

        return view('compare', [
            'player1' => $player1,
            'player1Stats' => $player1Stats,
            'player2' => $player2,
            'player2Stats' => $player2Stats,
            'categories' => WeaponCategory::getWeapons(),
        ]);
    }
}
