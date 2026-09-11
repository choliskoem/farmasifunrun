<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fun_run_events', function (Blueprint $table) {

            if (!Schema::hasColumn('fun_run_events', 'bank_name_2')) {
                $table->string('bank_name_2')->nullable()->after('account_holder');
            }

            if (!Schema::hasColumn('fun_run_events', 'account_number_2')) {
                $table->string('account_number_2')->nullable()->after('bank_name_2');
            }

            if (!Schema::hasColumn('fun_run_events', 'account_holder_2')) {
                $table->string('account_holder_2')->nullable()->after('account_number_2');
            }
        });
    }

    public function down(): void
    {
        Schema::table('fun_run_events', function (Blueprint $table) {

            $columns = array_filter([
                'bank_name_2',
                'account_number_2',
                'account_holder_2',
            ], fn ($column) => Schema::hasColumn('fun_run_events', $column));

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};