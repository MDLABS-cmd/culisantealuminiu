<?php

namespace App\Filament\Resources\Handles\Pages;

use App\Filament\Resources\Handles\HandleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHandles extends ListRecords
{
    protected static string $resource = HandleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
