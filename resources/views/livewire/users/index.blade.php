<div class="max-w-7xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold">Users</h2>
            <p class="text-sm text-gray-500">Manage application users</p>
        </div>
    </div>
    <!-- Users Navigation -->
    <div class="bg-white rounded-2xl shadow px-6 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <!-- Search -->
        <div class="flex-1 max-w-sm">
            <input
                type="text"
                wire:model.live.debounce.250ms="search"
                placeholder="Search by name or email..."
                class="input w-full"
            >
        </div>
        <!-- Tabs -->
        <div class="flex gap-2 flex-wrap">

            <button
                wire:click="$set('filter','all')"
                class="px-4 py-2 rounded-lg text-sm font-medium
                    {{ $filter === 'all'
                        ? 'bg-blue-600 text-white'
                        : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                All
                <span class="ml-1 text-xs">({{ $counts['all'] }})</span>
            </button>

            <button
                wire:click="$set('filter','active')"
                class="px-4 py-2 rounded-lg text-sm font-medium
                    {{ $filter === 'active'
                        ? 'bg-green-600 text-white'
                        : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Active
                <span class="ml-1 text-xs">({{ $counts['active'] }})</span>
            </button>

            <button
                wire:click="$set('filter','inactive')"
                class="px-4 py-2 rounded-lg text-sm font-medium
                    {{ $filter === 'inactive'
                        ? 'bg-yellow-500 text-white'
                        : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Inactive
                <span class="ml-1 text-xs">({{ $counts['inactive'] }})</span>
            </button>

            <button
                wire:click="$set('filter','deleted')"
                class="px-4 py-2 rounded-lg text-sm font-medium
                    {{ $filter === 'deleted'
                        ? 'bg-red-600 text-white'
                        : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Deleted
                <span class="ml-1 text-xs">({{ $counts['deleted'] }})</span>
            </button>

        </div>

        <!-- Create Button -->
        <a wire:navigate href="{{ route('users.create') }}" class="btn-primary">
            ➕ Create User
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-xs uppercase">
                <tr>
                    <th class="px-6 py-3 text-left">User</th>
                    <th class="px-6 py-3 text-left">Role</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-right">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @foreach($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <p class="font-medium">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $user->email }}</p>
                        </td>

                        <td class="px-6 py-4">
                            @foreach($user->roles as $role)
                                <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </td>

                        <td class="px-6 py-4">
                            <button
                                wire:click="toggleStatus({{ $user->id }})"
                                class="cursor-pointer inline-flex items-center px-3 py-1 text-xs font-medium rounded-full
                                    {{ $user->status === 'active'
                                        ? 'bg-green-100 text-green-700 hover:bg-green-200'
                                        : 'bg-red-100 text-red-700 hover:bg-red-200' }}">
                                {{ $user->status === 'active' ? ucfirst($user->status) : ucfirst($user->status) }}
                            </button>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            @if($user->trashed())
                                <!-- Restore -->
                                <button
                                    wire:click="restoreUser({{ $user->id }})"
                                    class="cursor-pointer inline-flex items-center px-3 py-1 text-xs font-medium rounded-full
                                        bg-green-100 text-green-700 hover:bg-green-200">
                                    Restore
                                </button>

                                <!-- Permanent Delete -->
                                <button
                                    wire:click="confirmforceDeleteUser({{ $user->id }})"
                                    class="cursor-pointer inline-flex items-center px-3 py-1 text-xs font-medium rounded-full
                                        bg-red-100 text-red-700 hover:bg-red-200">
                                    Delete
                                </button>
                            @else
                                <!-- Edit -->
                            <a
                                wire:navigate
                                href="{{ route('users.edit', $user) }}"
                                class="cursor-pointer inline-flex items-center px-3 py-1 text-xs font-medium rounded-full
                                    bg-blue-100 text-blue-700 hover:bg-blue-200">
                                Edit
                            </a>
                            <!-- Delete -->
                            <button
                                wire:click="confirmDelete({{ $user->id }})"
                                class="cursor-pointer inline-flex items-center px-3 py-1 text-xs font-medium rounded-full
                                    bg-red-100 text-red-700 hover:bg-red-200">
                                Delete
                            </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="px-6 py-4 border-t">
            {{ $users->links() }}
        </div>
    </div>
</div>