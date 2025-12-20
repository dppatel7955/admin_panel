<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('livewire.layout.app')]
#[Title('Role Management')]
class Roles extends Component
{
    public $roles;
    public $permissions;

    public $name;
    public $selectedPermissions = [];

    public $editRoleId = null;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->roles = Role::with('permissions')->get();
        $this->permissions = Permission::all();
    }

    public function createRole()
    {
        $this->validate([
            'name' => 'required|unique:roles,name',
        ]);

        $role = Role::create(['name' => $this->name]);
        $role->syncPermissions($this->selectedPermissions);

        $this->resetForm();

        $this->dispatch('notify', type: 'success', message: 'Role created successfully!');
        $this->loadData();
    }

    public function editRole($id)
    {
        $role = Role::findOrFail($id);

        $this->editRoleId = $role->id;
        $this->name = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
    }

    public function updateRole()
    {
        $this->validate([
            'name' => 'required|unique:roles,name,' . $this->editRoleId,
        ]);

        $role = Role::findOrFail($this->editRoleId);
        $role->update(['name' => $this->name]);
        $role->syncPermissions($this->selectedPermissions);

        $this->resetForm();

        $this->dispatch('notify', type: 'success', message: 'Role updated successfully!');
        $this->loadData();
    }

    public function resetForm()
    {
        $this->reset(['name', 'selectedPermissions', 'editRoleId']);
    }

    public function render()
    {
        return view('livewire.roles');
    }
}
