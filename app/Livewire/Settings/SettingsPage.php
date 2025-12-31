<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\Setting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('livewire.layout.app')]
#[Title('Setting')]
class SettingsPage extends Component
{
    /* ===== Global ===== */
    public $app_name;
    public $admin_email;
    public $timezone;
    public $currency;

    /* ===== SMTP ===== */
    public $mail_host;
    public $mail_port;
    public $mail_username;
    public $mail_password;
    public $mail_encryption;

    /* ===== Security ===== */
    public $session_timeout;
    public $password_min_length;

    public function mount()
    {
        $this->app_name = Setting::get('app_name', config('app.name'));
        $this->admin_email = Setting::get('admin_email');
        $this->timezone = Setting::get('timezone', config('app.timezone'));
        $this->currency = Setting::get('currency', 'INR');

        $this->mail_host = Setting::get('mail_host');
        $this->mail_port = Setting::get('mail_port');
        $this->mail_username = Setting::get('mail_username');
        $this->mail_password = Setting::get('mail_password');
        $this->mail_encryption = Setting::get('mail_encryption');

        $this->session_timeout = Setting::get('session_timeout', 120);
        $this->password_min_length = Setting::get('password_min_length', 8);
    }

    /* ===== Save Global ===== */
    public function saveGlobal()
    {
        Setting::set('app_name', $this->app_name);
        Setting::set('admin_email', $this->admin_email);
        Setting::set('timezone', $this->timezone);
        Setting::set('currency', $this->currency);

        $this->dispatch('notify', 'Global settings saved');
    }

    /* ===== Save SMTP ===== */
    public function saveMail()
    {
        Setting::set('mail_host', $this->mail_host);
        Setting::set('mail_port', $this->mail_port);
        Setting::set('mail_username', $this->mail_username);
        Setting::set('mail_password', $this->mail_password);
        Setting::set('mail_encryption', $this->mail_encryption);

        app()->forgetInstance('mailer');
        
        $this->dispatch('notify', 'Mail settings saved');
    }

    /* ===== Test Email ===== */
    public function testMail()
    {
        Mail::raw('Test mail from admin panel', function ($msg) {
            $msg->to($this->admin_email)
                ->subject('SMTP Test Mail');
        });

        $this->dispatch('notify', 'Test email sent');
    }

    /* ===== Save Security ===== */
    public function saveSecurity()
    {
        Setting::set('session_timeout', $this->session_timeout);
        Setting::set('password_min_length', $this->password_min_length);

        $this->dispatch('notify', 'Security settings saved');
    }

    public function render()
    {
        return view('livewire.settings.settings-page');
    }
}

