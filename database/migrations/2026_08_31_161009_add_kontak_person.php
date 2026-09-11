<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fun_run_events', function (Blueprint $table) {

            if (!Schema::hasColumn('fun_run_events', 'contact_person_name')) {
                $table->string('contact_person_name')->nullable()->after('qris_image');
            }

            if (!Schema::hasColumn('fun_run_events', 'contact_person_phone')) {
                $table->string('contact_person_phone')->nullable()->after('contact_person_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('fun_run_events', function (Blueprint $table) {

            $columns = array_filter([
                'contact_person_name',
                'contact_person_phone',
            ], fn ($column) => Schema::hasColumn('fun_run_events', $column));

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};