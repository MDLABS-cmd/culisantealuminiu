<?php

namespace App\Models;

use App\Enums\ConfiguratorSubmissionTypeEnum;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'type',
    'status',
    'customer_id',
    'observations',
    'system_id',
    'schema_id',
    'dimension_id',
    'handle_id',
    'color_id',
    'base_price',
    'handle_price',
    'accessories_total',
    'total_price',
    'submitted_at',
])]
class ConfiguratorSubmission extends Model
{
    protected function casts(): array
    {
        return [
            'type' => ConfiguratorSubmissionTypeEnum::class,
            'submitted_at' => 'datetime',
            'base_price' => 'decimal:2',
            'handle_price' => 'decimal:2',
            'accessories_total' => 'decimal:2',
            'total_price' => 'decimal:2',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function system(): BelongsTo
    {
        return $this->belongsTo(System::class);
    }

    public function schema(): BelongsTo
    {
        return $this->belongsTo(Schema::class);
    }

    public function dimension(): BelongsTo
    {
        return $this->belongsTo(Dimension::class);
    }

    public function handle(): BelongsTo
    {
        return $this->belongsTo(Handle::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    public function accessories(): HasMany
    {
        return $this->hasMany(ConfiguratorSubmissionAccessory::class, 'submission_id');
    }

    public function scopeOfType($query, ConfiguratorSubmissionTypeEnum $type)
    {
        return $query->where('type', $type);
    }
}
