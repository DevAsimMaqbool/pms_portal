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
        Schema::table('achievement_of_research_publications_target_co_author', function (Blueprint $table) {
            // Remove first_author_superviser column
            if (Schema::hasColumn('achievement_of_research_publications_target_co_author', 'first_author_superviser')) {
                $table->dropColumn('first_author_superviser');
            }
            if (!Schema::hasColumn('achievement_of_research_publications_target_co_author', 'your_role')) {
                $table->enum('your_role', ['Student', 'Other'])->nullable()->after('country'); // adjust 'after' as needed
            }

            // Add is_the_student_fitst_coauthor enum column
            if (!Schema::hasColumn('achievement_of_research_publications_target_co_author', 'is_the_student_fitst_coauthor')) {
                $table->enum('is_the_student_fitst_coauthor', ['YES', 'NO'])->nullable()->after('your_role');
            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('achievement_of_research_publications_target_co_author', function (Blueprint $table) {
            // Re-add first_author_superviser column
            $table->enum('first_author_superviser', ['YES', 'NO'])->nullable()->after('country');

            // Drop newly added columns
            $table->dropColumn('your_role');
            $table->dropColumn('is_the_student_fitst_coauthor');
        });
    }
};
