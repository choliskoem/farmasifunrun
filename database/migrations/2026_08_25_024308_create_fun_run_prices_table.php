<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fun_run_prices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('event_id')
                ->constrained('fun_run_events')
                ->cascadeOnDelete();

            $table->foreignId('period_id')
                ->constrained('fun_run_periods')
                ->cascadeOnDelete();

            $table->foreignId('category_id')
                ->constrained('fun_run_categories')
                ->cascadeOnDelete();

            $table->decimal('price', 15, 2);

            $table->unsignedInteger('quota')->nullable();

            $table->timestamps();

            $table->unique([
                'period_id',
                'category_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fun_run_prices');
    }
};