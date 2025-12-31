<div class="max-w-7xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold">Products</h2>
            <p class="text-sm text-gray-500">Manage store products</p>
        </div>

        <a wire:navigate href="{{ route('products.create') }}" class="btn-primary">
            ➕ Add Product
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow px-6 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <!-- Search -->
        <div class="flex-1 max-w-sm">
            <input
                type="text"
                wire:model.live.debounce.250ms="search"
                placeholder="Search product..."
                class="input w-full"
            >
        </div>

        <!-- Status Filter -->
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
                    <th class="px-6 py-3 text-left">Product</th>
                    <th class="px-6 py-3 text-left">Category</th>
                    <th class="px-6 py-3 text-left">Brand</th>
                    <th class="px-6 py-3 text-left">Price</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-right">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @foreach($products as $product)
                    <tr class="hover:bg-gray-50">

                        <!-- Product -->
                        <td class="px-6 py-4 flex items-center gap-3">
                            @if($product->images && count($product->images))
                                <img
                                    src="{{ asset('storage/'.$product->images[0]) }}"
                                    class="h-10 w-10 rounded-lg object-cover border">
                            @else
                                <div class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center text-xs">
                                    N/A
                                </div>
                            @endif

                            <div>
                                <p class="font-medium">{{ $product->name }}</p>
                                <p class="text-xs text-gray-500">SKU: {{ $product->sku }}</p>
                            </div>
                        </td>

                        <!-- Category -->
                        <td class="px-6 py-4">
                            {{ $product->category->name }}
                        </td>

                        <!-- Brand -->
                        <td class="px-6 py-4">
                            {{ $product->brand->name }}
                        </td>

                        <!-- Price -->
                        <td class="px-6 py-4">
                            ₹{{ $product->sale_price ?? $product->price }}
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4">
                            <button
                                wire:click="toggleStatus({{ $product->id }})"
                                class="px-3 py-1 text-xs rounded-full
                                    {{ $product->status
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-red-100 text-red-700' }}">
                                {{ $product->status ? 'Active' : 'Inactive' }}
                            </button>
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-right space-x-2">
                            <a wire:navigate
                               href="{{ route('products.edit', $product) }}"
                               class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs">
                                Edit
                            </a>

                            <button
                                wire:click="confirmDelete({{ $product->id }})"
                                class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">
                                Delete
                            </button>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="px-6 py-4 border-t">
            {{ $products->links() }}
        </div>
    </div>
</div>
