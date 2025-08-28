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
        Schema::create('commercial_gains_counsultancy_research_income_project', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consultancy_id');
            $table->integer('no_of_projects')->nullable();
            $table->string('name_of_project')->nullable();
            $table->string('name_of_contracting_industry')->nullable();
            $table->string('total_duration_of_project')->nullable();
            $table->string('estimate_cost_project')->nullable();
            $table->string('completion_year')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
            $table->foreign('consultancy_id', 'cgcri_project_consultancy_fk')
            ->references('id')
            ->on('commercial_gains_counsultancy_research_incomes')
            ->onDelete('cascade');   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commercial_gains_counsultancy_research_income_project');
    }
};
