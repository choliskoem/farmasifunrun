<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gallery_photos', function (Blueprint $table) {

            $table->id();

            $table->foreignId('gallery_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('foto');

            // 1, 2, atau 3 — urutan slot foto dalam satu kegiatan.
            $table->unsignedTinyInteger('urutan')->default(1);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery_photos');
    }
};