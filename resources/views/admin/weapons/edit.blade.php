<x-app-layout>
    <x-slot name="header">Admin: Weapons: Edit</x-slot>

    <x-panel>
        <form action="{{ route('admin.weapons.update', $weapon) }}" method="POST">
            @csrf
            @method('PATCH')
            <x-input-label for="weapon_name" :value="__('app.weapon_name')" />
            <x-text-input name="weapon_name" class="w-full" :value="old('weapon_name') ?? $weapon->weapon_name"></x-text-input>
            <x-input-error :messages="$errors->get('weapon_name')" class="mt-2" />

            <x-input-label for="category_id" :value="__('app.category')"></x-input-label>
            <select name="weapon_category_id" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                @foreach ($categories as $category)
                    <option value="{{ $category->weapon_category_id }}" {{ (old('weapon_category_id', $weapon->weapon_category_id) == $category->weapon_category_id) ? 'selected' : '' }}>
                        {{ $category->category_name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('weapon_category_id')" class="mt-2"></x-input-error>

            <x-input-label for="weapon_rank" :value="__('app.weapon_rank')" />
            <x-text-input name="weapon_rank" class="w-full" :value="old('weapon_rank') ?? $weapon->weapon_rank"></x-text-input>
            <x-input-error :messages="$errors->get('weapon_rank')" class="mt-2" />

            <div class="mt-4">
                <x-primary-button>{{ __('app.update') }}</x-primary-button>
            </div>
        </form>
    </x-panel>
</x-app-layout>
