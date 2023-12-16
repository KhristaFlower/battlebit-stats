<x-app-layout>
    <x-slot name="header">Global Stats</x-slot>

    <x-panel>
        @foreach ($categoryKills as $category)
            <h2 class="text-xl font-semibold">{{ $category->category_name }}</h2>
            <div>{{ $category->total_kills }}</div>
        @endforeach
    </x-panel>
</x-app-layout>
