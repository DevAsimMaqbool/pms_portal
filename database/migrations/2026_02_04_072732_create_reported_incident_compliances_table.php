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
        Schema::create('reported_incident_compliances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('indicator_id');
            $table->enum('form_status', ['HOD', 'RESEARCHER', 'DEAN', 'OTHER', 'ORIC', 'HR'])->default('RESEARCHER');
              
            $table->integer('total_reported_incidents')->nullable();
            $table->integer('academic_misconduct_cases')->nullable();
            $table->integer('administrative_breaches')->nullable();
            $table->integer('governance_protocol_violations')->nullable();
            $table->enum('severity_level', ['Low', 'Medium', 'High'])->nullable();
            $table->string('evidence_case_reference')->nullable();
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
        Schema::dropIfExists('reported_incident_compliances');
    }
};
