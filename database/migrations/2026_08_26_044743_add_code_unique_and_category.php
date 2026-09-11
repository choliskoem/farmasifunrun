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
        | KODE UNIK PEMBAYARAN (100-500)
        |--------------------------------------------------------------------------
        |
        | Ditambahkan di belakang harga kategori supaya nominal transfer
        | tiap peserta berbeda-beda, memudahkan admin mencocokkan mutasi
        | rekening dengan registrasi yang bersangkutan.
        |
        */

        Schema::table('fun_run_registrations', function (Blueprint $table) {
            $table->unsignedSmallInteger('unique_code')
                ->nullable()
                ->after('amount');
        });

        /*
        |--------------------------------------------------------------------------
        | RENTANG KODE REGISTRASI PER KATEGORI
        |--------------------------------------------------------------------------
        |
        | 4 digit terakhir pada kode registrasi (mis. FR-20260826-1042)
        | diambil dari rentang yang bisa diatur per kategori. Contoh:
        | kategori 5K -> 1000-2999, kategori 10K -> 3001-3999.
        |
        */

        Schema::table('fun_run_categories', function (Blueprint $table) {
            $table->unsignedInteger('code_min')
                ->nullable()
                ->after('quota');

            $table->unsignedInteger('code_max')
                ->nullable()
                ->after('code_min');
        });
    }

    public function down(): void
    {
        Schema::table('fun_run_registrations', function (Blueprint $table) {
            $table->dropColumn('unique_code');
        });

        Schema::table('fun_run_categories', function (Blueprint $table) {
            $table->dropColumn(['code_min', 'code_max']);
        });
    }
};