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
        Schema::create('achievement_of_research_publications_target_co_author', function (Blueprint $table) {
            $table->id();

            // Use short column name
            $table->unsignedBigInteger('target_id');

            $table->string('name')->nullable();
            $table->unsignedInteger('rank')->nullable();
            $table->string('univeristy_name')->nullable();
            $table->string('country')->nullable();
            $table->string('designation')->nullable();
            $table->unsignedInteger('no_paper_past')->nullable();
            $table->enum('first_author_superviser', ['YES','NO'])->default('NO');
            $table->string('student_roll_no')->nullable();
            $table->string('career')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();

            // Explicit short foreign key name
            $table->foreign('target_id', 'fk_co_author_target')
                  ->references('id')
                  ->on('achievement_of_research_publications_target')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievement_of_research_publications_target_co_author');
    }
};
