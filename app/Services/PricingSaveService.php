<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class PricingSaveService
{
    public function __construct(
        protected DimensionPricingService $dimensionPricingService,
    ) {}

    /**
     * Save pricing data for all dimensions within a transaction.
     */
    public function savePricingRows(array $rows): void
    {
        DB::transaction(function () use ($rows) {
            $this->dimensionPricingService->upsertMany($rows);
        });
    }
}
