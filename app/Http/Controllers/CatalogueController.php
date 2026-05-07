<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catalogue;

class CatalogueController extends Controller
{
    public function index()
    {
        $catalogues = Catalogue::query()
            ->with('files')
            ->latest()
            ->get(['id', 'title', 'description', 'created_at', 'updated_at']);

        return inertia('catalogues/index', [
            'catalogues' => $catalogues,
        ]);
    }
}
