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
        Schema::create('achievement_of_research_publications_target', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('indicator_id');

            $table->string('target_category')->nullable();
            $table->string('link_of_publications')->nullable();
            $table->string('rank')->nullable();
            $table->string('nationality')->nullable();
            
            $table->unsignedInteger('scopus_q1')->nullable();
            $table->unsignedInteger('scopus_q2')->nullable();
            $table->unsignedInteger('scopus_q3')->nullable();
            $table->unsignedInteger('scopus_q4')->nullable();

            // HEC targets
            $table->unsignedInteger('hec_w')->nullable();
            $table->unsignedInteger('hec_x')->nullable();
            $table->unsignedInteger('hec_y')->nullable();

            // Medical target
            $table->unsignedInteger('medical_recognized')->nullable();
            $table->string('as_author_your_rank')->nullable();
            
            $table->enum('form_status', ['HOD', 'RESEARCHER', 'DEAN', 'OTHER'])->default('RESEARCHER');
            $table->enum('status', ['1', '2', '3','4','5','6'])->default('1');
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
        Schema::dropIfExists('achievement_of_research_publications_target');
    }
};
