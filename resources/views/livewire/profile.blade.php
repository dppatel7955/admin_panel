<div class="max-w-6xl mx-auto space-y-10">

    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-6 text-white flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold">My Profile</h2>
            <p class="text-sm opacity-90">Manage your personal information</p>
        </div>

        <span class="px-4 py-1 text-sm rounded-full
            {{ auth()->user()->status === 'active'
                ? 'bg-green-500'
                : 'bg-red-500' }}">
            {{ ucfirst(auth()->user()->status) }}
        </span>
    </div>
    <!-- Profile Card -->
    <div class="bg-white shadow-xl rounded-xl p-8 grid lg:grid-cols-3 gap-8">

        <!-- Avatar Section -->
        <div class="flex flex-col items-center text-center gap-4">
            <div class="relative w-36 h-36">
                <!-- Avatar -->
                <img
                    src="{{ auth()->user()->avatar
                        ? asset('storage/' . auth()->user()->avatar)
                        : 'https://ui-avatars.com/api/?name=' . auth()->user()->name }}"
                    class="w-36 h-36 rounded-full object-cover border-4 border-blue-500"
                >
                <!-- Upload Loader -->
                <div
                    wire:loading
                    wire:target="avatar"
                    class="absolute inset-0 bg-black/60 rounded-full flex items-center justify-center"
                >
                    <svg class="animate-spin h-6 w-6 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10"
                            stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8v4l3-3-3-3v4a12 12 0 00-12 12h4z"></path>
                    </svg>
                </div>

                <!-- Upload Button -->
                <label
                    class="absolute bottom-1 right-1 bg-blue-600 text-white p-2 rounded-full cursor-pointer hover:bg-blue-700 shadow"
                    title="Change avatar"
                >
                    ✎
                    <input type="file" wire:model="avatar" class="hidden">
                </label>
            </div>
            @error('avatar')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
            <div class="text-sm text-gray-500">
                Last login:
                <span class="font-medium">
                    {{ auth()->user()->last_login_at
                        ? auth()->user()->last_login_at->diffForHumans()
                        : 'Never' }}
                </span>
            </div>

            <!-- Mini Stats -->
            <div class="grid grid-cols-2 gap-4 w-full mt-4">
                <div class="bg-gray-100 p-3 rounded-lg">
                    <p class="text-xs text-gray-500">Member Since</p>
                    <p class="font-semibold">
                        {{ auth()->user()->created_at->format('M Y') }}
                    </p>
                </div>
                <div class="bg-gray-100 p-3 rounded-lg">
                    <p class="text-xs text-gray-500">Account</p>
                    <p class="font-semibold capitalize">
                        {{ auth()->user()->status }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Profile Form -->
        <form wire:submit.prevent="updateProfile" class="lg:col-span-2 space-y-6">

            <h3 class="text-lg font-semibold border-b pb-2">
                Personal Information
            </h3>

            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="text-sm text-gray-600">Full Name</label>
                    <input wire:model.defer="name" class="input" />
                    @error('name')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-sm text-gray-600">Email Address</label>
                    <input wire:model.defer="email" class="input" />
                    @error('email')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-sm text-gray-600">Phone</label>
                    <input wire:model.defer="phone" class="input" />
                    @error('phone')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-sm text-gray-600">City</label>
                    <input wire:model.defer="city" class="input" />
                    @error('city')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-sm text-gray-600">State</label>
                    <input wire:model.defer="state" class="input" />
                    @error('state')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-sm text-gray-600">Country</label>
                    <input wire:model.defer="country" class="input" />
                    @error('country')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="text-sm text-gray-600">Address</label>
                <textarea wire:model.defer="address" rows="3" class="input"></textarea>
                @error('address')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2 rounded-lg shadow">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <!-- Password Section -->
    <div class="bg-white shadow-xl rounded-xl p-8 max-w-lg">
        <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
            🔒 Change Password
        </h3>
        <form wire:submit.prevent="updatePassword" class="space-y-4">
            <div>
                <input
                    type="password"
                    wire:model.defer="password"
                    class="input"
                    placeholder="New password"
                >
                @error('password')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <input
                    type="password"
                    wire:model.defer="password_confirmation"
                    class="input"
                    placeholder="Confirm password"
                >
            </div>
            <button class="bg-gray-900 hover:bg-gray-800 text-white px-6 py-2 rounded-lg">
                Update Password
            </button>
        </form>
    </div>
</div>
