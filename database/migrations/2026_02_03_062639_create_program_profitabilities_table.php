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
        Schema::create('program_profitabilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('indicator_id');
            $table->enum('form_status', ['HOD', 'RESEARCHER', 'DEAN', 'OTHER', 'ORIC', 'HR'])->default('RESEARCHER');
              
            // Program Info
            $table->date('financial_year')->nullable();
            $table->unsignedBigInteger('faculty_id');
            $table->unsignedBigInteger('program_id');
            $table->enum('program_level', ['UG', 'PG']);

            // Financial Data
            $table->decimal('total_program_income', 15, 2)->nullable();
            $table->decimal('faculty_cost', 15, 2)->nullable();
            $table->decimal('facilities_cost', 15, 2)->nullable();
            $table->decimal('materials_cost', 15, 2)->nullable();
            $table->decimal('support_services_cost', 15, 2)->nullable();
            $table->decimal('other_costs', 15, 2)->nullable();

            $table->string('evidence_reference')->nullable();
            $table->text('remarks')->nullable();

            // System Calculations
            $table->decimal('total_cost_of_delivery', 15, 2)->nullable();
            $table->decimal('net_program_surplus_deficit', 15, 2)->nullable();
            $table->enum('program_profitability_status', ['Profitable', 'not_profitable'])->nullable();
            $table->decimal('profitability_percentage', 8, 2)->nullable();

            // Aggregation
            $table->integer('total_programs_assessed')->nullable();
            $table->integer('number_of_profitable_programs')->nullable();
            $table->decimal('proportion_of_profitable_programs', 8, 2)->nullable();

           
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
        Schema::dropIfExists('program_profitabilities');
    }
};
