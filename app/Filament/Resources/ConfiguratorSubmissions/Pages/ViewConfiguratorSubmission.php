<?php

namespace App\Filament\Resources\ConfiguratorSubmissions\Pages;

use App\Filament\Resources\ConfiguratorSubmissions\ConfiguratorSubmissionResource;
use Filament\Resources\Pages\ViewRecord;

class ViewConfiguratorSubmission extends ViewRecord
{
    protected static string $resource = ConfiguratorSubmissionResource::class;

    protected string $view = 'filament.resources.configurator-submissions.pages.view-configurator-submission';

    public function mount(int|string $record): void
    {
        parent::mount($record);

        $this->record->load([
            'customer',
            'system',
            'schema',
            'dimension',
            'handle',
            'color',
            'accessories.accesory',
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
