<div class="max-w-4xl mx-auto space-y-6">
    <!-- Title -->
    <h2 class="text-2xl font-bold text-gray-800">
        {{ $brand ? '✏️ Edit Brand' : '➕ Create Brand' }}
    </h2>

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow p-8 space-y-8">

        <!-- ================= Basic Info ================= -->
        <div class="grid md:grid-cols-2 gap-6">

            <!-- Brand Name -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">
                    Brand Name
                </label>
                <input wire:model.defer="name"
                       class="input"
                       placeholder="Apple">
                @error('name')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Slug -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">
                    Slug
                </label>
                <input wire:model.defer="slug"
                       class="input"
                       placeholder="apple">
                @error('slug')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Sort Order -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">
                    Sort Order
                </label>
                <input type="number"
                       wire:model.defer="sort_order"
                       class="input"
                       placeholder="0">
                @error('sort_order')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">
                    Status
                </label>
                <select wire:model.defer="status" class="input">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

        </div>

        <!-- ================= Image ================= -->
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">
                Brand Image
            </label>

            <input type="file" wire:model="image" class="input">

            @if($image)
                <img src="{{ $image->temporaryUrl() }}"
                     class="h-20 mt-3 rounded border">
            @elseif($brand?->image)
                <img src="{{ asset('storage/'.$brand->image) }}"
                     class="h-20 mt-3 rounded border">
            @endif

            @error('image')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- ================= Actions ================= -->
        <div class="flex justify-end gap-3 pt-4">
            <a wire:navigate
               href="{{ route('brands.index') }}"
               class="btn-secondary">
                Cancel
            </a>

            <button wire:click="save"
                    class="btn-primary">
                {{ $brand ? 'Update Brand' : 'Create Brand' }}
            </button>
        </div>

    </div>
</div>
