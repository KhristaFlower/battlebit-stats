<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('app.dashboard') }}
        </h2>
    </x-slot>

    <x-panel>
        {{ __('app.you_are_logged_in') }}
    </x-panel>
</x-app-layout>
