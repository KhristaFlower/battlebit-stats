<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function weapons()
    {
        return $this->hasMany(Weapon::class, 'weapon_category_id', 'weapon_category_id')
            ->orderBy('weapon_rank');
    }
}
