<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable([
    'name',
    'price',
    'active',
])]
class Accesory extends Model
{
    protected $casts = [
        'active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function schemas(): BelongsToMany
    {
        return $this->belongsToMany(Schema::class)
            ->withTimestamps();
    }
}
