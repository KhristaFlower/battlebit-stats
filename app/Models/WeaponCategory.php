<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @property int $weapon_category_id
 * @property string $category_name
 * @property int $display_order
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

    protected $fillable = [
        'category_name',
    ];

    public static function getWeapons()
    {
        return static::query()
            ->with('weapons')
            ->orderBy('display_order')
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

    public function displayOrderMoveUp(): void
    {
        $this->setDisplayOrder($this->display_order - 1);
    }

    public function displayOrderMoveDown(): void
    {
        $this->setDisplayOrder($this->display_order + 1);
    }

    public function setDisplayOrder(int $position): void
    {
        if ($this->display_order && $this->display_order < $position) {
            // Move the category down (up the list)
            static::query()
                ->where('display_order', '>=', $position)
                ->where('display_order' , '<', $this->display_order)
                ->increment('display_order');
        } elseif ($this->display_order && $this->display_order > $position) {
            // Move the category up (down the list)
            static::query()
                ->where('display_order', '<=', $position)
                ->where('display_order' , '>', $this->display_order)
                ->decrement('display_order');
        } elseif (!$this->display_order) {
            // Move categories down (up the list) to make space
            static::query()
                ->where('display_order', '>=', $position)
                ->increment('display_order');
        }

        // Insert at new position
        $this->display_order = $position;
        $this->save();
    }
}
