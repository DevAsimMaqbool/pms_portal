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
        Schema::create('industrial_visits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('indicator_id');
            $table->enum('form_status', ['HOD', 'RESEARCHER', 'DEAN', 'OTHER', 'ORIC', 'HR'])->default('RESEARCHER');

            $table->string('employee_name');
            $table->string('employee_id');
            $table->string('designation');
            $table->string('department_program');
            $table->string('campus_unit')->nullable();

            $table->string('industry_organization');
            $table->string('industry_sector');

            $table->string('purpose_learning_objective');
            $table->string('course_subject');

            $table->integer('students_involved');

            $table->enum('employee_role', [
                'Organizer',
                'Coordinator',
                'Faculty-in-Charge',
                'Participant'
            ]);

            $table->enum('visit_category', [
                'Local',
                'National',
                'International'
            ]);

            $table->string('evidence_upload');

            $table->date('visit_start_date');
            $table->date('visit_end_date');
            $table->string('location');

            $table->boolean('visit_report_submitted');
            $table->date('report_submission_date')->nullable();

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
        Schema::dropIfExists('industrial_visits');
    }
};
