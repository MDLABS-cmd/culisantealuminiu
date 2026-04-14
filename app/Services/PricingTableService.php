<?php

namespace App\Services;

use App\Models\Dimension;
use App\Models\Schema;

class PricingTableService
{
    public function __construct(
        protected SystemService $systemService,
        protected SchemaService $schemaService,
    ) {}

    /**
     * Get systems as key-value pairs.
     */
    public function getSystems(): array
    {
        return $this->systemService->getSystemsForPricing();
    }

    /**
     * Get schemas for a system.
     */
    public function getSchemas(?int $systemId): array
    {
        return $this->schemaService->getForSystem($systemId);
    }

    public function getSchemaWithMaterial(?int $schemaId): Schema|null
    {
        return $this->schemaService->getForSystemWithMaterial($schemaId);
    }

    /**
     * Load pricing table with materials and dimensions.
     */
    public function loadTable(?int $systemId, ?int $schemaId): array
    {
        $material = null;
        $rows = [];

        if (!$systemId || !$schemaId) {
            return compact('material', 'rows');
        }

        // Load materials
        $schemaWithMaterial = $this->getSchemaWithMaterial($systemId);
        if (!$schemaWithMaterial) {
            return compact('material', 'rows');
        }

        $material = $schemaWithMaterial->material;

        // Load dimensions and calculate material prices
        $dimensions = Dimension::with('pricing')
            ->where('schema_id', $schemaId)
            ->where('active', true)
            ->orderBy('id')
            ->get();

        foreach ($dimensions as $dim) {

            $dimensionPricing = $dim->pricing;

            $rows[$dim->id] = [
                'dimension_id' => $dim->id,
                'material_id' => $material?->id,
                'material_cost' => $dimensionPricing?->material_cost ?? 0,
                'width' => $dim->width,
                'height' => $dim->height,
                'working_hours' => $dimensionPricing?->working_hours ?? 0,
                'working_cost' => $dimensionPricing?->working_cost ?? 0,
                'price_without_vat' => $dimensionPricing?->price_without_vat ?? 0,
                'additional_cost' => $dimensionPricing?->additional_cost ?? round(0, 2), // Will be recalculated with global_adjustment
            ];
        }

        return compact('material', 'rows');
    }
}
