<?php

use App\Http\Controllers\ConfiguratorSubmissionController;
use App\Http\Controllers\SchemaController;
use App\Http\Controllers\SystemController;
use App\Services\ConfiguratorSubmissionService;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'configurator')->name('home');

Route::get('/systems/{system}/schemas', [SystemController::class, 'schemas'])->name('systems.schemas');
Route::get('/schemas/{schema}/configurator-options', [SchemaController::class, 'configuratorOptions'])->name('schemas.configurator-options');
Route::post('/configurator/submissions', [ConfiguratorSubmissionController::class, 'store'])->name('configurator.submissions.store');
Route::inertia('/configurator/success', 'configurator/success')->name('configurator.success');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function (ConfiguratorSubmissionService $submissionService) {
        $submissions = $submissionService->getUserConfiguratorSubmissions();

        return inertia('dashboard', [
            'submissions' => $submissions,
        ]);
    })->name('dashboard');
    Route::get('configurator/submissions', [ConfiguratorSubmissionController::class, 'index'])->name('configurator.submissions.index');
    Route::get('configurator/submissions/{submission}', [ConfiguratorSubmissionController::class, 'show'])->name('configurator.submissions.show');
});

require __DIR__ . '/settings.php';
