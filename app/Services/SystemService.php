<?php

namespace App\Services;

use App\Models\System;

class SystemService
{
    /**
     * Get all active systems as key-value pairs.
     */
    public function getActive(): array
    {
        return System::where('active', true)
            ->orderBy('order')
            ->pluck('name', 'id')
            ->toArray();
    }
}
