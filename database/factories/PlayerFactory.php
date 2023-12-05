<?php

namespace Database\Factories;

use App\Models\Player;
use App\Models\PlayerWeapon;
use App\Models\Weapon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlayerFactory extends Factory
{
    protected $model = Player::class;

    public function definition(): array
    {
        return [
            'player_name' => $this->faker->userName(),
            'player_rank' => $this->faker->numberBetween(0, 200),
            'player_prestige' => $this->faker->biasedNumberBetween(0, 5),
        ];
    }

    public function interacted(): Factory
    {
        return $this->afterCreating(function (Player $player) {
            $weaponIds = Weapon::query()
                ->inRandomOrder()
                ->pluck('weapon_id');

            $chosenWeaponIds = $weaponIds->random($this->faker->randomNumber(1, $weaponIds->count()));

            $linkingRecords = [];
            foreach ($chosenWeaponIds as $weaponId) {
                $linkingRecords[] = [
                    'player_id' => $player->player_id,
                    'weapon_id' => $weaponId,
                    'kill_count' => $this->faker->numberBetween(0, 1000),
                ];
            }
            PlayerWeapon::query()->insert($linkingRecords);
        });
    }
}
