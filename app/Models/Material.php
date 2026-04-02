<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable([
    'name',
    'price',
    'active',
    'order',
])]
class Material extends Model
{
    /** @use HasFactory<\Database\Factories\MaterialFactory> */
    use HasFactory;

    protected $casts = [
        'price' => 'double',
        'active' => 'boolean',
    ];

    public function systems(): BelongsToMany
    {
        return $this->belongsToMany(System::class)
            ->withTimestamps();
    }
}
