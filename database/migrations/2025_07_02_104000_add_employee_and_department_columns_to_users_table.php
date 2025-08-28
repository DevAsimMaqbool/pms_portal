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
        Schema::table('users', function (Blueprint $table) {
            $table->string('employee_id', 19)->nullable()->after('id');
            $table->string('parent_department_id', 15)->nullable()->after('department_id');
            $table->string('parent_department_name', 191)->nullable()->after('parent_department_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn(['employee_id', 'parent_department_id', 'parent_department_name']);
        });
    }
};
