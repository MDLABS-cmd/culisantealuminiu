<?php

namespace App\Filament\Resources\Catalogues\Pages;

use App\Filament\Resources\Catalogues\CatalogueResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Http\UploadedFile;

class CreateCatalogue extends CreateRecord
{
    protected static string $resource = CatalogueResource::class;

    protected ?UploadedFile $fileUpload = null;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->fileUpload = $data['file'] ?? null;
        unset($data['file']);

        return $data;
    }

    protected function afterCreate(): void
    {
        if ($this->fileUpload instanceof UploadedFile) {
            $this->record->addFile($this->fileUpload, 'catalogue', 'public');
        }
    }
}
