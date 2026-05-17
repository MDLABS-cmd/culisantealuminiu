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
        Schema::table('configurator_submissions', function (Blueprint $table) {
            $table->foreignId('custom_option_id')->nullable()->constrained()->cascadeOnDelete()->after('handle_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('configurator_submissions', function (Blueprint $table) {
            $table->dropForeign(['custom_option_id']);
            $table->dropColumn('custom_option_id');
        });
    }
};
