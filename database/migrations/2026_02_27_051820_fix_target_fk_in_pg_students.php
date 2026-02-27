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
        Schema::table('research_productivity_of_pg_students', function (Blueprint $table) {
            // Drop wrong FK
            $table->dropForeign(['target_id']);

            // Add correct FK
            $table->foreign('target_id')
                ->references('id')
                ->on('research_productivity_of_pg_student_targets')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('research_productivity_of_pg_students', function (Blueprint $table) {
             $table->dropForeign(['target_id']);

            $table->foreign('target_id')
                ->references('id')
                ->on('achievement_of_research_publications_target')
                ->onDelete('cascade');
        });
    }
};
