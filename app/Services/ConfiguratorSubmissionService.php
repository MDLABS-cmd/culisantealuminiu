<?php

namespace App\Services;

use App\Models\ConfiguratorSubmission;
use Illuminate\Support\Facades\Auth;

class ConfiguratorSubmissionService
{
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
