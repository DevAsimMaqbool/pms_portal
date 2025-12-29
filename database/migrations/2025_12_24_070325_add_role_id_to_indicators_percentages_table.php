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
            $table->unsignedBigInteger('role_id')->index()->nullable()->after('employee_id');
            $table->enum('status', ['0', '1', '2'])->default('1')->after('given_by');
            // Optional: add unique constraint including role_id
            $table->unique(['employee_id','role_id','key_performance_area_id','indicator_category_id','indicator_id'], 'unique_employee_indicator');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('indicators_percentages', function (Blueprint $table) {
            $table->dropUnique('unique_employee_indicator');

            // Drop the foreign key and column
            $table->dropColumn('role_id');
            $table->dropColumn('status');
        });
    }
};
