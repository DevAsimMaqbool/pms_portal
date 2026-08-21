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
            $table->text('publication_title')->nullable()->after('journal_clasification');
            $table->text('journal_name')->nullable()->after('publication_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('achievement_of_research_publications_target', function (Blueprint $table) {
            $table->dropColumn([
                'publication_title',
                'journal_name',
            ]);
        });
    }
};
