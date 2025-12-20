<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md bg-white shadow rounded p-6">
        <h2 class="text-2xl font-bold mb-6 text-center">Create Account</h2>

        <form wire:submit.prevent="register" class="space-y-4">

            <!-- Name -->
            <div>
                <label class="block mb-1">Name</label>
                <input type="text" wire:model.defer="name"
                       class="w-full border rounded px-3 py-2">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block mb-1">Email</label>
                <input type="email" wire:model.defer="email"
                       class="w-full border rounded px-3 py-2">
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="block mb-1">Password</label>
                <input type="password" wire:model.defer="password"
                       class="w-full border rounded px-3 py-2">
                @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="block mb-1">Confirm Password</label>
                <input type="password" wire:model.defer="password_confirmation"
                       class="w-full border rounded px-3 py-2">
            </div>

            <!-- Submit -->
            <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                Register
            </button>

        </form>
    </div>
</div>
