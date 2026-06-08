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
            $table->date('publication_date')->nullable()->after('as_author_your_rank');
            $table->boolean('affiliated_with_superior')
                  ->default(true)
                  ->after('publication_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('achievement_of_research_publications_target', function (Blueprint $table) {
              $table->dropColumn([
                'publication_date',
                'affiliated_with_superior'
            ]);
        });
    }
};
