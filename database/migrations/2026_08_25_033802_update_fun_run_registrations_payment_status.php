<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fun_run_registrations', function (Blueprint $table) {

            $table->enum('status', [
                'waiting_payment',
                'waiting_verification',
                'paid',
                'rejected',
                'cancelled',
            ])
            ->default('waiting_payment')
            ->change();

        });
    }

    public function down(): void
    {
        Schema::table('fun_run_registrations', function (Blueprint $table) {

            $table->enum('status', [
                'pending',
                'paid',
                'cancelled',
                'expired',
            ])
            ->default('pending')
            ->change();

        });
    }
};