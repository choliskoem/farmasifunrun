<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fun_run_events', function (Blueprint $table) {

            if (!Schema::hasColumn('fun_run_events', 'is_maintenance')) {
                $table->boolean('is_maintenance')->default(false)->after('registration_end');
            }

            if (!Schema::hasColumn('fun_run_events', 'maintenance_until')) {
                $table->dateTime('maintenance_until')->nullable()->after('is_maintenance');
            }
        });
    }

    public function down(): void
    {
        Schema::table('fun_run_events', function (Blueprint $table) {

            $columns = array_filter([
                'is_maintenance',
                'maintenance_until',
            ], fn ($column) => Schema::hasColumn('fun_run_events', $column));

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};