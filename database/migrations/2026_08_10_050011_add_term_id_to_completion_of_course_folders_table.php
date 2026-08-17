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
        Schema::table('completion_of_course_folders', function (Blueprint $table) {
            $table->unsignedBigInteger('term_id')->after('faculty_member_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('completion_of_course_folders', function (Blueprint $table) {
            $table->dropColumn('term_id');
        });
    }
};
