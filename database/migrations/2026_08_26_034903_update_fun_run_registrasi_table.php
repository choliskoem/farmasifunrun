<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fun_run_registrations', function (Blueprint $table) {

            // Ukuran baju & riwayat penyakit peserta.
            $table->string('shirt_size', 5)
                ->nullable()
                ->after('address');

            $table->text('medical_history')
                ->nullable()
                ->after('shirt_size');

            // Kontak darurat disederhanakan jadi satu nomor saja.
            if (Schema::hasColumn('fun_run_registrations', 'emergency_contact_name')) {
                $table->dropColumn('emergency_contact_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('fun_run_registrations', function (Blueprint $table) {

            $table->dropColumn(['shirt_size', 'medical_history']);

            $table->string('emergency_contact_name')
                ->nullable()
                ->after('address');
        });
    }
};