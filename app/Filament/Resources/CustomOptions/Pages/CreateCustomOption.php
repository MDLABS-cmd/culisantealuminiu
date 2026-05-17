<?php

namespace App\Filament\Resources\CustomOptions\Pages;

use App\Filament\Resources\CustomOptions\CustomOptionResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Cache;

class CreateCustomOption extends CreateRecord
{
    protected static string $resource = CustomOptionResource::class;

    protected function afterCreate(): void
    {
        Cache::forget('active_custom_options');
    }
}
