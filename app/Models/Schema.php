<?php

namespace App\Models;

use App\Concerns\HasFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Enums\SchemaPriceTypeEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['system_id', 'material_id', 'name', 'price_type', 'order', 'active'])]
class Schema extends Model
{
    /** @use HasFactory<\Database\Factories\SchemaFactory> */
    use HasFactory, HasFiles;

    protected $casts = [
        'price_type' => SchemaPriceTypeEnum::class,
        'active' => 'boolean',
    ];

    public function system(): BelongsTo
    {
        return $this->belongsTo(System::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function dimensions(): HasMany
    {
        return $this->hasMany(Dimension::class);
    }

    public function accesories(): BelongsToMany
    {
        return $this->belongsToMany(Accesory::class)
            ->withTimestamps();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeStatus($query, SchemaPriceTypeEnum|string $status)
    {
        $value = $status instanceof SchemaPriceTypeEnum ? $status->value : $status;

        return $query->where('price_type', $value);
    }
}
