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
        Schema::create('no_of_programs_accredited_or_affiliated_nationally_internationally_and_ranking', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('indicator_id');
            $table->enum('form_status', ['HOD', 'RESEARCHER', 'DEAN', 'OTHER', 'ORIC', 'HR'])->default('RESEARCHER');
            $table->unsignedBigInteger('faculty_id');
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('program_id');
            $table->string('program_level');
            $table->string('recognition_type');
            $table->string('ranking_body');
            $table->string('scope');
            $table->string('status');
            $table->date('validity_from');
            $table->date('validity_to');
            $table->string('university_ranking')->nullable();
            $table->integer('ranking_position')->nullable();
            $table->string('evidence_available');
            $table->string('document_link')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('no_of_programs_accredited_or_affiliated_nationally_internationally_and_ranking');
    }
};
