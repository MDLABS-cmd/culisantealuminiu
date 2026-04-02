<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('color_categories', function (Blueprint $table) {
            $table->boolean('has_imported_colors')->default(false)->after('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('color_categories', function (Blueprint $table) {
            $table->dropColumn('has_imported_colors');
        });
    }
};
