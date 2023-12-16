<?php

namespace App\Http\Requests;

use App\Models\Player;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStatsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $player = $this->route('player');

        return $player && $this->user()->can('update', $player);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'weapon_kills.*.kill_count' => 'nullable|integer|min:0',
        ];
    }

    public function update(Player $player)
    {
        $weaponKills = $this->validated('weapon_kills');

        $player->weapons()->sync($weaponKills);
    }
}
