<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configurator_submission_accessories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('submission_id')
                ->constrained('configurator_submissions')
                ->cascadeOnDelete();

            $table->foreignId('accesory_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedInteger('qty')->default(1);

            $table->timestamps();

            $table->index('submission_id');
            $table->index('accesory_id');
            $table->unique(['submission_id', 'accesory_id'], 'csa_submission_accesory_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configurator_submission_accessories');
    }
};
