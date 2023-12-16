<x-app-layout>
    <x-slot name="header">Admin: Categories: Edit</x-slot>

    <x-panel>
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PATCH')
            <x-input-label for="category_name" :value="__('app.category_name')" />
            <x-text-input name="category_name" class="w-full" :value="old('category_name') ?? $category->category_name"></x-text-input>
            <x-input-error :messages="$errors->get('category_name')" class="mt-2" />

            <div class="mt-4">
                <x-primary-button>{{ __('app.update') }}</x-primary-button>
            </div>
        </form>
    </x-panel>
</x-app-layout>
