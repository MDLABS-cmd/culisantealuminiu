<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dimension_pricings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dimension_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('material_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->float('material_cost')->default(0);
            $table->float('working_hours')->default(0);
            $table->float('working_cost')->default(0);
            $table->float('price_without_vat')->default(0);
            $table->float('additional_cost')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dimension_pricings');
    }
};
