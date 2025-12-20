<aside
    x-data="{ open: true }"
    @toggle-sidebar.window="open = !open"
    :class="open ? 'translate-x-0' : '-translate-x-full'"
    class="fixed md:static z-40 w-64 bg-gray-900 text-white min-h-screen transform transition-transform duration-300"
>
    <!-- Logo -->
    <div class="p-6 text-2xl font-bold border-b border-gray-700">
        Admin Panel
    </div>

    <!-- Navigation -->
    <nav class="p-4 space-y-1">

        <!-- Dashboard -->
        <a wire:navigate
            href="{{ route('dashboard') }}"
            class="block px-4 py-2 rounded
            {{ request()->routeIs('dashboard') ? 'bg-gray-700' : 'hover:bg-gray-700' }}"
        >
            📊 Dashboard
        </a>

        <!-- Users -->
        @can('manage users')
            <a wire:navigate
                href="{{ route('users.index') }}"
                class="block px-4 py-2 rounded
                {{ request()->routeIs('users.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}"
            >
                👤 Users
            </a>
        @endcan

        <!-- Role Management -->
        @can('manage roles')
            <a wire:navigate
                href="{{ route('roles') }}"
                class="block px-4 py-2 rounded
                {{ request()->routeIs('roles') ? 'bg-gray-700' : 'hover:bg-gray-700' }}"
            >
                🛡 Roles
            </a>
        @endcan

        <!-- Permission Management -->
        @can('manage permissions')
            <a wire:navigate
                href="{{ route('permissions') }}"
                class="block px-4 py-2 rounded
                {{ request()->routeIs('permissions') ? 'bg-gray-700' : 'hover:bg-gray-700' }}"
            >
                🔑 Permissions
            </a>
        @endcan

        <!-- Settings -->
        @can('manage settings')
            <a wire:navigate
                href="#"
                class="block px-4 py-2 rounded
                {{ request()->routeIs('settings') ? 'bg-gray-700' : 'hover:bg-gray-700' }}"
            >
                ⚙️ Settings
            </a>
        @endcan
        @can('manage emails')
            <a wire:navigate
                href="{{route('emails')}}"
                class="block px-4 py-2 rounded
                {{ request()->routeIs('emails') ? 'bg-gray-700' : 'hover:bg-gray-700' }}"
            >
                ⚙️ Emails
            </a>
        @endcan
        @can('manage email-setup')
            <a wire:navigate
                href="{{route('email-setup')}}"
                class="block px-4 py-2 rounded
                {{ request()->routeIs('email-setup') ? 'bg-gray-700' : 'hover:bg-gray-700' }}"
            >
                ⚙️ Email Setup
            </a>
        @endcan

    </nav>

</aside>
