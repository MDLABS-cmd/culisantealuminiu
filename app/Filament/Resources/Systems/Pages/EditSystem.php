<?php

namespace App\Filament\Resources\Systems\Pages;

use App\Filament\Resources\Systems\SystemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Cache;

class EditSystem extends EditRecord
{
    protected static string $resource = SystemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        Cache::forget('active_systems_v2');
    }
}
