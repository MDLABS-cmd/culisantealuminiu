<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConfiguratorSubmissionRequest;
use App\Services\ConfiguratorSubmission\SubmitConfiguratorSelectionService;
use Illuminate\Http\RedirectResponse;

class ConfiguratorSubmissionController extends Controller
{
    public function __construct(
        protected SubmitConfiguratorSelectionService $submitService,
    ) {}

    public function store(StoreConfiguratorSubmissionRequest $request): RedirectResponse
    {
        $submission = $this->submitService->submit(
            $request->toServicePayload(),
            $request->user(),
        );

        return to_route('configurator.success')
            ->with('submissionId', $submission->id)
            ->with('submissionType', $submission->type->value);
    }
}
