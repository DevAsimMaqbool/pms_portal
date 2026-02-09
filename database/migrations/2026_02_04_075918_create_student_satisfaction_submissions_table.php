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
        Schema::create('student_satisfaction_submissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('indicator_id');
            $table->enum('form_status', ['HOD', 'RESEARCHER', 'DEAN', 'OTHER', 'ORIC', 'HR'])->default('RESEARCHER');
              
            // Engagement
            $table->json('stakeholder_category')->nullable();
            $table->string('nature_of_activity')->nullable();
            $table->json('activity_location')->nullable();

            // Activity details
            $table->string('title_of_activity')->nullable();
            $table->text('brief_description_of_activity')->nullable();
            $table->date('date_of_activity')->nullable();
            $table->string('partner_organization')->nullable();

            // Participation data
            $table->integer('total_number_of_faculty_in_department')->nullable();
            $table->integer('number_of_faculty_participated')->nullable();
            $table->integer('total_number_of_staff_in_office')->nullable();
            $table->integer('number_of_staff_participated')->nullable();
            $table->integer('total_number_of_students_in_program')->nullable();
            $table->integer('number_of_students_participated')->nullable();

            // Impact measurement
            $table->json('typ_of_impact_achieved')->nullable();
            $table->json('evidence_of_impact_available')->nullable();

            // Verification
            $table->boolean('declaration')->default(false);
            $table->tinyInteger('employer_satisfaction')->nullable(); // rating (1–5)

           
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
        Schema::dropIfExists('student_satisfaction_submissions');
    }
};
