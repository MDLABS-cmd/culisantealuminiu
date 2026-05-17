<?php

namespace App\Services\ConfiguratorSubmission;

use App\Enums\ConfiguratorSubmissionTypeEnum;
use App\Models\ConfiguratorSubmission;
use App\Models\Customer;

class CreateSubmissionRecordService
{
    /**
     * Create a configurator submission for a resolved customer.
     *
     * @param  array<string, mixed>  $submission
     */
    public function create(Customer $customer, array $submission, ?int $customOptionId = null): ConfiguratorSubmission
    {
        $isCustomConfiguration = (bool) ($submission['is_custom'] ?? false);
        $type = $isCustomConfiguration
            ? ConfiguratorSubmissionTypeEnum::OFFER
            : ConfiguratorSubmissionTypeEnum::ORDER;

        return ConfiguratorSubmission::create([
            'type' => $type,
            'status' => (string) ($submission['status'] ?? 'new'),
            'customer_id' => $customer->id,
            'observations' => $this->nullableString($submission['observations'] ?? null),
            'system_id' => $this->nullableInt($submission['system_id'] ?? null),
            'schema_id' => $this->nullableInt($submission['schema_id'] ?? null),
            'dimension_id' => $this->nullableInt($submission['dimension_id'] ?? null),
            'handle_id' => $this->nullableInt($submission['handle_id'] ?? null),
            'color_id' => $this->nullableInt($submission['color_id'] ?? null),
            'custom_option_id' => $customOptionId,
            'base_price' => (float) ($submission['base_price'] ?? 0),
            'handle_price' => (float) ($submission['handle_price'] ?? 0),
            'accessories_total' => (float) ($submission['accessories_total'] ?? 0),
            'total_price' => (float) ($submission['total_price'] ?? 0),
            'submitted_at' => now(),
        ]);
    }

    private function nullableInt(mixed $value): ?int
    {
        return $value === null ? null : (int) $value;
    }

    private function nullableString(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $trimmed = trim((string) $value);

        return $trimmed === '' ? null : $trimmed;
    }
}
