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
        Schema::table('achievement_of_research_publications_target', function (Blueprint $table) {
            // Remove rank column
            if (Schema::hasColumn('achievement_of_research_publications_target', 'rank')) {
                $table->dropColumn('rank');
            }

            // Add journal_clasification column as string and not nullable
            if (!Schema::hasColumn('achievement_of_research_publications_target', 'journal_clasification')) {
                $table->string('journal_clasification')->after('link_of_publications'); // not nullable by default
            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('achievement_of_research_publications_target', function (Blueprint $table) {
            // Re-add rank column
            $table->integer('rank')->nullable()->after('co_author_name');

            // Remove journal_clasification column
            $table->dropColumn('journal_clasification');
        });
    }
};
