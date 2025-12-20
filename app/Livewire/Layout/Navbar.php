<?php

namespace App\Livewire\Layout;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class Navbar extends Component
{
    public function confirmLogout()
    {
        $this->dispatch('confirm-logout');
    }

    #[On('logout')]
    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        $this->dispatch('notify',
            type: 'success',
            message: 'Logged out successfully!'
        );

        return $this->redirect('/login', navigate: true);
    }

    public function render()
    {
        return view('livewire.layout.navbar');
    }
}
