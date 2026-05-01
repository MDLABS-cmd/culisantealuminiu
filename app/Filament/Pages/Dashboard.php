<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\SubmissionsStatsWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected function getHeaderActions(): array
    {
        return [];
    }

    public function getWidgets(): array
    {
        return [
            SubmissionsStatsWidget::class,
        ];
    }
}
