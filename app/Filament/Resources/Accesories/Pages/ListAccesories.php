<?php

namespace App\Filament\Resources\Accesories\Pages;

use App\Filament\Resources\Accesories\AccesoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAccesories extends ListRecords
{
    protected static string $resource = AccesoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
