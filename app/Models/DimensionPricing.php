<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['dimension_id', 'working_hours', 'working_cost', 'price_without_vat', 'adaos'])]
class DimensionPricing extends Model
{
    protected $casts = [
        'working_hours' => 'float',
        'working_cost' => 'float',
        'price_without_vat' => 'float',
        'adaos' => 'float',
    ];

    public function dimension(): BelongsTo
    {
        return $this->belongsTo(Dimension::class);
    }
}
