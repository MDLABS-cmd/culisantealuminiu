<?php

namespace App\Filament\Resources\Catalogues\Pages;

use App\Filament\Resources\Catalogues\CatalogueResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCatalogues extends ListRecords
{
    protected static string $resource = CatalogueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
