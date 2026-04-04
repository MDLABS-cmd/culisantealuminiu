<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('pricing.global_adjustment', 0.0);
        $this->migrator->add('pricing.hourly_rate', 0.0);
    }
};
