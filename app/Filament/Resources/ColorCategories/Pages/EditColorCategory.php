<?php

namespace App\Filament\Resources\ColorCategories\Pages;

use App\Filament\Resources\ColorCategories\ColorCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditColorCategory extends EditRecord
{
    protected static string $resource = ColorCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
