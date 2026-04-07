<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('satisfaction_of_international_students', function (Blueprint $table) {

            // ✅ Add new columns after student_roll_no
            $table->unsignedBigInteger('faculty_id')->nullable()->after('student_roll_no');
            $table->unsignedBigInteger('department_id')->nullable()->after('faculty_id');
            $table->unsignedBigInteger('program_id')->nullable()->after('department_id');
            $table->string('program_level')->nullable()->after('program_id');

            // ✅ Drop old column
            if (Schema::hasColumn('satisfaction_of_international_students', 'student_program')) {
                $table->dropColumn('student_program');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('satisfaction_of_international_students', function (Blueprint $table) {

            // ❌ Remove added columns
            $table->dropColumn([
                'faculty_id',
                'department_id',
                'program_id',
                'program_level'
            ]);

            // 🔄 Restore dropped column
            $table->string('student_program')->nullable()->after('student_roll_no');
        });
    }
};
