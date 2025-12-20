<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('livewire.layout.app')]
#[Title('Permission Management')]
class Permissions extends Component
{
    public $permissions, $roles;
    public $name, $selectedRoles = [], $editPermissionId = null;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->permissions = Permission::with('roles')->get();
        $this->roles = Role::all();
    }

    public function createPermission()
    {
        $this->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        $permission = Permission::create(['name' => $this->name]);
        if ($this->selectedRoles) {
            $permission->syncRoles($this->selectedRoles);
        }

        $this->resetForm();
        $this->dispatch('notify', type: 'success', message: 'Permission created!');
        $this->loadData();
    }

    public function editPermission($id)
    {
        $permission = Permission::findOrFail($id);
        $this->editPermissionId = $permission->id;
        $this->name = $permission->name;
        $this->selectedRoles = $permission->roles->pluck('name')->toArray();
    }

    public function updatePermission()
    {
        $this->validate([
            'name' => 'required|unique:permissions,name,' . $this->editPermissionId,
        ]);

        $permission = Permission::findOrFail($this->editPermissionId);
        $permission->update(['name' => $this->name]);
        $permission->syncRoles($this->selectedRoles);

        $this->resetForm();
        $this->dispatch('notify', type: 'success', message: 'Permission updated!');
        $this->loadData();
    }

    public function resetForm()
    {
        $this->reset(['name', 'selectedRoles', 'editPermissionId']);
    }

    public function render()
    {
        return view('livewire.permissions');
    }
}
