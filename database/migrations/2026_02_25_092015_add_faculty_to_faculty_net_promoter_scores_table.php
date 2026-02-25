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
        Schema::table('faculty_net_promoter_scores', function (Blueprint $table) {
            $table->unsignedBigInteger('faculty_id')->after('year');
            $table->unsignedBigInteger('department_id')->after('faculty_id');
            $table->unsignedBigInteger('program_id')->nullable()->after('department_id');
            $table->string('program_level')->nullable()->after('program_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faculty_net_promoter_scores', function (Blueprint $table) {
             $table->dropColumn(['faculty_id', 'department_id', 'program_id','program_level']);
        });
    }
};
