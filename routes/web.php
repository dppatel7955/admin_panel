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
use App\Http\Controllers\GoogleCalendarController;
use App\Livewire\Auth\Register;
use App\Livewire\Brand\BrandForm;
use App\Livewire\Brand\BrandList;
use App\Livewire\Calendar;
use App\Livewire\Category\CategoryList;
use App\Livewire\Category\CategoryForm;
use App\Livewire\GmailInbox;
use App\Livewire\Mail\Emailsetup;
use App\Livewire\Product\ProductForm;
use App\Livewire\Product\ProductList;
use App\Livewire\Settings\SettingsPage;

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

    Route::get('/google/auth', [GoogleCalendarController::class, 'redirect']);
    Route::get('/calendar/google/callback', [GoogleCalendarController::class, 'callback'])->name('calender.callback');

    Route::get('/calendar', Calendar::class)->name('calender');
    Route::get('/settings', SettingsPage::class)->name('settings');

    Route::get('/products', ProductList::class)->name('products.index');
    Route::get('/products/create', ProductForm::class)->name('products.create');
    Route::get('/products/{id}/edit', ProductForm::class)->name('products.edit');

    Route::get('/brands', BrandList::class)->name('brands.index');
    Route::get('brands/create', BrandForm::class)->name('brands.create');
    Route::get('brands/{id}/edit', BrandForm::class)->name('brands.edit');

    Route::get('/categories', CategoryList::class)->name('categories.index');
    Route::get('categories/create', CategoryForm::class)->name('categories.create');
    Route::get('categories/{id}/edit', CategoryForm::class)->name('categories.edit');

    Route::get('/test-helper', function () {
        return parseEmailTemplate(
            'Hello {{ name }}',
            ['name' => 'Darshan']
        );
    });

});