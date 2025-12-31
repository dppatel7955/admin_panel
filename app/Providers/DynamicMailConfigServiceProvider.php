<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class DynamicMailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Prevent errors during migration
        if (!Schema::hasTable('settings')) {
            return;
        }

        Config::set('mail.mailers.smtp.host',
            Setting::get('mail_host', config('mail.mailers.smtp.host'))
        );

        Config::set('mail.mailers.smtp.port',
            Setting::get('mail_port', config('mail.mailers.smtp.port'))
        );

        Config::set('mail.mailers.smtp.encryption',
            Setting::get('mail_encryption', config('mail.mailers.smtp.encryption'))
        );

        Config::set('mail.mailers.smtp.username',
            Setting::get('mail_username', config('mail.mailers.smtp.username'))
        );

        Config::set('mail.mailers.smtp.password',
            Setting::get('mail_password', config('mail.mailers.smtp.password'))
        );

        Config::set('mail.from.address',
            Setting::get('admin_email', config('mail.from.address'))
        );
    }
}
