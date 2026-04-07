<?php

namespace App\Services;

use App\Models\DimensionPricing;

class DimensionPricingService
{
    /**
     * Upsert multiple dimension pricing records in a single query.
     */
    public function upsertMany(array $rows): void
    {
        $values = [];

        foreach ($rows as $dimId => $row) {
            $values[] = [
                'dimension_id' => $dimId,
                'material_id' => $row['material_id'],
                'material_cost' => $row['material_cost'],
                'working_hours' => $row['working_hours'],
                'working_cost' => $row['working_cost'],
                'price_without_vat' => $row['price_without_vat'],
                'additional_cost' => $row['additional_cost'],
            ];
        }

        DimensionPricing::upsert(
            $values,
            ['dimension_id', 'material_id'], // Unique by dimension_id and material_id
            ['material_cost', 'working_hours', 'working_cost', 'price_without_vat', 'additional_cost']
        );
    }
}
