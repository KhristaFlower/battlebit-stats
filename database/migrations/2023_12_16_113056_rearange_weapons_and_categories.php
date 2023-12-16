<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $battleRifleCategory = \App\Models\WeaponCategory::create([
            'category_name' => 'Battle Rifles',
        ]);
        $battleRifleCategory->setDisplayOrder(5);

        \App\Models\WeaponCategory::query()
            ->where('category_name', 'Automatic Rifles')
            ->update([
                'category_name' => 'Assault Rifles',
            ]);

        $weaponMapping = [
            'Assault Rifles' => [
                'AK74',
                'F2000',
                'AUG A3',
                'SG550',
                'FAMAS',
                'ACR',
            ],
            'Carbines' => [
                'M4A1',
                'GROZA',
                'AS VAL',
                'G36C',
                'HK419',
                'AK5C',
            ],
            'Personal Defense Weapons' => [
                'MP7',
                'PP-2000',
                'Honey Badger',
                'P90',
            ],
            'Submachine Guns' => [
                'UMP-45',
                'PP19',
                'Kriss Vector',
                'MP5',
                'SCORPIONEVO',
            ],
            'Battle Rifles' => [
                'AK15',
                'SCAR-H',
                'G3',
                'FAL',
            ],
            'Light Support Guns' => [
                'L86A1',
                'RPK16',
                'MG36',
            ],
            'Light Machine Guns' => [
                'M249',
                'ULTIMAX100',
            ],
            'Marksman Rifles' => [
                'MK-20',
                'M110',
                'MK-14 EBR',
                'SVD',
            ],
            'Sniper Rifles' => [
                'SSG 69',
                'SV-98',
                'L96',
                'REM700',
                'M200',
                'MSR',
            ],
            'Pistols' => [
                'MP443',
                'M9',
                'USP',
            ],
            'Automatic Pistols' => [
                'Glock 18',
            ],
            'Heavy Caliber Pistols' => [
                'Unica',
                'Desert Eagle',
                'RSH12',
            ],
        ];

        foreach ($weaponMapping as $categoryName => $weaponNames) {
            $category = \App\Models\WeaponCategory::query()
                ->where('category_name', $categoryName)
                ->firstOrFail();

            \App\Models\Weapon::query()
                ->whereIn('weapon_name', $weaponNames)
                ->update([
                    'weapon_category_id' => $category->weapon_category_id,
                ]);
        }

        $weaponRenames = [
            'PP-2000' => 'PP2000',
            'MK-20' => 'MK20',
            'MK-14 EBR' => 'MK14 EBR',
            'MP443' => 'MP 443',
        ];

        foreach ($weaponRenames as $oldName => $newName) {
            \App\Models\Weapon::query()
                ->where('weapon_name', $oldName)
                ->update([
                    'weapon_name' => $newName,
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
