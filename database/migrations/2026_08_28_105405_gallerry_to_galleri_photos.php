<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | PINDAHKAN FOTO LAMA
        |--------------------------------------------------------------------------
        |
        | Dulu satu baris `galleries` = satu foto (kolom `foto`).
        | Sekarang satu `galleries` = satu kegiatan, dengan banyak foto
        | (maks 3) di tabel `gallery_photos`. Foto lama dipindah supaya
        | tidak hilang, ditaruh sebagai foto urutan pertama.
        |
        */

        if (Schema::hasColumn('galleries', 'foto')) {

            $galleries = DB::table('galleries')
                ->whereNotNull('foto')
                ->where('foto', '!=', '')
                ->get();

            foreach ($galleries as $gallery) {

                DB::table('gallery_photos')->insert([
                    'gallery_id' => $gallery->id,
                    'foto' => $gallery->foto,
                    'urutan' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            Schema::table('galleries', function (Blueprint $table) {
                $table->dropColumn('foto');
            });
        }
    }

    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('foto')->nullable();
        });

        // Ambil balik foto urutan pertama tiap galeri sebagai `foto`.
        $firstPhotos = DB::table('gallery_photos')
            ->where('urutan', 1)
            ->get();

        foreach ($firstPhotos as $photo) {
            DB::table('galleries')
                ->where('id', $photo->gallery_id)
                ->update(['foto' => $photo->foto]);
        }
    }
};