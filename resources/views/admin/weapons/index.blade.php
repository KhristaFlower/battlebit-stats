<x-app-layout>
    <x-slot name="header">Admin: Weapons</x-slot>

    <x-panel>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold sticky top-0 bg-white dark:bg-gray-800 text-center">
                {{ __('app.weapons') }}
            </h2>
            <x-link-button href="{{ route('admin.weapons.create') }}">
                {{ __('app.create_new_weapon') }}
            </x-link-button>
        </div>
        <table class="w-full divide-y divide-gray-600 table-fixed">
            <thead>
                <tr>
                    <th class="sticky top-0 z-10 py-3.5 pl-4 pr-3 text-left text-sm font-semibold sm:pl-0">
                        Weapon Name
                    </th>
                    <th class="sticky top-0 z-10 py-3.5 pl-4 pr-3 text-left text-sm font-semibold sm:pl-0">
                        Category
                    </th>
                    <th class="sticky top-0 z-10 py-3.5 pl-4 pr-3 text-left text-sm font-semibold sm:pl-0">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @foreach ($weapons as $weapon)
                    <tr>
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium sm:pl-0">
                            {{ $weapon->weapon_name }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm pl-0">
                            {{ $weapon->category->category_name }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm flex pl-0">
                            <x-link-button href="{{ route('admin.weapons.edit', $weapon) }}">
                                {{ __('app.edit') }}
                            </x-link-button>
                            <form action="{{ route('admin.weapons.destroy', $weapon) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <x-danger-button class="ml-4">{{ __('app.delete') }}</x-danger-button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-panel>
</x-app-layout>
