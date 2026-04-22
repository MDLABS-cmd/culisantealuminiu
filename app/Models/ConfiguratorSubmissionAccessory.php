<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'submission_id',
    'accesory_id',
    'qty',
])]
class ConfiguratorSubmissionAccessory extends Model
{
    public function submission(): BelongsTo
    {
        return $this->belongsTo(ConfiguratorSubmission::class, 'submission_id');
    }

    public function accesory(): BelongsTo
    {
        return $this->belongsTo(Accesory::class);
    }
}
