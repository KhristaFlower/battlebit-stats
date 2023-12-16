<x-app-layout>
    <x-slot name="header">{{ __('app.create_new_player') }}</x-slot>

    <x-panel>
        <form action="{{ route('players.store') }}" method="POST">
            @csrf

            <x-input-label for="player_name" :value="__('app.player_name')" />
            <x-text-input name="player_name" class="w-full"></x-text-input>
            <x-input-error :messages="$errors->get('player_name')" class="mt-2" />

            <x-primary-button class="mt-4">{{ __('app.create') }}</x-primary-button>
        </form>
    </x-panel>
</x-app-layout>
