<?php

namespace App\Filament\Pages;

use App\Services\PricingCalculationService;
use App\Services\PricingSaveService;
use App\Services\PricingTableService;
use App\Settings\PricingSettings;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use App\Models\Material;

class Pricing extends Page
{
    protected string $view = 'filament.pages.pricing';

    public ?int $selectedSystem = null;
    public ?int $selectedSchema = null;

    public float $global_adjustment = 0.0;
    public float $hourly_rate = 0.0;

    public ?Material $material = null;
    public array $rows = [];

    public function mount(PricingSettings $settings): void
    {
        $this->global_adjustment = $settings->global_adjustment;
        $this->hourly_rate = $settings->hourly_rate;
    }

    public function getSystems(): array
    {
        return app(PricingTableService::class)->getSystems();
    }

    public function getSchemas(): array
    {
        return app(PricingTableService::class)->getSchemas($this->selectedSystem);
    }

    public function updatedSelectedSystem(): void
    {
        $this->selectedSchema = null;
        $this->material = null;
        $this->rows = [];
    }

    public function updatedSelectedSchema(): void
    {
        $tableService = app(PricingTableService::class);
        ['material' => $this->material, 'rows' => $this->rows] = $tableService->loadTable(
            $this->selectedSystem,
            $this->selectedSchema
        );
    }

    public function updatedHourlyRate(): void
    {
        app(PricingCalculationService::class)->recalculateAll(
            $this->rows,
            $this->hourly_rate,
            $this->global_adjustment
        );
    }

    public function updatedGlobalAdjustment(): void
    {
        app(PricingCalculationService::class)->recalculateAll(
            $this->rows,
            $this->hourly_rate,
            $this->global_adjustment
        );
    }

    public function updated(string $name): void
    {
        if (preg_match('/^rows\.(\d+)\.working_hours$/', $name, $matches)) {
            $dimId = (int) $matches[1];
            app(PricingCalculationService::class)->recalculateRow(
                $this->rows[$dimId],
                $this->hourly_rate,
                $this->global_adjustment
            );
        }

        if (preg_match('/^rows\.(\d+)\.material_cost$/', $name, $matches)) {
            $dimId = (int) $matches[1];
            app(PricingCalculationService::class)->recalculateRow(
                $this->rows[$dimId],
                $this->hourly_rate,
                $this->global_adjustment
            );
        }
    }

    public function savePricing(): void
    {
        app(PricingSaveService::class)->savePricingRows($this->rows);

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
