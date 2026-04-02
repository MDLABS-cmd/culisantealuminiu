<?php

namespace App\Concerns;

use App\Enums\FileTypeEnum;
use App\Models\File;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait HasFiles
{
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function addFile(
        UploadedFile $file,
        string $collection = 'default',
        string $disk = 'local',
    ): File {
        $directory = Str::kebab(class_basename($this));
        $path = $file->store($directory, $disk);
        $mime = $file->getMimeType() ?? 'application/octet-stream';

        return $this->files()->create([
            'name'       => $file->getClientOriginalName(),
            'path'       => $path,
            'disk'       => $disk,
            'mime_type'  => $mime,
            'size'       => $file->getSize(),
            'type'       => FileTypeEnum::fromMimeType($mime)->value,
            'collection' => $collection,
        ]);
    }

    public function getFiles(string $collection = 'default'): Collection
    {
        return $this->files()->where('collection', $collection)->get();
    }

    public function getFirstFile(string $collection = 'default'): ?File
    {
        return $this->files()->where('collection', $collection)->first();
    }

    public function getFirstFileUrl(string $collection = 'default'): ?string
    {
        return $this->getFirstFile($collection)?->getUrl();
    }
}
