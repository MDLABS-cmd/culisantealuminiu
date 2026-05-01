<?php

namespace App\Filament\Resources\ConfiguratorSubmissions\Pages;

use App\Enums\ConfiguratorSubmissionTypeEnum;
use App\Filament\Resources\ConfiguratorSubmissions\ConfiguratorSubmissionResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListConfiguratorSubmissions extends ListRecords
{
    protected static string $resource = ConfiguratorSubmissionResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('Toate'),
            ConfiguratorSubmissionTypeEnum::OFFER->value => Tab::make('Oferte')->query(fn($query) => $query->ofType(ConfiguratorSubmissionTypeEnum::OFFER)),
            ConfiguratorSubmissionTypeEnum::ORDER->value => Tab::make('Comenzi')->query(fn($query) => $query->ofType(ConfiguratorSubmissionTypeEnum::ORDER)),
        ];
    }
}
