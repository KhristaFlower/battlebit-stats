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

        @foreach ($categories ?? [] as $category)
            <div>
                <h2 class="text-xl font-bold sticky top-0 bg-white dark:bg-gray-800 text-center">
                    {{ $category->category_name }}
                </h2>
                <ul class="mt-2 mb-4">
                    @foreach ($category->weapons as $weapon)
                        <div class="flex items-center mb-1">
                            <div>
                                <x-text-input :value="$player1Stats[$weapon->weapon_id]"
                                              disabled
                                              class="w-20 p-1 text-center"/>
                            </div>
                            <div class="w-full">
                                <div class="bg-gray-200 dark:bg-gray-700 relative h-6" style="text-shadow: 1px 1px 1px rgba(128,128,128,.5)">
                                    <div
                                        style="width: {{ ($player1Stats[$weapon->weapon_id] / 10000) * 100 }}%"
                                        class="bg-green-500 dark:bg-green-700 whitespace-nowrap h-3">
                                    </div>
                                    <div
                                        style="width: {{ ($player2Stats[$weapon->weapon_id] / 10000) * 100 }}%"
                                        class="bg-gray-400 dark:bg-gray-400 whitespace-nowrap h-3">
                                    </div>
                                    <div class="text-center z-10 absolute inset-0">
                                        {{ $weapon->weapon_name }}
                                    </div>
                                    <div class="absolute inset-0 flex justify-between text-sm items-center">
                                        <div class="ml-2">
                                            @if ($player1Stats[$weapon->weapon_id] > $player2Stats[$weapon->weapon_id])
                                                +
                                            @elseif ($player1Stats[$weapon->weapon_id] < $player2Stats[$weapon->weapon_id])
                                                -
                                            @endif
                                            {{ abs($player1Stats[$weapon->weapon_id] - $player2Stats[$weapon->weapon_id]) }}
                                        </div>
                                        <div class="mr-2">
                                            @if ($player2Stats[$weapon->weapon_id] > $player1Stats[$weapon->weapon_id])
                                                +
                                            @elseif ($player2Stats[$weapon->weapon_id] < $player1Stats[$weapon->weapon_id])
                                                -
                                            @endif
                                            {{ abs($player2Stats[$weapon->weapon_id] - $player1Stats[$weapon->weapon_id]) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <x-text-input :value="$player2Stats[$weapon->weapon_id]"
                                              disabled
                                              class="w-20 p-1 text-center"/>
                            </div>
                        </div>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </x-panel>
</x-app-layout>
