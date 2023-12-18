<x-app-layout>
    <x-slot name="header">Compare</x-slot>

    <x-panel>
        <form action="{{ route('compare') }}" method="POST">
            <div class="grid grid-rows-1 grid-cols-2 gap-4 mb-4">
                @csrf
                <div>
                    <x-input-label for="player1" :value="__('app.player_one')" />
                    <x-text-input name="player1" class="w-full" :value="old('player1') ?? $player1->player_name ?? ''"></x-text-input>
                    <x-input-error :messages="$errors->get('player1')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="player2" :value="__('app.player_two')" />
                    <x-text-input name="player2" class="w-full" :value="old('player2') ?? $player2->player_name ?? ''"></x-text-input>
                    <x-input-error :messages="$errors->get('player2')" class="mt-2" />
                </div>
            </div>
            <x-primary-button class="mb-4">{{ __('app.compare') }}</x-primary-button>
        </form>

        @isset ($player1, $player2)

            <hr class="my-4 border-gray-500">

            <div class="flex">
                <div class="w-20 text-center">
                    {{ app('number')->format($totalKills['player1']) }}
                </div>
                <h2 class="flex-1 text-xl font-bold sticky top-0 bg-white dark:bg-gray-800 text-center">
                    Total Kills
                </h2>
                <div class="w-20 text-center">
                    {{ app('number')->format($totalKills['player2']) }}
                </div>
            </div>

            <hr class="my-4 border-gray-500">

            @foreach ($categories as $category)
                <div>
                    <div class="flex">
                        <div class="w-20 text-center">
                            {{ app('number')->format($categoryKills[$category->weapon_category_id]['player1']) }}
                        </div>
                        <h2 class="flex-1 text-xl font-bold sticky top-0 bg-white dark:bg-gray-800 text-center">
                            {{ $category->category_name }}
                        </h2>
                        <div class="w-20 text-center">
                            {{ app('number')->format($categoryKills[$category->weapon_category_id]['player2']) }}
                        </div>
                    </div>
                    <ul class="mt-2 mb-4">
                        @foreach ($category->weapons as $weapon)
                            <div class="flex items-center mb-1">
                                <div>
                                    <x-text-input :value="$comparison[$weapon->weapon_id]['player1']"
                                                  disabled
                                                  class="w-20 p-1 text-center"/>
                                </div>
                                <div class="w-full">
                                    <div class="bg-gray-200 dark:bg-gray-700 relative h-6"
                                         style="text-shadow: 1px 1px 1px rgba(128,128,128,.5)">
                                        <div class="flex">
                                            <div
                                                style="width: {{ min(($comparison[$weapon->weapon_id]['min'] / 10000) * 100, 100) }}%"
                                                @class([
                                                    'bg-zinc-400 dark:bg-zinc-500', 'h-6',
                                                ])></div>
                                            <div
                                                style="width: {{ min((abs($comparison[$weapon->weapon_id]['difference']) / 10000) * 100, 100) }}%"
                                                @class([
                                                    'bg-gray-400', 'h-6',
                                                    'bg-green-400 dark:bg-green-700' => $comparison[$weapon->weapon_id]['difference'] > 0,
                                                    'bg-red-400 dark:bg-red-700' => $comparison[$weapon->weapon_id]['difference'] < 0,
                                                ])></div>
                                        </div>
                                        <div class="text-center z-10 absolute inset-0">
                                            {{ $weapon->weapon_name }}
                                        </div>
                                        <div class="absolute inset-0 flex justify-between text-sm items-center">
                                            <div class="ml-2">
                                                @if ($comparison[$weapon->weapon_id]['difference'] > 0)
                                                    +
                                                @elseif ($comparison[$weapon->weapon_id]['difference'] < 0)
                                                    -
                                                @endif
                                                {{ abs($comparison[$weapon->weapon_id]['difference']) }}
                                            </div>
                                            <div class="mr-2">
                                                @if ($comparison[$weapon->weapon_id]['difference'] < 0)
                                                    +
                                                @elseif ($comparison[$weapon->weapon_id]['difference'] > 0)
                                                    -
                                                @endif
                                                {{ abs($comparison[$weapon->weapon_id]['difference']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <x-text-input :value="$comparison[$weapon->weapon_id]['player2']"
                                                  disabled
                                                  class="w-20 p-1 text-center"/>
                                </div>
                            </div>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        @endisset
    </x-panel>
</x-app-layout>
