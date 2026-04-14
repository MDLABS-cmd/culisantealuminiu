<?php

namespace App\Http\Controllers;

use App\Enums\SchemaPriceTypeEnum;
use App\Models\Schema;
use App\Models\System;
use Illuminate\Http\JsonResponse;

class SystemController extends Controller
{
    public function schemas(System $system): JsonResponse
    {
        abort_unless($system->active, 404);

        $schemas = Schema::query()
            ->where('system_id', $system->id)
            ->active()
            ->status(SchemaPriceTypeEnum::STANDARD)
            ->with([
                'files' => fn($query) => $query
                    ->where('collection', 'image')
                    ->orderByDesc('id'),
            ])
            ->orderBy('order')
            ->get(['id', 'name', 'order'])
            ->map(function (Schema $schema) {
                return [
                    'id' => $schema->id,
                    'name' => $schema->name,
                    'order' => $schema->order,
                    'image_url' => $schema->files->first()?->getUrl(),
                ];
            })
            ->values();

        return response()->json([
            'data' => $schemas,
        ]);
    }
}
