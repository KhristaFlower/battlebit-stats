<?php

use App\Http\Controllers\CompareController;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\ProfileController;
use App\Models\Player;
use App\Models\PlayerWeapon;
use App\Models\WeaponCategory;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // TODO: Add tests for this route
    return view('global-stats', [
        'categoryKills' => WeaponCategory::getCategoriesWithTotalKills(),
    ]);
});

Route::group(['middleware' => 'auth'], function () {
    Route::resource('players', PlayersController::class);
    Route::patch('/players/{player}/stats', [PlayersController::class, 'stats'])->name('players.stats');
    Route::get('/compare', [CompareController::class, 'index'])->name('compare');
    Route::post('/compare', [CompareController::class, 'postCompare'])->name('compare.post');
    Route::get('/compare/{player1}/{player2}', [CompareController::class, 'showCompare'])->name('compare.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/search', function () {
    $players = null;
    if ($term = request()->get('for')) {
        $players = Player::query()
            ->where('player_name', 'like', '%' . $term . '%')
            ->paginate(15);
    }
    return view('search', [
        'players' => $players,
    ]);
})->name('search');

Route::get('/stats/{player:player_name}', function (Player $player) {
    $playerStats = $player->playerWeapons()->get()->mapWithKeys(
        static fn($weapon) => [$weapon->weapon_id => $weapon->kill_count]
    );

    $weaponCategories = WeaponCategory::query()
        ->with('weapons:weapon_id,weapon_name,weapon_category_id')
        ->get();

    return view('stats', [
        'player' => $player,
        'playerStats' => $playerStats,
        'weaponCategories' => $weaponCategories,
    ]);
})->name('stats');

require __DIR__.'/auth.php';
