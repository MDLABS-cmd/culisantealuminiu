<?php

namespace App\Services\ConfiguratorSubmission;

use App\Models\Customer;
use App\Models\User;

class ResolveSubmissionCustomerService
{
    /**
     * Resolve or create the customer record used by a submission.
     *
     * @param  array<string, mixed>  $order
     */
    public function resolve(array $order, ?User $user = null): Customer
    {
        $attributes = [
            'company_name' => $this->nullableString($order['company_name'] ?? null),
            'first_name' => (string) ($order['first_name'] ?? ''),
            'last_name' => (string) ($order['last_name'] ?? ''),
            'email' => (string) ($order['email'] ?? ''),
            'phone' => (string) ($order['phone'] ?? ''),
            'address' => (string) ($order['address'] ?? ''),
        ];

        if ($user !== null) {
            return Customer::updateOrCreate(
                ['user_id' => $user->id],
                $attributes,
            );
        }

        return Customer::updateOrCreate(
            [
                'user_id' => null,
                'email' => $attributes['email'],
                'phone' => $attributes['phone'],
            ],
            $attributes,
        );
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
