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
        Schema::create('student_feedback', function (Blueprint $table) {
            $table->id();
            $table->string('house', '20')->nullable();
            $table->string('faculty_member', '250')->nullable();
            $table->string('empathy_compassion', '10')->nullable();
            $table->string('honesty_integrity', '10')->nullable();
            $table->string('inspirational_leadership', '10')->nullable();
            $table->string('responsibility_accountability', '10')->nullable();
            $table->string('overall', '10')->nullable();
            $table->string('attempts', '10')->nullable();
            $table->string('registered_students', '10')->nullable();
            $table->string('response_rate', '10')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_feedback');
    }
};
