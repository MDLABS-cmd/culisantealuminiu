<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'active', 'order'])]
class ColorCategory extends Model
{
    /** @use HasFactory<\Database\Factories\ColorCategoryFactory> */
    use HasFactory;

    protected $casts = [
        'active' => 'boolean',
    ];

    public function systems(): BelongsToMany
    {
        return $this->belongsToMany(System::class)
            ->withTimestamps();
    }

    public function colors(): HasMany
    {
        return $this->hasMany(Color::class, 'color_category_id');
    }
}
