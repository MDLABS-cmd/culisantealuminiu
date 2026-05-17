<?php

namespace App\Services\ConfiguratorSubmission;

use App\Models\ConfiguratorSubmission;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SubmitConfiguratorSelectionService
{
    public function __construct(
        protected ResolveSubmissionUserService $resolveSubmissionUserService,
        protected ResolveSubmissionCustomerService $resolveSubmissionCustomerService,
        protected CreateSubmissionRecordService $createSubmissionRecordService,
        protected AttachSubmissionAccessoriesService $attachSubmissionAccessoriesService,
    ) {}

    /**
     * Persist the configurator submission flow in one transaction.
     *
     * @param  array<string, mixed>  $payload
     */
    public function submit(array $payload, ?User $authenticatedUser = null): ConfiguratorSubmission
    {
        return DB::transaction(function () use ($payload, $authenticatedUser): ConfiguratorSubmission {
            $order = (array) ($payload['order'] ?? []);
            $submission = (array) ($payload['submission'] ?? []);
            $accessoryIds = (array) ($payload['selected_accesory_ids'] ?? []);
            $customOptionId = $payload['selected_custom_option_id'] ?? null;

            $user = $this->resolveSubmissionUserService->resolve($order, $authenticatedUser);
            $customer = $this->resolveSubmissionCustomerService->resolve($order, $user);
            $createdSubmission = $this->createSubmissionRecordService->create($customer, $submission, $customOptionId);

            $this->attachSubmissionAccessoriesService->attach($createdSubmission, $accessoryIds);

            return $createdSubmission->load(['customer', 'accessories']);
        });
    }
}
