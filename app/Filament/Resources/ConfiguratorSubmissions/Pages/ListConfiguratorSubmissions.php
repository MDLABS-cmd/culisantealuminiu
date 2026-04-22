<?php

namespace App\Filament\Resources\ConfiguratorSubmissions\Pages;

use App\Filament\Resources\ConfiguratorSubmissions\ConfiguratorSubmissionResource;
use Filament\Resources\Pages\ListRecords;

class ListConfiguratorSubmissions extends ListRecords
{
    protected static string $resource = ConfiguratorSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
