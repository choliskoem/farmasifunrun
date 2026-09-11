<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fun_run_payments', function (Blueprint $table) {

            $table->date('transfer_date')
                ->nullable()
                ->after('sender_account_number');

            $table->decimal('transfer_amount', 15, 2)
                ->nullable()
                ->after('transfer_date');
        });
    }

    public function down(): void
    {
        Schema::table('fun_run_payments', function (Blueprint $table) {
            $table->dropColumn([
                'transfer_date',
                'transfer_amount',
            ]);
        });
    }
};