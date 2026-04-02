<?php

namespace App\Filament\Resources\ColorCategories\Pages;

use App\Filament\Resources\ColorCategories\ColorCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListColorCategories extends ListRecords
{
    protected static string $resource = ColorCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
