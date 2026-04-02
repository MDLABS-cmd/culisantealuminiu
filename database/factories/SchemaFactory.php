<?php

namespace Database\Factories;

use App\Enums\SchemaPriceTypeEnum;
use App\Models\Schema;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Schema>
 */
class SchemaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'system_id' => SystemFactory::new(),
            'name' => $this->faker->word(),
            'price_type' => $this->faker->randomElement([
                SchemaPriceTypeEnum::STANDARD->value,
                SchemaPriceTypeEnum::CUSTOM->value,
            ]),
            'order' => $this->faker->numberBetween(0, 100),
            'active' => $this->faker->boolean(),
        ];
    }
}
