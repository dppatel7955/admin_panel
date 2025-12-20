<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('livewire.layout.app')]
#[Title('My Profile')]
class Profile extends Component
{
    use WithFileUploads;

    public $name, $email, $phone;
    public $city, $state, $country, $address;
    public $avatar;

    public $password, $password_confirmation;

    public function mount()
    {
        $user = Auth::user();

        $this->fill([
            'name'    => $user->name,
            'email'   => $user->email,
            'phone'   => $user->phone,
            'city'    => $user->city,
            'state'   => $user->state,
            'country' => $user->country,
            'address' => $user->address,
        ]);
    }

    public function updateProfile()
    {
        $this->validate([
            'name'    => 'required|min:3',
            'email'   => 'required|email|unique:users,email,' . Auth::id(),
            'phone'   => 'nullable|min:8',
            'city'    => 'nullable|string',
            'state'   => 'nullable|string',
            'country' => 'nullable|string',
            'address' => 'nullable|string',
            'avatar'  => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();

        if ($this->avatar) {
            $path = $this->avatar->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->update([
            'name'    => $this->name,
            'email'   => $this->email,
            'phone'   => $this->phone,
            'city'    => $this->city,
            'state'   => $this->state,
            'country' => $this->country,
            'address' => $this->address,
        ]);

        $this->dispatch('notify',type: 'success',message: 'Profile updated successfully!');
    }

    public function updatedAvatar()
    {
        $this->validate([
            'avatar' => 'image|max:2048',
        ]);

        $user = Auth::user();

        if ($user->avatar && \Storage::disk('public')->exists($user->avatar)) {
            \Storage::disk('public')->delete($user->avatar);
        }

        $path = $this->avatar->store('avatars', 'public');

        $user->update([
            'avatar' => $path,
        ]);

        $this->reset('avatar');

        $this->dispatch(
            'notify',
            type: 'success',
            message: 'Profile photo updated successfully!'
        );
    }


    public function updatePassword()
    {
        $this->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        Auth::user()->update([
            'password' => Hash::make($this->password),
        ]);

        $this->reset(['password', 'password_confirmation']);

        $this->dispatch('notify',type: 'success',message: 'Password updated successfully!');
    }

    public function render()
    {
        return view('livewire.profile');
    }
}
