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
        Schema::create('industrial_projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('indicator_id');
            $table->enum('form_status', ['HOD', 'RESEARCHER', 'DEAN', 'OTHER'])->default('RESEARCHER');
            $table->string('project_name')->nullable();
            $table->string('contracting_industry')->nullable();
            $table->integer('project_duration')->nullable();
            $table->integer('estimated_project_cost')->nullable();
            $table->date('estimated_complection')->nullable();
            $table->string('attachment')->nullable();
            $table->enum('status', ['1', '2', '3', '4', '5', '6'])->default('1');
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
        Schema::dropIfExists('industrial_projects');
    }
};
