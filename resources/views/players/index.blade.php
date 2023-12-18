<x-app-layout>
    <x-slot name="header">Your Players</x-slot>

    <x-panel>
        <table class="w-full divide-y divide-gray-600 table-fixed">
            <thead>
            <tr>
                <th scope="col"
                    class="sticky top-0 z-10 py-3.5 pl-4 pr-3 text-left text-sm font-semibold sm:pl-0">
                    {{ __('app.name') }}
                </th>
                <th scope="col"
                    class="sticky top-0 z-10 px-3 py-03.5 text-left text-sm font-semibold">
                    {{ __('app.kills') }}
                </th>
                <th scope="col"
                    class="sticky top-0 z-10 px-3 py-3.5 text-left text-sm font-semibold">
                    {{ __('app.actions') }}
                </th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
            @foreach ($players as $player)
                <tr>
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium sm:pl-0">
                        <a href="{{ route('players.show', $player) }}">
                            {{ $player->player_name }}
                        </a>
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm">
                        {{ app('number')->format($player->total_kills) }}
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm">
                        <x-link-button href="{{ route('players.show', $player) }}">
                            {{ __('app.open') }}
                        </x-link-button>

                        <x-link-button href="{{ route('players.edit', $player) }}">
                            {{ __('app.edit') }}
                        </x-link-button>

                        <form action="{{ route('players.destroy', $player) }}" method="POST"
                              class="inline-block">
                            @csrf
                            @method('DELETE')
                            <x-danger-button>{{ __('app.delete')  }}</x-danger-button>
                        </form>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            <a href="{{ route('players.create') }}"
               class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                {{ __('app.create_new_player') }}
            </a>
        </div>
    </x-panel>
</x-app-layout>
