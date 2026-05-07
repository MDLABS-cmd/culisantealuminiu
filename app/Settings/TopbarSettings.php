<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class TopbarSettings extends Settings
{
    public string $phone_number = '';
    public string $email = '';

    public static function group(): string
    {
        return 'topbar';
    }
}