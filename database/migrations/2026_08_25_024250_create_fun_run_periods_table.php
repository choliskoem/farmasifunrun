<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fun_run_periods', function (Blueprint $table) {
            $table->id();

            $table->foreignId('event_id')
                ->constrained('fun_run_events')
                ->cascadeOnDelete();

            $table->string('name');

            $table->dateTime('start_at');
            $table->dateTime('end_at');

            $table->unsignedInteger('sort_order')->default(0);

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fun_run_periods');
    }
};