<?php

namespace App\Models;

use App\Concerns\HasFiles;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'description'])]
class Catalogue extends Model
{
    use HasFiles;

    protected $appends = [
        'file_url',
    ];

    public function getFileUrlAttribute(): ?string
    {
        return $this->getFirstFileUrl('catalogue');
    }
}
