<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlayerRequest;
use App\Http\Requests\UpdatePlayerRequest;
use App\Http\Requests\UpdateStatsRequest;
use App\Models\Player;
use App\Models\PlayerWeapon;
use App\Models\WeaponCategory;

class PlayersController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('players.index', [
            'players' => Player::forUser(auth()->user()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('players.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlayerRequest $request)
    {
        $request->store();

        return redirect()->route('players.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Player $player)
    {
        $this->authorize('view', $player);

        return view('players.show', [
            'player' => $player,
            'weaponKills' => PlayerWeapon::getKillsFor($player),
            'categories' => WeaponCategory::getWeapons(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Player $player)
    {
        $this->authorize('update', $player);

        return view('players.edit', [
            'player' => $player,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlayerRequest $request, Player $player)
    {
        $request->update($player);

        return redirect()->route('players.show', $player);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $player)
    {
        $this->authorize('delete', $player);

        $player->delete();

        return redirect()->route('players.index');
    }

    /**
     * Update the weapon kill stats for the player.
     *
     * @param UpdateStatsRequest $request
     * @param Player $player
     * @return \Illuminate\Http\RedirectResponse
     */
    public function stats(UpdateStatsRequest $request, Player $player)
    {
        $request->update($player);

        return redirect()->route('players.show', $player);
    }
}
