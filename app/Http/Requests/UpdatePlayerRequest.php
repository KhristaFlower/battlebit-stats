<?php

namespace App\Http\Requests;

use App\Models\Player;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePlayerRequest extends FormRequest
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
            'player_name' => 'required|string|max:255|unique:players,player_name',
            'player_rank' => 'nullable|integer|min:0',
            'player_prestige' => 'nullable|integer|min:0',
        ];
    }

    public function update(Player $player): bool
    {
        return $player->update(
            $this->validated()
        );
    }
}
