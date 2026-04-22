<?php

namespace App\Services\ConfiguratorSubmission;

use App\Models\ConfiguratorSubmission;
use App\Models\ConfiguratorSubmissionAccessory;

class AttachSubmissionAccessoriesService
{
    /**
     * Attach selected accessories to the submission.
     *
     * @param  array<int, int>  $selectedAccessoryIds
     */
    public function attach(ConfiguratorSubmission $submission, array $selectedAccessoryIds): void
    {
        $rows = collect($selectedAccessoryIds)
            ->filter(fn(mixed $id) => is_numeric($id) && (int) $id > 0)
            ->unique()
            ->map(fn(mixed $id) => [
                'submission_id' => $submission->id,
                'accesory_id' => (int) $id,
                'qty' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ])
            ->values()
            ->all();

        if ($rows === []) {
            return;
        }

        ConfiguratorSubmissionAccessory::insert($rows);
    }
}
