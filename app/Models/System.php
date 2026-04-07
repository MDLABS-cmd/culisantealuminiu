<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['name', 'is_custom', 'active', 'order'])]
class System extends Model
{
    /** @use HasFactory<\Database\Factories\SystemFactory> */
    use HasFactory;

    protected $casts = [
        'active' => 'boolean',
        'is_custom' => 'boolean',
    ];

    public function colorCategories(): BelongsToMany
    {
        return $this->belongsToMany(ColorCategory::class)
            ->withTimestamps();
    }
}
