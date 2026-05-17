<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConfiguratorSubmissionRequest;
use App\Models\ConfiguratorSubmission;
use App\Services\ConfiguratorSubmission\SubmitConfiguratorSelectionService;
use App\Services\ConfiguratorSubmissionService;
use Illuminate\Http\RedirectResponse;

class ConfiguratorSubmissionController extends Controller
{
    public function __construct(
        protected SubmitConfiguratorSelectionService $submitService,
        protected ConfiguratorSubmissionService $submissionService,
    ) {}

    public function index()
    {
        $submissions = $this->submissionService->getUserConfiguratorSubmissions();

        return inertia('configurator-submissions/index', [
            'submissions' => $submissions,
        ]);
    }

    public function show(ConfiguratorSubmission $submission)
    {
        $submission->load([
            'customer',
            'system',
            'schema',
            'dimension',
            'handle',
            'customOption',
            'color',
            'accessories.accesory',
        ]);

        return inertia('configurator-submissions/show', [
            'submission' => $submission,
        ]);
    }

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
