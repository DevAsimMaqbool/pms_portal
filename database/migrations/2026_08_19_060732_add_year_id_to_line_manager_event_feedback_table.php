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
        Schema::table('line_manager_event_feedback', function (Blueprint $table) {
            $table->unsignedBigInteger('year_id')
                ->after('employee_id');
        });

        Schema::table('line_manager_event_feedback', function (Blueprint $table) {
            $table->dropUnique('employee_event_unique');

            $table->unique(
                ['employee_id', 'event_name', 'year_id'],
                'employee_event_year_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('line_manager_event_feedback', function (Blueprint $table) {
            $table->dropUnique('employee_event_year_unique');

            $table->unique(
                ['employee_id', 'event_name'],
                'employee_event_unique'
            );

            $table->dropColumn('year_id');
        });
    }
};
