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
        Schema::table('faculty_member_classes', function (Blueprint $table) {
            $table->dateTime('exam_date', '6')->nullable()->after('career_code');
            $table->dateTime('result_submit_date', '6')->nullable()->after('exam_date');
            $table->string('average_marks', '100')->nullable()->after('result_submit_date');
            $table->string('result_status', '20')->nullable()->after('average_marks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faculty_member_classes', function (Blueprint $table) {
            $table->dropColumn(['exam_date', 'result_submit_date', 'average_marks', 'result_status']);
        });
    }
};
