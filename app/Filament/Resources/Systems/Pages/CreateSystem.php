<?php

namespace App\Filament\Resources\Systems\Pages;

use App\Filament\Resources\Systems\SystemResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Cache;

class CreateSystem extends CreateRecord
{
    protected static string $resource = SystemResource::class;

    protected function afterCreate(): void
    {
        Cache::forget('active_systems_v2');
    }
}
