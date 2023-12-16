<?php

namespace App\Http\Requests;

use App\Models\Player;
use Illuminate\Foundation\Http\FormRequest;

class StorePlayerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Player::class);
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

    public function store()
    {
        $validated = $this->validated();

        $validated['player_rank'] ??= 0;
        $validated['player_prestige'] ??= 0;

        return $this->user()->players()->create($validated);
    }
}
