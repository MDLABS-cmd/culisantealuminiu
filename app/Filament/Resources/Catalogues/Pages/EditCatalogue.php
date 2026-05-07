<?php

namespace App\Filament\Resources\Catalogues\Pages;

use App\Filament\Resources\Catalogues\CatalogueResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class EditCatalogue extends EditRecord
{
    protected static string $resource = CatalogueResource::class;

    protected ?UploadedFile $fileUpload = null;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $file = $this->record->getFirstFile('catalogue');
        if ($file) {
            $data['file'] = $file->path;
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->fileUpload = $data['file'] ?? null;
        unset($data['file']);

        return $data;
    }

    protected function afterSave(): void
    {
        if (! $this->fileUpload instanceof UploadedFile) {
            return;
        }

        $existingFiles = $this->record->getFiles('catalogue');

        foreach ($existingFiles as $file) {
            Storage::disk($file->disk)->delete($file->path);
            $file->delete();
        }

        $this->record->addFile($this->fileUpload, 'catalogue', 'public');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
