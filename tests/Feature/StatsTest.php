<?php

use App\Models\Player;
use App\Models\PlayerWeapon;
use App\Models\Weapon;
use App\Models\WeaponCategory;
use Database\Seeders\WeaponSeeder;

test('stats page loads for a player', function () {
    $player = Player::factory()->create();

    $this->get('/stats/' . $player->player_name)
        ->assertStatus(200)
        ->assertSee($player->player_name);
});

test('stats page shows all weapons', function () {
    $this->seed(WeaponSeeder::class);

    $player = Player::factory()->create();

    $response = $this->get('/stats/' . $player->player_name);

    $categoryNames = WeaponCategory::query()->pluck('category_name');
    foreach ($categoryNames as $categoryName) {
        $response->assertSee($categoryName);
    }

    $weaponNames = Weapon::query()->pluck('weapon_name');
    foreach ($weaponNames as $weaponName) {
        $response->assertSee($weaponName);
    }
});

test('a players weapon kills are shown', function () {
    $this->seed(WeaponSeeder::class);

    $player = Player::factory()->create();
    $weapon = Weapon::query()->inRandomOrder()->first();

    PlayerWeapon::factory()->create([
        'player_id' => $player->player_id,
        'weapon_id' => $weapon->weapon_id,
        'kill_count' => 100,
    ]);

    $this->get('/stats/' . $player->player_name)
        ->assertSee($weapon->weapon_name)
        ->assertSee('100');
});
