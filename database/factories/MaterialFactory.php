<?php

namespace Database\Factories;

use App\Models\Material;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Material>
 */
class MaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'system_id' => \App\Models\System::factory(),
            'name' => $this->faker->word(),
            'active' => $this->faker->boolean(),
            'order' => $this->faker->numberBetween(0, 100),
        ];
    }
}
