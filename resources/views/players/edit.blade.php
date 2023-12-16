<x-app-layout>
    <x-slot name="header">{{ __('app.edit_player') }}</x-slot>

    <x-panel>
        <form action="{{ route('players.update', $player) }}" method="POST">
            @method('PATCH')
            @csrf

            <x-input-label for="player_name" :value="__('app.player_name')" />
            <x-text-input name="player_name" class="w-full" :value="old('player_name') ?? $player->player_name"></x-text-input>
            <x-input-error :messages="$errors->get('player_name')" class="mt-2" />

            <x-primary-button>{{ __('app.update') }}</x-primary-button>
        </form>
    </x-panel>
</x-app-layout>
