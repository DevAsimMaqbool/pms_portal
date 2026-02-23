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
        Schema::create('research_productivity_of_pg_students', function (Blueprint $table) {
            $table->id();

            $table->foreignId('target_id')
                ->constrained('achievement_of_research_publications_target')
                ->onDelete('cascade');

            $table->string('name')->nullable();
            $table->unsignedInteger('rank')->nullable();
            $table->string('univeristy_name')->nullable();
            $table->string('country')->nullable();

            $table->enum('your_role', ['Student', 'Researcher', 'Professional'])->nullable();
            $table->enum('is_the_student_fitst_coauthor', ['YES', 'NO'])->nullable();

            $table->string('designation')->nullable();
            $table->string('co_author_email', 255)->nullable();
            $table->unsignedInteger('no_paper_past')->nullable();
            $table->string('student_roll_no')->nullable();
            $table->string('career')->nullable();

            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');

            $table->timestamps();

            // Optional: If you want FK for created_by & updated_by
            // $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('research_productivity_of_pg_students');
    }
};
