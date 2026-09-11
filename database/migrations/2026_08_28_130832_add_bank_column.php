<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fun_run_events', function (Blueprint $table) {

            if (!Schema::hasColumn('fun_run_events', 'bank_name')) {
                $table->string('bank_name')->nullable();
            }

            if (!Schema::hasColumn('fun_run_events', 'account_number')) {
                $table->string('account_number')->nullable();
            }

            if (!Schema::hasColumn('fun_run_events', 'account_holder')) {
                $table->string('account_holder')->nullable();
            }

            if (!Schema::hasColumn('fun_run_events', 'qris_image')) {
                $table->string('qris_image')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('fun_run_events', function (Blueprint $table) {

            $columns = array_filter([
                'bank_name',
                'account_number',
                'account_holder',
                'qris_image',
            ], fn ($column) => Schema::hasColumn('fun_run_events', $column));

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};