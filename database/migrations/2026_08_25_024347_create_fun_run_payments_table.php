<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fun_run_payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('registration_id')
                ->constrained('fun_run_registrations')
                ->cascadeOnDelete();

            $table->string('payment_reference')->unique();

            $table->decimal('amount', 15, 2);

            $table->string('payment_method')->nullable();
            $table->string('payment_channel')->nullable();

            $table->string('proof')->nullable();

            $table->enum('status', [
                'pending',
                'paid',
                'failed',
                'expired',
            ])->default('pending');

            $table->dateTime('paid_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fun_run_payments');
    }
};