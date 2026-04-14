<?php

namespace App\Http\Controllers;

use App\Enums\SchemaPriceTypeEnum;
use App\Models\Handle;
use App\Models\Schema;
use Illuminate\Http\JsonResponse;

class SchemaController extends Controller
{
    public function configuratorOptions(Schema $schema): JsonResponse
    {
        $activeSchema = Schema::query()
            ->whereKey($schema->id)
            ->active()
            ->status(SchemaPriceTypeEnum::STANDARD)
            ->with(['system'])
            ->firstOrFail();

        $dimensions = $activeSchema->dimensions()
            ->where('active', true)
            ->with(['pricing'])
            ->orderBy('id')
            ->get(['id', 'schema_id', 'width', 'height', 'active']);

        $accesories = $activeSchema->accesories()
            ->where('active', true)
            ->orderBy('name')
            ->get(['accesories.id', 'name', 'price', 'active']);

        $handles = Handle::query()
            ->active()
            ->orderBy('name')
            ->get(['id', 'name', 'type', 'price', 'active']);

        $colorCategories = $activeSchema->system
            ->colorCategories()
            ->where('active', true)
            ->with([
                'colors' => fn($query) => $query
                    ->where('active', true)
                    ->orderBy('name'),
            ])
            ->orderBy('order')
            ->get(['color_categories.id', 'name', 'active', 'order']);

        return response()->json([
            'data' => [
                'schema' => $activeSchema->only(['id', 'name', 'system_id', 'material_id', 'price_type', 'order', 'active']),
                'dimensions' => $dimensions,
                'accesories' => $accesories,
                'handles' => $handles,
                'colorCategories' => $colorCategories,
            ],
        ]);
    }
}
