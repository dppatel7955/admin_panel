<div class="max-w-4xl mx-auto space-y-6">
    <!-- Title -->
    <h2 class="text-2xl font-bold text-gray-800">
        {{ $user ? '✏️ Edit User' : '➕ Create User' }}
    </h2>
    <!-- Card -->
    <div class="bg-white rounded-2xl shadow p-8 space-y-8">
        <!-- ================= Basic Info ================= -->
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Full Name -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Full Name</label>
                <input wire:model.defer="name"
                       class="input"
                       placeholder="John Doe">
                @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                <input wire:model.defer="email"
                       class="input"
                       placeholder="john@example.com">
                @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">
                    Password {{ $user ? '(optional)' : '' }}
                </label>
                <input type="password"
                       wire:model.defer="password"
                       class="input"
                       placeholder="********">
                @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Status</label>
                <select wire:model.defer="status" class="input">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>
        <!-- ================= Contact Info ================= -->
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Phone -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Phone</label>
                <input wire:model.defer="phone"
                       class="input"
                       placeholder="+91 9876543210">
            </div>
            <!-- City -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">City</label>
                <input wire:model.defer="city"
                       class="input"
                       placeholder="Ahmedabad">
            </div>
            <!-- State -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">State</label>
                <input wire:model.defer="state"
                       class="input"
                       placeholder="Gujarat">
            </div>
            <!-- Country -->
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Country</label>
                <input wire:model.defer="country"
                       class="input"
                       placeholder="India">
            </div>
        </div>
        <!-- Address -->
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Address</label>
            <textarea wire:model.defer="address"
                      rows="3"
                      class="input"
                      placeholder="Full address"></textarea>
        </div>
        <!-- ================= Role ================= -->
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Role</label>
            <select wire:model.defer="role" class="input">
                <option value="">Select role</option>
                @foreach($roles as $roleItem)
                    <option value="{{ $roleItem->name }}">
                        {{ ucfirst($roleItem->name) }}
                    </option>
                @endforeach
            </select>
            @error('role') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>
        <!-- ================= Actions ================= -->
        <div class="flex justify-end gap-3 pt-4">
            <a wire:navigate href="{{ route('users.index') }}" class="btn-secondary">
                Cancel
            </a>
            <button wire:click="save" class="btn-primary">
                {{ $user ? 'Update User' : 'Create User' }}
            </button>
        </div>
    </div>
</div>
