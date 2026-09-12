<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('role_menu_permissions', function (Blueprint $table) {

            $table->id();

            // 'admin' atau 'user' -- Super Admin TIDAK pernah dicatat
            // di sini, karena Super Admin selalu full akses (hardcode
            // di kode, bukan data), supaya nggak ada resiko Super
            // Admin ke-lockout dari menunya sendiri gara-gara
            // pengaturan yang salah/kehapus.
            $table->string('role');

            // Kunci menu, samakan dengan key di config/admin_menu.php
            $table->string('menu_key');

            $table->timestamps();

            $table->unique(['role', 'menu_key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_menu_permissions');
    }
};