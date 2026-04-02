<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['schema_id', 'width', 'height', 'active'])]
class Dimension extends Model
{
    /** @use HasFactory<\Database\Factories\DimensionFactory> */
    use HasFactory;

    protected $casts = [
        'active' => 'boolean',
    ];

    public function schema(): BelongsTo
    {
        return $this->belongsTo(Schema::class);
    }
}
