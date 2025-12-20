<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    public function login()
    {
        $this->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Brute force protection
        if (RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            throw ValidationException::withMessages([
                'email' => 'Too many login attempts. Try again later.',
            ]);
        }

        if (! Auth::attempt([
            'email' => $this->email,
            'password' => $this->password
        ], $this->remember)) {

            RateLimiter::hit($this->throttleKey(), 60);

            throw ValidationException::withMessages([
                'email' => 'Invalid login credentials.',
            ]);
        }

        $user = Auth::user();

        if ($user->status !== 'active') {

            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();

            throw ValidationException::withMessages([
                'email' => 'Your account is inactive or blocked. Please contact admin.',
            ]);
        }
        RateLimiter::clear($this->throttleKey());

        session()->regenerate();

        $user->update([
            'last_login_at' => now(),
        ]);

        return $this->redirectRoute('dashboard', navigate: true);
    }

    protected function throttleKey()
    {
        return strtolower($this->email).'|'.request()->ip();
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
