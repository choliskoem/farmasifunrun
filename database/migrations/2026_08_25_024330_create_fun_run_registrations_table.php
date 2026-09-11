<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fun_run_registrations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('event_id')
                ->constrained('fun_run_events')
                ->cascadeOnDelete();

            $table->foreignId('category_id')
                ->constrained('fun_run_categories')
                ->restrictOnDelete();

            $table->foreignId('price_id')
                ->constrained('fun_run_prices')
                ->restrictOnDelete();

            $table->string('registration_code')->unique();

            $table->string('name');
            $table->string('email');
            $table->string('phone');

            $table->string('identity_number')->nullable();

            $table->enum('gender', ['L', 'P'])->nullable();

            $table->date('birth_date')->nullable();

            $table->text('address')->nullable();

            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();

            $table->decimal('amount', 15, 2);

            $table->enum('status', [
                'pending',
                'paid',
                'cancelled',
                'expired',
            ])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fun_run_registrations');
    }
};