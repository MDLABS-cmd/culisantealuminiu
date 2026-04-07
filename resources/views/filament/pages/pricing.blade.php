<x-filament-panels::page>
    @include('filament.pages.pricing.partials.selectors')

    @include('filament.pages.pricing.partials.adjustment-card')
    <x-ui.loading-indicator target="selectedSystem,selectedSchema" />

    @if (!empty($rows))
        @include('filament.pages.pricing.partials.pricing-table', [
            'rows' => $rows,
        ])
    @endif
</x-filament-panels::page>
