<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fun_run_payments', function (Blueprint $table) {

            $table->enum('transfer_type', [
                'self',
                'other',
            ])
            ->nullable()
            ->after('payment_channel');

            $table->string('sender_name')
                ->nullable()
                ->after('transfer_type');

            $table->string('sender_bank')
                ->nullable()
                ->after('sender_name');

            $table->string('sender_account_number')
                ->nullable()
                ->after('sender_bank');

            // proof SUDAH ADA di migration awal,
            // jadi tidak perlu ditambahkan lagi.

            $table->dateTime('submitted_at')
                ->nullable()
                ->after('proof');

            $table->foreignId('verified_by')
                ->nullable()
                ->after('submitted_at')
                ->constrained('users')
                ->nullOnDelete();

            $table->dateTime('verified_at')
                ->nullable()
                ->after('verified_by');

            $table->text('admin_note')
                ->nullable()
                ->after('verified_at');

            $table->enum('status', [
                'pending',
                'submitted',
                'verified',
                'rejected',
            ])
            ->default('pending')
            ->change();
        });
    }

    public function down(): void
    {
        Schema::table('fun_run_payments', function (Blueprint $table) {

            $table->dropForeign(['verified_by']);

            $table->dropColumn([
                'transfer_type',
                'sender_name',
                'sender_bank',
                'sender_account_number',
                'submitted_at',
                'verified_by',
                'verified_at',
                'admin_note',
            ]);

            $table->enum('status', [
                'pending',
                'paid',
                'failed',
                'expired',
            ])
            ->default('pending')
            ->change();
        });
    }
};