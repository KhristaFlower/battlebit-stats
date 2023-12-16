<x-app-layout>
    <x-slot name="header">Admin: Categories</x-slot>

    <x-panel>
        <table class="w-full divide-y divide-gray-600 table-fixed">
            <thead>
                <tr>
                    <th class="sticky top-0 z-10 py-3.5 pl-4 pr-3 text-left text-sm font-semibold sm:pl-0">
                        Category Name
                    </th>
                    <th class="sticky top-0 z-10 py-3.5 pl-4 pr-3 text-left text-sm font-semibold sm:pl-0">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @foreach ($categories as $category)
                    <tr>
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium sm:pl-0">
                            {{ $category->category_name }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm flex pl-0">
                            <form action="{{ route('admin.categories.up', $category) }}" method="POST">
                                @csrf
                                <x-primary-button class="mr-1">&uparrow;</x-primary-button>
                            </form>
                            <form action="{{ route('admin.categories.down', $category) }}" method="POST">
                                @csrf
                                <x-primary-button class="mr-4">&downarrow;</x-primary-button>
                            </form>
                            <x-link-button href="{{ route('admin.categories.edit', $category) }}">Edit</x-link-button>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <x-danger-button class="ml-4">{{ __('app.delete') }}</x-danger-button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>

            <x-link-button href="{{ route('admin.categories.create') }}">
                {{ __('app.create_new_category') }}
            </x-link-button>
        </table>
    </x-panel>
</x-app-layout>
