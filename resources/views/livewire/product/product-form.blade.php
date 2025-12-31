<div class="max-w-6xl mx-auto space-y-6">

    <!-- Title -->
    <h2 class="text-2xl font-bold text-gray-800">
        {{ $product ? '✏️ Edit Product' : '➕ Create Product' }}
    </h2>

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow p-8 space-y-8">

        <!-- ================= BASIC INFO ================= -->
        <div class="grid md:grid-cols-2 gap-6">

            <!-- Product Name -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">
                    Product Name
                </label>
                <input wire:model.defer="name" class="input" placeholder="Product name">
                @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Slug -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">
                    Slug
                </label>
                <input wire:model.defer="slug" class="input" placeholder="product-slug">
                @error('slug') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Category -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">
                    Category
                </label>
                <select wire:model.defer="category_id" class="input">
                    <option value="">Select category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Brand -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">
                    Brand
                </label>
                <select wire:model.defer="brand_id" class="input">
                    <option value="">Select brand</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}">
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>
                @error('brand_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- ================= DESCRIPTION ================= -->
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">
                Description
            </label>
            <textarea wire:model.defer="description"
                      rows="4"
                      class="input"
                      placeholder="Product description"></textarea>
            @error('description') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- ================= PRICING ================= -->
        <div class="grid md:grid-cols-3 gap-6">

            <!-- Price -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">
                    Price
                </label>
                <input type="number" step="0.01" wire:model.defer="price" class="input">
                @error('price') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Sale Price -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">
                    Sale Price
                </label>
                <input type="number" step="0.01" wire:model.defer="sale_price" class="input">
                @error('sale_price') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Stock -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">
                    Stock
                </label>
                <input type="number" wire:model.defer="stock" class="input">
                @error('stock') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- ================= SKU & ORDER ================= -->
        <div class="grid md:grid-cols-2 gap-6">

            <!-- SKU -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">
                    SKU
                </label>
                <input wire:model.defer="sku" class="input">
                @error('sku') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Sort Order -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">
                    Sort Order
                </label>
                <input type="number" wire:model.defer="sort_order" class="input">
            </div>
        </div>

        <!-- ================= IMAGES ================= -->
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">
                Product Images
            </label>

            <input type="file" wire:model="images" multiple class="input">

            <!-- New Upload Preview -->
            @if($images)
                <div class="flex flex-wrap gap-3 mt-3">
                    @foreach($images as $img)
                        <img src="{{ $img->temporaryUrl() }}"
                             class="h-24 w-24 object-cover rounded border">
                    @endforeach
                </div>
            @endif

            <!-- Existing Images -->
            @if($existingImages)
                <div class="flex flex-wrap gap-3 mt-3">
                    @foreach($existingImages as $index => $img)
                        <div class="relative">
                            <img
                                src="{{ asset('storage/'.$img) }}"
                                class="h-24 w-24 object-cover rounded border">

                            <button
                                type="button"
                                wire:click="removeExistingImage({{ $index }})"
                                class="cursor-pointer absolute -top-2 -right-2 bg-red-600 text-white
                                    rounded-full text-xs px-2 hover:bg-red-700">
                                ✕
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif


            @error('images.*') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- ================= STATUS ================= -->
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">
                Status
            </label>
            <select wire:model.defer="status" class="input">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

        <!-- ================= ACTIONS ================= -->
        <div class="flex justify-end gap-3 pt-4">
            <a wire:navigate
               href="{{ route('products.index') }}"
               class="btn-secondary">
                Cancel
            </a>

            <button wire:click="save" class="btn-primary">
                {{ $product ? 'Update Product' : 'Create Product' }}
            </button>
        </div>

    </div>
</div>