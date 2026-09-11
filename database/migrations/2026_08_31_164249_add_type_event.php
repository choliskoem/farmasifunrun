<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {

            if (!Schema::hasColumn('events', 'tipe')) {
                $table->string('tipe')->default('full')->after('nama');
            }
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {

            if (Schema::hasColumn('events', 'tipe')) {
                $table->dropColumn('tipe');
            }
        });
    }
};