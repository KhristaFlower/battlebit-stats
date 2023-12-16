<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property int $category_id
 * @property string $category_name
 *
 * @property Weapon[] $weapons
 */
class WeaponCategory extends Model
{
    use HasFactory;

    protected $primaryKey = 'weapon_category_id';

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public static function getWeapons()
    {
        return static::query()
            ->with('weapons')
            ->orderBy('weapon_category_id')
            ->get();
    }

    public function weapons()
    {
        return $this->hasMany(Weapon::class, 'weapon_category_id', 'weapon_category_id')
            ->orderBy('weapon_rank');
    }

    public static function getCategoriesWithTotalKills(): Collection
    {
        return static::query()
            ->join('weapons', 'weapons.weapon_category_id', '=', 'weapon_categories.weapon_category_id')
            ->join('player_weapons', 'player_weapons.weapon_id', '=', 'weapons.weapon_id')
            ->groupBy('weapon_categories.weapon_category_id', 'weapon_categories.category_name')
            ->orderBy('weapon_categories.weapon_category_id')
            ->select('weapon_categories.weapon_category_id', 'weapon_categories.category_name')
            ->selectRaw('sum(player_weapons.kill_count) as total_kills')
            ->get();
    }
}
