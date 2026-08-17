<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('indicators_percentages', function (Blueprint $table) {
            $table->dropUnique('unique_employee_indicator');

            // NULL year_id becomes 0, otherwise keeps actual year_id
            $table->unsignedBigInteger('year_id_unique')
                ->storedAs('COALESCE(year_id, 0)');

            // Unique with year_id
            $table->unique(
                [
                    'employee_id',
                    'role_id',
                    'key_performance_area_id',
                    'indicator_category_id',
                    'indicator_id',
                    'year_id_unique',
                ],
                'unique_employee_indicator_year'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('indicators_percentages', function (Blueprint $table) {
            $table->dropUnique('unique_employee_indicator_year');

            $table->dropColumn('year_id_unique');

            // Restore old unique index
            $table->unique(
                [
                    'employee_id',
                    'role_id',
                    'key_performance_area_id',
                    'indicator_category_id',
                    'indicator_id',
                ],
                'unique_employee_indicator'
            );
        });
    }
};
