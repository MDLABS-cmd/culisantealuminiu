<?php

namespace Database\Factories;

use App\Models\System;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<System>
 */
class SystemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['MB82 HS', 'MB77 HS']),
            'is_custom' => $this->faker->boolean(),
            'active' => $this->faker->boolean(),
            'order' => $this->faker->numberBetween(0, 100),
        ];
    }
}
