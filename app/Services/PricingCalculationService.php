<?php

namespace App\Services;

class PricingCalculationService
{
    /**
     * Calculate working cost and update pricing row.
     */
    public function recalculateRow(array &$row, float $hourlyRate, float $globalAdjustment): void
    {
        $materialCost = (float) ($row['material_cost'] ?? 0);
        $workingHours = (float) ($row['working_hours'] ?? 0);
        $workingCost = round($workingHours * $hourlyRate, 2);

        $row['working_cost'] = $workingCost;
        $additionalCost = round($globalAdjustment * $materialCost, 2);
        $row['additional_cost'] = round($additionalCost, 2);
        $totalWithoutVat = round($additionalCost + $workingCost, 2);
        $row['price_without_vat'] = round($totalWithoutVat, 2);
    }

    /**
     * Recalculate all rows.
     */
    public function recalculateAll(array &$rows, float $hourlyRate, float $globalAdjustment): void
    {
        foreach (array_keys($rows) as $dimId) {
            $this->recalculateRow($rows[$dimId], $hourlyRate, $globalAdjustment);
        }
    }
}
