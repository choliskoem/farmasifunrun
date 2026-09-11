<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | BIODATA JADI OPSIONAL
        |--------------------------------------------------------------------------
        |
        | Dibutuhkan supaya registrasi manual (Jalur Undangan / Backdoor)
        | bisa disimpan tanpa isi biodata lengkap seperti pendaftaran
        | publik biasa.
        |
        */

        Schema::table('fun_run_registrations', function (Blueprint $table) {

            $table->string('gender')->nullable()->change();
            $table->date('birth_date')->nullable()->change();
            $table->text('address')->nullable()->change();
            $table->string('shirt_size', 5)->nullable()->change();
            $table->string('emergency_contact_phone')->nullable()->change();

            $table->string('channel')
                ->default('public')
                ->after('status');
        });

        /*
        |--------------------------------------------------------------------------
        | BUKTI TRANSFER JADI OPSIONAL
        |--------------------------------------------------------------------------
        |
        | Registrasi manual tidak punya file bukti transfer beneran.
        |
        */

        Schema::table('fun_run_payments', function (Blueprint $table) {
            $table->string('proof')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('fun_run_registrations', function (Blueprint $table) {
            $table->dropColumn('channel');
        });
    }
};