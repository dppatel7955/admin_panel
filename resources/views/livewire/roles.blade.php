<div class="max-w-7xl mx-auto space-y-10">

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Roles & Permissions</h2>
            <p class="text-sm text-gray-500 mt-1">
                Create roles and assign permissions to them
            </p>
        </div>
    </div>

    <!-- Create / Edit Role Card -->
    <div class="bg-white shadow-lg rounded-2xl p-6 space-y-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <h3 class="text-xl font-semibold text-gray-800">
                {{ $editRoleId ? '✏️ Edit Role' : '➕ Create New Role' }}
            </h3>

            @if($editRoleId)
                <span class="text-xs bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full">
                    Editing Mode
                </span>
            @endif
        </div>

        <!-- Role Name -->
        <div>
            <label class="text-sm font-medium text-gray-600 mb-1 block">
                Role Name
            </label>
            <input
                type="text"
                wire:model.defer="name"
                placeholder="e.g. Admin, Manager"
                class="mt-1 w-full rounded-xl border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200"
            >
            @error('name')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Permissions -->
        <div>
            <label class="text-sm font-medium text-gray-600 mb-2 block">
                Assign Permissions
            </label>
            <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                @foreach ($permissions as $permission)
                    <label
                        class="flex items-center gap-2 p-2 border rounded-xl cursor-pointer hover:bg-gray-50 transition"
                    >
                        <input
                            type="checkbox"
                            wire:model="selectedPermissions"
                            value="{{ $permission->name }}"
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        >
                        <span class="text-sm text-gray-700">
                            {{ ucfirst(str_replace('-', ' ', $permission->name)) }}
                        </span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Actions -->
        <div class="flex gap-3 justify-end">
            @if ($editRoleId)
                <button
                    wire:click="updateRole"
                    class="px-6 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white shadow-md transition"
                >
                    Update Role
                </button>

                <button
                    wire:click="resetForm"
                    class="px-6 py-2 rounded-xl bg-gray-200 hover:bg-gray-300 text-gray-700 shadow-sm transition"
                >
                    Cancel
                </button>
            @else
                <button
                    wire:click="createRole"
                    class="px-6 py-2 rounded-xl bg-green-600 hover:bg-green-700 text-white shadow-md transition"
                >
                    Create Role
                </button>
            @endif
        </div>
    </div>

    <!-- Roles List -->
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-100">

        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">
                Existing Roles
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm divide-y divide-gray-100">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">Role</th>
                        <th class="px-6 py-3 text-left">Permissions</th>
                        <th class="px-6 py-3 text-right">Action</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($roles as $role)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ ucfirst($role->name) }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($role->permissions as $permission)
                                        <span
                                            class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full"
                                        >
                                            {{ ucfirst(str_replace('-', ' ', $permission->name)) }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>

                            <td class="px-6 py-4 text-right">
                                <button
                                    wire:click="editRole({{ $role->id }})"
                                    class="text-blue-600 hover:text-blue-800 font-medium transition"
                                >
                                    Edit
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                No roles created yet
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>