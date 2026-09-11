<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fun_run_events', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug')->unique();

            $table->text('description')->nullable();

            $table->date('event_date');
            $table->time('start_time')->nullable();

            $table->string('location')->nullable();
            $table->string('banner')->nullable();

            $table->dateTime('registration_start')->nullable();
            $table->dateTime('registration_end')->nullable();

            $table->boolean('is_active')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fun_run_events');
    }
};