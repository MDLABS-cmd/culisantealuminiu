<?php

namespace App\Services;

use App\Enums\ConfiguratorSubmissionTypeEnum;
use App\Models\ConfiguratorSubmission;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ConfiguratorSubmissionService
{
    public function getMonthlyStats(): Collection
    {
        $now = now();
        $lastMonth = now()->subMonth();

        return ConfiguratorSubmission::query()
            ->selectRaw(
                'type,
                SUM(CASE WHEN MONTH(created_at) = ? AND YEAR(created_at) = ? THEN 1 ELSE 0 END) as this_month_count,
                SUM(CASE WHEN MONTH(created_at) = ? AND YEAR(created_at) = ? THEN 1 ELSE 0 END) as last_month_count,
                SUM(CASE WHEN MONTH(created_at) = ? AND YEAR(created_at) = ? THEN COALESCE(total_price, 0) ELSE 0 END) as this_month_revenue,
                SUM(CASE WHEN MONTH(created_at) = ? AND YEAR(created_at) = ? THEN COALESCE(total_price, 0) ELSE 0 END) as last_month_revenue',
                [
                    $now->month,
                    $now->year,
                    $lastMonth->month,
                    $lastMonth->year,
                    $now->month,
                    $now->year,
                    $lastMonth->month,
                    $lastMonth->year,
                ]
            )
            ->where('created_at', '>=', $lastMonth->copy()->startOfMonth())
            ->groupBy('type')
            ->get()
            ->keyBy('type');
    }

    public function getUserConfiguratorSubmissions(): array
    {
        return ConfiguratorSubmission::query()
            ->whereHas('customer', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->with(['system', 'schema'])
            ->latest()
            ->get()
            ->toArray();
    }
}
