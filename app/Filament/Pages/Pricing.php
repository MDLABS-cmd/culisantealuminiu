<?php

namespace App\Filament\Pages;

use App\Models\Dimension;
use App\Models\DimensionPricing;
use App\Models\Schema;
use App\Models\System;
use App\Settings\PricingSettings;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class Pricing extends Page
{
    protected string $view = 'filament.pages.pricing';

    public ?int $selectedSystem = null;
    public ?int $selectedSchema = null;

    public float $global_adjustment = 0.0;
    public float $hourly_rate = 0.0;

    public array $materials = [];
    public array $rows = [];

    public function mount(PricingSettings $settings): void
    {
        $this->global_adjustment = $settings->global_adjustment;
        $this->hourly_rate = $settings->hourly_rate;
    }

    public function getSystems(): array
    {
        return System::where('active', true)->orderBy('order')->pluck('name', 'id')->toArray();
    }

    public function getSchemas(): array
    {
        if (! $this->selectedSystem) {
            return [];
        }

        return Schema::where('system_id', $this->selectedSystem)
            ->where('active', true)
            ->orderBy('order')
            ->pluck('name', 'id')
            ->toArray();
    }

    public function updatedSelectedSystem(): void
    {
        $this->selectedSchema = null;
        $this->materials = [];
        $this->rows = [];
    }

    public function updatedSelectedSchema(): void
    {
        $this->loadTable();
    }

    public function updatedHourlyRate(): void
    {
        $this->recalculateAll();
    }

    public function updatedGlobalAdjustment(): void
    {
        $this->recalculateAll();
    }

    public function updated(string $name): void
    {
        if (preg_match('/^rows\.(\d+)\.working_hours$/', $name, $matches)) {
            $this->recalculateRow((int) $matches[1]);
        }
    }

    protected function loadTable(): void
    {
        if (! $this->selectedSystem || ! $this->selectedSchema) {
            $this->materials = [];
            $this->rows = [];

            return;
        }

        $system = System::with([
            'materials' => fn ($q) => $q->where('active', true)->orderBy('order'),
        ])->find($this->selectedSystem);

        $this->materials = $system->materials
            ->map(fn ($m) => ['id' => $m->id, 'name' => $m->name, 'price' => $m->price])
            ->values()
            ->toArray();

        $dimensions = Dimension::with('pricing')
            ->where('schema_id', $this->selectedSchema)
            ->where('active', true)
            ->orderBy('id')
            ->get();

        $this->rows = [];

        foreach ($dimensions as $dim) {
            $materialPrices = [];

            foreach ($this->materials as $material) {
                // price per m² × area in m²
                $materialPrices[$material['id']] = round(
                    $material['price'] * ($dim->width / 1000) * ($dim->height / 1000),
                    2
                );
            }

            $saved = $dim->pricing;

            $this->rows[$dim->id] = [
                'dimension_id' => $dim->id,
                'width' => $dim->width,
                'height' => $dim->height,
                'working_hours' => $saved?->working_hours ?? 0,
                'working_cost' => $saved?->working_cost ?? 0,
                'price_without_vat' => $saved?->price_without_vat ?? round(array_sum($materialPrices), 2),
                'adaos' => $saved?->adaos ?? round($this->global_adjustment, 2),
                'material_prices' => $materialPrices,
            ];
        }
    }

    protected function recalculateRow(int $dimId): void
    {
        if (! isset($this->rows[$dimId])) {
            return;
        }

        $workingHours = (float) $this->rows[$dimId]['working_hours'];
        $workingCost = round($workingHours * $this->hourly_rate, 2);
        $materialTotal = array_sum($this->rows[$dimId]['material_prices']);

        $this->rows[$dimId]['working_cost'] = $workingCost;
        $this->rows[$dimId]['price_without_vat'] = round($materialTotal + $workingCost, 2);
        $this->rows[$dimId]['adaos'] = round($workingCost + $this->global_adjustment, 2);
    }

    protected function recalculateAll(): void
    {
        foreach (array_keys($this->rows) as $dimId) {
            $this->recalculateRow($dimId);
        }
    }

    public function savePricing(): void
    {
        foreach ($this->rows as $dimId => $row) {
            DimensionPricing::updateOrCreate(
                ['dimension_id' => $dimId],
                [
                    'working_hours' => $row['working_hours'],
                    'working_cost' => $row['working_cost'],
                    'price_without_vat' => $row['price_without_vat'],
                    'adaos' => $row['adaos'],
                ]
            );
        }

        Notification::make()
            ->title('Pricing saved')
            ->success()
            ->send();
    }

    public function save(PricingSettings $settings): void
    {
        $settings->global_adjustment = $this->global_adjustment;
        $settings->hourly_rate = $this->hourly_rate;
        $settings->save();

        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();
    }
}
