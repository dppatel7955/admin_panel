<div class="max-w-7xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold">Brands</h2>
            <p class="text-sm text-gray-500">Manage product brands</p>
        </div>

        <a
            wire:navigate
            href="{{ route('brands.create') }}"
            class="btn-primary">
            ➕ Add Brand
        </a>
    </div>

    <!-- Toolbar -->
    <div class="bg-white rounded-2xl shadow px-6 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <!-- Search -->
        <div class="flex-1 max-w-sm">
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search brand..."
                class="input w-full"
            >
        </div>

        <!-- Status Filter (optional) -->
        <div class="flex gap-2">
            <button
                wire:click="$set('statusFilter','all')"
                class="px-4 py-2 rounded-lg text-sm font-medium
                {{ $statusFilter === 'all'
                    ? 'bg-blue-600 text-white'
                    : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                All
            </button>

            <button
                wire:click="$set('statusFilter','active')"
                class="px-4 py-2 rounded-lg text-sm font-medium
                {{ $statusFilter === 'active'
                    ? 'bg-green-600 text-white'
                    : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Active
            </button>

            <button
                wire:click="$set('statusFilter','inactive')"
                class="px-4 py-2 rounded-lg text-sm font-medium
                {{ $statusFilter === 'inactive'
                    ? 'bg-red-600 text-white'
                    : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Inactive
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3 text-left">Brand</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-right">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse($brands as $brand)
                    <tr class="hover:bg-gray-50">

                        <!-- Brand Info -->
                        <td class="px-6 py-4 flex items-center gap-3">
                            @if($brand->image)
                                <img
                                    src="{{ asset('storage/'.$brand->image) }}"
                                    class="h-10 w-10 rounded-lg object-cover border">
                            @else
                                <div class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center text-xs">
                                    N/A
                                </div>
                            @endif

                            <div>
                                <p class="font-medium">{{ $brand->name }}</p>
                                <p class="text-xs text-gray-500">Sort: {{ $brand->sort_order }}</p>
                            </div>
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4">
                            <button
                                wire:click="toggleStatus({{ $brand->id }})"
                                class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full
                                {{ $brand->status
                                    ? 'bg-green-100 text-green-700 hover:bg-green-200'
                                    : 'bg-red-100 text-red-700 hover:bg-red-200' }}">
                                {{ $brand->status ? 'Active' : 'Inactive' }}
                            </button>
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-right space-x-2">
                            <a
                                wire:navigate
                                href="{{ route('brands.edit', $brand->id) }}"
                                class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full
                                bg-blue-100 text-blue-700 hover:bg-blue-200">
                                Edit
                            </a>

                            <button
                                wire:click="confirmDelete({{ $brand->id }})"
                                class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full
                                bg-red-100 text-red-700 hover:bg-red-200">
                                Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-6 text-center text-gray-500">
                            No brands found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t">
            {{ $brands->links() }}
        </div>
    </div>
</div>
