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
        Schema::create('faculty_pursuing_skills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('indicator_id');
            $table->enum('form_status', ['HOD', 'RESEARCHER', 'DEAN', 'OTHER', 'ORIC', 'HR'])->default('RESEARCHER');
              
            // CPD Data
            $table->integer('total_faculty')->nullable();
            $table->integer('faculty_in_cpd_activities')->nullable();

            // Multi-select CPD types
            $table->json('cpd_type')->nullable();

            // Evidence
            $table->string('evidence_reference')->nullable();
            $table->text('remarks')->nullable();

            // Auto Calculation
            $table->decimal('faculty_cpd_percentage', 6, 2)->nullable();

           
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
        Schema::dropIfExists('faculty_pursuing_skills');
    }
};
