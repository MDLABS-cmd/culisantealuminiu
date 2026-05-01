<?php

namespace App\Filament\Widgets;

use App\Enums\ConfiguratorSubmissionTypeEnum;
use App\Models\Customer;
use App\Services\ConfiguratorSubmissionService;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SubmissionsStatsWidget extends StatsOverviewWidget
{
    protected static bool $isLazy = true;

    protected function getStats(): array
    {
        $stats = app(ConfiguratorSubmissionService::class)->getMonthlyStats();

        $orders = $stats->get(ConfiguratorSubmissionTypeEnum::ORDER->value);
        $offers  = $stats->get(ConfiguratorSubmissionTypeEnum::OFFER->value);

        $ordersThisMonth  = (int)   ($orders?->this_month_count    ?? 0);
        $ordersLastMonth  = (int)   ($orders?->last_month_count    ?? 0);
        $offersThisMonth  = (int)   ($offers?->this_month_count    ?? 0);
        $offersLastMonth  = (int)   ($offers?->last_month_count    ?? 0);
        $revenueThisMonth = (float) ($orders?->this_month_revenue  ?? 0);
        $revenueLastMonth = (float) ($orders?->last_month_revenue  ?? 0);

        $totalCustomers = Customer::count();

        $revenueTrend = $revenueThisMonth >= $revenueLastMonth ? 'success' : 'danger';
        $revenueTrendIcon = $revenueThisMonth >= $revenueLastMonth
            ? Heroicon::ArrowTrendingUp
            : Heroicon::ArrowTrendingDown;

        $ordersTrend = $ordersThisMonth >= $ordersLastMonth ? 'success' : 'danger';
        $ordersTrendIcon = $ordersThisMonth >= $ordersLastMonth
            ? Heroicon::ArrowTrendingUp
            : Heroicon::ArrowTrendingDown;

        $offersTrend = $offersThisMonth >= $offersLastMonth ? 'success' : 'danger';
        $offersTrendIcon = $offersThisMonth >= $offersLastMonth
            ? Heroicon::ArrowTrendingUp
            : Heroicon::ArrowTrendingDown;

        return [
            Stat::make('Comenzi luna aceasta', $ordersThisMonth)
                ->description($ordersLastMonth . ' luna trecuta')
                ->descriptionIcon($ordersTrendIcon)
                ->descriptionColor($ordersTrend)
                ->icon(Heroicon::OutlinedShoppingCart)
                ->color('primary'),

            Stat::make('Oferte luna aceasta', $offersThisMonth)
                ->description($offersLastMonth . ' luna trecuta')
                ->descriptionIcon($offersTrendIcon)
                ->descriptionColor($offersTrend)
                ->icon(Heroicon::OutlinedDocumentText)
                ->color('warning'),

            Stat::make('Venituri luna aceasta', 'RON ' . number_format($revenueThisMonth, 2, ',', '.'))
                ->description('RON ' . number_format($revenueLastMonth, 2, ',', '.') . ' luna trecuta')
                ->descriptionIcon($revenueTrendIcon)
                ->descriptionColor($revenueTrend)
                ->icon(Heroicon::OutlinedBanknotes)
                ->color($revenueTrend),

            Stat::make('Total clienți', $totalCustomers)
                ->description('Clienți înregistrați')
                ->icon(Heroicon::OutlinedUsers)
                ->color('info'),
        ];
    }
}
