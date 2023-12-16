<?php

namespace Database\Factories;

use App\Models\WeaponCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Weapon>
 */
class WeaponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'weapon_name' => $this->faker->word,
            'weapon_category_id' => WeaponCategory::factory(),
            'weapon_rank' => 0,
        ];
    }
}
