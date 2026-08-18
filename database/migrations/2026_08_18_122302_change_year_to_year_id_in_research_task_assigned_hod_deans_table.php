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
        Schema::table('research_task_assigned_hod_deans', function (Blueprint $table) {
            $table->unsignedBigInteger('year_id')->nullable()->after('employee_id');
            $table->dropColumn('year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('research_task_assigned_hod_deans', function (Blueprint $table) {
            $table->dropColumn('year_id');
            $table->string('year')->nullable()->after('employee_id');
        });
    }
};
