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
        Schema::table('user_answers', function (Blueprint $table) {
            $table->unsignedInteger('attempt')->after('answer')->default(1);
            $table->unique(['user_id', 'attempt', 'survey_id', 'question_id'], 'unique_user_attempt_survey_question');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_answers', function (Blueprint $table) {
            $table->dropUnique('unique_user_attempt_survey_question');
            $table->dropColumn('attempt');
        });
    }
};
