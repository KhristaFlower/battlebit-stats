<x-app-layout>
    <x-slot name="header">Stats for {{ $player->player_name }}</x-slot>

    <x-panel>
        Stats for {{ $player->player_name }}

        <div>
            @foreach ($weaponCategories as $category)
                <h2>{{ $category->category_name }}</h2>
                @foreach ($category->weapons as $weapon)
                    <div>
                        <x-text-input :disabled="true" class="text-sm w-20"
                                      :value="$playerStats[$weapon->weapon_id] ?? 0"></x-text-input>
                        {{ $weapon->weapon_name }}
                    </div>
                @endforeach
            @endforeach
        </div>
    </x-panel>
</x-app-layout>
