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
        Schema::create('student_engagement_rate', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('indicator_id');
            $table->enum('form_status', ['HOD', 'RESEARCHER', 'DEAN', 'OTHER', 'ORIC', 'HR'])->default('RESEARCHER');
              
            // Engagement
            $table->string('nature_of_event')->nullable();
            $table->string('other_event_detail')->nullable();

            // Checkbox (store as JSON)
            $table->json('event_location')->nullable();

            // Radio
            $table->string('scope_of_the_event')->nullable();

            // Event Details
            $table->text('title_of_the_event')->nullable();
            $table->text('brief_description_of_activity')->nullable();

            $table->date('event_start_date')->nullable();
            $table->date('event_end_date')->nullable();

            // Program Info (Relations)
            $table->unsignedBigInteger('faculty_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('program_id')->nullable();

            // Participation
            $table->integer('participation_target')->nullable();
            $table->integer('number_of_students_participated')->nullable();
            $table->integer('employer_satisfaction')->nullable(); // rating value

           
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
        Schema::dropIfExists('student_engagement_rate');
    }
};
