<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function weapon()
    {
        return $this->belongsTo(Weapon::class, 'weapon_id', 'weapon_id');
    }
}
