<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;
use App\Livewire\Dashboard;
use App\Livewire\Permissions;
use App\Livewire\Profile;
use App\Livewire\Roles;
use App\Livewire\Users\UserIndex;
use App\Livewire\Users\UserForm;
use App\Http\Controllers\GmailController;
use App\Livewire\Auth\Register;
use App\Livewire\GmailInbox;
use App\Livewire\Mail\Emailsetup;

Route::middleware('guest')->group(function () {
    Route::get('/', Login::class);
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/profile', Profile::class)->name('profile');
    
    Route::get('/permissions', Permissions::class)->name('permissions');
    Route::get('/roles', Roles::class)->name('roles');
    Route::get('/users', UserIndex::class)->name('users.index');
    Route::get('/users/create', UserForm::class)->name('users.create');
    Route::get('/users/{user}/edit', UserForm::class)->name('users.edit');
    Route::get('/mails', GmailInbox::class)->name('emails');
    Route::get('/email-setup', Emailsetup::class)->name('email-setup');


    Route::get('/gmail/connect', [GmailController::class, 'connect'])->name('gmail.connect');
    Route::get('/google/callback', [GmailController::class, 'callback'])->name('gmail.callback');

    Route::get('/test-helper', function () {
        return parseEmailTemplate(
            'Hello {{ name }}',
            ['name' => 'Darshan']
        );
    });

});