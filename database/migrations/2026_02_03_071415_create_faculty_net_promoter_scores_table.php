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
        Schema::create('faculty_net_promoter_scores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('indicator_id');
            $table->enum('form_status', ['HOD', 'RESEARCHER', 'DEAN', 'OTHER', 'ORIC', 'HR'])->default('RESEARCHER');
              
            // Survey Counts
            $table->integer('total_faculty_surveyed')->nullable();
            $table->integer('number_of_promoters')->nullable();
            $table->integer('number_of_passives')->nullable();
            $table->integer('number_of_detractors')->nullable();

            // Evidence
            $table->string('evidence_reference')->nullable();
            $table->text('remarks')->nullable();

            // Calculations (Auto)
            $table->decimal('promoters_percentage', 6, 2)->nullable();
            $table->decimal('detractors_percentage', 6, 2)->nullable();
            $table->decimal('net_promoter_score', 6, 2)->nullable();

           
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
        Schema::dropIfExists('faculty_net_promoter_scores');
    }
};
