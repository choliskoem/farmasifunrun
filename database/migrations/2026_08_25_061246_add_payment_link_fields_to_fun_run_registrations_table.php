<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fun_run_registrations', function (Blueprint $table) {

            $table->timestamp('email_verified_at')
                ->nullable()
                ->after('email');

            $table->string('payment_token_hash', 64)
                ->nullable()
                ->unique()
                ->after('email_verified_at');

            $table->timestamp('payment_link_sent_at')
                ->nullable()
                ->after('payment_token_hash');

        });
    }

    public function down(): void
    {
        Schema::table('fun_run_registrations', function (Blueprint $table) {

            $table->dropColumn([
                'email_verified_at',
                'payment_token_hash',
                'payment_link_sent_at',
            ]);

        });
    }
};