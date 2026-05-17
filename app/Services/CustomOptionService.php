<?php

namespace App\Services;

use App\Models\CustomOption;

class CustomOptionService
{
    public function getActiveCustomOptions(): array
    {
        return CustomOption::query()
            ->active()
            ->get()
            ->toArray();
    }
}