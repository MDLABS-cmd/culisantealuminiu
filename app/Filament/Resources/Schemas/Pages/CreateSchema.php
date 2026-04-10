<?php

namespace App\Filament\Resources\Schemas\Pages;

use App\Filament\Resources\Schemas\SchemaResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Http\UploadedFile;

class CreateSchema extends CreateRecord
{
    protected static string $resource = SchemaResource::class;

    protected ?UploadedFile $imageUpload = null;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->imageUpload = $data['image'] ?? null;
        unset($data['image']);

        return $data;
    }

    protected function afterCreate(): void
    {
        if ($this->imageUpload instanceof UploadedFile) {
            $this->record->addFile($this->imageUpload, 'image', 'public');
        }
    }
}
