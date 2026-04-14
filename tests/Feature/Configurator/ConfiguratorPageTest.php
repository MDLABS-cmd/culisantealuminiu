<?php

use App\Models\System;
use Inertia\Testing\AssertableInertia as Assert;

test('guests can visit the configurator page', function () {
    System::factory()->create([
        'active' => true,
        'order' => 1,
        'name' => 'MB82 HS',
    ]);

    $response = $this->get(route('configurator'));

    $response
        ->assertOk()
        ->assertInertia(fn(Assert $page) => $page
            ->component('configurator')
            ->has('activeSystems', 1)
            ->where('activeSystems.0.name', 'MB82 HS'));
});
