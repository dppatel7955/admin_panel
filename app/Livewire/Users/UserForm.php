<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('livewire.layout.app')]
#[Title('User Form')]
class UserForm extends Component
{
    public User|null $user = null;

    public $name, $email, $password;
    public $status = 'active';
    public $phone, $city, $state, $country, $address;
    public $role;

    public $roles;

    public function mount(User $user)
    {
        $this->roles = Role::all();

        if ($user->exists) {
            $this->user = $user;
            $this->fill($user->toArray());
            $this->role = $user->roles->first()?->name;
        }
    }

    public function save()
    {
        $data = $this->validate([
            'name'  => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . optional($this->user)->id,
            'password' => $this->user ? 'nullable|min:8' : 'required|min:8',
            'phone'   => 'nullable|min:8',
            'city'    => 'nullable|string',
            'state'   => 'nullable|string',
            'country' => 'nullable|string',
            'address' => 'nullable|string',
            'role' => 'required',
        ]);
        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        } else {
            unset($data['password']);
        }

        $user = User::updateOrCreate(
            ['id' => optional($this->user)->id],
            $data
        );

        $user->syncRoles([$this->role]);
        $msg = $this->user ? 'User update successfully' : 'User create successfully';
        $this->dispatch('notify', type: 'success', message: $msg);
        return $this->redirectRoute('users.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.users.form');
    }
}