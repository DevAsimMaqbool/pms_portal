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
        Schema::create('research_conference_impacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('indicator_id');
            $table->enum('form_status', ['HOD', 'RESEARCHER', 'DEAN', 'OTHER', 'ORIC', 'HR'])->default('RESEARCHER');
            



            // Conference Detail
            $table->string('conference_name');
            $table->string('conference_theme')->nullable();
            $table->date('conference_date')->nullable();
            $table->string('conference_venue')->nullable();
            $table->enum('conference_scope', ['national', 'international']);
            $table->enum('scopus_indexing', ['yes', 'no']);

            // Participants Summary
            $table->integer('national_participants')->default(0);
            $table->integer('international_participants')->default(0);
            $table->integer('industry_participants')->default(0);

            // Impact Remarks
            $table->text('scholarly_impact')->nullable();
            $table->text('industry_engagement')->nullable();
            $table->text('international_participation')->nullable();
            $table->text('indexing_recognition')->nullable();
            $table->text('overall_remarks')->nullable();

            // Research Partner
            $table->enum('nature_of_partner', ['academia', 'industry'])->nullable();
            $table->string('partner_institute')->nullable();
            $table->string('partner_country')->nullable();


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
        Schema::dropIfExists('research_conference_impacts');
    }
};
