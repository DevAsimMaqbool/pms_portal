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
        Schema::table('employabilities', function (Blueprint $table) {
            $table->date('passing_year')->change();
            

            // Add new fields
            $table->string('period')->nullable()->after('student_id');
            $table->unsignedBigInteger('department_id')->after('faculty_id');
            $table->date('date_of_appointment')->nullable()->after('passing_year');
            $table->string('proof_salary_and_appointment')->nullable()->after('date_of_appointment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employabilities', function (Blueprint $table) {
            // Revert changes
            $table->year('passing_year')->change();

            $table->dropColumn([
                'date_of_appointment',
                'department_id',
                'proof_salary_and_appointment'
            ]);
        });
    }
};
