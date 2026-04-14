<?php

use App\Enums\HandleTypeEnum;
use App\Enums\SchemaPriceTypeEnum;
use App\Models\Accesory;
use App\Models\Color;
use App\Models\ColorCategory;
use App\Models\Dimension;
use App\Models\DimensionPricing;
use App\Models\Handle;
use App\Models\Material;
use App\Models\Schema;
use App\Models\System;

test('guests can load configurator route', function () {
    $response = $this->get(route('configurator'));

    $response->assertOk();
});

test('system schemas endpoint returns active standard schemas in order', function () {
    $system = System::factory()->create([
        'active' => true,
    ]);

    $material = Material::query()->create([
        'name' => 'Aluminium',
        'active' => true,
        'order' => 1,
    ]);

    Schema::query()->create([
        'system_id' => $system->id,
        'material_id' => $material->id,
        'active' => true,
        'price_type' => SchemaPriceTypeEnum::CUSTOM->value,
        'order' => 1,
        'name' => 'Custom schema',
    ]);

    Schema::query()->create([
        'system_id' => $system->id,
        'material_id' => $material->id,
        'active' => true,
        'price_type' => SchemaPriceTypeEnum::STANDARD->value,
        'order' => 2,
        'name' => 'Second',
    ]);

    Schema::query()->create([
        'system_id' => $system->id,
        'material_id' => $material->id,
        'active' => true,
        'price_type' => SchemaPriceTypeEnum::STANDARD->value,
        'order' => 1,
        'name' => 'First',
    ]);

    $response = $this->getJson(route('systems.schemas', $system));

    $response
        ->assertOk()
        ->assertJsonCount(2, 'data')
        ->assertJsonPath('data.0.name', 'First')
        ->assertJsonPath('data.1.name', 'Second');
});

test('schema options endpoint returns dimensions accessories handles and color categories', function () {
    $system = System::factory()->create(['active' => true]);
    $material = Material::query()->create([
        'name' => 'Aluminium',
        'active' => true,
        'order' => 1,
    ]);

    $schema = Schema::query()->create([
        'system_id' => $system->id,
        'material_id' => $material->id,
        'name' => 'Schema A',
        'active' => true,
        'price_type' => SchemaPriceTypeEnum::STANDARD->value,
        'order' => 1,
    ]);

    $dimension = Dimension::factory()->create([
        'schema_id' => $schema->id,
        'active' => true,
        'width' => 1200,
        'height' => 2200,
    ]);

    DimensionPricing::query()->create([
        'dimension_id' => $dimension->id,
        'material_id' => $material->id,
        'material_cost' => 100,
        'working_hours' => 2,
        'working_cost' => 50,
        'price_without_vat' => 150,
        'additional_cost' => 10,
    ]);

    $accesory = Accesory::query()->create([
        'name' => 'Soft close',
        'price' => '20.00',
        'active' => true,
    ]);
    $schema->accesories()->attach($accesory->id);

    Handle::query()->create([
        'name' => 'Classic handle',
        'type' => HandleTypeEnum::STANDARD,
        'price' => '45.00',
        'active' => true,
    ]);

    $colorCategory = ColorCategory::factory()->create([
        'active' => true,
        'order' => 1,
        'name' => 'Matte',
    ]);
    $system->colorCategories()->attach($colorCategory->id);

    Color::factory()->create([
        'color_category_id' => $colorCategory->id,
        'name' => 'Black',
        'active' => true,
    ]);

    $response = $this->getJson(route('schemas.configurator-options', $schema));

    $response
        ->assertOk()
        ->assertJsonPath('data.schema.id', $schema->id)
        ->assertJsonCount(1, 'data.dimensions')
        ->assertJsonCount(1, 'data.accesories')
        ->assertJsonCount(1, 'data.handles')
        ->assertJsonCount(1, 'data.colorCategories')
        ->assertJsonPath('data.dimensions.0.pricing.price_without_vat', 150)
        ->assertJsonPath('data.colorCategories.0.colors.0.name', 'Black');
});

test('inactive schema returns not found for configurator options endpoint', function () {
    $system = System::factory()->create(['active' => true]);
    $material = Material::query()->create([
        'name' => 'Steel',
        'active' => true,
        'order' => 1,
    ]);

    $schema = Schema::query()->create([
        'system_id' => $system->id,
        'material_id' => $material->id,
        'name' => 'Inactive Schema',
        'active' => false,
        'price_type' => SchemaPriceTypeEnum::STANDARD->value,
        'order' => 1,
    ]);

    $response = $this->getJson(route('schemas.configurator-options', $schema));

    $response->assertNotFound();
});
