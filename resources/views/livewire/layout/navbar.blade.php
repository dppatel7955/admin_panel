<header
    x-data="{ open: false }"
    class="bg-white shadow px-6 py-4 flex justify-between items-center"
>
    <!-- Left -->
    <div class="flex items-center gap-4">
        <!-- Mobile sidebar toggle -->
        <button
            @click="$dispatch('toggle-sidebar')"
            class="md:hidden text-gray-600"
        >
            ☰
        </button>

        <h1 class="text-xl font-semibold text-gray-800">
            My Dashboard
        </h1>
    </div>
    <button
        @click="toggle()"
        class="w-9 h-9 flex items-center justify-center rounded-xl
            bg-gray-100 dark:bg-gray-800
            text-gray-700 dark:text-gray-200
            hover:bg-gray-200 dark:hover:bg-gray-700 transition"
    >
        <span x-show="!isDark">🌙</span>
        <span x-show="isDark">☀️</span>
    </button>
    <!-- Right -->
    <div class="relative">
        <button
            @click="open = !open"
            class="flex items-center gap-2 focus:outline-none"
        >
            <span class="text-gray-700 font-medium">
                {{ auth()->user()->name ?? 'Admin' }}
            </span>

            <img
                src="https://ui-avatars.com/api/?name={{ auth()->user()->name ?? 'Admin' }}"
                class="w-8 h-8 rounded-full"
            >
        </button>

        <!-- Dropdown -->
        <div
            x-show="open"
            @click.outside="open = false"
            x-transition
            class="absolute right-0 mt-2 w-40 bg-white rounded shadow"
        >
            <a wire:navigate
                href="{{route('profile')}}"
                class="block px-4 py-2 hover:bg-gray-100"
            >
                Profile
            </a>

            <button
                @click="open = false"
                wire:click="confirmLogout"
                class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100 flex items-center gap-2"
            >
                Logout
            </button>

        </div>
    </div>
</header>
