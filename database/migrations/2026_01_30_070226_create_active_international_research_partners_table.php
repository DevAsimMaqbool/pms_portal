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
        Schema::create('active_international_research_partners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('indicator_id');
            $table->enum('form_status', ['HOD', 'RESEARCHER', 'DEAN', 'OTHER', 'ORIC', 'HR'])->default('RESEARCHER');
              
            $table->string('university_name');
            $table->string('country', 10)->nullable();
            $table->string('city')->nullable();

            // Agreement Details
            $table->string('signing_authorities')->nullable();
            $table->string('duration_of_agreement')->nullable();
            $table->string('outcome_timeline')->nullable();

            // Collaboration Info
            $table->text('collaboration_scope')->nullable();
            $table->text('contact_details')->nullable();
            $table->text('projects_activities_planned')->nullable();

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
        Schema::dropIfExists('active_international_research_partners');
    }
};
