<?php

namespace App\Filament\Resources\Accesories\Pages;

use App\Filament\Resources\Accesories\AccesoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAccesory extends EditRecord
{
    protected static string $resource = AccesoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
