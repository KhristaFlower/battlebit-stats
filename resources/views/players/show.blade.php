<x-app-layout>
    <x-slot name="header">{{ $player->player_name }}</x-slot>

    <x-panel>
        <form action="{{ route('players.stats', $player) }}" method="POST">
            @method('PATCH')
            @csrf

            @foreach ($categories as $category)
                <div>
                    <h2 class="text-xl font-bold sticky top-0 bg-white dark:bg-gray-800">{{ $category->category_name }}</h2>
                    <ul class="mt-2 mb-4">
                        @foreach ($category->weapons as $weapon)
                            <div class="flex items-center mb-1">
                                <div>
                                    <x-text-input name="weapon_kills[{{ $weapon->weapon_id }}][kill_count]"
                                                  :value="$weaponKills[$weapon->weapon_id]->kill_count"
                                                  class="w-20 p-1"/>
                                </div>
                                <div class="w-full">
                                    <div class="bg-gray-300 dark:bg-gray-700">
                                        <div
                                            style="width: {{ ($weaponKills[$weapon->weapon_id]->kill_count / 10000) * 100 }}%"
                                            class="bg-green-500 dark:bg-green-700 whitespace-nowrap">
                                            <div class="ml-2">{{ $weapon->weapon_name }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </ul>
                </div>
            @endforeach

            <div class="sticky bg-white dark:bg-gray-800 py-2 bottom-0 border-t border-gray-500">
                <x-primary-button>{{ __('app.save') }}</x-primary-button>
                <a href="{{ route('players.edit', $player) }}"
                   class="ml-4 underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                    {{ __('app.edit_player') }}
                </a>
            </div>
        </form>
    </x-panel>
</x-app-layout>
