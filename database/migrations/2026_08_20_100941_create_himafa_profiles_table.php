<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('himafa_profiles', function (Blueprint $table) {
            $table->id();

            $table->string('nama_organisasi')
                ->default('Himpunan Mahasiswa Jurusan Farmasi');

            $table->string('tagline')
                ->nullable();

            $table->text('deskripsi')
                ->nullable();

            $table->unsignedSmallInteger('tahun_berdiri')
                ->nullable();

            $table->text('sejarah_awal')
                ->nullable();

            $table->text('sejarah_perjalanan')
                ->nullable();

            $table->text('sejarah_kini')
                ->nullable();

            $table->string('hero_image')
                ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('himafa_profiles');
    }
};