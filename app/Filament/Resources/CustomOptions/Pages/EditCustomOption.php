<?php

namespace App\Filament\Resources\CustomOptions\Pages;

use App\Filament\Resources\CustomOptions\CustomOptionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCustomOption extends EditRecord
{
    protected static string $resource = CustomOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
