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
        Schema::create('commercial_gains_counsultancy_research_incomes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kpa_id');
            $table->unsignedBigInteger('sp_category_id');
            $table->unsignedBigInteger('indicator_id');
            $table->enum('form_status', ['HOD', 'RESEARCHER', 'DEAN','OTHER'])->default('RESEARCHER');
            $table->string('target_of_consultancy_projects')->nullable();
            $table->string('target_of_industrial_projects')->nullable();
            $table->integer('no_of_consultancies_done')->nullable();
            $table->string('title_of_consultancy')->nullable();
            $table->string('duration_of_consultancy')->nullable();
            $table->string('name_of_client_organization')->nullable();
            $table->enum('status', ['1', '2', '3','4','5','6'])->default('1');
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
        Schema::dropIfExists('commercial_gains_counsultancy_research_incomes');
    }
};
