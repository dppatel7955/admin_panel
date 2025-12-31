<div class="max-w-7xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold">Categories</h2>
            <p class="text-sm text-gray-500">Manage product categories</p>
        </div>

        <a wire:navigate href="{{ route('categories.create') }}" class="btn-primary">
            ➕ Add Category
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow px-6 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <!-- Search -->
        <div class="flex-1 max-w-sm">
            <input
                type="text"
                wire:model.live.debounce.250ms="search"
                placeholder="Search category..."
                class="input w-full"
            >
        </div>

        <!-- Status Filter (optional) -->
        <div class="flex gap-2">
            @foreach(['all','active','inactive'] as $status)
                <button
                    wire:click="$set('statusFilter','{{ $status }}')"
                    class="px-4 py-2 rounded-lg text-sm font-medium
                        {{ $statusFilter === $status
                            ? 'bg-blue-600 text-white'
                            : 'bg-gray-100 hover:bg-gray-200' }}">
                    {{ ucfirst($status) }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3 text-left">Category</th>
                    <th class="px-6 py-3 text-left">Parent</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-right">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @foreach($categories as $category)
                    {{-- Parent --}}
                    <tr class="hover:bg-gray-50 font-medium">
                        <td class="px-6 py-4 flex items-center gap-3">
                            @if($category->image)
                                <img
                                    src="{{ asset('storage/'.$category->image) }}"
                                    class="h-10 w-10 rounded-lg object-cover border">
                            @else
                                <div class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center text-xs">
                                    N/A
                                </div>
                            @endif
                            <div>
                                <p class="font-medium">{{ $category->name }}</p>
                                <p class="text-xs text-gray-500">Sort: {{ $category->sort_order }}</p>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-gray-400">
                            —
                        </td>

                        <td class="px-6 py-4">
                            <button
                                wire:click="toggleStatus({{ $category->id }})"
                                class="px-3 py-1 text-xs rounded-full
                                    {{ $category->status
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-red-100 text-red-700' }}">
                                {{ $category->status ? 'Active' : 'Inactive' }}
                            </button>
                        </td>

                        <td class="px-6 py-4 text-right space-x-2">
                            <a wire:navigate
                               href="{{ route('categories.edit', $category) }}"
                               class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs">
                                Edit
                            </a>

                            <button
                                wire:click="confirmDelete({{ $category->id }})"
                                class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">
                                Delete
                            </button>
                        </td>
                    </tr>

                    {{-- Children --}}
                    @foreach($category->children as $child)
                        <tr class="hover:bg-gray-50 text-gray-600">
                            <td class="px-6 py-4 pl-12 flex items-center gap-3">
                                └ @if($child->image)
                                    <img
                                        src="{{ asset('storage/'.$child->image) }}"
                                        class="h-10 w-10 rounded-lg object-cover border">
                                @else
                                    <div class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center text-xs">
                                        N/A
                                    </div>
                                @endif
                                <div>
                                    <p class="font-medium">{{ $child->name }}</p>
                                    <p class="text-xs text-gray-500">Sort: {{ $child->sort_order }}</p>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                {{ $category->name }}
                            </td>

                            <td class="px-6 py-4">
                                <button
                                    wire:click="toggleStatus({{ $child->id }})"
                                    class="px-3 py-1 text-xs rounded-full
                                        {{ $child->status
                                            ? 'bg-green-100 text-green-700'
                                            : 'bg-red-100 text-red-700' }}">
                                    {{ $child->status ? 'Active' : 'Inactive' }}
                                </button>
                            </td>

                            <td class="px-6 py-4 text-right space-x-2">
                                <a wire:navigate
                                   href="{{ route('categories.edit', $child) }}"
                                   class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs">
                                    Edit
                                </a>

                                <button
                                    wire:click="confirmDelete({{ $child->id }})"
                                    class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>

        <div class="px-6 py-4 border-t">
            {{ $categories->links() }}
        </div>
    </div>
</div>
