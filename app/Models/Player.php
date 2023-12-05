<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $player_id
 * @property string $player_name
 * @property int $player_rank
 * @property int $player_prestige
 */
class Player extends Model
{
    use HasFactory;

    protected $primaryKey = 'player_id';

    public function playerWeapons()
    {
        return $this->hasMany(PlayerWeapon::class, 'player_id', 'player_id');
    }

    public function weapons()
    {
        return $this->belongsToMany(Weapon::class, 'player_weapons', 'player_id', 'weapon_id')
            ->withPivot('kill_count');
    }
}
