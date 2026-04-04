<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class PricingSettings extends Settings
{

    public float $global_adjustment = 0.0;
    public float $hourly_rate = 0.0;

    public static function group(): string
    {
        return 'pricing';
    }
}
