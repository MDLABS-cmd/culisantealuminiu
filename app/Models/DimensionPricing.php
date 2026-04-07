<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['dimension_id', 'material_id', 'material_cost', 'working_hours', 'working_cost', 'price_without_vat', 'additional_cost'])]
class DimensionPricing extends Model
{
    protected $casts = [
        'material_cost' => 'float',
        'working_hours' => 'float',
        'working_cost' => 'float',
        'price_without_vat' => 'float',
        'additional_cost' => 'float',
    ];

    public function dimension(): BelongsTo
    {
        return $this->belongsTo(Dimension::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
}
