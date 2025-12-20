<div class="max-w-7xl mx-auto space-y-10">

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Permissions</h2>
            <p class="text-sm text-gray-500 mt-1">
                Create permissions and assign roles to them
            </p>
        </div>
    </div>

    <!-- Create / Edit Permission Card -->
    <div class="bg-white shadow-lg rounded-2xl p-6 space-y-6 border border-gray-100">

        <div class="flex items-center justify-between">
            <h3 class="text-xl font-semibold text-gray-800">
                {{ $editPermissionId ? '✏️ Edit Permission' : '➕ Create New Permission' }}
            </h3>

            @if($editPermissionId)
                <span class="text-xs bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full">
                    Editing Mode
                </span>
            @endif
        </div>

        <!-- Permission Name -->
        <div>
            <label class="text-sm font-medium text-gray-600 mb-1 block">
                Permission Name
            </label>
            <input
                type="text"
                wire:model.defer="name"
                placeholder="e.g. manage-users, edit-posts"
                class="mt-1 w-full rounded-xl border border-gray-300 px-4 py-2 focus:border-blue-500 focus:ring focus:ring-blue-200"
            >
            @error('name')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Assign Roles -->
        <div>
            <label class="text-sm font-medium text-gray-600 mb-2 block">
                Assign Roles
            </label>
            <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                @foreach ($roles as $role)
                    <label class="flex items-center gap-2 p-2 border rounded-xl cursor-pointer hover:bg-gray-50 transition">
                        <input
                            type="checkbox"
                            wire:model="selectedRoles"
                            value="{{ $role->name }}"
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        >
                        <span class="text-sm text-gray-700">
                            {{ ucfirst($role->name) }}
                        </span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Actions -->
        <div class="flex gap-3 justify-end">
            @if ($editPermissionId)
                <button
                    wire:click="updatePermission"
                    class="px-6 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white shadow-md transition"
                >
                    Update Permission
                </button>

                <button
                    wire:click="resetForm"
                    class="px-6 py-2 rounded-xl bg-gray-200 hover:bg-gray-300 text-gray-700 shadow-sm transition"
                >
                    Cancel
                </button>
            @else
                <button
                    wire:click="createPermission"
                    class="px-6 py-2 rounded-xl bg-green-600 hover:bg-green-700 text-white shadow-md transition"
                >
                    Create Permission
                </button>
            @endif
        </div>
    </div>

    <!-- Permissions List -->
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-100">

        <div class="p-6 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">
                Existing Permissions
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm divide-y divide-gray-100">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">Permission</th>
                        <th class="px-6 py-3 text-left">Roles</th>
                        <th class="px-6 py-3 text-right">Action</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse ($permissions as $permission)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ ucfirst($permission->name) }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($permission->roles as $role)
                                        <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>

                            <td class="px-6 py-4 text-right">
                                <button
                                    wire:click="editPermission({{ $permission->id }})"
                                    class="text-blue-600 hover:text-blue-800 font-medium transition"
                                >
                                    Edit
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                No permissions created yet
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
