<?php

use App\Enums\HandleTypeEnum;
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
        Schema::create('handles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->default(HandleTypeEnum::STANDARD->value);
            $table->decimal('price', 8, 2);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('handles');
    }
};
