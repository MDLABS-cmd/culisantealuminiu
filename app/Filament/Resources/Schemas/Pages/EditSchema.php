<?php

namespace App\Filament\Resources\Schemas\Pages;

use App\Filament\Resources\Schemas\SchemaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class EditSchema extends EditRecord
{
    protected static string $resource = SchemaResource::class;

    protected ?UploadedFile $imageUpload = null;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $file = $this->record->getFirstFile('image');
        if ($file) {
            $data['image'] = $file->path;
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->imageUpload = $data['image'] ?? null;
        unset($data['image']);

        return $data;
    }

    protected function afterSave(): void
    {
        if (! $this->imageUpload instanceof UploadedFile) {
            return;
        }

        $existingImages = $this->record->getFiles('image');

        foreach ($existingImages as $file) {
            Storage::disk($file->disk)->delete($file->path);
            $file->delete();
        }

        $this->record->addFile($this->imageUpload, 'image', 'public');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
