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
        Schema::create('employabilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('indicator_id');
            $table->enum('form_status', ['HOD', 'RESEARCHER', 'DEAN', 'OTHER','ORIC','HR'])->default('RESEARCHER');

            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('faculty_id');
            $table->unsignedBigInteger('program_id');
            $table->string('batch');
            $table->year('passing_year');
            $table->string('employer_name');
            $table->string('sector');

            $table->unsignedInteger('salary');
            $table->enum('market_competitive_salary', ['Above', 'At Par', 'Low']);
            $table->enum('job_relevancy', ['yes', 'no'])->default('no');
            $table->decimal('employer_satisfaction', 3, 2)->nullable(); 
            $table->decimal('graduate_satisfaction', 3, 2)->nullable();
            $table->enum('status', ['1', '2', '3', '4', '5', '6'])->default('1');
            $table->json('update_history')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employabilities');
    }
};
