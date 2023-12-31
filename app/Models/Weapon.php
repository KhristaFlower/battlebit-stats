<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $weapon_id
 * @property string $weapon_name
 * @property int $weapon_category_id
 * @property int $weapon_rank
 * @property int $display_order
 *
 * @property WeaponCategory $category
 */
class Weapon extends Model
{
    use HasFactory;

    protected $primaryKey = 'weapon_id';

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'weapon_name',
        'weapon_category_id',
        'weapon_rank',
    ];

    public function category()
    {
        return $this->belongsTo(WeaponCategory::class, 'weapon_category_id', 'weapon_category_id');
    }
}
