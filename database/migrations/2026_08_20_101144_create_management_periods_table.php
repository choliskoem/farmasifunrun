<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('management_periods', function (Blueprint $table) {
            $table->id();

            $table->string('nama_periode');

            $table->unsignedSmallInteger('tahun_mulai');

            $table->unsignedSmallInteger('tahun_selesai')
                ->nullable();

            $table->boolean('aktif')
                ->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('management_periods');
    }
};