<x-app-layout>
    <x-slot name="header">{{ __('app.search') }}</x-slot>

    <x-panel>
        <form action="{{ route('search') }}" method="GET">

            <!-- Search -->
            <div>
                <x-input-label for="search" :value="__('app.search')"/>
                <x-text-input id="search" class="block mt-1 w-full" type="text" name="for" :value="old('for')" required
                              autofocus autocomplete="search"/>
                <x-input-error :messages="$errors->get('for')" class="mt-2"/>
            </div>

            <div class="flex items-center justify-end mt-4">
                {{--        <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">--}}
                {{--            {{ __('My profile') }}--}}
                {{--        </a>--}}

                <x-primary-button class="ms-4">
                    {{ __('app.search') }}
                </x-primary-button>
            </div>
        </form>

        <div>
            @if(isset($players) && count($players) > 0)
                @foreach ($players as $player)
                    <a href="{{ route('stats', $player->player_name) }}">{{ $player->player_name }}</a>
                @endforeach
            @elseif (isset($players) && count($players) === 0)
                {{ __('app.no_players_found') }}
            @else
                {{ __('app.search_for_players') }}
            @endif
        </div>
    </x-panel>

</x-app-layout>
