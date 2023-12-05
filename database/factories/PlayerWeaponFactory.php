<?php

namespace Database\Factories;

use App\Models\PlayerWeapon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlayerWeaponFactory extends Factory
{
    protected $model = PlayerWeapon::class;

    public function definition(): array
    {
        return [
            'player_id' => $this->faker->randomNumber(),
            'weapon_id' => $this->faker->randomNumber(),
            'kill_count' => $this->faker->randomNumber(),
        ];
    }
}
