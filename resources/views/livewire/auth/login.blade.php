<div>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="w-full max-w-md bg-white p-6 rounded shadow">

            <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>

            <form wire:submit.prevent="login" class="space-y-4">

                <!-- Email -->
                <div>
                    <label>Email</label>
                    <input type="email"
                        wire:model.defer="email"
                        class="w-full border rounded p-2">
                    @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Password -->
                <div>
                    <label>Password</label>
                    <input type="password"
                        wire:model.defer="password"
                        class="w-full border rounded p-2">
                    @error('password') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <!-- Remember -->
                <div class="flex items-center">
                    <input type="checkbox" wire:model="remember">
                    <span class="ml-2">Remember me</span>
                </div>

                <!-- Loader -->
                <div>
                    <button type="submit"
                        wire:loading.attr="disabled"
                        class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                            <span wire:loading.remove>Login</span>
                            <span wire:loading>Logging in...</span>
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>
