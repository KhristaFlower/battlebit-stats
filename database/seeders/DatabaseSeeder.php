<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\WeaponCategory;
use App\Models\Player;
use App\Models\Weapon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(WeaponSeeder::class);
        $this->createUsers();
        $this->createPlayers();
    }

    private function createUsers(): void
    {
        User::create([
            'name' => 'Khrista',
            'email' => 'me@khrista.io',
            'email_verified_at' => now(),
            'password' => bcrypt('testing'),
        ]);
    }

    private function createPlayers(): void
    {
        Player::factory()
            ->interacted()
            ->create([
                'player_name' => 'Khrista',
                'player_rank' => 80,
                'player_prestige' => 2,
                'user_id' => 1,
            ]);

        Player::factory()
            ->interacted()
            ->create([
                'player_name' => 'Lenore',
                'player_rank' => 60,
                'player_prestige' => 2,
            ]);

        Player::factory()
            ->count(5)
            ->create();

        Player::factory()
            ->count(10)
            ->interacted()
            ->create();
    }
}
