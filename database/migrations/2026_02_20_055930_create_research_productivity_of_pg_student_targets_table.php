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
        Schema::create('research_productivity_of_pg_student_targets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('faculty_member_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('indicator_id')
                ->constrained('indicators')
                ->cascadeOnDelete();

            $table->string('target_category')->nullable();
            $table->string('link_of_publications', 500)->nullable();
            $table->string('journal_clasification');

            $table->unsignedInteger('scopus_q1')->nullable();
            $table->unsignedInteger('scopus_q2')->nullable();
            $table->unsignedInteger('scopus_q3')->nullable();
            $table->unsignedInteger('scopus_q4')->nullable();

            $table->unsignedInteger('hec_w')->nullable();
            $table->unsignedInteger('hec_x')->nullable();
            $table->unsignedInteger('hec_y')->nullable();
            $table->unsignedInteger('medical_recognized')->nullable();

            $table->string('student_name')->nullable();
            $table->string('roll_no')->nullable();
            $table->string('as_author_your_rank', 255)->nullable();
            $table->foreignId('faculty_id')
                ->nullable()
                ->constrained('faculties')
                ->nullOnDelete();

            $table->foreignId('department_id')
                ->nullable()
                ->constrained('departments')
                ->nullOnDelete();

            $table->foreignId('program_id')
                ->nullable()
                ->constrained('programs')
                ->nullOnDelete();
            $table->string('nationality', 255)->nullable();

            $table->enum('status', ['1', '2', '3', '4', '5', '6'])->default('1');

            $table->json('update_history')->nullable();

            $table->enum('form_status', ['HOD', 'RESEARCHER', 'DEAN', 'OTHER'])
                ->default('RESEARCHER');

            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('updated_by')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('research_productivity_of_pg_student_targets');
    }
};
