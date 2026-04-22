<?php

use App\Enums\ConfiguratorSubmissionTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configurator_submissions', function (Blueprint $table) {
            $table->id();

            $table->string('type')->default(ConfiguratorSubmissionTypeEnum::OFFER->value)->index();
            $table->string('status', 32)->default('new')->index();

            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->text('observations')->nullable();

            $table->foreignId('system_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('schema_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('dimension_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('handle_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('color_id')->nullable()->constrained()->nullOnDelete();

            $table->decimal('base_price', 10, 2)->default(0);
            $table->decimal('handle_price', 10, 2)->default(0);
            $table->decimal('accessories_total', 10, 2)->default(0);
            $table->decimal('total_price', 10, 2)->default(0);

            $table->timestamp('submitted_at')->useCurrent()->index();
            $table->timestamps();

            $table->index(['type', 'status', 'submitted_at']);
            $table->index(['system_id', 'schema_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configurator_submissions');
    }
};
