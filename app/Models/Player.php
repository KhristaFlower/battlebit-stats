<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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

    protected $fillable = [
        'player_name',
        'player_rank',
        'player_prestige',
    ];

    public function getRouteKeyName(): string
    {
        return 'player_name';
    }

    public function playerWeapons()
    {
        return $this->hasMany(PlayerWeapon::class, 'player_id', 'player_id');
    }

    public function weapons()
    {
        return $this->belongsToMany(Weapon::class, 'player_weapons', 'player_id', 'weapon_id')
            ->withPivot('kill_count');
    }

    public static function forUser(User $user): Collection
    {
        return static::query()
            ->leftJoin('player_weapons', 'players.player_id', '=', 'player_weapons.player_id')
            ->where('user_id', '=', $user->id)
            ->groupBy('players.player_id')
            ->orderBy('player_id')
            ->selectRaw('players.*, coalesce(sum(player_weapons.kill_count), 0) as total_kills')
            ->get();
    }
}
