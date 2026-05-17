<?php

namespace App\Filament\Resources\CustomOptions\Pages;

use App\Filament\Resources\CustomOptions\CustomOptionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCustomOptions extends ListRecords
{
    protected static string $resource = CustomOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
