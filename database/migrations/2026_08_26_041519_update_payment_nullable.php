<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fun_run_payments', function (Blueprint $table) {

            // Field ini sudah tidak diisi lagi lewat form pembayaran,
            // jadi harus boleh kosong.
            $table->string('transfer_type')->nullable()->change();
            $table->string('sender_name')->nullable()->change();
            $table->string('sender_bank')->nullable()->change();
            $table->string('sender_account_number')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('fun_run_payments', function (Blueprint $table) {

            $table->string('transfer_type')->nullable(false)->change();
            $table->string('sender_name')->nullable(false)->change();
            $table->string('sender_bank')->nullable(false)->change();
            $table->string('sender_account_number')->nullable(false)->change();
        });
    }
};