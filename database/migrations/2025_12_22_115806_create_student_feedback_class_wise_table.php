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
        Schema::create('student_feedback_class_wise', function (Blueprint $table) {
            $table->id();
            $table->string('campus', '200')->nullable();
            $table->string('faculties', '250')->nullable();
            $table->string('program', '200')->nullable();
            $table->string('batch', '200')->nullable();
            $table->string('section', '50')->nullable();
            $table->string('course', '250')->nullable();
            $table->string('component_class', '250')->nullable();
            $table->string('faculty_member', '250')->nullable();
            $table->string('feedback', '10')->nullable();
            $table->string('response_rate', '10')->nullable();
            $table->string('attempts', '10')->nullable();
            $table->string('registered_students', '10')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_feedback_class_wise');
    }
};
