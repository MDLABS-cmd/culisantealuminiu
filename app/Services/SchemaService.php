<?php

namespace App\Services;

use App\Enums\SchemaPriceTypeEnum;
use App\Models\Schema;

class SchemaService
{
    /**
     * Get schemas for a system as key-value pairs.
     */
    public function getForSystem(?int $systemId): array
    {
        if (!$systemId) {
            return [];
        }

        return Schema::query()
            ->where('system_id', $systemId)
            ->active()
            ->status(SchemaPriceTypeEnum::STANDARD)
            ->orderBy('order')
            ->pluck('name', 'id')
            ->toArray();
    }

    public function getForSystemWithMaterial(?int $schemaId)
    {
        if (!$schemaId) {
            return null;
        }

        return Schema::query()->with(['material' => function ($q) {
            $q->where('active', true);
        }])
            ->whereKey($schemaId)
            ->active()
            ->status(SchemaPriceTypeEnum::STANDARD)
            ->orderBy('order')
            ->first();
    }
}
