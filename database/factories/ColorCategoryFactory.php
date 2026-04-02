<?php

namespace Database\Factories;

use App\Models\ColorCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ColorCategory>
 */
class ColorCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'active' => $this->faker->boolean(),
            'order' => $this->faker->numberBetween(0, 100),
        ];
    }
}
