<?php

use App\Http\Controllers\ConfiguratorSubmissionController;
use App\Http\Controllers\SchemaController;
use App\Http\Controllers\SystemController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::inertia('/configurator', 'configurator')->name('configurator');
Route::get('/systems/{system}/schemas', [SystemController::class, 'schemas'])->name('systems.schemas');
Route::get('/schemas/{schema}/configurator-options', [SchemaController::class, 'configuratorOptions'])->name('schemas.configurator-options');
Route::post('/configurator/submissions', [ConfiguratorSubmissionController::class, 'store'])->name('configurator.submissions.store');
Route::inertia('/configurator/success', 'configurator/success')->name('configurator.success');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__ . '/settings.php';
