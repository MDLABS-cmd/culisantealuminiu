<?php

namespace App\Filament\Resources\Handles\Pages;

use App\Filament\Resources\Handles\HandleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHandle extends EditRecord
{
    protected static string $resource = HandleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
