<?php

namespace App\Models;

use App\Enums\HandleTypeEnum;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'type',
    'price',
    'active',
])]
class Handle extends Model
{
    protected $casts = [
        'active' => 'boolean',
        'price' => 'decimal:2',
        'type' => HandleTypeEnum::class,
    ];

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
