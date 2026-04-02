<?php

namespace Database\Factories;

use App\Models\Dimension;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Dimension>
 */
class DimensionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'width' => $this->faker->numberBetween(500, 3000), // Width in millimeters
            'height' => $this->faker->numberBetween(500, 3000), // Height in millimeters
            'active' => $this->faker->boolean(80), // 80% chance to be active
        ];
    }
}
