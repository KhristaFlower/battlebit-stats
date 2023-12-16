<?php

namespace Database\Seeders;

use App\Models\Weapon;
use App\Models\WeaponCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WeaponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createCategories();
        $this->createWeapons();
    }

    private function createCategories(): void
    {
        WeaponCategory::query()->insert([
            ['category_name' => 'Automatic Rifles'],
            ['category_name' => 'Carbines'],
            ['category_name' => 'Personal Defense Weapons'],
            ['category_name' => 'Submachine Guns'],
            ['category_name' => 'Light Support Guns'],
            ['category_name' => 'Light Machine Guns'],
            ['category_name' => 'Marksman Rifles'],
            ['category_name' => 'Sniper Rifles'],
            ['category_name' => 'Pistols'],
            ['category_name' => 'Automatic Pistols'],
            ['category_name' => 'Heavy Caliber Pistols'],
        ]);
    }

    private function createWeapons(): void
    {
        $categoryNameToIdMap = WeaponCategory::all()->mapWithKeys(
            static fn(WeaponCategory $category) => [$category->category_name => $category->weapon_category_id]
        );

        $weaponCategories = [
            'Automatic Rifles' => [
                ['name' => 'M4A1', 'rank' => 0],
                ['name' => 'AK74', 'rank' => 0],
                ['name' => 'AK15', 'rank' => 15],
                ['name' => 'F2000', 'rank' => 35],
                ['name' => 'SCAR-H', 'rank' => 50],
                ['name' => 'AUG A3', 'rank' => 75],
                ['name' => 'SG550', 'rank' => 80],
                ['name' => 'FAMAS', 'rank' => 95],
                ['name' => 'ACR', 'rank' => 110],
                ['name' => 'G36C', 'rank' => 120],
                ['name' => 'HK419', 'rank' => 135],
                ['name' => 'FAL', 'rank' => 140],
                ['name' => 'AK5C', 'rank' => 145],
            ],
            'Carbines' => [
                ['name' => 'AS VAL', 'rank' => 105],
                ['name' => 'SCORPIONEVO', 'rank' => 150],
            ],
            'Personal Defense Weapons' => [
                ['name' => 'Honey Badger', 'rank' => 35],
                ['name' => 'GROZA', 'rank' => 55],
                ['name' => 'P90', 'rank' => 125],
            ],
            'Submachine Guns' => [
                ['name' => 'MP7', 'rank' => 0],
                ['name' => 'UMP-45', 'rank' => 0],
                ['name' => 'PP-2000', 'rank' => 25],
                ['name' => 'PP19', 'rank' => 45],
                ['name' => 'Kriss Vector', 'rank' => 70],
                ['name' => 'MP5', 'rank' => 90],
            ],
            'Light Support Guns' => [
                ['name' => 'L86A1', 'rank' => 0],
                ['name' => 'MG36', 'rank' => 50],
                ['name' => 'RPK16', 'rank' => 35],
            ],
            'Light Machine Guns' => [
                ['name' => 'M249', 'rank' => 20],
                ['name' => 'ULTIMAX100', 'rank' => 100],
            ],
            'Marksman Rifles' => [
                ['name' => 'MK-20', 'rank' => 10],
                ['name' => 'M110', 'rank' => 40],
                ['name' => 'MK-14 EBR', 'rank' => 60],
                ['name' => 'G3', 'rank' => 90],
                ['name' => 'SVD', 'rank' => 115],
            ],
            'Sniper Rifles' => [
                ['name' => 'SSG 69', 'rank' => 0],
                ['name' => 'SV-98', 'rank' => 30],
                ['name' => 'L96', 'rank' => 65],
                ['name' => 'REM700', 'rank' => 85],
                ['name' => 'M200', 'rank' => 100],
                ['name' => 'MSR', 'rank' => 130],
            ],
            'Pistols' => [
                ['name' => 'MP443', 'rank' => 0],
                ['name' => 'M9', 'rank' => 0],
                ['name' => 'USP', 'rank' => 60],
            ],
            'Automatic Pistols' => [
                ['name' => 'Glock 18', 'rank' => 80],
            ],
            'Heavy Caliber Pistols' => [
                ['name' => 'Unica', 'rank' => 40],
                ['name' => 'Desert Eagle', 'rank' => 100],
                ['name' => 'RSH12', 'rank' => 120],
            ],
        ];

        foreach ($weaponCategories as $categoryName => $categoryWeapons) {
            foreach ($categoryWeapons as $categoryWeapon) {
                $weapon = [
                    'weapon_name' => $categoryWeapon['name'],
                    'weapon_rank' => $categoryWeapon['rank'],
                    'weapon_category_id' => $categoryNameToIdMap[$categoryName],
                ];
                Weapon::query()->create($weapon);
            }
        }
    }
}
