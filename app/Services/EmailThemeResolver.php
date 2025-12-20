<?php
namespace App\Services;

use App\Models\EmailSetting;

class EmailThemeResolver
{
    public static function resolve(string $emailType): string
    {
        return EmailSetting::where('email_type', $emailType)
            ->value('theme_key')
            ?? 'default';
    }
}
