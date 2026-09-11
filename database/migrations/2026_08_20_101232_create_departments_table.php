<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('management_period_id')
                ->constrained('management_periods')
                ->cascadeOnDelete();

            $table->string('nama');

            $table->text('deskripsi')
                ->nullable();

            $table->string('ketua');

            $table->string('sekretaris');

            $table->string('urutan')
                ->default(0);

            $table->boolean('aktif')
                ->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};