<?php

namespace App\Models;

use App\Enums\FileTypeEnum;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

#[Fillable(['name', 'path', 'mime_type', 'size', 'type', 'disk', 'collection'])]
class File extends Model
{
    protected $casts = [
        'type' => FileTypeEnum::class,
        'size' => 'integer',
    ];

    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getUrl(): string
    {
        return Storage::disk($this->disk)->url($this->path);
    }

    public function isImage(): bool
    {
        return $this->type === FileTypeEnum::IMAGE;
    }
}
