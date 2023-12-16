<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property int $player_weapon_id
 * @property int $player_id
 * @property int $weapon_id
 * @property int $kill_count
 */
class PlayerWeapon extends Model
{
    use HasFactory;

    protected $primaryKey = 'player_weapon_id';

    protected $hidden = [
        'player_weapon_id',
        'created_at',
        'updated_at',
    ];

    public static function getKillsFor(Player $player): Collection
    {
        return Weapon::query()
            ->leftJoin('player_weapons', static function ($query) use ($player) {
                $query->on('weapons.weapon_id', '=', 'player_weapons.weapon_id')
                    ->where('player_weapons.player_id', '=', $player->player_id);
            })
            ->selectRaw('weapons.weapon_id, weapon_name, coalesce(kill_count, 0) as kill_count')
            ->get()
            ->collect()
            ->mapWithKeys(static function ($weapon) {
                return [$weapon->weapon_id => $weapon];
            });
    }

    public function weapon()
    {
        return $this->belongsTo(Weapon::class, 'weapon_id', 'weapon_id');
    }
}
