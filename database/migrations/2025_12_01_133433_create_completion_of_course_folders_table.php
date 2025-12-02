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
        Schema::create('completion_of_course_folders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('faculty_member_id'); // Faculty member
            $table->longText('class_cod')->nullable(); // Faculty member
            $table->integer('completion_of_Course_folder')->nullable();
            $table->unsignedBigInteger('completion_of_Course_folder_indicator_id')->nullable();
            $table->enum('form_status', ['HOD', 'RESEARCHER', 'DEAN', 'OTHER'])->default('HOD');

            
            $table->integer('compliance_and_usage_of_lms')->nullable();
            $table->unsignedBigInteger('compliance_and_usage_of_lms_indicator_id')->nullable();
            $table->enum('status', ['1', '2', '3', '4', '5', '6'])->default('1');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
             // Foreign keys (optional, if tables exist)
            $table->foreign('faculty_member_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('completion_of_course_folders');
    }
};
