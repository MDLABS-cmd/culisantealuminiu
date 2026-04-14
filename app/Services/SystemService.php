<?php

namespace App\Services;

use App\Models\System;
use Illuminate\Database\Eloquent\Collection;

class SystemService
{
    /**
     * Get all active systems.
     * @return Collection<int, System>
     */
    public function getActiveSystems(): Collection
    {
        return System::active()
            ->orderBy('order')
            ->get();
    }

    /**
     * Get all active systems as plain arrays for frontend/shared props.
     *
     * @return array<int, array{id:int, name:string}>
     */
    public function getActiveSystemsArray(): array
    {
        return $this->getActiveSystems()
            ->map(fn(System $system) => [
                'id' => $system->id,
                'name' => $system->name,
            ])
            ->values()
            ->all();
    }

    /**
     * Get all active systems as key-value pairs.
     */
    public function getSystemsForPricing(): array
    {
        return System::active()
            ->orderBy('order')
            ->pluck('name', 'id')
            ->toArray();
    }
}
