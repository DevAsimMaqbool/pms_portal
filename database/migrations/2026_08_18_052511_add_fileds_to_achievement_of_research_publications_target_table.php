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
            $table->string('journal_hec')->nullable()->after('journal_clasification');
            $table->string('journal_wos')->nullable()->after('journal_hec');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('achievement_of_research_publications_target', function (Blueprint $table) {
            $table->dropColumn(['journal_hec','journal_wos']);
        });
    }
};
