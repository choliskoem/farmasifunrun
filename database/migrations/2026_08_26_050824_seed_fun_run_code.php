<?php

use App\Models\FunRunCategory;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | ISI RENTANG KODE REGISTRASI OTOMATIS
        |--------------------------------------------------------------------------
        |
        | Kategori dengan jarak 5 (5K) -> 1000-2999
        | Kategori dengan jarak 10 (10K) -> 3000-3999
        |
        | Dicocokkan lewat kolom `distance` (angka di dalamnya diambil,
        | jadi "5", "5 KM", atau "5km" semuanya cocok jadi 5).
        |
        | Kategori dengan jarak lain (mis. 21K, 42K) TIDAK disentuh oleh
        | migration ini - silakan set manual lewat tinker/SQL kalau ada.
        |
        */

        FunRunCategory::query()->each(function (FunRunCategory $category) {

            $distance = (float) preg_replace(
                '/[^0-9.]/',
                '',
                (string) $category->distance
            );

            if ($distance == 5.0) {

                $category->update([
                    'code_min' => 1000,
                    'code_max' => 2999,
                ]);

            } elseif ($distance == 10.0) {

                $category->update([
                    'code_min' => 3000,
                    'code_max' => 3999,
                ]);
            }
        });
    }

    public function down(): void
    {
        FunRunCategory::whereIn('code_min', [1000, 3000])
            ->update([
                'code_min' => null,
                'code_max' => null,
            ]);
    }
};